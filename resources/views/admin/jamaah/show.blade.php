@extends('admin.layouts.app')

@section('title', 'Detail Jemaah: ' . $jamaah->name)
@section('page_title', 'Detail Jemaah')

@section('styles')
<style>
    /* Custom layout grid for admin details */
    .jamaah-detail-grid {
        display: grid;
        grid-template-columns: 1.8fr 1fr;
        gap: 1.75rem;
        align-items: start;
    }
    @media (max-width: 992px) {
        .jamaah-detail-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }
    .profile-banner {
        background: linear-gradient(135deg, var(--brand-dark) 0%, #062b30 100%);
        color: white;
        padding: 2.25rem;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.75rem;
        box-shadow: 0 4px 20px rgba(13, 76, 84, 0.08);
    }
    .profile-banner::after {
        content: '\f2c2';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 11rem;
        color: rgba(255, 255, 255, 0.025);
        pointer-events: none;
    }
    .profile-avatar {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        background: var(--gold-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-weight: 800;
        border: 3px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        flex-shrink: 0;
    }
    .profile-banner-flex {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    .profile-badge-pill {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .profile-badge-pill.gold {
        background: rgba(139, 94, 60, 0.2);
        border-color: rgba(139, 94, 60, 0.3);
        color: #e5b583;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.95rem 0;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.06);
        gap: 1.5rem;
    }
    .detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .detail-label {
        font-size: 0.85rem;
        color: #777;
        font-weight: 400;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .detail-val {
        font-size: 0.95rem;
        color: var(--text-dark);
        font-weight: 600;
        text-align: right;
    }
    .badge-status-capsule {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }
    .status-pending { background: rgba(245, 158, 11, 0.12); color: #d97706; }
    .status-dp { background: rgba(59, 130, 246, 0.12); color: #2563eb; }
    .status-lunas { background: rgba(16, 185, 129, 0.12); color: #059669; }
    .status-cancelled { background: rgba(239, 68, 68, 0.12); color: #dc2626; }
    
    .doc-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.85rem 1.1rem;
        background: #fdfdfd;
        border: 1px solid rgba(139, 94, 60, 0.08);
        border-radius: 12px;
        margin-bottom: 0.65rem;
        transition: 0.3s;
    }
    .doc-item:hover {
        background: #fff;
        border-color: var(--brand-gold);
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .doc-item:last-child {
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        .profile-banner-flex {
            flex-direction: column;
            text-align: center;
            gap: 1.25rem;
        }
        .profile-badges-wrapper {
            justify-content: center;
        }
        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }
        .detail-val {
            text-align: left;
        }
    }
</style>
@endsection

@section('content')
<!-- Action Bar & Navigation -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <a href="{{ route('admin.jamaahs.index') }}" class="btn-admin-outline" style="padding: 0.5rem 1.2rem; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center;">
        <!-- Quick Verification Buttons (No Page Jumps) -->
        @if($jamaah->status === 'Pending')
            <form action="{{ route('admin.jamaahs.update', $jamaah->id) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Apakah Anda yakin ingin ACC pendaftaran jemaah ini?')">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="DP">
                <button type="submit" class="btn-admin" style="padding: 0.5rem 1.2rem; font-size: 0.85rem; background: #2563eb; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-check-circle"></i> ACC Pendaftaran (Set DP)
                </button>
            </form>
        @endif
        @if($jamaah->status === 'DP')
            <form action="{{ route('admin.jamaahs.update', $jamaah->id) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Apakah Anda yakin ingin menyatakan jemaah ini Lunas?')">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="Lunas">
                <button type="submit" class="btn-admin" style="padding: 0.5rem 1.2rem; font-size: 0.85rem; background: #16a34a; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-clipboard-check"></i> Set Lunas
                </button>
            </form>
        @endif
        @if($jamaah->status === 'Lunas')
            <div style="background: rgba(22, 163, 74, 0.1); color: #16a34a; padding: 0.45rem 1rem; border-radius: 8px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-check-double"></i> Administrasi & Keuangan Selesai
            </div>
        @endif

        @can('manage_documents')
            <a href="{{ route('admin.documents.show', $jamaah->id) }}" class="btn-admin-outline" style="padding: 0.5rem 1.2rem; font-size: 0.85rem; border-color: #10b981; color: #10b981; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-folder-open"></i> Kelola Dokumen & Visa
            </a>
        @endcan
        <a href="{{ route('admin.jamaahs.edit', $jamaah->id) }}" class="btn-admin-outline" style="padding: 0.5rem 1.2rem; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fas fa-edit"></i> Edit Status Manual
        </a>
    </div>
</div>

<!-- Premium Profile Banner Header -->
<div class="profile-banner">
    <div class="profile-banner-flex">
        <div class="profile-avatar">
            {{ strtoupper(substr($jamaah->name, 0, 1)) }}
        </div>
        <div style="flex-grow: 1;">
            <div class="profile-badges-wrapper" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 0.5rem;">
                <span class="profile-badge-pill gold">
                    <i class="fas fa-crown"></i> Jemaah Manifest
                </span>
                <span class="profile-badge-pill">
                    ID: #{{ $jamaah->id }}
                </span>
                <span class="badge-status-capsule status-{{ strtolower($jamaah->status) }}">
                    {{ $jamaah->status }}
                </span>
                <span class="profile-badge-pill" style="background: {{ $jamaah->visa_status === 'Issued' ? 'rgba(22, 163, 74, 0.2)' : ($jamaah->visa_status === 'Visa Process' ? 'rgba(202, 138, 4, 0.2)' : ($jamaah->visa_status === 'Rejected' ? 'rgba(220, 38, 38, 0.2)' : 'rgba(255, 255, 255, 0.15)')) }}; color: {{ $jamaah->visa_status === 'Issued' ? '#2ecc71' : ($jamaah->visa_status === 'Visa Process' ? '#f1c40f' : ($jamaah->visa_status === 'Rejected' ? '#e74c3c' : '#fff')) }}; border: 1px solid {{ $jamaah->visa_status === 'Issued' ? '#16a34a' : ($jamaah->visa_status === 'Visa Process' ? '#ca8a04' : ($jamaah->visa_status === 'Rejected' ? '#dc2626' : 'rgba(255, 255, 255, 0.2)')) }}; font-weight: 700;">
                    <i class="fas fa-passport" style="margin-right: 4px;"></i> Visa: {{ $jamaah->visa_status ?? 'Belum Diajukan' }}
                </span>
            </div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: clamp(1.5rem, 4vw, 2rem); font-weight: 900; margin-bottom: 0.5rem; color: #fff;">
                {{ $jamaah->name }}
            </h3>
            <div class="profile-badges-wrapper" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <span style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.75);">
                    <i class="far fa-id-card" style="margin-right: 6px;"></i> NIK: <strong style="font-weight: 600;">{{ $jamaah->nik }}</strong>
                </span>
                <span style="color: rgba(255,255,255,0.4);">•</span>
                <span style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.75); display: flex; align-items: center; gap: 6px;">
                    <i class="fab fa-whatsapp" style="color: #25d366;"></i> <strong style="font-weight: 600;">{{ $jamaah->whatsapp }}</strong>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Main Details Layout Grid -->
<div class="jamaah-detail-grid">
    <!-- Left Column: Personal Data & Contacts -->
    <div>
        <!-- Card 1: Identitas Personal -->
        <div class="admin-card">
            <h3 class="admin-card-title" style="font-size: 1.15rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1.25rem;">
                <i class="fas fa-user-check text-primary" style="margin-right: 6px;"></i> Data Identitas Personal
            </h3>
            <div style="display: flex; flex-direction: column;">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-user text-muted"></i> Nama Lengkap</span>
                    <span class="detail-val">{{ $jamaah->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-file-signature text-muted"></i> Nama Sesuai Paspor</span>
                    <span class="detail-val" style="text-transform: uppercase;">{{ $jamaah->passport_name ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-id-card text-muted"></i> Nomor NIK KTP</span>
                    <span class="detail-val" style="font-family: monospace; font-size: 0.95rem;">{{ $jamaah->nik ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-venus-mars text-muted"></i> Jenis Kelamin</span>
                    <span class="detail-val">{{ $jamaah->gender ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-birthday-cake text-muted"></i> Tempat & Tanggal Lahir</span>
                    <span class="detail-val">
                        {{ $jamaah->birth_place ?? '-' }}, {{ $jamaah->birth_date ? \Carbon\Carbon::parse($jamaah->birth_date)->format('d F Y') : '-' }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-passport text-muted"></i> Nomor Paspor</span>
                    <span class="detail-val" style="font-family: monospace; font-size: 0.95rem; color: var(--brand-gold);">{{ $jamaah->passport_number ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-alt text-muted"></i> Masa Berlaku Paspor</span>
                    <span class="detail-val">
                        {{ $jamaah->passport_expiry ? \Carbon\Carbon::parse($jamaah->passport_expiry)->format('d F Y') : '-' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 2: Kontak & Domisili -->
        <div class="admin-card">
            <h3 class="admin-card-title" style="font-size: 1.15rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1.25rem;">
                <i class="fas fa-address-book text-success" style="margin-right: 6px;"></i> Kontak & Alamat Domisili
            </h3>
            <div style="display: flex; flex-direction: column;">
                <div class="detail-row">
                    <span class="detail-label"><i class="fab fa-whatsapp" style="color: #25d366;"></i> Nomor WhatsApp</span>
                    <span class="detail-val">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $jamaah->whatsapp) }}" target="_blank" style="color: #25d366; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-weight: 600;">
                            {{ $jamaah->whatsapp }} <i class="fas fa-external-link-alt" style="font-size: 0.72rem;"></i>
                        </a>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-envelope text-muted"></i> Alamat Email</span>
                    <span class="detail-val" style="font-family: monospace; font-size: 0.88rem;">{{ $jamaah->email ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-map-marker-alt text-muted"></i> Kota Domisili</span>
                    <span class="detail-val">{{ $jamaah->city ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Accommodation, Schedules & Documents -->
    <div>
        <!-- Premium Unified Financial Summary & Quick Payment Form -->
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <h3 class="admin-card-title" style="font-size: 1.15rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1.25rem;">
                <i class="fas fa-wallet text-success" style="margin-right: 6px;"></i> Ringkasan Pembayaran & Catat Keuangan
            </h3>
            
            @php
                $totalPrice = $jamaah->package ? $jamaah->package->price_numeric : 0;
                $totalPaid = $jamaah->payments->where('status', 'Approved')->sum('amount');
                $outstanding = max(0, $totalPrice - $totalPaid);
            @endphp
            
            <div style="display: flex; flex-direction: column; gap: 0.85rem; margin-bottom: 1.25rem; background: #fafafa; border-radius: 10px; padding: 1rem; border: 1px solid #eee;">
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #555;">
                    <span>Harga Paket:</span>
                    <strong style="color: var(--brand-dark); font-size: 0.95rem;">Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #555;">
                    <span>Dana Terbayar (Disetujui):</span>
                    <strong style="color: #16a34a; font-size: 0.95rem;">Rp {{ number_format($totalPaid, 0, ',', '.') }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #555; border-top: 1px dashed #ddd; padding-top: 0.6rem;">
                    <span>Sisa Tagihan (Outstanding):</span>
                    <strong style="color: {{ $outstanding > 0 ? '#dc2626' : '#16a34a' }}; font-size: 1rem; font-weight: 700;">
                        Rp {{ number_format($outstanding, 0, ',', '.') }}
                    </strong>
                </div>
            </div>

            @if($outstanding > 0)
                <div style="background: #fdfcfa; border: 1px solid var(--brand-beige); padding: 1rem; border-radius: 10px;">
                    <h4 style="font-size: 0.85rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 0.75rem; text-transform: uppercase;">
                        <i class="fas fa-plus-circle" style="color: var(--brand-gold);"></i> Catat Pembayaran Baru (Instan)
                    </h4>
                    <form action="{{ route('admin.payments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="jamaah_id" value="{{ $jamaah->id }}">
                        
                        <div class="form-group" style="margin-bottom: 0.75rem;">
                            <label style="font-size: 0.75rem; font-weight: 700; color: #666; margin-bottom: 4px;">Tipe Pembayaran</label>
                            <select name="type" class="form-control" required style="padding: 0.45rem 0.65rem; font-size: 0.82rem; height: auto;">
                                <option value="DP">Uang Muka (DP)</option>
                                <option value="Cicilan 1">Cicilan 1</option>
                                <option value="Cicilan 2">Cicilan 2</option>
                                <option value="Pelunasan">Pelunasan</option>
                            </select>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 0.75rem;">
                            <label style="font-size: 0.75rem; font-weight: 700; color: #666; margin-bottom: 4px;">Nominal (Rp)</label>
                            <input type="number" name="amount" class="form-control" placeholder="Contoh: 5000000" min="0" max="{{ $outstanding }}" required style="padding: 0.45rem 0.65rem; font-size: 0.82rem;">
                        </div>
                        
                        <input type="hidden" name="payment_date" value="{{ date('Y-m-d') }}">
                        
                        <button type="submit" class="btn-admin" style="width: 100%; justify-content: center; padding: 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-save"></i> Simpan Transaksi Keuangan
                        </button>
                    </form>
                </div>
            @else
                <div style="background: rgba(22, 163, 74, 0.05); border: 1px solid rgba(22, 163, 74, 0.2); color: #16a34a; padding: 0.75rem; border-radius: 8px; text-align: center; font-size: 0.82rem; font-weight: 600;">
                    <i class="fas fa-check-double"></i> Jemaah ini sudah Lunas Sepenuhnya.
                </div>
            @endif

            @if($jamaah->payments->isNotEmpty())
                <div style="margin-top: 1rem; border-top: 1px dashed #eee; padding-top: 1rem;">
                    <h4 style="font-size: 0.8rem; font-weight: 700; color: #666; margin-bottom: 0.5rem; text-transform: uppercase;">Riwayat Transaksi Jemaah</h4>
                    <div style="max-height: 150px; overflow-y: auto; font-size: 0.8rem;">
                        @foreach($jamaah->payments as $pay)
                            @php
                                // Detect duplicate entry: check if there's another payment with identical amount on the same day
                                $isPotentialDuplicate = false;
                                foreach($jamaah->payments as $otherPay) {
                                    if ($otherPay->id !== $pay->id && 
                                        (float)$otherPay->amount === (float)$pay->amount && 
                                        \Carbon\Carbon::parse($otherPay->payment_date)->isSameDay(\Carbon\Carbon::parse($pay->payment_date))) {
                                        $isPotentialDuplicate = true;
                                        break;
                                    }
                                }
                            @endphp
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #fafafa; gap: 8px;">
                                <div>
                                    <strong style="color: #444;">{{ $pay->type }}</strong> - <span style="color: #777;">{{ \Carbon\Carbon::parse($pay->payment_date)->format('d/m/Y') }}</span>
                                    <br>
                                    <span style="font-weight: 600; color: var(--brand-gold);">Rp {{ number_format($pay->amount, 0, ',', '.') }}</span>
                                    @if($isPotentialDuplicate)
                                        <span style="display: block; background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.25); padding: 1px 4px; border-radius: 4px; font-size: 0.65rem; font-weight: 700; margin-top: 3px; width: fit-content;">
                                            <i class="fas fa-exclamation-triangle"></i> Potensi Double Input!
                                        </span>
                                    @endif
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: 700; 
                                        @if($pay->status === 'Approved') background: rgba(22,163,74,0.1); color: #16a34a;
                                        @elseif($pay->status === 'Pending') background: rgba(245,158,11,0.1); color: #d97706;
                                        @else background: rgba(220,38,38,0.1); color: #dc2626; @endif">
                                        {{ $pay->status }}
                                    </span>
                                    @if($pay->status === 'Pending')
                                        <!-- ACC / Approve Button -->
                                        <form action="{{ route('admin.payments.status', $pay->id) }}" method="POST" style="display: inline; margin: 0;">
                                            @csrf
                                            <input type="hidden" name="status" value="Approved">
                                            <button type="submit" class="btn-action btn-action-view" style="width: auto; height: auto; padding: 3px 6px; font-size: 0.65rem; background-color: #16a34a; color: white;" title="Approve Bukti Bayar">
                                                <i class="fas fa-check"></i> ACC
                                            </button>
                                        </form>
                                        <!-- Tolak / Reject Button -->
                                        <form action="{{ route('admin.payments.status', $pay->id) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK pembayaran ini?');">
                                            @csrf
                                            <input type="hidden" name="status" value="Rejected">
                                            <button type="submit" class="btn-action btn-action-danger" style="width: auto; height: auto; padding: 3px 6px; font-size: 0.65rem; background-color: #dc2626; color: white; border: none; border-radius: 4px;" title="Tolak Bukti Bayar">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    @else
                                        <!-- Hapus / Void / Refund Button -->
                                        <form action="{{ route('admin.payments.destroy', $pay->id) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus/refund transaksi ini? Status keuangan jemaah akan dihitung ulang secara otomatis.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; padding: 2px 4px; font-size: 0.75rem;" title="Hapus / Void / Refund Pembayaran">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Card 3: Paket Pilihan -->
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <h3 class="admin-card-title" style="font-size: 1.15rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1.25rem;">
                <i class="fas fa-suitcase text-warning" style="margin-right: 6px;"></i> Detail Paket Pilihan
            </h3>
            
            <form action="{{ route('admin.jamaahs.update', $jamaah->id) }}" method="POST" style="margin: 0; display: flex; flex-direction: column; gap: 1.1rem;">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="{{ $jamaah->status }}">

                <!-- Paket Terdaftar -->
                <div>
                    <label style="font-size: 0.72rem; color: #777; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 4px;">Paket Terdaftar <span style="color: red;">*</span></label>
                    <select name="package_id" id="jamaah_package_id" class="form-control" required style="padding: 0.45rem 0.65rem; font-size: 0.85rem; border-radius: 6px; height: auto;">
                        <option value="">-- Pilih Paket --</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ $jamaah->package_id == $package->id ? 'selected' : '' }}>
                                {{ $package->title }} (Rp {{ number_format($package->price_numeric, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jadwal Keberangkatan -->
                <div>
                    <label style="font-size: 0.72rem; color: #777; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 4px;">Jadwal Keberangkatan</label>
                    <select name="departure_schedule_id" id="jamaah_schedule_id" class="form-control" style="padding: 0.45rem 0.65rem; font-size: 0.85rem; border-radius: 6px; height: auto;">
                        <option value="">-- Pilih Jadwal (Opsional) --</option>
                        @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}" data-package="{{ $schedule->package_id }}" {{ $jamaah->departure_schedule_id == $schedule->id ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($schedule->departure_date)->format('d F Y') }} (Sisa {{ $schedule->available_seats }} seat)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilihan Kamar Hotel -->
                <div>
                    <label style="font-size: 0.72rem; color: #777; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 4px;">Pilihan Kamar Hotel</label>
                    <select name="room_type" class="form-control" style="padding: 0.45rem 0.65rem; font-size: 0.85rem; border-radius: 6px; height: auto;">
                        <option value="Double" {{ $jamaah->room_type == 'Double' ? 'selected' : '' }}>Double (Sekamar Berdua)</option>
                        <option value="Triple" {{ $jamaah->room_type == 'Triple' ? 'selected' : '' }}>Triple (Sekamar Bertiga)</option>
                        <option value="Quad" {{ ($jamaah->room_type ?? 'Quad') == 'Quad' ? 'selected' : '' }}>Quad (Sekamar Berempat)</option>
                    </select>
                </div>

                <button type="submit" class="btn-action btn-action-edit" style="width: 100%; justify-content: center; font-size: 0.8rem; padding: 0.5rem 1rem; border-radius: 6px; height: auto; margin-top: 4px;">
                    <i class="fas fa-save" style="margin-right: 4px;"></i> Simpan Paket & Jadwal
                </button>
            </form>
        </div>

        <!-- Card 4: Dokumen Berkas Jemaah -->
        <div class="admin-card">
            <h3 class="admin-card-title" style="font-size: 1.15rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1.25rem;">
                <i class="fas fa-file-alt text-info" style="margin-right: 6px;"></i> Berkas & Dokumen
            </h3>

            <!-- Visa Status Inline Editor -->
            <div style="background: rgba(139, 94, 60, 0.05); border: 1px dashed rgba(139, 94, 60, 0.25); border-radius: 8px; padding: 1rem; margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <div>
                    <span style="font-size: 0.72rem; color: #777; font-weight: 400; text-transform: uppercase; display: block; margin-bottom: 3px;">Status Visa Paspor</span>
                    <strong style="font-size: 0.95rem; color: {{ $jamaah->visa_status === 'Issued' ? '#16a34a' : ($jamaah->visa_status === 'Visa Process' ? '#ca8a04' : ($jamaah->visa_status === 'Rejected' ? '#dc2626' : '#666')) }}; font-weight: 700;">
                        <i class="fas fa-passport"></i> {{ strtoupper($jamaah->visa_status ?? 'Belum Diajukan') }}
                    </strong>
                </div>
                <form action="{{ route('admin.documents.visa', $jamaah->id) }}" method="POST" style="margin: 0; display: flex; gap: 8px; align-items: center;">
                    @csrf
                    <select name="visa_status" class="form-control" required style="padding: 0.4rem 0.6rem; font-size: 0.8rem; border-radius: 6px; min-width: 160px; height: auto;">
                        <option value="Belum Diajukan" {{ ($jamaah->visa_status ?? 'Belum Diajukan') === 'Belum Diajukan' ? 'selected' : '' }}>Belum Diajukan</option>
                        <option value="Visa Process" {{ $jamaah->visa_status === 'Visa Process' ? 'selected' : '' }}>Dalam Proses Pengajuan</option>
                        <option value="Issued" {{ $jamaah->visa_status === 'Issued' ? 'selected' : '' }}>Visa Telah Diterbitkan (Issued)</option>
                        <option value="Rejected" {{ $jamaah->visa_status === 'Rejected' ? 'selected' : '' }}>Ditolak Kedutaan (Rejected)</option>
                    </select>
                    <button type="submit" class="btn-action btn-action-edit" style="font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 6px; width: auto; height: auto;">
                        Perbarui
                    </button>
                </form>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <!-- KTP File -->
                <div class="doc-item" style="flex-direction: column; align-items: stretch; gap: 6px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span style="font-size: 0.85rem; font-weight: 600; color: #444; display: flex; align-items: center; gap: 8px;">
                            <i class="far fa-file-pdf" style="color: #e74c3c; font-size: 1.1rem;"></i> KTP (Kartu Tanda Penduduk)
                        </span>
                        @if($jamaah->ktp_file)
                            <a href="{{ asset('storage/' . $jamaah->ktp_file) }}" target="_blank" class="btn-action btn-action-view" style="font-size: 0.72rem; padding: 0.35rem 0.75rem; border-radius: 6px; width: auto; height: auto;">Lihat</a>
                        @else
                            <span style="font-size: 0.75rem; color: #aaa; font-style: italic;">Belum Ada</span>
                        @endif
                    </div>
                    <form action="{{ route('admin.documents.upload', $jamaah->id) }}" method="POST" enctype="multipart/form-data" style="margin-top: 4px; display: flex; gap: 8px; align-items: center; justify-content: space-between; border-top: 1px dashed #eee; padding-top: 6px;">
                        @csrf
                        <input type="file" name="ktp_file" accept="image/*,application/pdf" style="font-size: 0.7rem; color: #555; max-width: 170px;" required>
                        <button type="submit" class="btn-action btn-action-edit" style="font-size: 0.7rem; padding: 4px 10px; height: auto; width: auto; border-radius: 6px; gap: 3px;">
                            <i class="fas fa-upload"></i> Unggah
                        </button>
                    </form>
                </div>

                <!-- Paspor File -->
                <div class="doc-item" style="flex-direction: column; align-items: stretch; gap: 6px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span style="font-size: 0.85rem; font-weight: 600; color: #444; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-passport" style="color: var(--brand-gold); font-size: 1.1rem;"></i> Paspor Jemaah
                        </span>
                        @if($jamaah->passport_file)
                            <a href="{{ asset('storage/' . $jamaah->passport_file) }}" target="_blank" class="btn-action btn-action-view" style="font-size: 0.72rem; padding: 0.35rem 0.75rem; border-radius: 6px; width: auto; height: auto;">Lihat</a>
                        @else
                            <span style="font-size: 0.75rem; color: #aaa; font-style: italic;">Belum Ada</span>
                        @endif
                    </div>
                    <form action="{{ route('admin.documents.upload', $jamaah->id) }}" method="POST" enctype="multipart/form-data" style="margin-top: 4px; display: flex; gap: 8px; align-items: center; justify-content: space-between; border-top: 1px dashed #eee; padding-top: 6px;">
                        @csrf
                        <input type="file" name="passport_file" accept="image/*,application/pdf" style="font-size: 0.7rem; color: #555; max-width: 170px;" required>
                        <button type="submit" class="btn-action btn-action-edit" style="font-size: 0.7rem; padding: 4px 10px; height: auto; width: auto; border-radius: 6px; gap: 3px;">
                            <i class="fas fa-upload"></i> Unggah
                        </button>
                    </form>
                </div>

                <!-- KK File -->
                <div class="doc-item" style="flex-direction: column; align-items: stretch; gap: 6px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span style="font-size: 0.85rem; font-weight: 600; color: #444; display: flex; align-items: center; gap: 8px;">
                            <i class="far fa-file-image" style="color: #3498db; font-size: 1.1rem;"></i> Kartu Keluarga (KK)
                        </span>
                        @if($jamaah->kk_file)
                            <a href="{{ asset('storage/' . $jamaah->kk_file) }}" target="_blank" class="btn-action btn-action-view" style="font-size: 0.72rem; padding: 0.35rem 0.75rem; border-radius: 6px; width: auto; height: auto;">Lihat</a>
                        @else
                            <span style="font-size: 0.75rem; color: #aaa; font-style: italic;">Belum Ada</span>
                        @endif
                    </div>
                    <form action="{{ route('admin.documents.upload', $jamaah->id) }}" method="POST" enctype="multipart/form-data" style="margin-top: 4px; display: flex; gap: 8px; align-items: center; justify-content: space-between; border-top: 1px dashed #eee; padding-top: 6px;">
                        @csrf
                        <input type="file" name="kk_file" accept="image/*,application/pdf" style="font-size: 0.7rem; color: #555; max-width: 170px;" required>
                        <button type="submit" class="btn-action btn-action-edit" style="font-size: 0.7rem; padding: 4px 10px; height: auto; width: auto; border-radius: 6px; gap: 3px;">
                            <i class="fas fa-upload"></i> Unggah
                        </button>
                    </form>
                </div>

                <!-- Vaksin Meningitis File -->
                <div class="doc-item" style="flex-direction: column; align-items: stretch; gap: 6px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span style="font-size: 0.85rem; font-weight: 600; color: #444; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-syringe" style="color: var(--brand-teal); font-size: 1.1rem;"></i> Vaksin Meningitis
                        </span>
                        @if($jamaah->vaccine_file)
                            <a href="{{ asset('storage/' . $jamaah->vaccine_file) }}" target="_blank" class="btn-action btn-action-view" style="font-size: 0.72rem; padding: 0.35rem 0.75rem; border-radius: 6px; width: auto; height: auto;">Lihat</a>
                        @else
                            <span style="font-size: 0.75rem; color: #aaa; font-style: italic;">Belum Ada</span>
                        @endif
                    </div>
                    <form action="{{ route('admin.documents.upload', $jamaah->id) }}" method="POST" enctype="multipart/form-data" style="margin-top: 4px; display: flex; gap: 8px; align-items: center; justify-content: space-between; border-top: 1px dashed #eee; padding-top: 6px;">
                        @csrf
                        <input type="file" name="vaccine_file" accept="image/*,application/pdf" style="font-size: 0.7rem; color: #555; max-width: 170px;" required>
                        <button type="submit" class="btn-action btn-action-edit" style="font-size: 0.7rem; padding: 4px 10px; height: auto; width: auto; border-radius: 6px; gap: 3px;">
                            <i class="fas fa-upload"></i> Unggah
                        </button>
                    </form>
                </div>

                <!-- Pas Foto File -->
                <div class="doc-item" style="flex-direction: column; align-items: stretch; gap: 6px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span style="font-size: 0.85rem; font-weight: 600; color: #444; display: flex; align-items: center; gap: 8px;">
                            <i class="far fa-id-badge" style="color: #9b59b6; font-size: 1.1rem;"></i> Pas Foto (3x4 / 4x6)
                        </span>
                        @if($jamaah->photo_file)
                            <a href="{{ asset('storage/' . $jamaah->photo_file) }}" target="_blank" class="btn-action btn-action-view" style="font-size: 0.72rem; padding: 0.35rem 0.75rem; border-radius: 6px; width: auto; height: auto;">Lihat</a>
                        @else
                            <span style="font-size: 0.75rem; color: #aaa; font-style: italic;">Belum Ada</span>
                        @endif
                    </div>
                    <form action="{{ route('admin.documents.upload', $jamaah->id) }}" method="POST" enctype="multipart/form-data" style="margin-top: 4px; display: flex; gap: 8px; align-items: center; justify-content: space-between; border-top: 1px dashed #eee; padding-top: 6px;">
                        @csrf
                        <input type="file" name="photo_file" accept="image/*,application/pdf" style="font-size: 0.7rem; color: #555; max-width: 170px;" required>
                        <button type="submit" class="btn-action btn-action-edit" style="font-size: 0.7rem; padding: 4px 10px; height: auto; width: auto; border-radius: 6px; gap: 3px;">
                            <i class="fas fa-upload"></i> Unggah
                        </button>
                    </form>
                </div>

                <!-- Payment Proof File -->
                <div class="doc-item">
                    <span style="font-size: 0.85rem; font-weight: 600; color: #444; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-receipt" style="color: #2ecc71; font-size: 1.1rem;"></i> Bukti Bayar Terakhir
                    </span>
                    @if($jamaah->payment_proof_file)
                        <a href="{{ asset('storage/' . $jamaah->payment_proof_file) }}" target="_blank" class="btn-action btn-action-view" style="font-size: 0.72rem; padding: 0.35rem 0.75rem; border-radius: 6px; width: auto; height: auto;">Lihat</a>
                    @else
                        <span style="font-size: 0.75rem; color: #aaa; font-style: italic;">Belum Ada</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageSelect = document.getElementById('jamaah_package_id');
    const scheduleSelect = document.getElementById('jamaah_schedule_id');
    
    if (packageSelect && scheduleSelect) {
        const originalOptions = Array.from(scheduleSelect.options).filter(opt => opt.value !== "");

        function filterSchedules() {
            const selectedPackage = packageSelect.value;
            const currentSelectedValue = "{{ $jamaah->departure_schedule_id }}";
            
            // Clear current options except placeholder
            scheduleSelect.innerHTML = '<option value="">-- Pilih Jadwal (Opsional) --</option>';
            
            if (selectedPackage) {
                // Filter matching options
                const matchingOptions = originalOptions.filter(opt => opt.dataset.package === selectedPackage);
                matchingOptions.forEach(opt => {
                    const clonedOpt = opt.cloneNode(true);
                    if (clonedOpt.value === currentSelectedValue) {
                        clonedOpt.selected = true;
                    }
                    scheduleSelect.add(clonedOpt);
                });
            } else {
                originalOptions.forEach(opt => {
                    const clonedOpt = opt.cloneNode(true);
                    if (clonedOpt.value === currentSelectedValue) {
                        clonedOpt.selected = true;
                    }
                    scheduleSelect.add(clonedOpt);
                });
            }
        }

        // Run filter on initial page load
        filterSchedules();

        // Listen for package changes
        packageSelect.addEventListener('change', filterSchedules);
    }
});
</script>
@endsection
