@extends('admin.layouts.app')

@section('title', 'Add Package')
@section('page_title', 'Create New Package')

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Package Title <span style="color:#dc3545;">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Haji Furoda Luxury" value="{{ old('title') }}" required>
            @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="grid-2" style="gap: 1rem;">
            <div class="form-group">
                <label>Price Label (e.g. IDR) <span style="color:#dc3545;">*</span></label>
                <input type="text" name="price_label" class="form-control @error('price_label') is-invalid @enderror" placeholder="IDR" value="{{ old('price_label') }}" required>
                @error('price_label') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Price Value (e.g. 350jt) <span style="color:#dc3545;">*</span></label>
                <input type="text" name="price_value" class="form-control @error('price_value') is-invalid @enderror" placeholder="350jt" value="{{ old('price_value') }}" required>
                @error('price_value') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Description <span style="color:#dc3545;">*</span></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Brief details about the package..." required>{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Package Image (Thumbnail) <span style="color:#dc3545;">*</span></label>
            <input type="file" name="image" id="input_pkg_image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required onchange="previewImage(this, 'preview_pkg_image')">
            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            <small style="color:#888; font-size:0.8rem;">Format: JPG, PNG, WebP. Ukuran file bebas (akan otomatis dikompres & dioptimasi di latar belakang).</small>
            <div id="preview_pkg_image" style="margin-top: 0.6rem; display: none;">
                <img src="" style="max-height: 120px; border-radius: 8px; border: 1px solid #ddd; object-fit: cover;">
            </div>
        </div>
        <div class="grid-2" style="gap: 1rem;">
            <div class="form-group">
                <label>Hotel Makkah</label>
                <input type="text" name="hotel_makkah" class="form-control @error('hotel_makkah') is-invalid @enderror" placeholder="Swissotel Makkah" value="{{ old('hotel_makkah') }}">
                @error('hotel_makkah') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Hotel Madinah</label>
                <input type="text" name="hotel_madinah" class="form-control @error('hotel_madinah') is-invalid @enderror" placeholder="Anwar Al Madinah" value="{{ old('hotel_madinah') }}">
                @error('hotel_madinah') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Maskapai</label>
            <input type="text" name="maskapai" class="form-control @error('maskapai') is-invalid @enderror" placeholder="Saudia Airlines" value="{{ old('maskapai') }}">
            @error('maskapai') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Fasilitas</label>
            <textarea name="fasilitas" class="form-control @error('fasilitas') is-invalid @enderror" rows="4" placeholder="- Visa Umrah&#10;- Tiket PP&#10;- Makan 3x Sehari">{{ old('fasilitas') }}</textarea>
            @error('fasilitas') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Itinerary Text</label>
            <textarea name="itinerary" class="form-control @error('itinerary') is-invalid @enderror" rows="6" placeholder="Hari 1: Keberangkatan...&#10;Hari 2: Tiba di Madinah...">{{ old('itinerary') }}</textarea>
            @error('itinerary') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        <div class="grid-2" style="gap: 1rem;">
            <div class="form-group">
                <label>Upload File Itinerary (PDF) <span style="color:#dc3545;">*</span></label>
                <input type="file" name="itinerary_pdf" id="input_itinerary" class="form-control @error('itinerary_pdf') is-invalid @enderror" accept=".pdf" required onchange="previewPdfFile(this, 'preview_itinerary_info')">
                <small style="color:#888; font-size:0.8rem;">File PDF Itinerary lengkap untuk diunduh pengunjung website (Ukuran bebas).</small>
                @error('itinerary_pdf') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                <div id="preview_itinerary_info" style="margin-top: 0.5rem; display: none; font-size: 0.82rem; color: #27ae60; font-weight: 500;"></div>
            </div>
            <div class="form-group">
                <label>Upload File Flyer Paket (PDF / Gambar) <span style="color:#dc3545;">*</span></label>
                <input type="file" name="flyer_pdf" id="input_flyer" class="form-control @error('flyer_pdf') is-invalid @enderror" accept=".pdf,image/*" required onchange="previewFlyerFile(this)">
                <small style="color:#888; font-size:0.8rem;">Flyer resmi paket (PDF / Gambar, Ukuran bebas). Gambar akan otomatis dikompres di latar belakang.</small>
                @error('flyer_pdf') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                <div id="preview_flyer_box" style="margin-top: 0.5rem; display: none;"></div>
            </div>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}> Active / Visible on Website
            </label>
        </div>
        
        <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Create Package</button>
            <a href="{{ route('admin.packages.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>

<script>
function previewImage(input, previewId) {
    var container = document.getElementById(previewId);
    if (!container) return;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            container.querySelector('img').src = e.target.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        container.style.display = 'none';
    }
}

function previewPdfFile(input, infoId) {
    var info = document.getElementById(infoId);
    if (!info) return;
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        info.innerHTML = '<i class="fas fa-file-pdf" style="color:#e74c3c;"></i> File dipilih: <strong>' + file.name + '</strong> (' + sizeMB + ' MB)';
        info.style.display = 'block';
    } else {
        info.style.display = 'none';
    }
}

function previewFlyerFile(input) {
    var box = document.getElementById('preview_flyer_box');
    if (!box) return;
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        if (file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                box.innerHTML = '<div style="font-size:0.82rem; color:#27ae60; margin-bottom:4px;"><i class="fas fa-check-circle"></i> Gambar dipilih (' + sizeMB + ' MB - akan otomatis dikompres):</div>' +
                                '<img src="' + e.target.result + '" style="max-height: 140px; border-radius: 6px; border: 1px solid #ddd; object-fit: contain; background: #fff; padding: 2px;">';
                box.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            box.innerHTML = '<div style="font-size:0.82rem; color:#27ae60;"><i class="fas fa-file-pdf" style="color:#e74c3c;"></i> PDF dipilih: <strong>' + file.name + '</strong> (' + sizeMB + ' MB)</div>';
            box.style.display = 'block';
        }
    } else {
        box.style.display = 'none';
    }
}
</script>
@endsection
