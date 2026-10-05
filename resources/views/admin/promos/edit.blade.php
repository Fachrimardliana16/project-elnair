@extends('admin.layouts.app')
@section('title', 'Edit Promo / Offering')
@section('page_title', 'Edit Data Promo / Offering')

@section('content')
<div class="admin-card">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.promos.index') }}" class="btn-admin-outline"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
    </div>

    <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Judul Promo / Offering <span style="color:red;">*</span></label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $promo->title) }}" required>
            @error('title')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="badge">Badge / Subtitle Label</label>
                <input type="text" name="badge" id="badge" class="form-control" value="{{ old('badge', $promo->badge) }}">
            </div>

            <div class="form-group">
                <label for="sort_order">Urutan Tampil (Sort Order)</label>
                <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $promo->sort_order) }}">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="image">Upload Foto Visual Baru (Opsional)</label>
                @if($promo->image)
                    <div style="margin-bottom: 0.8rem;">
                        <img src="{{ asset($promo->image) }}" alt="Foto Promo" style="max-height: 100px; border-radius: 8px; border: 1px solid #ddd;">
                        <br><small style="color: #666;">Gambar saat ini</small>
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                <small style="color: #888;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="pdf_file">Upload Dokumen PDF Brosur Promo (Opsional)</label>
                @if($promo->pdf_file)
                    <div style="margin-bottom: 0.8rem;">
                        <a href="{{ asset($promo->pdf_file) }}" target="_blank" class="btn-admin-outline" style="font-size: 0.8rem; padding: 4px 10px; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fas fa-file-pdf" style="color: #e74c3c;"></i> Lihat File PDF Saat Ini
                        </a>
                    </div>
                @endif
                <input type="file" name="pdf_file" id="pdf_file" class="form-control @error('pdf_file') is-invalid @enderror" accept="application/pdf">
                <small style="color: #888;">Format: PDF (Max 10MB). Biarkan kosong jika tidak mengubah file.</small>
                @error('pdf_file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="description">Ringkasan Deskripsi Promo</label>
            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $promo->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="details">Detail Point Benefit (Pisahkan per baris baru untuk bullet list)</label>
            @php
                $detailsValue = is_array(json_decode($promo->details, true)) 
                    ? implode("\n", json_decode($promo->details, true)) 
                    : $promo->details;
            @endphp
            <textarea name="details" id="details" rows="5" class="form-control">{{ old('details', $detailsValue) }}</textarea>
        </div>

        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }}>
                <span>Aktifkan Promo ini di Website</span>
            </label>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Perbarui Promo</button>
        </div>
    </form>
</div>
@endsection
