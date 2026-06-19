@extends('landing.jemaah.layout')

@section('portal-content')
<div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">

    <!-- 1. Ringkasan Keuangan (Cards) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
        
        <!-- Harga Paket -->
        <div class="portal-card" style="padding: 1.75rem; border-left: 4px solid var(--brand-dark);">
            <span style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 5px;">Harga Paket Umrah</span>
            <h4 style="font-size: 1.5rem; font-weight: 900; color: var(--portal-title-color);">
                Rp {{ number_format($price, 0, ',', '.') }}
            </h4>
            <small style="color: var(--text-muted); font-size: 0.78rem; display: block; margin-top: 5px;">Tipe Kamar: Kamar {{ $jemaah->room_type }}</small>
        </div>

        <!-- Total Terbayar -->
        <div class="portal-card" style="padding: 1.75rem; border-left: 4px solid #2ecc71;">
            <span style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 5px;">Total Terbayar (Approved)</span>
            <h4 style="font-size: 1.5rem; font-weight: 900; color: #2ecc71;">
                Rp {{ number_format($totalPaid, 0, ',', '.') }}
            </h4>
            <small style="color: var(--text-muted); font-size: 0.78rem; display: block; margin-top: 5px;">Tervalidasi oleh Admin</small>
        </div>

        <!-- Sisa Tagihan -->
        <div class="portal-card" style="padding: 1.75rem; border-left: 4px solid #e74c3c;">
            <span style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 5px;">Sisa Tagihan (Outstanding)</span>
            <h4 style="font-size: 1.5rem; font-weight: 900; color: #e74c3c;">
                Rp {{ number_format($outstanding, 0, ',', '.') }}
            </h4>
            <small style="color: var(--text-muted); font-size: 0.78rem; display: block; margin-top: 5px;">Wajib Dilunasi H-30 Keberangkatan</small>
        </div>

    </div>

    <!-- 2. Form Pembayaran Dinamis (Lock / Unlock based on status) -->
    <div class="portal-card" style="padding: 2.25rem;">
        @if($jemaah->status === 'Pending')
            <!-- Locked State: Elegant Banner -->
            <div style="border-bottom: 1px solid var(--border-muted); padding-bottom: 1.25rem; margin-bottom: 1.75rem;">
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 800; color: var(--portal-title-color); display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-lock" style="color: var(--brand-gold);"></i> Pembayaran Terkunci
                </h4>
            </div>
            <div style="background: rgba(139, 94, 60, 0.08); border: 1px dashed var(--brand-gold); border-radius: 16px; padding: 2.5rem; text-align: center;">
                <i class="fas fa-lock" style="font-size: 3.5rem; color: var(--brand-gold); margin-bottom: 1.25rem; opacity: 0.8;"></i>
                <h5 style="font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 800; color: var(--portal-title-color); margin-bottom: 0.75rem;">Pendaftaran Anda Sedang Ditinjau</h5>
                <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; max-width: 550px; margin: 0 auto;">
                    Form konfirmasi pembayaran dan unggah bukti transfer **hanya terbuka setelah pendaftaran Anda disetujui (di-ACC) oleh tim admin**. 
                    Silakan tunggu konfirmasi melalui WhatsApp, atau lengkapi berkas di menu **Kelola Dokumen** untuk mempercepat proses persetujuan.
                </p>
            </div>
        @elseif($jemaah->status === 'Lunas' || $jemaah->status === 'Pelunasan' || (float)$outstanding <= 0)
            <!-- Fully Paid State: Premium Success Banner -->
            <div style="border-bottom: 1px solid var(--border-muted); padding-bottom: 1.25rem; margin-bottom: 1.75rem;">
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 800; color: var(--portal-title-color); display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-check-double" style="color: #2ecc71;"></i> Administrasi Keuangan Selesai
                </h4>
            </div>
            <div style="background: rgba(46, 204, 113, 0.08); border: 1px dashed #2ecc71; border-radius: 16px; padding: 2.5rem; text-align: center;">
                <i class="fas fa-check-circle" style="font-size: 3.5rem; color: #2ecc71; margin-bottom: 1.25rem; opacity: 0.8;"></i>
                <h5 style="font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 800; color: var(--portal-title-color); margin-bottom: 0.75rem;">Pembayaran Anda Telah Lunas!</h5>
                <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; max-width: 550px; margin: 0 auto;">
                    Terima kasih, seluruh kewajiban administrasi dan pembiayaan untuk perjalanan ibadah umrah Anda telah **terverifikasi Lunas 100%** oleh tim admin Elnair Travel. 
                    Anda tidak perlu melakukan konfirmasi pembayaran lagi. Selamat mempersiapkan rihlah suci Anda!
                </p>
            </div>
        @else
            <!-- Unlocked State: Premium Form -->
            <div style="border-bottom: 1px solid var(--border-muted); padding-bottom: 1.25rem; margin-bottom: 1.75rem;">
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 800; color: var(--portal-title-color); display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-file-invoice-dollar" style="color: var(--brand-gold);"></i> Konfirmasi Pembayaran Baru
                </h4>
            </div>
            <form action="{{ route('jemaah.payments.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                    
                    <!-- Jenis Pembayaran -->
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="type" style="font-size: 0.82rem; font-weight: 700; color: var(--brand-gold); text-transform: uppercase; letter-spacing: 0.5px;">Jenis Pembayaran</label>
                        <select name="type" id="type" style="padding: 0.85rem 1rem; border-radius: 10px; border: 1px solid var(--border-muted); background: var(--bg-muted); color: var(--text-dark); font-size: 0.95rem; font-weight: 600;" required>
                            <option value="" style="background: var(--card-bg);">-- Pilih --</option>
                            <option value="DP" style="background: var(--card-bg);" {{ old('type') == 'DP' ? 'selected' : '' }}>DP (Uang Muka)</option>
                            <option value="Cicilan 1" style="background: var(--card-bg);" {{ old('type') == 'Cicilan 1' ? 'selected' : '' }}>Cicilan Ke-1</option>
                            <option value="Cicilan 2" style="background: var(--card-bg);" {{ old('type') == 'Cicilan 2' ? 'selected' : '' }}>Cicilan Ke-2</option>
                            <option value="Pelunasan" style="background: var(--card-bg);" {{ old('type') == 'Pelunasan' ? 'selected' : '' }}>Pelunasan Akhir</option>
                        </select>
                    </div>

                    <!-- Nominal Transfer -->
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="amount" style="font-size: 0.82rem; font-weight: 700; color: var(--brand-gold); text-transform: uppercase; letter-spacing: 0.5px;">Nominal Transfer (Rupiah)</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" placeholder="Contoh: 10000000" style="padding: 0.85rem 1rem; border-radius: 10px; border: 1px solid var(--border-muted); background: var(--bg-muted); color: var(--text-dark); font-size: 0.95rem;" required>
                    </div>

                    <!-- Tanggal Transfer -->
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="payment_date" style="font-size: 0.82rem; font-weight: 700; color: var(--brand-gold); text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Transfer</label>
                        <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" style="padding: 0.85rem 1rem; border-radius: 10px; border: 1px solid var(--border-muted); background: var(--bg-muted); color: var(--text-dark); font-size: 0.95rem; font-weight: 600;" required>
                    </div>

                    <!-- File Bukti -->
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="payment_proof" style="font-size: 0.82rem; font-weight: 700; color: var(--brand-gold); text-transform: uppercase; letter-spacing: 0.5px;">File Bukti Transfer</label>
                        <input type="file" name="payment_proof" id="payment_proof" accept="image/*" style="padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid var(--border-muted); background: var(--bg-muted); color: var(--text-dark); font-size: 0.85rem;" required>
                        <small style="color: var(--text-muted); font-size: 0.72rem;">Format: JPG, JPEG, PNG (Maks. 5MB)</small>
                    </div>

                </div>

                <div style="text-align: right;">
                    <button type="submit" class="btn btn-gold" style="padding: 0.9rem 2.5rem; font-size: 0.85rem; border: none; cursor: pointer; font-weight: 700; border-radius: 8px;">
                        <i class="fas fa-paper-plane" style="margin-right: 6px;"></i> Unggah & Konfirmasi
                    </button>
                </div>
            </form>
        @endif
    </div>

    <!-- 3. Riwayat Cicilan / Pembayaran -->
    <div class="portal-card" style="padding: 2.25rem;">
        <div style="border-bottom: 1px solid var(--border-muted); padding-bottom: 1.25rem; margin-bottom: 1.5rem;">
            <h4 style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 800; color: var(--portal-title-color); display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-history" style="color: var(--brand-gold);"></i> Riwayat Setoran Pembayaran
            </h4>
        </div>

        @if($payments->isNotEmpty())
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 600px; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-muted); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); font-weight: 800;">
                            <th style="padding: 1rem 0.5rem;">Jenis Bayar</th>
                            <th style="padding: 1rem 0.5rem;">Tanggal Transfer</th>
                            <th style="padding: 1rem 0.5rem;">Nominal</th>
                            <th style="padding: 1rem 0.5rem; text-align: center;">Status Verifikasi</th>
                            <th style="padding: 1rem 0.5rem; text-align: right;">Bukti Transfer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $pm)
                            @php
                                $pmStatus = strtolower($pm->status);
                            @endphp
                            <tr style="border-bottom: 1px solid var(--border-muted); font-size: 0.92rem; color: var(--text-dark);">
                                <td style="padding: 1.25rem 0.5rem; font-weight: 700; color: var(--portal-title-color);">
                                    {{ $pm->type }}
                                </td>
                                <td style="padding: 1.25rem 0.5rem; color: var(--text-muted);">
                                    {{ $pm->payment_date ? \Carbon\Carbon::parse($pm->payment_date)->format('d F Y') : '-' }}
                                </td>
                                <td style="padding: 1.25rem 0.5rem; font-weight: 800; color: var(--portal-title-color);">
                                    Rp {{ number_format($pm->amount, 0, ',', '.') }}
                                </td>
                                <td style="padding: 1.25rem 0.5rem; text-align: center;">
                                    @if($pmStatus === 'approved')
                                        <span style="background: rgba(46, 204, 113, 0.15); color: #2ecc71; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-check-circle"></i> Disetujui
                                        </span>
                                    @elseif($pmStatus === 'rejected')
                                        <span style="background: rgba(231, 76, 60, 0.15); color: #e74c3c; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @else
                                        <span style="background: rgba(243, 156, 18, 0.15); color: #f39c12; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-spinner fa-spin"></i> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 1.25rem 0.5rem; text-align: right;">
                                    @if($pm->payment_proof)
                                        <a href="{{ asset('storage/' . $pm->payment_proof) }}" target="_blank" style="color: var(--brand-gold); text-decoration: none; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-image"></i> Lihat File
                                        </a>
                                    @else
                                        <span style="color: var(--text-muted); font-size: 0.8rem;">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 2.5rem 0; color: var(--text-muted);">
                <i class="fas fa-receipt" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p style="font-size: 0.85rem; line-height: 1.5;">Anda belum pernah mengunggah data setoran/bukti transfer cicilan pembayaran.</p>
            </div>
        @endif
    </div>

</div>

<!-- CSS style for spinners in table status -->
<style>
    @keyframes fa-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .fa-spin {
        animation: fa-spin 2s linear infinite;
    }
</style>
@endsection
