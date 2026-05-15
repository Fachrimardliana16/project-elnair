@extends('admin.layouts.app')
@section('title', 'Edit Landing Page')
@section('page_title', 'Edit Sales Landing Page: ' . $landingPage->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.landing-pages.update', $landingPage->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Page Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title', $landingPage->title) }}">
        </div>
        <div class="form-group">
            <label>Page Content (HTML or Markdown supported)</label>
            <textarea name="content" class="form-control" rows="15">{{ old('content', $landingPage->content) }}</textarea>
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Update Landing Page</button>
            <a href="{{ route('admin.landing-pages.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
