@extends('admin.layouts.app')

@section('title', 'Edit Package')
@section('page_title', 'Edit Package: ' . $package->title)

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Package Title</label>
            <input type="text" name="title" class="form-control" value="{{ $package->title }}" required>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label>Price Label (e.g. IDR)</label>
                <input type="text" name="price_label" class="form-control" value="{{ $package->price_label }}" required>
            </div>
            <div class="form-group">
                <label>Price Value (e.g. 350jt)</label>
                <input type="text" name="price_value" class="form-control" value="{{ $package->price_value }}" required>
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="5" required>{{ $package->description }}</textarea>
        </div>
        <div class="form-group">
            <label>Package Image</label>
            <input type="file" name="image" class="form-control">
            <div style="margin-top: 1rem;">
                <img src="{{ asset($package->image) }}" style="width: 150px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
            </div>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ $package->is_active ? 'checked' : '' }}> Active / Visible on Website
            </label>
        </div>
        
        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Update Package</button>
            <a href="{{ route('admin.packages.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
