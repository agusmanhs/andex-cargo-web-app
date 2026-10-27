<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan Manifest - {{ $manifest->manifest_number }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        @page {
            size: A4 portrait;
            margin: 8mm 10mm;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #fff;
            line-height: 1.4;
            padding: 12px;
        }
        .no-print-bar {
            background: #0f172a;
            color: #fff;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        .btn-print {
            background: #1d58cd;
            color: #fff;
            border: none;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-pdf {
            background: #475569;
            color: #fff;
            text-decoration: none;
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
        }
        .manifest-container {
            max-width: 210mm;
            margin: 0 auto;
            background: #fff;
        }
        .doc-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }
        .company-title {
            font-size: 22px;
            font-weight: 900;
            color: #1d58cd;
            letter-spacing: -0.5px;
        }
        .company-sub {
            font-size: 11px;
            font-weight: 600;
            color: #475569;
        }
        .company-address {
            font-size: 10px;
            color: #64748b;
            margin-top: 3px;
            max-width: 320px;
        }
        .doc-title-box {
            text-align: right;
        }
        .doc-title {
            font-size: 16px;
            font-weight: 900;
            text-transform: uppercase;
            color: #0f172a;
        }
        .manifest-no {
            font-size: 15px;
            font-weight: 800;
            font-family: monospace;
            color: #c5161d;
            margin: 3px 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 14px;
            font-size: 11px;
        }
        .info-row {
            display: flex;
            margin-bottom: 4px;
        }
        .info-label {
            width: 130px;
            font-weight: 700;
            color: #475569;
        }
        .info-val {
            flex: 1;
            font-weight: 600;
            color: #0f172a;
        }
        .cargo-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 14px;
        }
        .cargo-table th {
            background: #1e293b;
            color: #fff;
            padding: 7px 6px;
            text-align: left;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
            border: 1px solid #0f172a;
        }
        .cargo-table td {
            padding: 6px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        .cargo-table tr:nth-child(even) {
            background: #f8fafc;
        }
        .cargo-table .text-center {
            text-align: center;
        }
        .cargo-table .text-right {
            text-align: right;
        }
        .total-row td {
            background: #e2e8f0 !important;
            font-weight: 900;
            font-size: 11px;
            border-top: 2px solid #0f172a;
            border-bottom: 2px solid #0f172a;
        }
        .signature-section {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            page-break-inside: avoid;
        }
        .sig-box {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px;
            background: #fff;
        }
        .sig-role {
            font-weight: 700;
            color: #475569;
            margin-bottom: 50px;
            text-transform: uppercase;
            font-size: 10px;
        }
        .sig-name {
            font-weight: 800;
            border-top: 1px dotted #000;
            padding-top: 4px;
            display: inline-block;
            min-width: 140px;
        }
        @media print {
            .no-print-bar {
                display: none !important;
            }
            body {
                padding: 0;
                background: none;
            }
        }
    </style>
</head>
<body>

@if(!$isPdf)
<div class="no-print-bar">
    <div>
        <strong>Surat Jalan Manifest Kargo Antar-Cabang</strong>
        <span style="font-size: 11px; opacity: 0.8; margin-left: 8px;">Format Dokumen Resmi A4</span>
    </div>
    <div style="display: flex; gap: 8px; align-items: center;">
        <a href="{{ route('print.manifest', ['manifest' => $manifest->id, 'format' => 'pdf']) }}" class="btn-pdf">📥 Unduh PDF</a>
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Dokumen</button>
    </div>
</div>
@endif

<div class="manifest-container">
    <!-- Header -->
    <div class="doc-header">
        <div>
            <div class="company-title">ANDEX CARGO</div>
            <div class="company-sub">PT. ANDEX CIPTA CELEBES - CARGO & LOGISTICS</div>
            <div class="company-address">
                Hub Makassar: Jl. Perintis Kemerdekaan KM 9, Tamalanrea, Makassar.<br>
                Telp / WhatsApp: (0411) 890-2345 / 0811-444-2321 | Web: www.andexcargo.com
            </div>
        </div>
        <div class="doc-title-box">
            <div class="doc-title">SURAT JALAN / MANIFEST</div>
            <div class="manifest-no">{{ $manifest->manifest_number }}</div>
            <img src="data:image/png;base64,{{ $barcodePng }}" style="height: 34px; max-width: 200px; display: inline-block;" alt="Barcode">
        </div>
    </div>

    <!-- Metadata Grid -->
    <div class="info-grid">
        <div>
            <div class="info-row">
                <span class="info-label">Cabang Asal (Origin):</span>
                <span class="info-val">{{ $manifest->originBranch?->name ?? 'Hub Makassar' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Cabang Tujuan (Dest):</span>
                <span class="info-val">{{ $manifest->destinationBranch?->name ?? 'Hub Tujuan' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jalur Transportasi:</span>
                <span class="info-val">{{ $manifest->transport_type ?? 'DARAT (TRUK)' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status Dispatch:</span>
                <span class="info-val">{{ $manifest->status }}</span>
            </div>
        </div>
        <div>
            <div class="info-row">
                <span class="info-label">Plat Armada / Kendaraan:</span>
                <span class="info-val">{{ $manifest->vehicle_plate_number ?: '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Nama Pengemudi / Driver:</span>
                <span class="info-val">{{ $manifest->driver_name ?: '-' }} ({{ $manifest->driver_phone ?: '-' }})</span>
            </div>
            <div class="info-row">
                <span class="info-label">Vendor Transportasi:</span>
                <span class="info-val">{{ $manifest->vendor_name ?: 'Armada Internal Andex' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Waktu Berangkat:</span>
                <span class="info-val">{{ $manifest->departure_time ? $manifest->departure_time->format('d/m/Y H:i') : 'Menunggu Jadwal' }}</span>
            </div>
        </div>
    </div>

    <!-- Tabel Rincian Resi Muatan -->
    <table class="cargo-table">
        <thead>
            <tr>
                <th style="width: 28px;" class="text-center">No</th>
                <th style="width: 100px;">No. Resi (AWB)</th>
                <th>Pengirim</th>
                <th>Penerima & Alamat Tujuan</th>
                <th style="width: 50px;" class="text-center">Koli</th>
                <th style="width: 65px;" class="text-right">Berat (Kg)</th>
                <th style="width: 60px;" class="text-center">Bayar</th>
                <th>Keterangan / Komoditi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $calcColly = 0;
                $calcWeight = 0;
            @endphp
            @forelse($manifest->items as $idx => $item)
                @php
                    $shipment = $item->shipment;
                    $calcColly += $shipment?->total_colly ?? 0;
                    $calcWeight += $shipment?->chargeable_weight ?: ($shipment?->actual_weight ?? 0);
                @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td style="font-weight: 800; font-family: monospace;">{{ $shipment?->tracking_number ?? '-' }}</td>
                    <td>
                        <strong>{{ $shipment?->sender_name }}</strong><br>
                        <span style="font-size: 8.5px; color: #64748b;">{{ $shipment?->origin_city }}</span>
                    </td>
                    <td>
                        <strong>{{ $shipment?->receiver_name }}</strong><br>
                        <span style="font-size: 8.5px; color: #64748b;">{{ $shipment?->destination_city }}</span>
                    </td>
                    <td class="text-center" style="font-weight: 700;">{{ $shipment?->total_colly ?? 1 }}</td>
                    <td class="text-right" style="font-weight: 700;">{{ number_format($shipment?->chargeable_weight ?: $shipment?->actual_weight, 1) }}</td>
                    <td class="text-center">
                        <span style="font-weight: 700; font-size: 8.5px;">{{ $shipment?->payment_type }}</span>
                    </td>
                    <td style="font-size: 9px;">
                        {{ $shipment?->notes ?: ($shipment?->items->first()?->item_name ?? '-') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 16px; color: #94a3b8;">
                        Belum ada item resi yang dimanifestasikan pada surat jalan ini.
                    </td>
                </tr>
            @endforelse

            <!-- Total Row -->
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL MUATAN:</td>
                <td class="text-center">{{ $manifest->total_colly ?: $calcColly }} Koli</td>
                <td class="text-right">{{ number_format($manifest->total_weight ?: $calcWeight, 1) }} Kg</td>
                <td colspan="2">({{ $manifest->items->count() }} Resi)</td>
            </tr>
        </tbody>
    </table>

    <!-- Tanda Tangan 3 Pihak -->
    <div class="signature-section">
        <div class="sig-box">
            <div class="sig-role">Diserahkan Oleh<br>(Checker Hub Asal)</div>
            <div class="sig-name">{{ $manifest->createdBy?->name ?? 'Petugas Asal' }}</div>
        </div>
        <div class="sig-box">
            <div class="sig-role">Dibawa Oleh<br>(Driver / Supir Ekspedisi)</div>
            <div class="sig-name">{{ $manifest->driver_name ?: 'Pengemudi' }}</div>
        </div>
        <div class="sig-box">
            <div class="sig-role">Diterima Oleh<br>(Checker Hub Tujuan)</div>
            <div class="sig-name">( ........................................ )</div>
        </div>
    </div>
</div>

</body>
</html>
