<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Thermal - {{ $shipment->tracking_number }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        @page {
            size: 100mm 150mm;
            margin: 2.5mm;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #000;
            background: #fff;
            line-height: 1.25;
            padding: 3px;
        }
        .no-print-bar {
            background: #1e293b;
            color: #fff;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            border-radius: 8px;
            margin-bottom: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        .btn-print {
            background: #c5161d;
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-pdf {
            background: #1d58cd;
            color: #fff;
            text-decoration: none;
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
        }
        .label-wrapper {
            width: 95mm;
            max-width: 100%;
            margin: 0 auto;
            border: 2px solid #000;
            background: #fff;
        }
        .header {
            border-bottom: 2px solid #000;
            padding: 6px 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand-name {
            font-size: 17px;
            font-weight: 900;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        .brand-sub {
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .route-badge {
            border: 2px solid #000;
            padding: 3px 6px;
            text-align: center;
            font-weight: 900;
            font-size: 13px;
            background: #000;
            color: #fff;
            border-radius: 4px;
        }
        .barcode-section {
            border-bottom: 2px solid #000;
            padding: 8px 6px;
            text-align: center;
        }
        .tracking-title {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: 1.5px;
            font-family: monospace;
            margin-bottom: 4px;
        }
        .barcode-img {
            max-width: 90%;
            height: 44px;
            display: block;
            margin: 0 auto 3px;
        }
        .service-info {
            font-size: 9px;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            padding: 0 4px;
        }
        .address-box {
            border-bottom: 1.5px solid #000;
            padding: 6px;
        }
        .address-title {
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            border-bottom: 1px dashed #000;
            padding-bottom: 2px;
            margin-bottom: 4px;
            color: #333;
        }
        .receiver-name {
            font-size: 13px;
            font-weight: 900;
            margin-bottom: 2px;
        }
        .receiver-phone {
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 3px;
        }
        .receiver-address {
            font-size: 10px;
            line-height: 1.25;
            font-weight: 500;
        }
        .dest-city-highlight {
            font-size: 11px;
            font-weight: 900;
            margin-top: 3px;
            text-transform: uppercase;
            background: #eee;
            padding: 2px 4px;
            display: inline-block;
            border: 1px solid #000;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1.5px solid #000;
            font-size: 10px;
        }
        .details-table td, .details-table th {
            border-right: 1px solid #000;
            padding: 4px 5px;
            text-align: center;
        }
        .details-table td:last-child, .details-table th:last-child {
            border-right: none;
        }
        .details-table th {
            background: #f0f0f0;
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .details-table td {
            font-weight: 700;
            font-size: 11px;
        }
        .payment-section {
            border-bottom: 2px solid #000;
            padding: 6px 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafafa;
        }
        .pay-type {
            font-size: 14px;
            font-weight: 900;
            border: 1.5px solid #000;
            padding: 2px 8px;
            display: inline-block;
            background: #000;
            color: #fff;
            border-radius: 3px;
        }
        .pay-amount {
            font-size: 14px;
            font-weight: 900;
            text-align: right;
        }
        .footer-section {
            padding: 6px;
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .qr-box {
            text-align: center;
        }
        .qr-img {
            width: 58px;
            height: 58px;
            display: block;
        }
        .sign-grid {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px;
            font-size: 8px;
            text-align: center;
        }
        .sign-box {
            border: 1px solid #000;
            padding: 2px;
            height: 58px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .disclaimer {
            border-top: 1px solid #000;
            font-size: 6.5px;
            line-height: 1.15;
            padding: 3px 6px;
            color: #444;
            text-align: center;
        }
        @media print {
            .no-print-bar {
                display: none !important;
            }
            body {
                padding: 0;
                background: none;
            }
            .label-wrapper {
                border: 2px solid #000;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

@if(!$isPdf)
<div class="no-print-bar">
    <div>
        <strong>Cetak Resi Pengiriman (Thermal AWB)</strong>
        <span style="font-size: 11px; opacity: 0.8; margin-left: 8px;">100mm x 150mm Label Sticker</span>
    </div>
    <div style="display: flex; gap: 8px; align-items: center;">
        <a href="{{ route('print.resi', ['shipment' => $shipment->id, 'format' => 'pdf']) }}" class="btn-pdf">📥 Unduh PDF</a>
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Sekarang</button>
    </div>
</div>
@endif

<div class="label-wrapper">
    <!-- Header -->
    <div class="header">
        <div>
            <div class="brand-name">ANDEX CARGO</div>
            <div class="brand-sub">Express & Logistic Services</div>
        </div>
        <div style="text-align: right;">
            <div class="route-badge">
                {{ $shipment->originBranch?->code ?? substr($shipment->origin_city, 0, 3) }} ➔ {{ $shipment->destinationBranch?->code ?? substr($shipment->destination_city, 0, 3) }}
            </div>
            <div style="font-size: 8px; font-weight: 700; margin-top: 2px;">
                {{ $shipment->service?->transport_type ?? 'DARAT' }} / {{ $shipment->service?->name ?? 'REGULER' }}
            </div>
        </div>
    </div>

    <!-- Barcode & Tracking Number -->
    <div class="barcode-section">
        <div class="tracking-title">{{ $shipment->tracking_number }}</div>
        <img class="barcode-img" src="data:image/png;base64,{{ $barcodePng }}" alt="Barcode">
        <div class="service-info">
            <span>Tgl: {{ $shipment->created_at->format('d/m/Y H:i') }}</span>
            <span>Asal: {{ $shipment->origin_city }}</span>
            <span>Rute: {{ $shipment->destination_city }}</span>
        </div>
    </div>

    <!-- Penerima (Utama) -->
    <div class="address-box" style="background: #fff;">
        <div class="address-title">PENERIMA / CONSIGNEE</div>
        <div class="receiver-name">{{ $shipment->receiver_name }}</div>
        <div class="receiver-phone">📞 {{ $shipment->receiver_phone }}</div>
        <div class="receiver-address">{{ $shipment->receiver_address }}</div>
        <div class="dest-city-highlight">TUJUAN: {{ $shipment->destination_city }}</div>
    </div>

    <!-- Pengirim -->
    <div class="address-box" style="padding: 4px 6px;">
        <div class="address-title">PENGIRIM / SHIPPER</div>
        <div style="font-size: 11px; font-weight: 700;">{{ $shipment->sender_name }} ({{ $shipment->sender_phone }})</div>
        <div style="font-size: 9px; color: #333;">{{ $shipment->sender_address ?: $shipment->origin_city }}</div>
    </div>

    <!-- Detail Muatan -->
    <table class="details-table">
        <thead>
            <tr>
                <th>Total Koli</th>
                <th>Berat Aktual</th>
                <th>Berat Ditagih</th>
                <th>Isi / Komoditi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $shipment->total_colly }} Koli</td>
                <td>{{ number_format($shipment->actual_weight, 1) }} Kg</td>
                <td>{{ number_format($shipment->chargeable_weight ?: $shipment->actual_weight, 1) }} Kg</td>
                <td style="font-size: 9px; max-width: 35mm; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $shipment->notes ?: ($shipment->items->first()?->item_name ?? 'Paket Kargo') }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Pembayaran -->
    <div class="payment-section">
        <div>
            <div style="font-size: 8px; font-weight: 700; text-transform: uppercase;">Metode Pembayaran</div>
            <div class="pay-type">{{ $shipment->payment_type }}</div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 8px; font-weight: 700; text-transform: uppercase;">Total Tarif Ongkir</div>
            <div class="pay-amount">Rp {{ number_format($shipment->total_cost, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- QR Code & Signature -->
    <div class="footer-section">
        <div class="qr-box">
            <img class="qr-img" src="data:image/png;base64,{{ $qrCodePng }}" alt="QR Tracking">
            <span style="font-size: 6.5px; font-weight: 700;">SCAN TRACK</span>
        </div>
        <div class="sign-grid">
            <div class="sign-box">
                <span>Pengirim / Checker</span>
                <span style="border-top: 1px dotted #000; font-size: 7px; padding-top: 1px;">( .................... )</span>
            </div>
            <div class="sign-box">
                <span>Penerima / Tanggal</span>
                <span style="border-top: 1px dotted #000; font-size: 7px; padding-top: 1px;">( .................... )</span>
            </div>
        </div>
    </div>

    <!-- Syarat & Ketentuan Singkat -->
    <div class="disclaimer">
        Barang kiriman tunduk pada ketentuan PT Andex Cargo. Klaim kehilangan/kerusakan maks. 1x24 jam sejak barang diterima disertai bukti fisik & resi asli. CS: 0811-444-2321.
    </div>
</div>

</body>
</html>
