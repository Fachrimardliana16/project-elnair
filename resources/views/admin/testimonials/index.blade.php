@extends('admin.layouts.app')
@section('title', 'Testimonials')
@section('page_title', 'Manage Customer Stories')
@section('content')
<div class="admin-card">
    <div style="text-align: right; margin-bottom: 1rem;">
        <a href="{{ route('admin.testimonials.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Add Testimonial</a>
    </div>
    <table>
        <thead>
            <tr><th>Name</th><th>Role</th><th>Quote</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse(\App\Models\Testimonial::all() as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->role_label }}</td>
                    <td>{{ Str::limit($item->quote, 50) }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.testimonials.edit', $item->id) }}" style="color: #4a90e2;"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.testimonials.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align: center; color: #888;">No testimonials found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
