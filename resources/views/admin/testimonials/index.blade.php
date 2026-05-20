@extends('admin.layouts.app')
@section('title', 'Testimonials')
@section('page_title', 'Manage Customer Stories')
@section('content')
<div class="admin-card">
    <div style="text-align: right; margin-bottom: 1rem;">
        <a href="{{ route('admin.testimonials.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Add Testimonial</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr><th>Name</th><th>Role</th><th>Quote</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($testimonials as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->role_label }}</td>
                        <td>{{ Str::limit($item->quote, 50) }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.testimonials.edit', $item->id) }}" style="color: #4a90e2;"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.testimonials.destroy', $item->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="delete-btn" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0;"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align: center; color: #888; padding: 2rem;">Belum ada testimoni.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($testimonials->hasPages())
        <div class="mt-3 d-flex justify-content-end">{{ $testimonials->links() }}</div>
        @endif
    </div>
</div>
@endsection
