@extends('landing.jemaah.layout')

@section('portal-content')
<style>
    .profile-header-card {
        background: linear-gradient(135deg, var(--brand-dark) 0%, #062b30 100%);
        color: #fff;
        padding: 2.5rem;
        border-radius: 24px;
        position: relative;
        overflow: hidden;
        border: none;
        box-shadow: 0 15px 35px rgba(13, 76, 84, 0.15);
        margin-bottom: 2rem;
    }
    .profile-header-card::before {
        content: '\f2c2';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: -30px;
        bottom: -30px;
        font-size: 14rem;
        color: rgba(255, 255, 255, 0.03);
        pointer-events: none;
    }
    .profile-avatar-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--gold-gradient);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-weight: 800;
        border: 4px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        flex-shrink: 0;
    }
    .profile-header-content {
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    .profile-badge-pill {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .profile-badge-pill.gold {
        background: rgba(139, 94, 60, 0.15);
        border-color: rgba(139, 94, 60, 0.3);
        color: var(--brand-gold);
    }
    .profile-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    .profile-info-card {
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 25px rgba(13, 76, 84, 0.03);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    [data-theme="dark"] .profile-info-card {
        background: #14201F;
        border-color: rgba(255, 255, 255, 0.05);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }
    .profile-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(139, 94, 60, 0.08);
        border-color: rgba(139, 94, 60, 0.15);
    }
    [data-theme="dark"] .profile-info-card:hover {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border-color: rgba(139, 94, 60, 0.25);
    }
    .profile-card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--portal-title-color);
        margin-bottom: 1.5rem;
        padding-bottom: 0.85rem;
        border-bottom: 1px solid var(--border-muted);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .profile-item-row {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 0.75rem 0;
        border-bottom: 1px dashed var(--border-dashed);
    }
    .profile-item-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .profile-item-icon {
        color: var(--brand-gold);
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: var(--card-sub-bg);
        border: 1px solid var(--card-sub-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .profile-item-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 3px;
    }
    .profile-item-value {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.4;
    }

    @media (max-width: 768px) {
        .profile-header-card {
            padding: 1.5rem;
        }
        .profile-header-content {
            flex-direction: column;
            text-align: center;
            gap: 1.25rem;
        }
        .profile-badges-wrapper {
            justify-content: center;
        }
        .profile-info-grid {
            grid-template-columns: 1fr !important;
            gap: 1.5rem !important;
        }
        .profile-info-card {
            padding: 1.5rem !important;
        }
    }
</style>

<!-- Top Identity Banner Card -->
<div class="profile-header-card">
    <div class="profile-header-content">
        <div class="profile-avatar-circle">
            {{ strtoupper(substr($jemaah->name, 0, 1)) }}
        </div>
        <div style="flex-grow: 1;">
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 0.5rem; justify-content: inherit;">
                <span class="profile-badge-pill gold">
                    <i class="fas fa-star"></i> Jemaah Premium
                </span>
                <span class="profile-badge-pill">
                    ID: #{{ $jemaah->id }}
                </span>
            </div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: clamp(1.5rem, 4vw, 2rem); font-weight: 900; margin-bottom: 0.5rem; color: #fff;">
                {{ $jemaah->name }}
            </h3>
            <div class="profile-badges-wrapper" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <span style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.75);">
                    <i class="far fa-id-card" style="margin-right: 6px;"></i> NIK: <strong>{{ $jemaah->nik }}</strong>
                </span>
                <span style="color: rgba(255,255,255,0.4);">•</span>
                <span style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.75); display: flex; align-items: center; gap: 6px;">
                    <i class="fab fa-whatsapp" style="color: #25d366;"></i> <strong>{{ $jemaah->whatsapp }}</strong>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Three Columns Details Grid -->
