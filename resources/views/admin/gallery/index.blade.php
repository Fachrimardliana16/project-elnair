@extends('admin.layouts.app')
@section('title', 'Gallery')
@section('page_title', 'Gallery Management')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 style="margin: 0;">Gallery Items</h3>
        <a href="{{ route('admin.gallery.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Add Image</a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
        @foreach($galleries as $item)
        <div style="background: #fdfdfd; border: 1px solid #eee; border-radius: 10px; overflow: hidden; position: relative;">
            <img src="{{ asset($item->image) }}" style="width: 100%; height: 150px; object-fit: cover;">
            <div style="padding: 1rem;">
                <h5 style="margin: 0; font-size: 0.9rem;">{{ $item->title }}</h5>
                <p style="color: #888; font-size: 0.75rem; margin-top: 0.3rem;">{{ $item->category }}</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                    <a href="{{ route('admin.gallery.edit', $item->id) }}" style="color: #4a90e2; font-size: 0.8rem; text-decoration: none;"><i class="fas fa-edit"></i> Edit</a>
                    <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 0.8rem; padding: 0;"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if($galleries->hasPages())
    <div class="mt-3 d-flex justify-content-end">{{ $galleries->links() }}</div>
    @endif
</div>
@endsection
