<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Tanda Terima - {{ $shipment->tracking_number }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        @page {
            size: A5 landscape;
            margin: 6mm 8mm;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #0f172a;
            background: #fff;
            padding: 10px;
        }
        .no-print-bar {
            background: #0f172a;
            color: #fff;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            border-radius: 8px;
            margin-bottom: 16px;
        }
        .btn-print {
            background: #1d58cd;
            color: #fff;
            border: none;
            padding: 7px 16px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-pdf {
            background: #475569;
            color: #fff;
            text-decoration: none;
            padding: 7px 12px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 6px;
        }
        .nota-box {
            border: 2px solid #0f172a;
            padding: 10px;
            background: #fff;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1.5px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .brand {
            font-size: 18px;
            font-weight: 900;
            color: #1d58cd;
        }
        .sub {
            font-size: 9px;
            color: #475569;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 8px;
        }
        .card-info {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            border-radius: 4px;
        }
        .card-info h4 {
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            border-bottom: 1px dashed #cbd5e1;
            padding-bottom: 2px;
            margin-bottom: 4px;
            color: #334155;
        }
        .table-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 9.5px;
        }
        .table-items th {
            background: #1e293b;
            color: #fff;
            padding: 5px;
            text-align: left;
            font-size: 8.5px;
            border: 1px solid #0f172a;
        }
        .table-items td {
            padding: 5px;
            border: 1px solid #cbd5e1;
        }
        .fin-grid {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f1f5f9;
            padding: 8px 12px;
            border: 1.5px solid #0f172a;
            margin-bottom: 8px;
        }
        .total-box {
            text-align: right;
        }
        .total-val {
            font-size: 16px;
            font-weight: 900;
            color: #1d58cd;
        }
        .sign-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            text-align: center;
            font-size: 9px;
        }
        @media print {
            .no-print-bar {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

@if(!$isPdf)
<div class="no-print-bar">
    <div>
        <strong>Nota Tanda Terima Kargo (Lembar Konsumen)</strong>
        <span style="font-size: 11px; opacity: 0.8; margin-left: 8px;">A5 Landscape</span>
    </div>
    <div style="display: flex; gap: 8px; align-items: center;">
        <a href="{{ route('print.nota', ['shipment' => $shipment->id, 'format' => 'pdf']) }}" class="btn-pdf">📥 Unduh PDF</a>
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Nota</button>
    </div>
</div>
@endif

<div class="nota-box">
    <div class="header">
        <div>
            <div class="brand">ANDEX CARGO</div>
            <div class="sub">TANDA TERIMA PENGIRIMAN RESMI</div>
            <div style="font-size: 8.5px; color: #64748b; margin-top: 2px;">
                Cabang: {{ $shipment->originBranch?->name ?? $shipment->origin_city }} | CS: 0811-444-2321
            </div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 14px; font-weight: 800; font-family: monospace;">{{ $shipment->tracking_number }}</div>
            <img src="data:image/png;base64,{{ $barcodePng }}" style="height: 28px; max-width: 160px; margin-top: 3px;" alt="Barcode">
            <div style="font-size: 8.5px; color: #475569;">{{ $shipment->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>

    <div class="grid-2">
        <div class="card-info">
            <h4>PENGIRIM (SHIPPER)</h4>
            <strong>{{ $shipment->sender_name }}</strong> ({{ $shipment->sender_phone }})<br>
            {{ $shipment->sender_address ?: $shipment->origin_city }}
        </div>
        <div class="card-info">
            <h4>PENERIMA (CONSIGNEE)</h4>
            <strong>{{ $shipment->receiver_name }}</strong> ({{ $shipment->receiver_phone }})<br>
            {{ $shipment->receiver_address }}<br>
            <strong>Tujuan: {{ $shipment->destination_city }}</strong>
        </div>
    </div>

    <table class="table-items">
        <thead>
            <tr>
                <th>Layanan</th>
                <th style="text-align: center;">Jumlah Koli</th>
                <th style="text-align: right;">Berat Aktual</th>
                <th style="text-align: right;">Berat Ditagih</th>
                <th style="text-align: right;">Tarif / Kg</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $shipment->service?->name ?? 'Reguler Kargo' }}</td>
                <td style="text-align: center;">{{ $shipment->total_colly }} Koli</td>
                <td style="text-align: right;">{{ number_format($shipment->actual_weight, 1) }} Kg</td>
                <td style="text-align: right; font-weight: 700;">{{ number_format($shipment->chargeable_weight ?: $shipment->actual_weight, 1) }} Kg</td>
                <td style="text-align: right;">Rp {{ number_format($shipment->tariff_per_kg, 0, ',', '.') }}</td>
                <td style="text-align: right; font-weight: 700;">Rp {{ number_format($shipment->shipping_cost, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="fin-grid">
        <div>
            <div style="font-size: 9px; font-weight: 700; text-transform: uppercase;">Metode Pembayaran</div>
            <div style="font-size: 13px; font-weight: 900;">{{ $shipment->payment_type }} ({{ $shipment->payment_status }})</div>
            <div style="font-size: 8.5px; color: #64748b;">Biaya Packing: Rp {{ number_format($shipment->packing_cost, 0, ',', '.') }} | Lain-lain: Rp {{ number_format($shipment->other_cost, 0, ',', '.') }}</div>
        </div>
        <div class="total-box">
            <div style="font-size: 9px; font-weight: 700; text-transform: uppercase;">Total Yang Dibayar</div>
            <div class="total-val">Rp {{ number_format($shipment->total_cost, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="sign-grid">
        <div>
            <div style="margin-bottom: 28px;">Pengirim</div>
            <div>( {{ $shipment->sender_name }} )</div>
        </div>
        <div>
            <div style="margin-bottom: 28px;">Petugas / Kasir Andex Cargo</div>
            <div>( ........................................ )</div>
        </div>
    </div>
</div>

</body>
</html>