<div class="profile-info-grid">

    <!-- Card 1: Identitas Diri -->
    <div class="profile-info-card">
        <h4 class="profile-card-title">
            <i class="fas fa-user-check" style="color: var(--brand-gold);"></i> Identitas Personal
        </h4>
        <div style="display: flex; flex-direction: column;">
            <!-- Nama Lengkap -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <span class="profile-item-label">Nama Lengkap (KTP)</span>
                    <span class="profile-item-value">{{ $jemaah->name }}</span>
                </div>
            </div>
            <!-- NIK KTP -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div>
                    <span class="profile-item-label">Nomor Induk Kependudukan</span>
                    <span class="profile-item-value">{{ $jemaah->nik ?? '-' }}</span>
                </div>
            </div>
            <!-- Jenis Kelamin -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-venus-mars"></i>
                </div>
                <div>
                    <span class="profile-item-label">Jenis Kelamin</span>
                    <span class="profile-item-value">{{ $jemaah->gender ?? '-' }}</span>
                </div>
            </div>
            <!-- TTL -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-birthday-cake"></i>
                </div>
                <div>
                    <span class="profile-item-label">Tempat & Tanggal Lahir</span>
                    <span class="profile-item-value">
                        {{ $jemaah->birth_place ?? '-' }}, {{ $jemaah->birth_date ? \Carbon\Carbon::parse($jemaah->birth_date)->format('d F Y') : '-' }}
                    </span>
                </div>
            </div>
            <!-- Domisili -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <span class="profile-item-label">Kota Domisili</span>
                    <span class="profile-item-value">{{ $jemaah->city ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Kontak & Akomodasi -->
    <div class="profile-info-card">
        <h4 class="profile-card-title">
            <i class="fas fa-bed" style="color: var(--brand-gold);"></i> Kontak & Akomodasi
        </h4>
        <div style="display: flex; flex-direction: column;">
            <!-- WhatsApp -->
            <div class="profile-item-row">
                <div class="profile-item-icon" style="background: rgba(37, 211, 102, 0.05); border-color: rgba(37, 211, 102, 0.1); color: #25d366;">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div>
                    <span class="profile-item-label">Nomor WhatsApp</span>
                    <span class="profile-item-value" style="color: #25d366; display: flex; align-items: center; gap: 6px;">
                        {{ $jemaah->whatsapp }} <i class="fas fa-check-circle" style="font-size: 0.75rem;"></i>
                    </span>
                </div>
            </div>
            <!-- Email -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <span class="profile-item-label">Alamat Email</span>
                    <span class="profile-item-value" style="font-family: monospace; font-size: 0.88rem;">{{ $jemaah->email ?? '-' }}</span>
                </div>
            </div>
            <!-- Tipe Kamar -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-bed"></i>
                </div>
                <div>
                    <span class="profile-item-label">Tipe Pilihan Kamar</span>
                    <span class="profile-item-value">Kamar {{ $jemaah->room_type ?? 'Quad (Sekamar Berempat)' }}</span>
                </div>
            </div>
            <!-- Paket Umrah -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <div>
                    <span class="profile-item-label">Paket Keberangkatan</span>
                    <span class="profile-item-value" style="color: var(--brand-gold);">
                        {{ $jemaah->package ? $jemaah->package->title : 'Belum Memilih Paket' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Dokumen Paspor & Visa -->
    <div class="profile-info-card">
        <h4 class="profile-card-title">
            <i class="fas fa-passport" style="color: var(--brand-gold);"></i> Dokumen Keberangkatan
        </h4>
        <div style="display: flex; flex-direction: column;">
            <!-- Nama Paspor -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div>
                    <span class="profile-item-label">Nama Sesuai Paspor</span>
                    <span class="profile-item-value" style="text-transform: uppercase;">{{ $jemaah->passport_name ?? 'Belum Diinput' }}</span>
                </div>
            </div>
            <!-- Nomor Paspor -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-passport"></i>
                </div>
                <div>
                    <span class="profile-item-label">Nomor Paspor</span>
                    <span class="profile-item-value" style="font-family: monospace; font-size: 0.95rem; letter-spacing: 0.5px;">
                        {{ $jemaah->passport_number ?? 'Belum Diinput' }}
                    </span>
                </div>
            </div>
            <!-- Masa Berlaku -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <div>
                    <span class="profile-item-label">Masa Berlaku Paspor</span>
                    <span class="profile-item-value">
                        {{ $jemaah->passport_expiry ? \Carbon\Carbon::parse($jemaah->passport_expiry)->format('d F Y') : 'Belum Diinput' }}
                    </span>
                </div>
            </div>
            <!-- Status Visa -->
            <div class="profile-item-row">
                <div class="profile-item-icon">
                    <i class="fas fa-stamp"></i>
                </div>
                <div>
                    <span class="profile-item-label">Status Dokumen Visa</span>
                    <span class="profile-item-value" style="color: var(--brand-gold); display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-shield-alt"></i> {{ $jemaah->visa_status ?? 'Belum Diajukan / Antrian Manifest' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Footer Notice Info -->
<div style="margin-top: 3rem; background: rgba(139, 94, 60, 0.05); border: 1px solid rgba(139, 94, 60, 0.15); padding: 1.25rem 1.5rem; border-radius: 16px; display: flex; gap: 15px; align-items: flex-start;">
    <i class="fas fa-info-circle" style="color: var(--brand-gold); font-size: 1.3rem; margin-top: 2px; flex-shrink: 0;"></i>
    <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
        <strong>Perlu melakukan perubahan data?</strong> Untuk menjaga keamanan proses manifest penerbangan, pemesanan akomodasi di Arab Saudi, dan pengurusan visa resmi, perubahan data sensitif/krusial hanya dapat diajukan secara valid melalui tim administrasi Elnair Travel. Silakan hubungi Customer Service kami via WhatsApp jika ada ketidaksesuaian data.
    </p>
</div>
@endsection
