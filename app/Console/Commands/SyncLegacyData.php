<?php

namespace App\Console\Commands;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\ShippingService;
use App\Models\Tariff;
use App\Models\TrackingActivity;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDO;

class SyncLegacyData extends Command
{
    protected $signature = 'app:sync-legacy-data {--shipments-limit=500 : Limit shipments to migrate (or 0 for all)}';
    protected $description = 'Sync data from legacy kargo_andex_db to new andex_cargo_db';

    public function handle(): int
    {
        $this->info("Connecting to legacy database...");
        $legacy = new PDO(
            "mysql:host=127.0.0.1;dbname=kargo_andex_db;charset=utf8mb4",
            "kargo_andex",
            "ZBwjcVCpYyTKgkH9MGhtsF",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );

        $this->syncProvincesAndRegencies($legacy);
        $this->syncBranches($legacy);
        $this->syncServices($legacy);
        $this->syncUsers($legacy);
        $this->syncCustomers($legacy);
        $this->syncTariffs($legacy);
        $this->syncShipments($legacy);

        $this->info("Data synchronization completed successfully!");
        return Command::SUCCESS;
    }

    protected function syncProvincesAndRegencies(PDO $legacy): void
    {
        $this->info("1. Syncing Provinces & Regencies...");
        $provs = $legacy->query("SELECT * FROM provinsi")->fetchAll();
        foreach ($provs as $p) {
            Province::updateOrCreate(
                ['code' => $p['kode_provinsi']],
                ['name' => $p['nama_provinsi']]
            );
        }

        $regencies = $legacy->query("SELECT * FROM kabupaten")->fetchAll();
        foreach ($regencies as $r) {
            Regency::updateOrCreate(
                ['code' => $r['kode_kabupaten']],
                [
                    'province_code' => $r['kode_provinsi'],
                    'name' => $r['nama_kabupaten'],
                ]
            );
        }
        $this->info("   -> Imported " . count($provs) . " provinces and " . count($regencies) . " regencies.");
    }

    protected function syncBranches(PDO $legacy): void
    {
        $this->info("2. Syncing Branches (Kantor)...");
        $kantor = $legacy->query("SELECT * FROM kantor")->fetchAll();
        foreach ($kantor as $k) {
            $branchCode = strtoupper(trim($k['kode_kantor'] ?: 'BR-' . $k['id']));
            Branch::updateOrCreate(
                ['code' => $branchCode],
                [
                    'code' => strtoupper(trim($k['kode_kantor'] ?: 'BR-' . $k['id'])),
                    'name' => trim($k['nama_kantor']),
                    'type' => in_array(strtoupper($k['kode_kantor']), ['UPG', 'JKT', 'SUB']) ? 'HUB' : 'BRANCH',
                    'address' => $k['alamat'],
                    'header_address' => $k['header_alamat'] ?? $k['alamat'],
                    'is_active' => $k['active'] === '1',
                ]
            );
        }
        $this->info("   -> Imported " . count($kantor) . " branches.");
    }

    protected function syncServices(PDO $legacy): void
    {
        $this->info("3. Syncing Shipping Services (Produk)...");
        $services = $legacy->query("SELECT * FROM produk")->fetchAll();
        foreach ($services as $s) {
            $code = match ((int)$s['id']) {
                2 => 'EXP',
                3 => 'REG',
                7 => 'FTL',
                8 => 'KND',
                default => 'SRV-' . $s['id']
            };

            ShippingService::updateOrCreate(
                ['code' => $code],
                [
                    'code' => $code,
                    'name' => trim($s['nama_produk']),
                    'transport_type' => in_array($s['jenis'], ['DARAT', 'UDARA', 'LAUT']) ? $s['jenis'] : 'DARAT',
                    'description' => 'Layanan ' . $s['nama_produk'] . ' (' . $s['jenis'] . ')',
                    'min_weight' => 1.00,
                    'estimated_time' => $s['jenis'] === 'UDARA' ? '1-2 Hari' : '2-4 Hari',
                    'is_active' => $s['active'] === '1',
                ]
            );
        }
        $this->info("   -> Imported " . count($services) . " services.");
    }

