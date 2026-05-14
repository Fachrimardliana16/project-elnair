@extends('admin.layouts.app')

@section('title', 'Hero Content')
@section('page_title', 'Manage Hero Section')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.hero.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div>
                <div class="form-group">
                    <label>Tagline (Small text above title)</label>
                    <input type="text" name="tagline" class="form-control" value="{{ $hero->tagline ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Main Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $hero->title ?? '' }}" required>
                </div>
                <div class="form-group">
                    <label>Subtitle / Description</label>
                    <textarea name="subtitle" class="form-control" rows="4">{{ $hero->subtitle ?? '' }}</textarea>
                </div>
            </div>
            <div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Primary Button Text</label>
                        <input type="text" name="btn_primary_text" class="form-control" value="{{ $hero->btn_primary_text ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>Primary Button URL</label>
                        <input type="text" name="btn_primary_url" class="form-control" value="{{ $hero->btn_primary_url ?? '' }}">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Secondary Button Text</label>
                        <input type="text" name="btn_secondary_text" class="form-control" value="{{ $hero->btn_secondary_text ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>Secondary Button URL</label>
                        <input type="text" name="btn_secondary_url" class="form-control" value="{{ $hero->btn_secondary_url ?? '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Background Image</label>
                    <input type="file" name="background_image" class="form-control">
                    @if(isset($hero->background_image))
                        <div style="margin-top: 1rem;">
                            <img src="{{ asset($hero->background_image) }}" style="width: 200px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
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
