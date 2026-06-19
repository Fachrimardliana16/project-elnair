@extends('admin.layouts.app')

@section('title', 'Update Status Jemaah: ' . $jamaah->name)
@section('page_title', 'Update Status Jemaah')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.jamaahs.index') }}" style="color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 4px;">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Jemaah
    </a>
</div>

<div class="admin-card" style="max-width: 600px; margin: 0 auto; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid var(--brand-beige); border-radius: 15px;">
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem;">
        <div style="width: 45px; height: 45px; border-radius: 50%; background: rgba(13, 76, 84, 0.05); color: var(--brand-dark); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
            <i class="fas fa-user-edit" style="color: var(--brand-gold);"></i>
        </div>
        <div>
            <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--brand-dark); margin: 0;">Update Status Jemaah</h3>
            <p style="color: #666; font-size: 0.8rem; margin: 0;">Ubah status pendaftaran atau pembayaran jemaah aktif.</p>
        </div>
    </div>
    
    <form action="{{ route('admin.jamaahs.update', $jamaah->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label style="font-weight: 700; font-size: 0.85rem; color: #555; text-transform: uppercase; margin-bottom: 6px;">Nama Jemaah</label>
            <input type="text" class="form-control" value="{{ $jamaah->name }}" disabled style="background: #fafafa; border-color: #eee; color: #777; font-weight: 600;">
        </div>

        <div class="form-group">
            <label style="font-weight: 700; font-size: 0.85rem; color: #555; text-transform: uppercase; margin-bottom: 6px;">Paket Pilihan</label>
            <input type="text" class="form-control" value="{{ $jamaah->package ? $jamaah->package->title : 'Belum Memilih Paket' }}" disabled style="background: #fafafa; border-color: #eee; color: #777; font-weight: 600;">
        </div>

        <div class="form-group">
            <label for="status" style="font-weight: 700; font-size: 0.85rem; color: #555; text-transform: uppercase; margin-bottom: 6px;">Status Pendaftaran / Pembayaran <span style="color: red;">*</span></label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required style="padding: 0.8rem 1rem; border-radius: 8px; font-weight: 600; color: var(--brand-dark); cursor: pointer; height: auto;">
                <option value="Pending" {{ $jamaah->status == 'Pending' ? 'selected' : '' }}>Pending (Verifikasi Berkas / DP)</option>
                <option value="DP" {{ $jamaah->status == 'DP' ? 'selected' : '' }}>DP (Uang Muka Terverifikasi)</option>
                <option value="Lunas" {{ $jamaah->status == 'Lunas' ? 'selected' : '' }}>Lunas (Lunas Pembayaran & Berkas)</option>
                <option value="Cancelled" {{ $jamaah->status == 'Cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
            </select>
            @error('status')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.jamaahs.index') }}" class="btn-admin-outline" style="text-decoration: none; padding: 0.65rem 1.5rem; font-size: 0.88rem; display: inline-flex; align-items: center; justify-content: center;">Batal</a>
            <button type="submit" class="btn-admin" style="padding: 0.65rem 1.8rem; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
