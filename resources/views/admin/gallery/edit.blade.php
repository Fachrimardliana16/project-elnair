@extends('admin.layouts.app')

@section('title', 'Edit Foto Galeri')
@section('page_title', 'Ubah Foto')

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
        <i class="fas fa-edit" style="color: var(--brand-gold);"></i> Ubah Detail Foto Galeri
    </h3>

    <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Judul Foto <span style="color: red;">*</span></label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $gallery->title) }}" required placeholder="Contoh: Kegiatan Manasik Akbar Jemaah Umrah Elnair" style="padding: 0.75rem 1rem;">
            @error('title')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        @php
            $defaultCategories = ['Manasik', 'Keberangkatan', 'Ziarah', 'Hotel', 'Kegiatan'];
            $allCategories = array_unique(array_merge($defaultCategories, $categories ?? []));
        @endphp

        <div class="form-group">
            <label for="category_select">Pilih Album / Kategori <span style="color: red;">*</span></label>
            <select id="category_select" class="form-control" style="padding: 0.75rem 1rem; background: white;">
                @foreach($allCategories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
                <option value="Lainnya">-- Buat Album Baru (Kustom) --</option>
            </select>
        </div>

        <div class="form-group" id="custom_category_group" style="display: none;">
            <label for="category_custom">Nama Album Baru <span style="color: red;">*</span></label>
            <input type="text" id="category_custom" class="form-control @error('category') is-invalid @enderror" placeholder="Tulis nama album baru..." style="padding: 0.75rem 1rem;">
            @error('category')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Hidden Input to Actually Submit the Category -->
        <input type="hidden" name="category" id="category_hidden" value="{{ old('category', $gallery->category) }}">

        <div class="form-group">
            <label>Gambar Galeri <span style="color: #888; font-weight: normal;">(Biarkan kosong jika tidak ingin mengubah)</span></label>
            <input type="file" name="image" id="image_file" class="form-control @error('image') is-invalid @enderror" style="display: none;" accept="image/*">
            
            <div class="gallery-preview-container" onclick="document.getElementById('image_file').click()">
                <div class="preview-placeholder" id="upload_placeholder" style="display: none;">
                    <i class="fas fa-cloud-upload-alt" style="color: var(--brand-gold);"></i>
                    <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #666; font-weight: 600;">Klik di sini untuk mengganti gambar</p>
                    <p style="margin: 0.25rem 0 0 0; font-size: 0.75rem; color: #999;">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                </div>
                @if($gallery->image)
                    <img id="preview_img" class="gallery-preview-img" src="{{ asset($gallery->image) }}">
                @else
                    <img id="preview_img" class="gallery-preview-img" style="display: none;">
                @endif
            </div>
            @error('image')
                <div class="invalid-feedback d-block" style="margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.gallery.index') }}" class="btn-admin-outline" style="text-decoration: none;">Batal</a>
            <button type="submit" class="btn-admin">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('category_select');
        const customGroup = document.getElementById('custom_category_group');
        const customInput = document.getElementById('category_custom');
        const hiddenInput = document.getElementById('category_hidden');
        
        function updateCategoryValue() {
            if (select.value === 'Lainnya') {
                customGroup.style.display = 'block';
                customInput.required = true;
                hiddenInput.value = customInput.value;
            } else {
                customGroup.style.display = 'none';
                customInput.required = false;
                hiddenInput.value = select.value;
            }
        }
        
        select.addEventListener('change', updateCategoryValue);
        customInput.addEventListener('input', function() {
            hiddenInput.value = this.value;
        });
        
        // Initial setup based on old or existing value
        const initialVal = "{{ old('category', $gallery->category) }}";
        const defaultCats = @json($allCategories);
        
        if (initialVal) {
            if (defaultCats.includes(initialVal)) {
                select.value = initialVal;
            } else {
                select.value = 'Lainnya';
                customInput.value = initialVal;
            }
        }
        updateCategoryValue();

        // Image Preview Script
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
