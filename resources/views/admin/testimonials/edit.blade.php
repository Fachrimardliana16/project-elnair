@extends('admin.layouts.app')
@section('title', 'Edit Testimonial')
@section('page_title', 'Edit Testimonial: ' . $testimonial->name)

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $testimonial->name) }}">
        </div>
        <div class="form-group">
            <label>Role (e.g. Jamaah Umroh 2023)</label>
            <input type="text" name="role_label" class="form-control" required value="{{ old('role_label', $testimonial->role_label) }}">
        </div>
        <div class="form-group">
            <label>Testimonial Quote</label>
            <textarea name="quote" class="form-control" rows="4" required>{{ old('quote', $testimonial->quote) }}</textarea>
        </div>
        <div class="form-group">
            <label>Avatar (Photo)</label>
            <input type="file" name="avatar" class="form-control">
            @if($testimonial->avatar)
                <img src="{{ asset($testimonial->avatar) }}" style="width: 50px; height: 50px; border-radius: 50%; margin-top: 0.5rem; object-fit: cover;">
            @endif
        </div>
        <div class="form-group">
            <label>Thumbnail (Preview)</label>
            <input type="file" name="thumbnail" class="form-control">
            @if($testimonial->thumbnail)
                <img src="{{ asset($testimonial->thumbnail) }}" style="width: 100px; height: 60px; border-radius: 8px; margin-top: 0.5rem; object-fit: cover;">
            @endif
        </div>
        <div class="form-group">
            <label>Video URL (Optional)</label>
            <input type="url" name="video_url" class="form-control" placeholder="https://youtube.com/..." value="{{ old('video_url', $testimonial->video_url) }}">
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Update Testimonial</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
