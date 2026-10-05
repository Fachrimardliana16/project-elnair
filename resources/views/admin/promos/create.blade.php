@extends('admin.layouts.app')
@section('title', 'Tambah Promo / Offering')
@section('page_title', 'Tambah Promo / Offering Baru')

@section('content')
<div class="admin-card">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.promos.index') }}" class="btn-admin-outline"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
    </div>

    <form action="{{ route('admin.promos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title">Judul Promo / Offering <span style="color:red;">*</span></label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Personal Kit Jamaah Wanita & Keluarga" required>
            @error('title')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="badge">Badge / Subtitle Label</label>
                <input type="text" name="badge" id="badge" class="form-control" value="{{ old('badge') }}" placeholder="Contoh: Exclusive Benefit Woman Kit">
            </div>

            <div class="form-group">
                <label for="sort_order">Urutan Tampil (Sort Order)</label>
                <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 1) }}">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="image">Upload Foto Visual Promo (Gambar High Quality)</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                <small style="color: #888;">Format: JPG, PNG, WebP (Max 5MB).</small>
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="pdf_file">Upload Dokumen PDF Promo / Brosur (Opsional)</label>
                <input type="file" name="pdf_file" id="pdf_file" class="form-control @error('pdf_file') is-invalid @enderror" accept="application/pdf">
                <small style="color: #888;">Format: File PDF (Max 10MB). Akan menjadi tombol download PDF untuk pengunjung.</small>
                @error('pdf_file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="description">Ringkasan Deskripsi Promo</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Jelaskan secara singkat penawaran atau benefit yang didapatkan jamaah...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="details">Detail Point Benefit (Pisahkan per baris baru untuk bullet list)</label>
            <textarea name="details" id="details" rows="5" class="form-control" placeholder="Contoh:
Tas Koper & Handbag Travel Wanita
Tumbler Stainless Thermos Pengatur Suhu
HT Wireless Audio Receiver Bimbingan Tawaf
Mukena & Kain Ihram Silk Premium">{{ old('details') }}</textarea>
        </div>

        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <span>Aktifkan Promo ini di Website</span>
            </label>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Simpan Promo</button>
        </div>
    </form>
</div>
@endsection
