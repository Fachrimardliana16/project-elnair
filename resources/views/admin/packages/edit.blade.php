@extends('admin.layouts.app')

@section('title', 'Edit Package')
@section('page_title', 'Edit Package: ' . $package->title)

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Package Title <span style="color:#dc3545;">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $package->title) }}" required>
            @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="grid-2" style="gap: 1rem;">
            <div class="form-group">
                <label>Price Label <span style="color:#dc3545;">*</span></label>
                <input type="text" name="price_label" class="form-control @error('price_label') is-invalid @enderror" value="{{ old('price_label', $package->price_label) }}" required>
                @error('price_label') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Price Value <span style="color:#dc3545;">*</span></label>
                <input type="text" name="price_value" class="form-control @error('price_value') is-invalid @enderror" value="{{ old('price_value', $package->price_value) }}" required>
                @error('price_value') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Description <span style="color:#dc3545;">*</span></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $package->description) }}</textarea>
            @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Package Image</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            @if($package->image)
            <div style="margin-top: 1rem;">
                <img src="{{ str_starts_with($package->image, 'http') ? $package->image : asset($package->image) }}" style="width: 150px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                <p style="font-size:0.8rem; color:#888; margin-top:0.3rem;">Gambar saat ini. Upload baru untuk mengganti.</p>
            </div>
            @endif
        </div>
        <div class="grid-2" style="gap: 1rem;">
            <div class="form-group">
                <label>Hotel Makkah</label>
                <input type="text" name="hotel_makkah" class="form-control @error('hotel_makkah') is-invalid @enderror" value="{{ old('hotel_makkah', $package->hotel_makkah) }}">
                @error('hotel_makkah') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Hotel Madinah</label>
                <input type="text" name="hotel_madinah" class="form-control @error('hotel_madinah') is-invalid @enderror" value="{{ old('hotel_madinah', $package->hotel_madinah) }}">
                @error('hotel_madinah') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Maskapai</label>
            <input type="text" name="maskapai" class="form-control @error('maskapai') is-invalid @enderror" value="{{ old('maskapai', $package->maskapai) }}">
            @error('maskapai') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Fasilitas</label>
            <textarea name="fasilitas" class="form-control @error('fasilitas') is-invalid @enderror" rows="4">{{ old('fasilitas', $package->fasilitas) }}</textarea>
            @error('fasilitas') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Itinerary Text</label>
            <textarea name="itinerary" class="form-control @error('itinerary') is-invalid @enderror" rows="6">{{ old('itinerary', $package->itinerary) }}</textarea>
            @error('itinerary') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        <div class="grid-2" style="gap: 1rem;">
            <div class="form-group">
                <label>Upload File Itinerary (PDF)</label>
                @if($package->itinerary_pdf)
                    <div style="margin-bottom: 0.5rem;">
                        <a href="{{ asset($package->itinerary_pdf) }}" target="_blank" style="color: var(--brand-dark); font-size: 0.85rem; font-weight: 600;"><i class="fas fa-file-pdf"></i> Lihat File Itinerary Saat Ini</a>
                    </div>
                @endif
                <input type="file" name="itinerary_pdf" class="form-control @error('itinerary_pdf') is-invalid @enderror" accept=".pdf">
                <small style="color:#888; font-size:0.8rem;">Kosongkan jika tidak ingin mengganti file PDF Itinerary.</small>
                @error('itinerary_pdf') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Upload File Flyer Paket (PDF / Gambar)</label>
                @if($package->flyer_pdf)
                    <div style="margin-bottom: 0.5rem;">
                        <a href="{{ asset($package->flyer_pdf) }}" target="_blank" style="color: var(--brand-dark); font-size: 0.85rem; font-weight: 600;"><i class="fas fa-file-pdf"></i> Lihat File Flyer Saat Ini</a>
                    </div>
                @endif
                <input type="file" name="flyer_pdf" class="form-control @error('flyer_pdf') is-invalid @enderror" accept=".pdf,image/*">
                <small style="color:#888; font-size:0.8rem;">Kosongkan jika tidak ingin mengganti file Flyer.</small>
                @error('flyer_pdf') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}> Active / Visible on Website
            </label>
        </div>
        
        <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Update Package</button>
            <a href="{{ route('admin.packages.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
