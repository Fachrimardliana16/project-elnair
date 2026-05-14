@extends('admin.layouts.app')
@section('title', 'Add Testimonial')
@section('page_title', 'Add New Testimonial')
@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Role (e.g. Jamaah Umroh 2023)</label>
            <input type="text" name="role_label" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Testimonial Quote</label>
            <textarea name="quote" class="form-control" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label>Avatar (Photo)</label>
            <input type="file" name="avatar" class="form-control">
        </div>
        <div class="form-group">
            <label>Video URL (Optional)</label>
            <input type="url" name="video_url" class="form-control" placeholder="https://youtube.com/...">
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Save Testimonial</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
