@extends('admin.layouts.app')
@section('title', 'Testimonials')
@section('page_title', 'Manage Customer Stories')
@section('content')
<div class="admin-card">
    <div style="text-align: right; margin-bottom: 1rem;">
        <button class="btn-admin"><i class="fas fa-plus"></i> Add Testimonial</button>
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
                    <td><div style="display: flex; gap: 0.5rem;"><i class="fas fa-edit"></i> <i class="fas fa-trash"></i></div></td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align: center; color: #888;">No testimonials found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
