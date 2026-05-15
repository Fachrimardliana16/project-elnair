@extends('admin.layouts.app')
@section('title', 'Edit Feature')
@section('page_title', 'Edit Feature: ' . $feature->title)

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.features.update', $feature->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Icon (FontAwesome class, e.g. fas fa-kaaba)</label>
            <input type="text" name="icon" class="form-control" required value="{{ old('icon', $feature->icon) }}">
        </div>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title', $feature->title) }}">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $feature->description) }}</textarea>
        </div>
        <div class="form-group">
            <label>Order</label>
            <input type="number" name="order" class="form-control" value="{{ old('order', $feature->order) }}">
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Update Feature</button>
            <a href="{{ route('admin.features.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
