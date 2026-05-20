<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Elnair Marketing ROI Performance Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 3px solid #0d4c54;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .company-title {
            font-size: 20px;
            font-weight: bold;
            color: #0d4c54;
            letter-spacing: 0.5px;
            margin: 0;
            text-transform: uppercase;
        }
        .report-title {
            font-size: 13px;
            color: #475569;
            margin: 4px 0 0 0;
            font-weight: 500;
        }
        .meta-info {
            float: right;
            text-align: right;
            font-size: 10px;
            color: #64748b;
        }
        .clearfix {
            clear: both;
        }
        .period-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 15px;
            margin-bottom: 25px;
            font-size: 11px;
        }
        .period-box table {
            width: 100%;
        }
        .period-box td {
            padding: 2px 0;
        }

        /* KPI Cards Grid */
        .kpi-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .kpi-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            width: 23%;
        }
        .kpi-title {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .kpi-value {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
        }

        /* Section Headings */
        .section-heading {
            font-size: 12px;
            font-weight: bold;
            color: #0d4c54;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        /* Tables styling */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .data-table th {
            background-color: #f8fafc;
            border-bottom: 2px solid #cbd5e1;
            color: #475569;
            font-weight: bold;
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }
        .data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }
        .status-pending { background-color: #fef3c7; color: #d97706; }
        .status-followed_up { background-color: #dbeafe; color: #2563eb; }
        .status-deal { background-color: #d1fae5; color: #059669; }
        .status-cancel { background-color: #fee2e2; color: #dc2626; }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="header">
        <div class="meta-info">
            <strong>Tanggal Cetak:</strong> {{ now()->format('d M Y H:i') }}<br>
            <strong>Status Dokumen:</strong> Rahasia Perusahaan
        </div>
        <h1 class="company-title">Elnair Premium Travel</h1>
        <div class="report-title">Laporan Analisis ROI & Kinerja Iklan Pemasaran</div>
        <div class="clearfix"></div>
    </div>

    <!-- Meta Details Box -->
    <div class="period-box">
        <table cellspacing="0" cellpadding="0">
            <tr>
                <td width="15%" style="font-weight: bold; color: #64748b;">Halaman Iklan:</td>
                <td width="35%">{{ $landingPageTitle }}</td>
                <td width="15%" style="font-weight: bold; color: #64748b;">Metode Sync:</td>
                <td width="35%">Otomatis API & Input Manual</td>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #64748b;">Rentang Laporan:</td>
                <td>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s.d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</td>
                <td style="font-weight: bold; color: #64748b;">Status Laporan:</td>
                <td><span style="color: #059669; font-weight: bold;">Aktif & Terverifikasi</span></td>
            </tr>
        </table>
    </div>

    <!-- KPI Summary Grid -->
    <div class="section-heading">Ringkasan Finansial & Konversi Iklan</div>
    <table class="kpi-table" cellspacing="10" cellpadding="0">
        <tr>
            <td class="kpi-card" style="border-left: 3px solid #3b82f6;">
                <div class="kpi-title">Total Leads Masuk</div>
                <div class="kpi-value">{{ $totalLeads }} Prospek</div>
            </td>
            <td class="kpi-card" style="border-left: 3px solid #d97706;">
                <div class="kpi-title">Total Pengeluaran Iklan</div>
                <div class="kpi-value">Rp {{ number_format($totalSpend, 0, ',', '.') }}</div>
            </td>
            <td class="kpi-card" style="border-left: 3px solid #0d4c54;">
                <div class="kpi-title">Rata-Rata CPL</div>
                <div class="kpi-value" style="color: #0d4c54;">Rp {{ number_format($cpl, 0, ',', '.') }}</div>
            </td>
            <td class="kpi-card" style="border-left: 3px solid #059669;">
                <div class="kpi-title">Rasio Closing (Deal)</div>
                <div class="kpi-value" style="color: #059669;">{{ number_format($dealRate, 1) }}%</div>
            </td>
        </tr>
    </table>

    <!-- Funnel Analytics Section -->
    <div class="section-heading">Analisis Corong Konversi (Funneling Performance)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="25%">Metrik Corong</th>
                <th width="25%" style="text-align: right;">Volume Hasil</th>
                <th width="25%" style="text-align: right;">Rasio (%)</th>
                <th width="25%">Deskripsi Kinerja</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: bold;">Impression (Tayangan Iklan)</td>
                <td style="text-align: right;">{{ number_format($totalImpressions, 0, ',', '.') }}</td>
                <td style="text-align: right; color: #64748b;">-</td>
                <td>Jumlah iklan tampil di feed audiens target.</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Clicks (Klik Link Iklan)</td>
                <td style="text-align: right;">{{ number_format($totalClicks, 0, ',', '.') }}</td>
                <td style="text-align: right; font-weight: bold; color: #2563eb;">CTR: {{ number_format($ctr, 2) }}%</td>
                <td>Rasio minat audiens mengeklik tombol iklan.</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Leads (WhatsApp Form)</td>
                <td style="text-align: right;">{{ number_format($totalLeads, 0, ',', '.') }}</td>
                <td style="text-align: right; font-weight: bold; color: #0d4c54;">CVR: {{ number_format($cvr, 2) }}%</td>
                <td>Rasio prospek mendaftar dari jumlah klik.</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Closing / Deal (Jamaah Fix)</td>
                <td style="text-align: right;">{{ number_format($dealLeads, 0, ',', '.') }}</td>
                <td style="text-align: right; font-weight: bold; color: #059669;">Deal: {{ number_format($dealRate, 1) }}%</td>
                <td>Persentase konversi akhir menjadi transaksi riil.</td>
            </tr>
        </tbody>
    </table>

    <!-- Detailed Ledger Section -->
    <div class="section-heading" style="margin-top: 15px;">Daftar Detail Prospek Kampanye (Campaign Leads Ledger)</div>
    @if($leads->isEmpty())
        <div style="text-align: center; padding: 20px; color: #64748b; border: 1px solid #e2e8f0; border-radius: 6px;">
            Tidak ada data leads yang tercatat untuk kriteria filter ini.
        </div>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th width="20%">Nama Calon</th>
                    <th width="15%">No WhatsApp</th>
                    <th width="25%">Landing Page Sumber</th>
                    <th width="15%">Pilihan Paket</th>
                    <th width="10%" style="text-align: center;">Status CS</th>
                    <th width="15%" style="text-align: center;">Tanggal Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                <tr>
                    <td style="font-weight: bold;">{{ $lead->name }}</td>
                    <td>{{ $lead->phone }}</td>
                    <td>{{ $lead->landingPage ? $lead->landingPage->title : '-' }}</td>
                    <td style="font-weight: bold;">{{ $lead->package ?? '-' }}</td>
                    <td style="text-align: center;">
                        <span class="status-badge status-{{ $lead->status }}">
                            {{ $lead->status == 'followed_up' ? 'Follow Up' : $lead->status }}
                        </span>
                    </td>
                    <td style="text-align: center; font-size: 9px; color: #64748b;">
                        {{ $lead->created_at->format('d M Y H:i') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Footer Document -->
    <div class="footer">
        Laporan Keuangan ROI Iklan & Leads ini digenerate secara otomatis oleh Elnair Premium Marketing Platform.<br>
        Halaman 1 dari 1 — Hak Cipta Terpelihara Elnair Premium Travel.
    </div>

</body>
</html>
