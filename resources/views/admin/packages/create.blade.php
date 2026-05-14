@extends('admin.layouts.app')

@section('title', 'Add Package')
@section('page_title', 'Create New Package')

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Package Title</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Haji Furoda Luxury" required>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label>Price Label (e.g. IDR)</label>
                <input type="text" name="price_label" class="form-control" placeholder="IDR" required>
            </div>
            <div class="form-group">
                <label>Price Value (e.g. 350jt)</label>
                <input type="text" name="price_value" class="form-control" placeholder="350jt" required>
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="5" placeholder="Brief details about the package..." required></textarea>
        </div>
        <div class="form-group">
            <label>Package Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" checked> Active / Visible on Website
            </label>
        </div>
        
        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Create Package</button>
            <a href="{{ route('admin.packages.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
