@extends('admin.layouts.app')
@section('title', 'Add Testimonial')
@section('page_title', 'Add New Testimonial')
@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Customer Name <span style="color:#dc3545;">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Role (e.g. Jamaah Umroh 2023) <span style="color:#dc3545;">*</span></label>
            <input type="text" name="role_label" class="form-control @error('role_label') is-invalid @enderror" value="{{ old('role_label') }}" required>
            @error('role_label') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Testimonial Quote <span style="color:#dc3545;">*</span></label>
            <textarea name="quote" class="form-control @error('quote') is-invalid @enderror" rows="4" required>{{ old('quote') }}</textarea>
            @error('quote') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Avatar (Photo)</label>
            <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
            @error('avatar') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Thumbnail (Preview)</label>
            <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
            @error('thumbnail') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Video URL (Optional)</label>
            <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror" placeholder="https://youtube.com/..." value="{{ old('video_url') }}">
            @error('video_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin">Save Testimonial</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
