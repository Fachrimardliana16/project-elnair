@extends('admin.layouts.app')

@section('title', 'Packages')
@section('page_title', 'Manage Ibadah Packages')

@section('content')
<div style="margin-bottom: 2rem; text-align: right;">
    <a href="{{ route('admin.packages.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Add New Package</a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packages as $pkg)
                <tr>
                    <td><img src="{{ asset($pkg->image) }}" style="width: 80px; height: 50px; object-fit: cover; border-radius: 5px;"></td>
                    <td style="font-weight: 600;">{{ $pkg->title }}</td>
                    <td>{{ $pkg->price_label }} {{ $pkg->price_value }}</td>
                    <td>
                        <span style="background: {{ $pkg->is_active ? '#d4edda' : '#f8d7da' }}; color: {{ $pkg->is_active ? '#155724' : '#721c24' }}; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem;">
                            {{ $pkg->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.packages.edit', $pkg->id) }}" style="color: var(--brand-dark);"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.packages.destroy', $pkg->id) }}" method="POST" onsubmit="return confirm('Delete this package?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
