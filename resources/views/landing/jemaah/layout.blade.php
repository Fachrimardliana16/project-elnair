@extends('landing.layouts.app')

@section('content')
<section class="jemaah-portal-section" style="padding: 100px 0 60px 0; background: linear-gradient(180deg, #FDFBF9 0%, #F5EFEB 100%); min-height: 100vh;">
    <!-- Dark mode style override for container -->
    <style>
        :root {
            --text-muted: rgba(26, 26, 26, 0.6);
            --bg-muted: rgba(0, 0, 0, 0.02);
            --border-muted: rgba(0, 0, 0, 0.05);
            --border-dashed: rgba(0, 0, 0, 0.06);
            --card-sub-bg: rgba(13, 76, 84, 0.03);
            --card-sub-border: rgba(13, 76, 84, 0.05);
            --portal-title-color: var(--brand-dark);
        }
        [data-theme="dark"] {
            --text-muted: rgba(226, 232, 233, 0.6);
            --bg-muted: rgba(255, 255, 255, 0.04);
            --border-muted: rgba(255, 255, 255, 0.08);
            --border-dashed: rgba(255, 255, 255, 0.1);
            --card-sub-bg: rgba(102, 165, 173, 0.05);
            --card-sub-border: rgba(102, 165, 173, 0.1);
            --portal-title-color: #E2E8E9;
        }
        [data-theme="dark"] .jemaah-portal-section {
            background: linear-gradient(180deg, #0C1517 0%, #060B0C 100%) !important;
        }
        .portal-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.95rem 1.25rem;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
            border-left: 3px solid transparent;
        }
        .portal-sidebar-nav a:hover {
            background: rgba(139, 94, 60, 0.08);
            color: var(--brand-gold);
            padding-left: 1.5rem;
        }
        .portal-sidebar-nav a.active {
            background: var(--gold-gradient);
            color: #fff;
            border-left-color: #fff;
            box-shadow: 0 8px 20px rgba(139, 94, 60, 0.2);
        }
        [data-theme="dark"] .portal-sidebar-nav a:hover {
            background: rgba(139, 94, 60, 0.15);
        }
        .portal-card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(13, 76, 84, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        [data-theme="dark"] .portal-card {
            background: #14201F;
            border-color: rgba(255, 255, 255, 0.05);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        }
        .badge-status {
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .badge-status.pending {
            background: rgba(243, 156, 18, 0.15);
            color: #f39c12;
        }
        .badge-status.dp {
            background: rgba(52, 152, 219, 0.15);
            color: #3498db;
        }
        .badge-status.lunas {
            background: rgba(46, 204, 113, 0.15);
            color: #2ecc71;
        }
        .badge-status.cancelled {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }
        @media (max-width: 991px) {
            .portal-grid {
                grid-template-columns: 1fr !important;
                gap: 1.5rem !important;
            }
            .portal-sidebar-nav {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            .portal-sidebar-nav a {
                margin-bottom: 0;
                flex: 1 1 calc(50% - 0.5rem);
                justify-content: center;
                border-left: none;
                border-bottom: 3px solid transparent;
            }
            .portal-sidebar-nav a.active {
                border-bottom-color: #fff;
            }
        }
        @media (max-width: 768px) {
            .portal-sidebar-nav {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 0.75rem !important;
            }
            .portal-sidebar-nav a {
                margin-bottom: 0 !important;
                padding: 1rem 0.5rem !important;
                font-size: 0.8rem !important;
                flex: none !important;
                justify-content: center !important;
                flex-direction: column !important;
                gap: 8px !important;
                border-left: none !important;
                border-bottom: none !important;
                text-align: center !important;
                border-radius: 16px !important;
            }
            .portal-sidebar-nav a i {
                font-size: 1.3rem !important;
            }
            .portal-sidebar-nav hr {
                display: none !important;
            }
        }

        /* Dashboard & Profile Premium Responsive Overrides */
        .dashboard-banner-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            align-items: center;
        }
        .dashboard-card-padding {
            padding: 2rem;
        }
        .dashboard-banner-padding {
            padding: 2.5rem;
        }
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            align-items: start;
        }
        @media (max-width: 768px) {
            .dashboard-banner-grid {
                grid-template-columns: 1fr !important;
                gap: 1.5rem !important;
                text-align: center;
            }
            .dashboard-banner-grid > div {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .dashboard-banner-grid > div:last-child {
                width: 100%;
                min-width: unset !important;
            }
            .dashboard-card-padding {
                padding: 1.25rem !important;
            }
            .dashboard-banner-padding {
                padding: 1.5rem !important;
            }
            .room-grid {
                grid-template-columns: 1fr !important;
                gap: 1.5rem !important;
            }
            .portal-grid {
                gap: 1.5rem !important;
            }
        }
    </style>

    <div class="container">
        <!-- Header Section -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span style="letter-spacing: 3px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.8rem; display: block; margin-bottom: 0.5rem;">Selamat Datang Kembali</span>
                <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(1.75rem, 4vw, 2.25rem); font-weight: 900; color: var(--portal-title-color);">
                    {{ $jemaah->name }}
                </h2>
                <div style="display: flex; align-items: center; gap: 8px; margin-top: 0.5rem;">
                    <span style="color: var(--text-muted); font-size: 0.85rem;" id="jemaah-status-txt">
                        NIK: {{ substr($jemaah->nik, 0, 4) . str_repeat('•', max(0, strlen($jemaah->nik) - 6)) . substr($jemaah->nik, -2) }} • Paket: <strong>{{ $jemaah->package ? $jemaah->package->title : 'Belum Memilih' }}</strong>
                    </span>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="badge-status {{ strtolower($jemaah->status) }}">
                    <i class="fas fa-info-circle"></i> Status Pendaftaran: {{ $jemaah->status }}
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="background: rgba(46, 204, 113, 0.12); border: 1px solid rgba(46, 204, 113, 0.2); color: #27ae60; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 2rem; font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle" style="font-size: 1.1rem;"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" style="background: rgba(231, 76, 60, 0.12); border: 1px solid rgba(231, 76, 60, 0.2); color: #c0392b; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 2rem; font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-circle" style="font-size: 1.1rem;"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <!-- Portal Grid -->
        <div class="portal-grid" style="display: grid; grid-template-columns: 280px 1fr; gap: 2.5rem; align-items: start;">
            <!-- Sidebar -->
            <aside class="portal-card" style="padding: 1.5rem;">
                <div class="portal-sidebar-nav">
                    <a href="{{ route('jemaah.dashboard') }}" class="{{ Route::is('jemaah.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard Anda
                    </a>
                    <a href="{{ route('jemaah.payments') }}" class="{{ Route::is('jemaah.payments') ? 'active' : '' }}">
                        <i class="fas fa-wallet"></i> Riwayat Keuangan
                    </a>
                    <a href="{{ route('jemaah.documents') }}" class="{{ Route::is('jemaah.documents') ? 'active' : '' }}">
                        <i class="fas fa-folder-open"></i> Kelola Dokumen
                    </a>
                    <a href="{{ route('jemaah.profile') }}" class="{{ Route::is('jemaah.profile') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i> Profil Lengkap
                    </a>
                    
                    <hr style="border: none; border-top: 1px solid rgba(0,0,0,0.06); margin: 1rem 0;">
                    
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #e74c3c;">
                        <i class="fas fa-sign-out-alt"></i> Keluar Portal
                    </a>
                    <form id="logout-form" action="{{ route('jemaah.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </aside>

            <!-- Main Workspace -->
            <main>
                @yield('portal-content')
            </main>
        </div>
    </div>
</section>
@endsection
