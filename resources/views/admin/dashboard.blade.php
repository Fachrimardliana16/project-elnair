@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('styles')
<style>
    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, var(--brand-dark) 0%, #1a6e78 100%);
        border-radius: 20px;
        padding: 2.5rem 3rem;
        color: white;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(13, 76, 84, 0.2);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .welcome-banner::after {
        content: '\f0f6';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 5%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 8rem;
        color: rgba(255, 255, 255, 0.05);
        pointer-events: none;
    }

    .welcome-banner h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-family: 'Playfair Display', serif;
    }

    .welcome-banner p {
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.85);
        max-width: 600px;
        line-height: 1.5;
    }

    /* Stats Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.02);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        border-color: rgba(13, 76, 84, 0.1);
    }

    .stat-icon {
        width: 65px;
        height: 65px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.08) rotate(3deg);
    }

    .stat-info h4 {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1f2937;
        line-height: 1.2;
        margin-bottom: 0.2rem;
        font-family: 'Outfit', sans-serif;
    }

    .stat-info p {
        color: #6b7280;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    /* Table Container */
    .recent-table-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        padding: 2rem;
        border: 1px solid rgba(0, 0, 0, 0.02);
        margin-bottom: 2rem;
    }

    .recent-table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .recent-table-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--brand-dark);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .recent-table-title i {
        color: var(--brand-gold);
        background: rgba(139, 94, 60, 0.1);
        padding: 10px;
        border-radius: 10px;
        font-size: 1rem;
    }

    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
        margin-top: -8px;
    }

    .modern-table th {
        background: transparent;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 0.75rem 1rem;
        border: none;
    }

    .modern-table tbody tr {
        background: #f8fafc;
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: #f1f5f9;
        transform: scale(1.002);
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }

    .modern-table td {
        padding: 1rem;
        border: none;
        vertical-align: middle;
        font-size: 0.95rem;
    }

    .modern-table tbody tr td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
        font-weight: 600;
        color: #1f2937;
    }

    .modern-table tbody tr td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.35rem 0.85rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .status-deal { background: rgba(16, 185, 129, 0.15); color: #059669; }
    .status-cancel { background: rgba(239, 68, 68, 0.15); color: #dc2626; }
    .status-follow_up { background: rgba(245, 158, 11, 0.15); color: #d97706; }
    .status-new { background: rgba(59, 130, 246, 0.15); color: #2563eb; }
    
    .link-primary {
        color: var(--brand-dark);
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }
    
    .link-primary:hover {
        color: var(--brand-gold);
    }
</style>
@endsection

@section('content')

<!-- Welcome Banner -->
<div class="welcome-banner">
    <h2>Selamat Datang kembali, {{ Auth::user()->name }}!</h2>
    <p>Ini adalah ikhtisar performa website dan data jamaah Anda. Pantau aktivitas pengunjung, konversi, dan ringkasan platform di sini.</p>
</div>

<!-- Key Metrics Grid -->
<div class="dashboard-grid">
    <!-- Visitors Stats -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(59, 130, 246, 0.12); color: #3b82f6;">
            <i class="fas fa-eye"></i>
        </div>
        <div class="stat-info">
            <h4>{{ number_format($visitorsToday) }}</h4>
            <p>Visitor Hari Ini</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="stat-info">
            <h4>{{ number_format($totalVisitors) }}</h4>
            <p>Total Visitor</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(139, 92, 246, 0.12); color: #8b5cf6;">
            <i class="fas fa-mouse-pointer"></i>
        </div>
        <div class="stat-info">
            <h4>{{ number_format($totalHits) }}</h4>
            <p>Total Page Views</p>
        </div>
    </div>

    <!-- Leads Stats -->
    @can('manage_leads')
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(245, 158, 11, 0.12); color: #d97706;">
            <i class="fas fa-user-clock"></i>
        </div>
        <div class="stat-info">
            <h4>{{ number_format($leadsThisMonth) }}</h4>
            <p>Leads Bulan Ini</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.12); color: #059669;">
            <i class="fas fa-handshake"></i>
        </div>
        <div class="stat-info">
            <h4>{{ number_format($dealsThisMonth) }}</h4>
            <p>Deal Bulan Ini</p>
        </div>
    </div>
    @endcan

    <!-- Content & Admin Stats -->
    @can('manage_packages')
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(13, 76, 84, 0.12); color: var(--brand-dark);">
            <i class="fas fa-kaaba"></i>
        </div>
        <div class="stat-info">
            <h4>{{ number_format($activePackages) }}</h4>
            <p>Paket Aktif</p>
        </div>
    </div>
    @endcan

    @can('manage_articles')
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(13, 76, 84, 0.12); color: var(--brand-dark);">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="stat-info">
            <h4>{{ number_format($publishedArticles) }}</h4>
            <p>Artikel Publish</p>
        </div>
    </div>
    @endcan

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(139, 94, 60, 0.12); color: var(--brand-gold);">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="stat-info">
            <h4>{{ number_format($totalUsers) }}</h4>
            <p>Total Admin</p>
        </div>
    </div>
</div>

<!-- Recent Activity / Leads -->
@can('manage_leads')
@if($recentLeads->isNotEmpty())
<div class="recent-table-container">
    <div class="recent-table-header">
        <div class="recent-table-title">
            <i class="fas fa-bell"></i>
            Lead Landing Page Terbaru
        </div>
        <a href="{{ route('admin.landing-pages.leads.index') }}" class="btn-admin-outline">
            Lihat Semua <i class="fas fa-arrow-right" style="font-size: 0.8rem; margin-left: 5px;"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Nama Calon Jamaah</th>
                    <th>WhatsApp</th>
                    <th>Sumber Halaman</th>
                    <th>Waktu Masuk</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentLeads as $lead)
                @php
                    $statusClass = 'status-new';
                    if($lead->status === 'deal') $statusClass = 'status-deal';
                    if($lead->status === 'cancel') $statusClass = 'status-cancel';
                    if(in_array($lead->status, ['follow_up', 'fu'])) $statusClass = 'status-follow_up';
                @endphp
                <tr>
                    <td>{{ $lead->name }}</td>
                    <td>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" class="link-primary">
                            {{ $lead->phone }}
                        </a>
                    </td>
                    <td><span style="color: #6b7280; font-weight: 500;">{{ $lead->landingPage?->title ?? '-' }}</span></td>
                    <td><span style="color: #6b7280; font-size: 0.85rem;"><i class="far fa-clock" style="margin-right: 4px;"></i> {{ $lead->created_at->diffForHumans() }}</span></td>
                    <td>
                        <span class="status-pill {{ $statusClass }}">
                            {{ strtoupper($lead->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endcan

@endsection
