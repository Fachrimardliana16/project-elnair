<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kuitansi Pembayaran - #{{ $payment->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 10px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0D4C54;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #0D4C54;
            margin: 0;
            text-transform: uppercase;
        }
        .company-details {
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .title-receipt {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #0D4C54;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 20px 0;
            text-decoration: underline;
        }
        .receipt-body {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        .receipt-body td {
            padding: 8px 5px;
            vertical-align: top;
        }
        .receipt-body td.label {
            font-weight: bold;
            color: #555;
            width: 25%;
            border-bottom: 1px dotted #ccc;
        }
        .receipt-body td.value {
            color: #111;
            border-bottom: 1px dotted #ccc;
        }
        .amount-box {
            background-color: #f2f7f7;
            border: 2px solid #0D4C54;
            color: #0D4C54;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            display: inline-block;
            margin-top: 10px;
            border-radius: 4px;
        }
        .signature-table {
            width: 100%;
            margin-top: 50px;
        }
        .signature-title {
            font-size: 11px;
            color: #666;
            margin-bottom: 60px;
            text-align: center;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td>
                    <div class="logo-text">Elnair Travel</div>
                    <span style="font-size: 10px; color: #8B5E3C; font-weight: bold; letter-spacing: 1px;">HAJI & UMRAH EXCLUSIVE</span>
                </td>
                <td class="company-details">
                    <strong>PT. Elnair Travel Wisata</strong><br>
                    Gedung Elnair Lt. 2, Kebayoran Baru<br>
                    Jakarta Selatan, DKI Jakarta<br>
                    WhatsApp: 0812-3456-7890 | Email: finance@elnairtravel.com
                </td>
            </tr>
        </table>

        <!-- Receipt Title -->
        <div class="title-receipt">Kuitansi Pembayaran Resmi</div>

        <!-- Receipt Metadata -->
        <table style="width: 100%; margin-bottom: 15px; font-size: 11px; color: #555;">
            <tr>
                <td>No. Kuitansi: <strong>#ELN-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                <td style="text-align: right;">Tanggal Cetak: {{ date('d M Y') }}</td>
            </tr>
        </table>

        <!-- Receipt Form Fields -->
        <table class="receipt-body">
            <tr>
                <td class="label">Telah Diterima Dari</td>
                <td class="value">: <strong>{{ $payment->jamaah->name ?? 'Jemaah' }}</strong></td>
            </tr>
            <tr>
                <td class="label">Untuk Pembayaran</td>
                <td class="value">: {{ $payment->type }} - Paket Umrah/Haji: <strong>{{ $payment->jamaah->package->title ?? 'Custom Paket' }}</strong></td>
            </tr>
            <tr>
                <td class="label">Tanggal Bayar</td>
                <td class="value">: {{ $payment->payment_date->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Metode Pembayaran</td>
                <td class="value">: Transfer Bank (Bukti Terlampir & Tervalidasi Sistem)</td>
            </tr>
            <tr>
                <td class="label">Terbilang</td>
                <td class="value" style="font-style: italic;">: — Rupiah —</td>
            </tr>
        </table>

        <!-- Amount Box and Signature -->
        <table style="width: 100%;">
            <tr>
                <td style="width: 60%; vertical-align: middle;">
                    <span style="font-size: 11px; color: #666; font-weight: bold;">Jumlah Pembayaran:</span><br>
                    <div class="amount-box">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }},-
                    </div>
                </td>
                <td style="width: 40%; text-align: center;">
                    <div class="signature-title">Jakarta, {{ $payment->payment_date->format('d M Y') }}<br>Kasir / Bagian Keuangan</div>
                    <div style="height: 50px;"></div> <!-- Space for signature stamp -->
                    <div class="signature-name">Elnair Finance Team</div>
                    <span style="font-size: 9px; color: #888;">Validasi Elektronik Aman</span>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
