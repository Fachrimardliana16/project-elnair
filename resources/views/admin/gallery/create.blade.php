@extends('admin.layouts.app')

@section('title', 'Tambah Foto Galeri')
@section('page_title', 'Tambah Foto')

@section('styles')
<style>
    .gallery-preview-container {
        border: 2px dashed var(--brand-beige);
        border-radius: 12px;
        padding: 2.5rem 1.5rem;
        text-align: center;
        background: #fafafa;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 0.5rem;
    }
    .gallery-preview-container:hover {
        border-color: var(--brand-dark);
        background: rgba(13, 76, 84, 0.02);
    }
    .gallery-preview-img {
        max-width: 100%;
        max-height: 250px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: none;
    }
    .preview-placeholder i {
        font-size: 3rem;
        color: var(--brand-beige);
        margin-bottom: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="admin-card" style="max-width: 700px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.gallery.index') }}" style="color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 4px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Galeri
        </a>
    </div>

    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1.5rem;">
        <i class="fas fa-images" style="color: var(--brand-gold);"></i> Unggah Foto Galeri Baru
    </h3>

    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Judul Foto <span style="color: red;">*</span></label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Contoh: Kegiatan Manasik Akbar Jemaah Umrah Elnair" style="padding: 0.75rem 1rem;">
            @error('title')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="folder_id">Pilih Album <span style="color: red;">*</span></label>
            <select name="folder_id" id="folder_id" class="form-control @error('folder_id') is-invalid @enderror" style="padding: 0.75rem 1rem; background: white;">
                <option value="">-- Pilih Album --</option>
                @foreach($folders as $folder)
                    <option value="{{ $folder->id }}" {{ old('folder_id') == $folder->id ? 'selected' : '' }}>
                        {{ $folder->name }}
                    </option>
                @endforeach
                <option value="new">+ Buat Album Baru</option>
            </select>
            @error('folder_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" id="new_folder_group" style="display: none;">
            <label for="new_folder_name">Nama Album Baru <span style="color: red;">*</span></label>
            <input type="text" name="new_folder_name" id="new_folder_name" class="form-control @error('new_folder_name') is-invalid @enderror" value="{{ old('new_folder_name') }}" placeholder="Tulis nama album baru..." style="padding: 0.75rem 1rem;">
            @error('new_folder_name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Unggah Gambar <span style="color: red;">*</span></label>
            <input type="file" name="image" id="image_file" class="form-control @error('image') is-invalid @enderror" required style="display: none;" accept="image/*">
            
            <div class="gallery-preview-container" onclick="document.getElementById('image_file').click()">
                <div class="preview-placeholder" id="upload_placeholder">
                    <i class="fas fa-cloud-upload-alt" style="color: var(--brand-gold);"></i>
                    <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #666; font-weight: 600;">Klik di sini untuk memilih gambar</p>
                    <p style="margin: 0.25rem 0 0 0; font-size: 0.75rem; color: #999;">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                </div>
                <img id="preview_img" class="gallery-preview-img">
            </div>
            @error('image')
                <div class="invalid-feedback d-block" style="margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.gallery.index') }}" class="btn-admin-outline" style="text-decoration: none;">Batal</a>
            <button type="submit" class="btn-admin">
                <i class="fas fa-cloud-upload-alt"></i> Unggah Foto
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const folderSelect = document.getElementById('folder_id');
        const newFolderGroup = document.getElementById('new_folder_group');
        const newFolderInput = document.getElementById('new_folder_name');

        folderSelect.addEventListener('change', function() {
            if (this.value === 'new') {
                newFolderGroup.style.display = 'block';
                newFolderInput.required = true;
                // clear folder_id so validation uses new_folder_name
                this.name = '';
                newFolderInput.name = 'new_folder_name';
            } else {
                newFolderGroup.style.display = 'none';
                newFolderInput.required = false;
                this.name = 'folder_id';
            }
        });

        // Image Preview
        const imageFile = document.getElementById('image_file');
        const previewImg = document.getElementById('preview_img');
        const placeholder = document.getElementById('upload_placeholder');

        imageFile.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'inline-block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
