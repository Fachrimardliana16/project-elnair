@extends('admin.layouts.app')

@section('title', 'Tambah Pembimbing')
@section('page_title', 'Tambah Pembimbing Baru')

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <form action="{{ route('admin.guides.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap <span style="color:#dc3545;">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Ustadz Fulan bin Fulan" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Peran / Jabatan</label>
            <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" placeholder="e.g. Pembimbing Umrah & Haji Khusus" value="{{ old('role', 'Pembimbing') }}">
            @error('role') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Deskripsi Singkat / Profil</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Lulusan Universitas Islam Madinah...">{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Foto Pembimbing</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            <small style="color: #666; display: block; margin-top: 0.5rem;">Gunakan rasio 1:1 (persegi) untuk hasil terbaik. Maks: 2MB.</small>
        </div>
        <div class="form-group">
            <label>Urutan Tampil</label>
            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
            @error('order') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            <small style="color: #666; display: block; margin-top: 0.5rem;">Angka lebih kecil tampil lebih dulu.</small>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}> Aktif / Tampil di Website
            </label>
        </div>
        
        <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Simpan Pembimbing</button>
            <a href="{{ route('admin.guides.index') }}" class="btn-admin-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
