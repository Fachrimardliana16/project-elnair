@extends('admin.layouts.app')
@section('title', 'Edit Testimonial')
@section('page_title', 'Edit Testimonial: ' . $testimonial->name)

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Customer Name <span style="color:#dc3545;">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name', $testimonial->name) }}">
            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Role (e.g. Jamaah Umroh 2023) <span style="color:#dc3545;">*</span></label>
            <input type="text" name="role_label" class="form-control @error('role_label') is-invalid @enderror" required value="{{ old('role_label', $testimonial->role_label) }}">
            @error('role_label') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Testimonial Quote <span style="color:#dc3545;">*</span></label>
            <textarea name="quote" class="form-control @error('quote') is-invalid @enderror" rows="4" required>{{ old('quote', $testimonial->quote) }}</textarea>
            @error('quote') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Avatar (Photo)</label>
            <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
            @error('avatar') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            @if($testimonial->avatar)
                <img src="{{ asset($testimonial->avatar) }}" style="width: 50px; height: 50px; border-radius: 50%; margin-top: 0.5rem; object-fit: cover; border:1px solid #ddd;">
                <p style="font-size:0.8rem; color:#888;">Upload baru untuk mengganti.</p>
            @endif
        </div>
        <div class="form-group">
            <label>Thumbnail (Preview)</label>
            <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
            @error('thumbnail') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            @if($testimonial->thumbnail)
                <img src="{{ asset($testimonial->thumbnail) }}" style="width: 100px; height: 60px; border-radius: 8px; margin-top: 0.5rem; object-fit: cover; border:1px solid #ddd;">
                <p style="font-size:0.8rem; color:#888;">Upload baru untuk mengganti.</p>
            @endif
        </div>
        <div class="form-group">
            <label>Video URL (Optional)</label>
            <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror" placeholder="https://youtube.com/..." value="{{ old('video_url', $testimonial->video_url) }}">
            @error('video_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin">Update Testimonial</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