    protected function syncUsers(PDO $legacy): void
    {
        $this->info("4. Syncing Users...");
        $users = $legacy->query("SELECT * FROM users")->fetchAll();
        foreach ($users as $u) {
            $role = match ((int)$u['role_id']) {
                1 => 'SUPERADMIN',
                2 => 'BRANCH_MANAGER',
                3 => 'OPERATOR',
                4 => 'COURIER',
                default => 'OPERATOR'
            };

            $branchId = (int)$u['kantor_id'];
            if (!Branch::where('id', $branchId)->exists()) {
                $branchId = 2; // Default Makassar UPG
            }

            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'username' => $u['username'],
                    'password' => $u['password'], // Retain existing hashed password
                    'role' => $role,
                    'branch_id' => $branchId,
                    'is_active' => $u['active'] === '1',
                ]
            );
        }

        // Ensure default developer / superadmin exists
        User::updateOrCreate(
            ['email' => 'admin@andexcargo.id'],
            [
                'name' => 'Super Administrator',
                'username' => 'admin_dev',
                'password' => Hash::make('password123'),
                'role' => 'SUPERADMIN',
                'branch_id' => 2,
                'is_active' => true,
            ]
        );

        $this->info("   -> Imported " . count($users) . " users + standard admin created (admin@andexcargo.id / password123).");
    }

    protected function syncCustomers(PDO $legacy): void
    {
        $this->info("5. Syncing Customers (sample / all)...");
        $customers = $legacy->query("SELECT * FROM customer LIMIT 1000")->fetchAll();
        foreach ($customers as $c) {
            $branchId = is_numeric($c['kantor_id']) ? (int)$c['kantor_id'] : 2;
            if (!Branch::where('id', $branchId)->exists()) {
                $branchId = 2;
            }

            $code = 'CUST-' . str_pad($c['id'], 5, '0', STR_PAD_LEFT);
            Customer::updateOrCreate(
                ['code' => $code],
                [
                    'name' => trim($c['nama']),
                    'phone' => trim($c['no_telp'] ?: '0811000000'),
                    'whatsapp' => $c['no_wa'],
                    'email' => $c['email'],
                    'province' => $c['provinsi'],
                    'regency' => $c['kabupaten'],
                    'address' => $c['alamat'],
                    'customer_type' => 'REGULAR',
                    'branch_id' => $branchId,
                    'is_active' => $c['active'] === '1',
                ]
            );
        }
        $this->info("   -> Imported " . count($customers) . " customers.");
    }

    protected function syncTariffs(PDO $legacy): void
    {
        $this->info("6. Syncing Tariffs...");
        $tariffs = $legacy->query("SELECT * FROM tarif")->fetchAll();
        foreach ($tariffs as $t) {
            $serviceId = is_numeric($t['produk_id']) ? (int)$t['produk_id'] : null;
            if ($serviceId && !ShippingService::where('id', $serviceId)->exists()) {
                $serviceId = null;
            }

            Tariff::updateOrCreate(
                ['from_regency' => trim($t['from_kabupaten']), 'to_regency' => trim($t['to_kabupaten']), 'service_id' => $serviceId],
                [
                    'service_id' => $serviceId,
                    'from_regency' => trim($t['from_kabupaten']),
                    'to_regency' => trim($t['to_kabupaten']),
                    'price_per_kg' => (float)$t['harga'],
                    'min_weight' => (float)($t['berat_min'] ?: 10),
                    'min_price' => (float)($t['harga_min'] ?: 0),
                    'estimated_time' => $t['estimasi'] ?: '2-3 Hari',
                    'is_active' => $t['active'] === '1',
                ]
            );
        }
        $this->info("   -> Imported " . count($tariffs) . " tariffs.");
    }

    protected function syncShipments(PDO $legacy): void
    {
        $limit = (int)$this->option('shipments-limit');
        $this->info("7. Syncing Shipments (Limit: " . ($limit > 0 ? $limit : 'ALL') . ")...");

        $sql = "SELECT * FROM pengiriman ORDER BY id DESC";
        if ($limit > 0) {
            $sql .= " LIMIT " . $limit;
        }

        $shipments = $legacy->query($sql)->fetchAll();
        $importedCount = 0;

        foreach ($shipments as $s) {
            $originBranchId = is_numeric($s['kantors']) ? (int)$s['kantors'] : 2;
            if (!Branch::where('id', $originBranchId)->exists()) {
                $originBranchId = 2;
            }

            $serviceId = is_numeric($s['produk_id']) ? (int)$s['produk_id'] : 3;
            if (!ShippingService::where('id', $serviceId)->exists()) {
                $serviceId = 3;
            }

            $status = match ((int)$s['status_dis']) {
                1 => 'MANIFESTED',
                default => 'ORIGIN_HUB'
            };

            $trackingNumber = trim($s['kode']);
            if (!$trackingNumber) {
                continue;
            }

            $shipment = Shipment::updateOrCreate(
                ['tracking_number' => $trackingNumber],
                [
                    'id' => $s['id'],
                    'origin_branch_id' => $originBranchId,
                    'destination_branch_id' => 20, // Default Sub / hub
                    'service_id' => $serviceId,
                    'customer_id' => is_numeric($s['customer_id']) && Customer::where('id', (int)$s['customer_id'])->exists() ? (int)$s['customer_id'] : null,
                    'sender_name' => 'Pengirim #' . ($s['pengirim_id'] ?? '1'),
                    'sender_phone' => '08123456789',
                    'origin_city' => 'MAKASSAR',
                    'receiver_name' => 'Penerima #' . ($s['penerima_id'] ?? '1'),
                    'receiver_phone' => '08987654321',
                    'destination_city' => 'SURABAYA',
                    'total_colly' => (int)($s['tot_koli'] ?: 1),
                    'actual_weight' => (float)$s['berat_ori'],
                    'chargeable_weight' => (float)$s['berat_ori'],
                    'shipping_cost' => (float)$s['biaya_kirim'],
                    'packing_cost' => (float)($s['biaya_packing'] ?: 0),
                    'other_cost' => (float)($s['biaya_lain'] ?: 0),
                    'total_cost' => (float)$s['total_harga'],
                    'payment_type' => in_array($s['payment'], ['CASH', 'COD', 'INVOICE']) ? $s['payment'] : 'CASH',
                    'payment_status' => $s['status_pembayaran'] === 'LUNAS' ? 'PAID' : 'UNPAID',
                    'status' => $status,
                    'is_manifested' => $s['status_dis'] === '1',
                    'notes' => $s['note'],
                    'created_at' => $s['created_at'],
                    'updated_at' => $s['updated_at'],
                ]
            );

            // Add default tracking activity if none
            if ($shipment->wasRecentlyCreated) {
                TrackingActivity::create([
                    'shipment_id' => $shipment->id,
                    'status' => 'ORIGIN_HUB',
                    'title' => 'Kiriman Diterima di Gudang ' . ($shipment->originBranch->name ?? 'Makassar'),
                    'description' => 'Paket telah diterima di agen/cabang asal dan siap diproses.',
                    'location' => $shipment->originBranch->name ?? 'Makassar Hub',
                    'happened_at' => $s['created_at'] ?: now(),
                ]);
            }

            $importedCount++;
        }

        $this->info("   -> Imported " . $importedCount . " shipments.");
    }
}
