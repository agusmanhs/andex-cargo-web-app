<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;

class MigrateLastYearTransactions extends Command
{
    protected $signature = 'cargo:migrate-last-year-transactions {--since=2025-10-01 : Filter transactions created on or after this date}';
    protected $description = 'Migrate all customers and transactions from the last year from legacy database into new schema';

    public function handle(): int
    {
        ini_set('memory_limit', '512M');
        $since = $this->option('since') ?: '2025-10-01';
        $this->info("=== Starting Migration of Transactions (Since: {$since}) ===");

        $legacyDb = env('DB_LEGACY_DATABASE', 'kargo_andex_db');
        $legacyUser = env('DB_LEGACY_USERNAME', 'kargo_andex');
        $legacyPass = env('DB_LEGACY_PASSWORD', 'ZBwjcVCpYyTKgkH9MGhtsF');
        $legacyHost = env('DB_LEGACY_HOST', '127.0.0.1');
        $legacyPort = env('DB_LEGACY_PORT', '3306');

        try {
            $legacy = new PDO(
                "mysql:host={$legacyHost};port={$legacyPort};dbname={$legacyDb};charset=utf8mb4",
                $legacyUser,
                $legacyPass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (\Throwable $e) {
            $this->error("Failed to connect to legacy database: " . $e->getMessage());
            return Command::FAILURE;
        }

        // 1. Build Lookups Cache
        $this->info("1. Loading lookups cache (Branches, Services, Regencies)...");
        $validBranchIds = DB::table('branches')->pluck('id')->toArray();
        $defaultBranchId = in_array(2, $validBranchIds) ? 2 : ($validBranchIds[0] ?? 1);
        $validServiceIds = DB::table('shipping_services')->pluck('id')->toArray();
        $defaultServiceId = in_array(3, $validServiceIds) ? 3 : ($validServiceIds[0] ?? 1);

        $regencies = DB::table('kabupaten')->pluck('nama_kabupaten', 'kode_kabupaten')->toArray();
        $this->info("   -> Cached " . count($regencies) . " regencies and " . count($validBranchIds) . " branches.");

        // 2. Full Sync of ALL Customers
        $this->info("2. Syncing ALL customers from legacy database...");
        $legacyCustomers = $legacy->query("SELECT * FROM customer ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        
        $customerDetails = [];
        $customerBatch = [];

        foreach ($legacyCustomers as $c) {
            $cid = (int)$c['id'];
            $code = 'CUST-' . str_pad($cid, 5, '0', STR_PAD_LEFT);
            $name = trim($c['nama']);
            $phone = trim($c['no_telp'] ?: '0811000000');
            $address = trim($c['alamat'] ?: '');
            $isCorp = preg_match('/^(PT|CV|UD|YAYASAN|TOKO)\b/i', $name) ? 'CORPORATE' : 'REGULAR';
            
            $bId = is_numeric($c['kantor_id']) ? (int)$c['kantor_id'] : $defaultBranchId;
            $branchId = in_array($bId, $validBranchIds) ? $bId : $defaultBranchId;

            $customerDetails[$cid] = [
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
            ];

            $customerBatch[] = [
                'code' => $code,
                'name' => $name,
                'pic_name' => null,
                'phone' => $phone,
                'whatsapp' => $c['no_wa'],
                'email' => $c['email'],
                'province' => $c['provinsi'],
                'regency' => $c['kabupaten'],
                'address' => $address,
                'customer_type' => $isCorp,
                'branch_id' => $branchId,
                'user_id' => null,
                'is_active' => $c['active'] === '1' ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Upsert customers in chunks
        foreach (array_chunk($customerBatch, 500) as $chunk) {
            DB::table('customers')->upsert(
                $chunk,
                ['code'],
                ['name', 'phone', 'whatsapp', 'email', 'province', 'regency', 'address', 'customer_type', 'branch_id', 'is_active', 'updated_at']
            );
        }

        // Fetch customer IDs mapped by code
        $codeToId = DB::table('customers')->pluck('id', 'code')->toArray();
        $customerMap = [];
        foreach ($legacyCustomers as $c) {
            $code = 'CUST-' . str_pad($c['id'], 5, '0', STR_PAD_LEFT);
            if (isset($codeToId[$code])) {
                $customerMap[(int)$c['id']] = $codeToId[$code];
            }
        }
        $this->info("   -> Synchronized " . count($customerBatch) . " total customers.");

        // 3. Preload latest activity status per shipment
        $this->info("3. Preloading latest activities for shipments...");
        $activityStmt = $legacy->prepare("
            SELECT a.id_pengiriman, a.proses_pengiriman, a.waktu, a.created_at
            FROM activity a
            INNER JOIN (
                SELECT id_pengiriman, MAX(id) as max_id
                FROM activity
                GROUP BY id_pengiriman
            ) latest ON a.id = latest.max_id
        ");
        $activityStmt->execute();
        $latestActivities = [];
        while ($row = $activityStmt->fetch(PDO::FETCH_ASSOC)) {
            $latestActivities[(int)$row['id_pengiriman']] = $row;
        }
        $this->info("   -> Preloaded latest activity for " . count($latestActivities) . " shipments.");

        // 4. Fetch Transactions from Last Year
        $this->info("4. Fetching transactions created since {$since}...");
        $shipStmt = $legacy->prepare("
            SELECT * FROM pengiriman 
            WHERE created_at >= :since 
            ORDER BY id ASC
        ");
        $shipStmt->execute([':since' => $since]);
        $legacyShipments = $shipStmt->fetchAll(PDO::FETCH_ASSOC);
        $totalShipments = count($legacyShipments);
        $this->info("   -> Found {$totalShipments} transactions to migrate.");

        $shipmentBatch = [];

        foreach ($legacyShipments as $s) {
            $tracking = trim($s['kode']);
            if (!$tracking) continue;

            $kId = is_numeric($s['kantors']) ? (int)$s['kantors'] : $defaultBranchId;
            $originBranchId = in_array($kId, $validBranchIds) ? $kId : $defaultBranchId;

            $pId = is_numeric($s['produk_id']) ? (int)$s['produk_id'] : $defaultServiceId;
            $serviceId = in_array($pId, $validServiceIds) ? $pId : $defaultServiceId;

            // Resolve Origin and Destination City Names
            $originCity = $regencies[$s['asal_id']] ?? 'KOTA MAKASSAR';
            $destCity = $regencies[$s['tujuan_id']] ?? 'SURABAYA';

            // Resolve Sender & Receiver details
            $senderId = (int)$s['pengirim_id'];
            $receiverId = (int)$s['penerima_id'];

            $senderName = $customerDetails[$senderId]['name'] ?? 'Pengirim #' . $senderId;
            $senderPhone = $customerDetails[$senderId]['phone'] ?? '0811000000';
            $senderAddress = $customerDetails[$senderId]['address'] ?? '';

            $receiverName = $customerDetails[$receiverId]['name'] ?? 'Penerima #' . $receiverId;
            $receiverPhone = $customerDetails[$receiverId]['phone'] ?? '0811000000';
            $receiverAddress = $customerDetails[$receiverId]['address'] ?? '';

            // Map status from latest activity
            $shipmentId = (int)$s['id'];
            $latestAct = $latestActivities[$shipmentId]['proses_pengiriman'] ?? null;
            $actTime = $latestActivities[$shipmentId]['waktu'] ?? $latestActivities[$shipmentId]['created_at'] ?? null;
            $deliveredAt = null;

            if ($latestAct === 'DITERIMA') {
                $status = 'DELIVERED';
                $deliveredAt = $actTime;
            } elseif ($latestAct === 'SAMPAI') {
                $status = 'DESTINATION_HUB';
            } elseif (in_array($latestAct, ['BERANGKAT', 'TRANSIT'])) {
                $status = 'IN_TRANSIT';
            } elseif ($latestAct === 'PENGANTARAN') {
                $status = 'OUT_FOR_DELIVERY';
            } elseif ($s['status_dis'] === '1') {
                $status = 'MANIFESTED';
            } else {
                $status = 'ORIGIN_HUB';
            }

            $shipmentBatch[] = [
                'tracking_number' => $tracking,
                'origin_branch_id' => $originBranchId,
                'destination_branch_id' => in_array(20, $validBranchIds) ? 20 : $defaultBranchId,
                'service_id' => $serviceId,
                'customer_id' => $customerMap[(int)$s['customer_id']] ?? null,
                'sender_name' => $senderName,
                'sender_phone' => $senderPhone,
                'sender_address' => $senderAddress,
                'origin_city' => $originCity,
                'receiver_name' => $receiverName,
                'receiver_phone' => $receiverPhone,
                'receiver_address' => $receiverAddress,
                'destination_city' => $destCity,
                'total_colly' => (int)($s['tot_koli'] ?: 1),
                'actual_weight' => (float)$s['berat_ori'],
                'volume_weight' => 0.00,
                'chargeable_weight' => (float)$s['berat_ori'],
                'tariff_per_kg' => (float)($s['biaya_kirim'] / max(1, (float)$s['berat_ori'])),
                'shipping_cost' => (float)$s['biaya_kirim'],
                'packing_cost' => (float)($s['biaya_packing'] ?: 0),
                'insurance_cost' => 0.00,
                'other_cost' => (float)($s['biaya_lain'] ?: 0),
                'total_cost' => (float)$s['total_harga'],
                'payment_type' => in_array($s['payment'], ['CASH', 'COD', 'INVOICE']) ? $s['payment'] : 'CASH',
                'payment_status' => $s['status_pembayaran'] === 'LUNAS' ? 'PAID' : 'UNPAID',
                'status' => $status,
                'is_manifested' => $s['status_dis'] === '1' ? 1 : 0,
                'current_location' => $status === 'DELIVERED' ? $destCity : $originCity,
                'delivered_at' => $deliveredAt,
                'recipient_name' => $status === 'DELIVERED' ? $receiverName : null,
                'pod_notes' => null,
                'pod_photo' => null,
                'notes' => $s['note'],
                'is_active' => $s['active'] === '1' ? 1 : 0,
                'created_at' => $s['created_at'],
                'updated_at' => $s['updated_at'] ?: $s['created_at'],
            ];
        }

        $this->info("   -> Inserting shipments in batches...");
        foreach (array_chunk($shipmentBatch, 500) as $chunk) {
            DB::table('shipments')->upsert(
                $chunk,
                ['tracking_number'],
                [
                    'origin_branch_id', 'destination_branch_id', 'service_id', 'customer_id',
                    'sender_name', 'sender_phone', 'sender_address', 'origin_city',
                    'receiver_name', 'receiver_phone', 'receiver_address', 'destination_city',
                    'total_colly', 'actual_weight', 'chargeable_weight', 'tariff_per_kg',
                    'shipping_cost', 'packing_cost', 'other_cost', 'total_cost',
                    'payment_type', 'payment_status', 'status', 'is_manifested',
                    'current_location', 'delivered_at', 'recipient_name', 'notes', 'is_active', 'updated_at'
                ]
            );
        }
        $this->info("   -> Migrated " . count($shipmentBatch) . " shipments successfully.");

        // Build tracking_number => shipment_id mapping
        $trackingToId = DB::table('shipments')->pluck('id', 'tracking_number')->toArray();

        // 5. Migrate Shipment Items (barang) via Streaming
        $this->info("5. Migrating items (barang) for these shipments (streaming)...");
        $barangStmt = $legacy->prepare("
            SELECT b.* 
            FROM barang b
            INNER JOIN pengiriman p ON b.resi_pengiriman_id = p.kode
            WHERE p.created_at >= :since
        ");
        $barangStmt->execute([':since' => $since]);

        // Clean existing items for these shipments first
        if (!empty($trackingToId)) {
            DB::table('shipment_items')->whereIn('shipment_id', array_values($trackingToId))->delete();
        }

        $itemBatch = [];
        $totalItemsMigrated = 0;
        while ($b = $barangStmt->fetch(PDO::FETCH_ASSOC)) {
            $tracking = trim($b['resi_pengiriman_id']);
            if (!isset($trackingToId[$tracking])) continue;

            $itemBatch[] = [
                'shipment_id' => $trackingToId[$tracking],
                'item_name' => $b['nama_barang'] ?: 'Barang Kiriman Paket',
                'colly_count' => (int)($b['bagasi_coly'] ?: 1),
                'length_cm' => (float)$b['panjang_cm'],
                'width_cm' => (float)$b['lebar_cm'],
                'height_cm' => (float)$b['tinggi_cm'],
                'actual_weight_kg' => (float)($b['berat_actual'] ?: $b['berat_kg']),
                'volume_weight_kg' => (float)$b['volume'],
                'chargeable_weight_kg' => (float)($b['berat_charge'] ?: $b['berat_actual']),
                'created_at' => $b['created_at'],
                'updated_at' => $b['updated_at'] ?: $b['created_at'],
            ];

            if (count($itemBatch) >= 500) {
                DB::table('shipment_items')->insert($itemBatch);
                $totalItemsMigrated += count($itemBatch);
                $itemBatch = [];
            }
        }
        if (!empty($itemBatch)) {
            DB::table('shipment_items')->insert($itemBatch);
            $totalItemsMigrated += count($itemBatch);
        }
        $this->info("   -> Migrated " . $totalItemsMigrated . " item details successfully.");

        // 6. Migrate Tracking Activities via Streaming
        $this->info("6. Migrating tracking milestones (activity) (streaming)...");
        $actStmt = $legacy->prepare("
            SELECT a.*, p.kode as tracking_number
            FROM activity a
            INNER JOIN pengiriman p ON a.id_pengiriman = p.id
            WHERE p.created_at >= :since
            ORDER BY a.id ASC
        ");
        $actStmt->execute([':since' => $since]);

        if (!empty($trackingToId)) {
            DB::table('tracking_activities')->whereIn('shipment_id', array_values($trackingToId))->delete();
        }

        $actBatch = [];
        $totalActsMigrated = 0;
        while ($a = $actStmt->fetch(PDO::FETCH_ASSOC)) {
            $tracking = trim($a['tracking_number']);
            if (!isset($trackingToId[$tracking])) continue;

            $status = match ($a['proses_pengiriman']) {
                'DITERIMA' => 'DELIVERED',
                'SAMPAI' => 'DESTINATION_HUB',
                'BERANGKAT' => 'IN_TRANSIT',
                'TRANSIT' => 'IN_TRANSIT',
                'PENGANTARAN' => 'OUT_FOR_DELIVERY',
                'PERSIAPAN' => 'MANIFESTED',
                'PACKING' => 'ORIGIN_HUB',
                default => 'ORIGIN_HUB'
            };

            $title = match ($a['proses_pengiriman']) {
                'DITERIMA' => 'Paket Telah Diterima oleh Penerima',
                'SAMPAI' => 'Paket Tiba di Gudang/Hub Tujuan',
                'BERANGKAT' => 'Paket Diberangkatkan Menuju Kota Tujuan',
                'TRANSIT' => 'Paket Sedang Dalam Perjalanan Transit',
                'PENGANTARAN' => 'Paket Sedang Dibawa Kurir ke Alamat Penerima',
                'PERSIAPAN' => 'Paket Dimasukkan ke dalam Manifest Pengiriman',
                'PACKING' => 'Paket Selesai Packing & Verifikasi di Gudang Asal',
                default => 'Aktivitas Kiriman Diperbarui'
            };

            $actBatch[] = [
                'shipment_id' => $trackingToId[$tracking],
                'status' => $status,
                'title' => $title,
                'description' => "Status operasional: {$a['proses_pengiriman']}",
                'location' => 'Andex Cargo Hub',
                'happened_at' => $a['waktu'] ?: $a['created_at'],
                'created_at' => $a['created_at'],
                'updated_at' => $a['updated_at'] ?: $a['created_at'],
            ];

            if (count($actBatch) >= 500) {
                DB::table('tracking_activities')->insert($actBatch);
                $totalActsMigrated += count($actBatch);
                $actBatch = [];
            }
        }
        if (!empty($actBatch)) {
            DB::table('tracking_activities')->insert($actBatch);
            $totalActsMigrated += count($actBatch);
        }
        $this->info("   -> Migrated " . $totalActsMigrated . " tracking activities successfully.");

        $this->info("=== Migration of Last Year Transactions Completed Successfully! ===");
        return Command::SUCCESS;
    }
}
