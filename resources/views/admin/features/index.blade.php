@extends('admin.layouts.app')
@section('title', 'Features')
@section('page_title', 'Manage Why Choose Us')
@section('content')
<div class="admin-card">
    <div style="text-align: right; margin-bottom: 1rem;">
        <a href="{{ route('admin.features.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Add Feature</a>
    </div>
    <table>
        <thead>
            <tr><th>Icon</th><th>Title</th><th>Order</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse(\App\Models\Feature::orderBy('order')->get() as $item)
                <tr>
                    <td><i class="{{ $item->icon }}"></i></td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->order }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.features.edit', $item->id) }}" style="color: #4a90e2;"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.features.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align: center; color: #888;">No features found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
