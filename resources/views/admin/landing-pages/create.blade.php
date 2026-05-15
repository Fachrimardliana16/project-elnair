@extends('admin.layouts.app')
@section('title', 'New Landing Page')
@section('page_title', 'Create Sales Landing Page')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.landing-pages.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Page Title</label>
            <input type="text" name="title" class="form-control" required placeholder="e.g. Promo Ramadhan 2024">
        </div>
        <div class="form-group">
            <label>Page Content (HTML or Markdown supported)</label>
            <textarea name="content" class="form-control" rows="15" placeholder="Enter landing page content..."></textarea>
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Create Landing Page</button>
            <a href="{{ route('admin.landing-pages.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
