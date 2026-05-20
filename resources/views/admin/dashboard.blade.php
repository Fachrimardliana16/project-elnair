@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    @can('manage_packages')
    <div class="admin-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 60px; height: 60px; background: rgba(13, 76, 84, 0.1); color: var(--brand-dark); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-kaaba"></i>
        </div>
        <div>
            <h4 style="font-size: 1.5rem; font-weight: 700;">{{ $activePackages }}</h4>
            <p style="color: #888; font-size: 0.9rem;">Paket Aktif</p>
        </div>
    </div>
    @endcan

    @can('manage_leads')
    <div class="admin-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 60px; height: 60px; background: rgba(139, 94, 60, 0.1); color: var(--brand-gold); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <h4 style="font-size: 1.5rem; font-weight: 700;">{{ $leadsThisMonth }}</h4>
            <p style="color: #888; font-size: 0.9rem;">Leads Bulan Ini</p>
        </div>
    </div>

    <div class="admin-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 60px; height: 60px; background: rgba(22, 163, 74, 0.1); color: #16a34a; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-handshake"></i>
        </div>
        <div>
            <h4 style="font-size: 1.5rem; font-weight: 700;">{{ $dealsThisMonth }}</h4>
            <p style="color: #888; font-size: 0.9rem;">Deal Bulan Ini</p>
        </div>
    </div>
    @endcan

    @can('manage_articles')
    <div class="admin-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 60px; height: 60px; background: rgba(13, 76, 84, 0.1); color: var(--brand-dark); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-newspaper"></i>
        </div>
        <div>
            <h4 style="font-size: 1.5rem; font-weight: 700;">{{ $publishedArticles }}</h4>
            <p style="color: #888; font-size: 0.9rem;">Artikel Published</p>
        </div>
    </div>
    @endcan

    <div class="admin-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 60px; height: 60px; background: rgba(139, 94, 60, 0.1); color: var(--brand-gold); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-user-shield"></i>
        </div>
        <div>
            <h4 style="font-size: 1.5rem; font-weight: 700;">{{ $totalUsers }}</h4>
            <p style="color: #888; font-size: 0.9rem;">Total Admin</p>
        </div>
    </div>
</div>

@can('manage_leads')
@if($recentLeads->isNotEmpty())
<div class="admin-card" style="margin-bottom: 2rem;">
    <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--brand-dark);">
        <i class="fas fa-bell" style="margin-right: 0.5rem; color: var(--brand-gold);"></i>
        Lead Terbaru
    </h3>
    <table style="width:100%; border-collapse: collapse; font-size: 0.875rem;">
        <thead>
            <tr style="border-bottom: 2px solid #f1f1f1;">
                <th style="text-align:left; padding: 0.5rem 0.75rem; color: #666;">Nama</th>
                <th style="text-align:left; padding: 0.5rem 0.75rem; color: #666;">WhatsApp</th>
                <th style="text-align:left; padding: 0.5rem 0.75rem; color: #666;">Landing Page</th>
                <th style="text-align:left; padding: 0.5rem 0.75rem; color: #666;">Status</th>
                <th style="text-align:left; padding: 0.5rem 0.75rem; color: #666;">Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentLeads as $lead)
            <tr style="border-bottom: 1px solid #f9f9f9;">
                <td style="padding: 0.5rem 0.75rem; font-weight: 600;">{{ $lead->name }}</td>
                <td style="padding: 0.5rem 0.75rem;">{{ $lead->phone }}</td>
                <td style="padding: 0.5rem 0.75rem; color: #888;">{{ $lead->landingPage?->title ?? '-' }}</td>
                <td style="padding: 0.5rem 0.75rem;">
                    <span style="padding: 2px 8px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;
                        background: {{ $lead->status === 'deal' ? 'rgba(22,163,74,0.1)' : ($lead->status === 'cancel' ? 'rgba(220,38,38,0.1)' : 'rgba(202,138,4,0.1)') }};
                        color: {{ $lead->status === 'deal' ? '#16a34a' : ($lead->status === 'cancel' ? '#dc2626' : '#ca8a04') }};">
                        {{ strtoupper($lead->status) }}
                    </span>
                </td>
                <td style="padding: 0.5rem 0.75rem; color: #888; font-size: 0.8rem;">{{ $lead->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 1rem;">
        <a href="{{ route('admin.landing-pages.leads.index') }}" class="btn-admin-outline" style="font-size: 0.85rem;">Lihat Semua Leads →</a>
    </div>
</div>
@endif
@endcan

@endsection

