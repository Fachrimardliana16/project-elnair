@extends('admin.layouts.app')

@section('title', 'Hero Content')
@section('page_title', 'Manage Hero Section')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.hero.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid-2">
            <div>
                <div class="form-group">
                    <label>Tagline (Small text above title)</label>
                    <input type="text" name="tagline" class="form-control @error('tagline') is-invalid @enderror" value="{{ old('tagline', $hero->tagline ?? '') }}">
                    @error('tagline') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Main Title <span style="color:#dc3545;">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $hero->title ?? '') }}" required>
                    @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Subtitle / Description</label>
                    <textarea name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" rows="4">{{ old('subtitle', $hero->subtitle ?? '') }}</textarea>
                    @error('subtitle') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
            <div>
                <div class="grid-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label>Primary Button Text</label>
                        <input type="text" name="btn_primary_text" class="form-control @error('btn_primary_text') is-invalid @enderror" value="{{ old('btn_primary_text', $hero->btn_primary_text ?? '') }}">
                        @error('btn_primary_text') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Primary Button URL</label>
                        <input type="text" name="btn_primary_url" class="form-control @error('btn_primary_url') is-invalid @enderror" value="{{ old('btn_primary_url', $hero->btn_primary_url ?? '') }}">
                        @error('btn_primary_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="grid-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label>Secondary Button Text</label>
                        <input type="text" name="btn_secondary_text" class="form-control @error('btn_secondary_text') is-invalid @enderror" value="{{ old('btn_secondary_text', $hero->btn_secondary_text ?? '') }}">
                        @error('btn_secondary_text') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Secondary Button URL</label>
                        <input type="text" name="btn_secondary_url" class="form-control @error('btn_secondary_url') is-invalid @enderror" value="{{ old('btn_secondary_url', $hero->btn_secondary_url ?? '') }}">
                        @error('btn_secondary_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Background Image</label>
                    <input type="file" name="background_image" class="form-control @error('background_image') is-invalid @enderror" accept="image/*">
                    @error('background_image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    @if(isset($hero->background_image))
                        <div style="margin-top: 1rem;">
                            <img src="{{ asset($hero->background_image) }}" style="width: 200px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                            <p style="font-size:0.8rem; color:#888; margin-top:0.3rem;">Upload baru untuk mengganti.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div style="margin-top: 1rem; text-align: right;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Save Changes</button>
        </div>
    </form>
</div>
@endsection
