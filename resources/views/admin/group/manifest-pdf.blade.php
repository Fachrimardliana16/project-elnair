<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manifest Rombongan - {{ $group->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #0D4C54;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #0D4C54;
            font-size: 18px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            font-size: 11px;
            color: #666;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .info-table td.label {
            font-weight: bold;
            color: #555;
            width: 18%;
        }
        .info-table td.value {
            color: #111;
        }
        .manifest-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .manifest-table th {
            background-color: #0D4C54;
            color: white;
            padding: 8px;
            font-weight: bold;
            text-align: left;
            border: 1px solid #0D4C54;
        }
        .manifest-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .manifest-table tr:nth-child(even) {
            background-color: #fcfcfc;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Manifest Rombongan Jemaah</h1>
        <p>Elnair Travel — Portal Manajemen Operasional Haji & Umrah Resmi</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Rombongan</td>
            <td class="value">: {{ $group->name }}</td>
            <td class="label">Kode Booking PNR</td>
            <td class="value">: <strong>{{ $group->booking_code ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="label">Jadwal Berangkat</td>
            <td class="value">: {{ $group->departureSchedule ? $group->departureSchedule->departure_date->format('d M Y') : '-' }}</td>
            <td class="label">Kode Penerbangan</td>
            <td class="value">: {{ $group->flight_code ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Muthowif</td>
            <td class="value">: {{ $group->muthowif ?? '-' }}</td>
            <td class="label">Rute Transit</td>
            <td class="value">: {{ $group->flight_transit ?? 'Direct (Tanpa Transit)' }}</td>
        </tr>
        <tr>
            <td class="label">Pembimbing</td>
            <td class="value">: {{ $group->pembimbing ?? '-' }}</td>
            <td class="label">Bus Rombongan</td>
            <td class="value">: {{ $group->bus_number ?? '-' }}</td>
        </tr>
    </table>

    <h3 style="color: #0D4C54; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-top: 15px;">Daftar Manifest Jemaah (Total: {{ $group->jamaahs->count() }} Jemaah)</h3>
    
    <table class="manifest-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Nama Lengkap (Sesuai Paspor)</th>
                <th style="width: 10%;">L/P</th>
                <th style="width: 25%;">No. Paspor / Kadaluwarsa</th>
                <th style="width: 15%;">Tipe Kamar</th>
                <th style="width: 15%;">Kontak WhatsApp</th>
            </tr>
        </thead>
        <tbody>
            @forelse($group->jamaahs as $index => $jamaah)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="font-weight: bold;">
                    {{ $jamaah->passport_name ?? $jamaah->name }}
                    @if($jamaah->passport_name && $jamaah->passport_name !== $jamaah->name)
                        <br><span style="font-size: 9px; font-weight: normal; color: #666;">(Nama KTP: {{ $jamaah->name }})</span>
                    @endif
                </td>
                <td>{{ $jamaah->gender === 'Laki-laki' ? 'L' : 'P' }}</td>
                <td>
                    <strong>{{ $jamaah->passport_number ?? 'Belum Diisi' }}</strong>
                    @if($jamaah->passport_expiry)
                        <br><span style="font-size: 9px; color: #666;">Exp: {{ \Carbon\Carbon::parse($jamaah->passport_expiry)->format('d M Y') }}</span>
                    @endif
                </td>
                <td>{{ $jamaah->room_type }}</td>
                <td>{{ $jamaah->whatsapp }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #999; padding: 20px;">Belum ada jemaah yang masuk dalam rombongan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini diunduh secara otomatis dari Panel Admin Elnair Travel pada tanggal {{ date('d M Y H:i') }}.
    </div>

</body>
</html>
