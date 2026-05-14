@extends('admin.layouts.app')
@section('title', 'Add Feature')
@section('page_title', 'Add New Feature')
@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.features.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Icon Class (FontAwesome, e.g. fas fa-heart)</label>
            <input type="text" name="icon" class="form-control" placeholder="fas fa-check" required>
        </div>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="order" class="form-control" value="0">
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Save Feature</button>
            <a href="{{ route('admin.features.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
