@extends('admin.layouts.app')

@section('title', 'Kelola Dokumen Jemaah')
@section('page_title', 'Kelola Dokumen Jemaah')

@section('styles')
<style>
    .doc-card {
        border: 1px solid var(--brand-beige);
        border-radius: 12px;
        padding: 1.5rem;
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.01);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .doc-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .doc-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: rgba(13, 76, 84, 0.08);
        color: var(--brand-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .doc-icon.uploaded {
        background: rgba(22, 163, 74, 0.1);
        color: #16a34a;
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.documents.index') }}" style="color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 4px;">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Dokumen
    </a>
</div>

@if(session('success'))
    <div style="background: rgba(22, 163, 74, 0.1); color: #16a34a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.9rem;">
        <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
    </div>
@endif

<div class="grid-2">
    <!-- Left Column: Upload Forms -->
    <div>
        <div class="admin-card">
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 0.5rem;">Dokumen Persyaratan Jemaah</h3>
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem;">Silakan unggah berkas jemaah di bawah ini (Format: JPG/PNG/PDF, Maks: 2MB).</p>

            <form action="{{ route('admin.documents.upload', $jamaah->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- KTP -->
                <div class="doc-card">
                    <div class="doc-info">
                        <div class="doc-icon {{ $jamaah->ktp_file ? 'uploaded' : '' }}">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0;">Kartu Tanda Penduduk (KTP)</h4>
                            @if($jamaah->ktp_file)
                                <a href="{{ asset('storage/' . $jamaah->ktp_file) }}" target="_blank" style="color: var(--brand-gold); text-decoration: none; font-size: 0.8rem; font-weight: 600;"><i class="fas fa-external-link-alt"></i> Lihat Dokumen</a>
                            @else
                                <small style="color: #ca8a04; font-weight: 600;"><i class="fas fa-clock"></i> Belum Diunggah</small>
                            @endif
                        </div>
                    </div>
                    <input type="file" name="ktp_file" style="font-size: 0.8rem; max-width: 200px;">
                </div>

                <!-- KK -->
                <div class="doc-card">
                    <div class="doc-info">
                        <div class="doc-icon {{ $jamaah->kk_file ? 'uploaded' : '' }}">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0;">Kartu Keluarga (KK)</h4>
                            @if($jamaah->kk_file)
                                <a href="{{ asset('storage/' . $jamaah->kk_file) }}" target="_blank" style="color: var(--brand-gold); text-decoration: none; font-size: 0.8rem; font-weight: 600;"><i class="fas fa-external-link-alt"></i> Lihat Dokumen</a>
                            @else
                                <small style="color: #ca8a04; font-weight: 600;"><i class="fas fa-clock"></i> Belum Diunggah</small>
                            @endif
                        </div>
                    </div>
                    <input type="file" name="kk_file" style="font-size: 0.8rem; max-width: 200px;">
                </div>

                <!-- Paspor -->
                <div class="doc-card">
                    <div class="doc-info">
                        <div class="doc-icon {{ $jamaah->passport_file ? 'uploaded' : '' }}">
                            <i class="fas fa-passport"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0;">Halaman Pertama Paspor</h4>
                            @if($jamaah->passport_file)
                                <a href="{{ asset('storage/' . $jamaah->passport_file) }}" target="_blank" style="color: var(--brand-gold); text-decoration: none; font-size: 0.8rem; font-weight: 600;"><i class="fas fa-external-link-alt"></i> Lihat Dokumen</a>
                            @else
                                <small style="color: #ca8a04; font-weight: 600;"><i class="fas fa-clock"></i> Belum Diunggah</small>
                            @endif
                        </div>
                    </div>
                    <input type="file" name="passport_file" style="font-size: 0.8rem; max-width: 200px;">
                </div>

                <!-- Vaksin -->
                <div class="doc-card">
                    <div class="doc-info">
                        <div class="doc-icon {{ $jamaah->vaccine_file ? 'uploaded' : '' }}">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0;">Sertifikat Meningitis / Vaksin</h4>
                            @if($jamaah->vaccine_file)
                                <a href="{{ asset('storage/' . $jamaah->vaccine_file) }}" target="_blank" style="color: var(--brand-gold); text-decoration: none; font-size: 0.8rem; font-weight: 600;"><i class="fas fa-external-link-alt"></i> Lihat Dokumen</a>
                            @else
                                <small style="color: #ca8a04; font-weight: 600;"><i class="fas fa-clock"></i> Belum Diunggah</small>
                            @endif
                        </div>
                    </div>
                    <input type="file" name="vaccine_file" style="font-size: 0.8rem; max-width: 200px;">
                </div>

                <!-- Pas Foto -->
                <div class="doc-card">
                    <div class="doc-info">
                        <div class="doc-icon {{ $jamaah->photo_file ? 'uploaded' : '' }}">
                            <i class="fas fa-image"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0;">Pas Foto Resmi 4x6</h4>
                            @if($jamaah->photo_file)
                                <a href="{{ asset('storage/' . $jamaah->photo_file) }}" target="_blank" style="color: var(--brand-gold); text-decoration: none; font-size: 0.8rem; font-weight: 600;"><i class="fas fa-external-link-alt"></i> Lihat Dokumen</a>
                            @else
                                <small style="color: #ca8a04; font-weight: 600;"><i class="fas fa-clock"></i> Belum Diunggah</small>
                            @endif
                        </div>
                    </div>
                    <input type="file" name="photo_file" style="font-size: 0.8rem; max-width: 200px;">
                </div>

                <div style="margin-top: 1.5rem; text-align: right;">
                    <button type="submit" class="btn-admin" style="padding: 0.75rem 2rem;">
                        <i class="fas fa-cloud-upload-alt"></i> Unggah & Verifikasi Berkas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Profil & Visa Status -->
    <div>
        <!-- Profile Card -->
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">Profil Jemaah</h3>
            <table style="width: 100%; border: none;">
                <tr style="border: none;">
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem; color: #666; width: 40%;">Nama Lengkap</td>
                    <td style="padding: 0.5rem 0; font-weight: 700; font-size: 0.85rem; color: var(--brand-dark);">{{ $jamaah->name }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem; color: #666;">Paspor Name</td>
                    <td style="padding: 0.5rem 0; font-size: 0.85rem;">{{ $jamaah->passport_name ?? '-' }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem; color: #666;">No. Paspor</td>
                    <td style="padding: 0.5rem 0; font-size: 0.85rem;"><code>{{ $jamaah->passport_number ?? '-' }}</code></td>
                </tr>
                <tr style="border: none;">
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem; color: #666;">Jenis Kelamin</td>
                    <td style="padding: 0.5rem 0; font-size: 0.85rem;">{{ $jamaah->gender ?? '-' }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem; color: #666;">WhatsApp</td>
                    <td style="padding: 0.5rem 0; font-size: 0.85rem;">{{ $jamaah->whatsapp }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem; color: #666;">Kota Asal</td>
                    <td style="padding: 0.5rem 0; font-size: 0.85rem;">{{ $jamaah->city ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Visa Status Editor -->
        <div class="admin-card">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">
                <i class="fas fa-passport" style="color: var(--brand-gold);"></i> Status Pengurusan Visa
            </h3>

            <div style="background: #fcfbfa; border: 1px solid var(--brand-beige); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; font-size: 0.9rem;">
                Status Visa Saat Ini: 
                <strong style="margin-left: 0.5rem; color: {{ $jamaah->visa_status === 'Issued' ? '#16a34a' : ($jamaah->visa_status === 'Visa Process' ? '#ca8a04' : '#666') }}; font-weight: 700;">
                    {{ strtoupper($jamaah->visa_status) }}
                </strong>
            </div>

            <form action="{{ route('admin.documents.visa', $jamaah->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Ubah Status Visa</label>
                    <select name="visa_status" class="form-control" required style="padding: 0.6rem 0.8rem;">
                        <option value="Belum Diajukan" {{ $jamaah->visa_status === 'Belum Diajukan' ? 'selected' : '' }}>Belum Diajukan</option>
                        <option value="Visa Process" {{ $jamaah->visa_status === 'Visa Process' ? 'selected' : '' }}>Dalam Proses Pengajuan</option>
                        <option value="Issued" {{ $jamaah->visa_status === 'Issued' ? 'selected' : '' }}>Visa Telah Diterbitkan (Issued)</option>
                        <option value="Rejected" {{ $jamaah->visa_status === 'Rejected' ? 'selected' : '' }}>Ditolak Kedutaan (Rejected)</option>
                    </select>
                </div>
                <button type="submit" class="btn-admin" style="width: 100%; justify-content: center; padding: 0.6rem 1rem;">
                    Perbarui Status Visa
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
