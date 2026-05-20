@extends('admin.layouts.app')
@section('title', 'Campaign Leads & Marketing ROI')
@section('page_title', 'Marketer Command Center')

@section('content')
<!-- CDN Chart.js & FontAwesome for Premium Visuals -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@include('admin.landing-pages.partials._styles')

<!-- Top Global Filters Bar -->
@include('admin.landing-pages.partials._filters')

<!-- Dynamic KPI Metrik ROI Grid -->
@include('admin.landing-pages.partials._metrics')

<!-- Tab Navigation Bar -->
<div class="tab-nav">
    <button class="tab-btn active" onclick="switchTab(event, 'tab-crm')"><i class="fas fa-address-book"></i> Leads CRM</button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-roi')"><i class="fas fa-chart-line"></i> ROI Insights</button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-api')"><i class="fas fa-plug"></i> Integrasi API ({{ $adAccounts->count() }})</button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-manual')"><i class="fas fa-pencil-alt"></i> Input Manual Biaya</button>
    <button class="tab-btn" onclick="switchTab(event, 'tab-tutorial')"><i class="fas fa-book-open"></i> Panduan API</button>
</div>

<!-- ==========================================
     TAB 1: LEADS CRM
     ========================================== -->
@include('admin.landing-pages.partials._tab_crm')

<!-- ==========================================
     TAB 2: ROI INSIGHTS
     ========================================== -->
@include('admin.landing-pages.partials._tab_roi')

<!-- ==========================================
     TAB 3: INTEGRASI API ACCOUNTS
     ========================================== -->
@include('admin.landing-pages.partials._tab_api')

<!-- ==========================================
     TAB 4: MANUAL SPEND ENTRY
     ========================================== -->
@include('admin.landing-pages.partials._tab_manual')

<!-- ==========================================
     TAB 5: API TUTORIAL & GUIDES
     ========================================== -->
@include('admin.landing-pages.partials._tab_tutorial')

<!-- ==========================================
     MODAL CONNECT AD ACCOUNT POP-UP (TAB 3)
     ========================================== -->
@include('admin.landing-pages.partials._modal_connect')

<!-- Dynamic JavaScript Controls -->
@include('admin.landing-pages.partials._scripts')

@endsection
