@extends('admin.layouts.app')

@section('title', 'Edit Pembimbing')
@section('page_title', 'Edit Pembimbing: ' . $guide->name)

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <form action="{{ route('admin.guides.update', $guide->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Lengkap <span style="color:#dc3545;">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $guide->name) }}" required>
            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Peran / Jabatan</label>
            <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" value="{{ old('role', $guide->role) }}">
            @error('role') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Deskripsi Singkat / Profil</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $guide->description) }}</textarea>
            @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Foto Pembimbing</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            @if($guide->image)
            <div style="margin-top: 1rem;">
                <img src="{{ str_starts_with($guide->image, 'http') ? $guide->image : asset($guide->image) }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 1px solid #ddd;">
                <p style="font-size:0.8rem; color:#888; margin-top:0.3rem;">Upload baru untuk mengganti.</p>
            </div>
            @endif
        </div>
        <div class="form-group">
            <label>Urutan Tampil</label>
            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $guide->order) }}">
            @error('order') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $guide->is_active) ? 'checked' : '' }}> Aktif / Tampil di Website
            </label>
        </div>
        
        <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Update Pembimbing</button>
            <a href="{{ route('admin.guides.index') }}" class="btn-admin-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
