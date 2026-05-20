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
            <label>Package Image <span style="color:#dc3545;">*</span></label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            <small style="color:#888; font-size:0.8rem;">Format: JPG, PNG, WebP. Maks: 2MB</small>
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
            <label>Itinerary</label>
            <textarea name="itinerary" class="form-control @error('itinerary') is-invalid @enderror" rows="8" placeholder="Hari 1: Keberangkatan...&#10;Hari 2: Tiba di Madinah...">{{ old('itinerary') }}</textarea>
            @error('itinerary') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
@endsection
