@extends('admin.layouts.app')

@section('title', 'Packages')
@section('page_title', 'Manage Ibadah Packages')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <form method="GET" action="{{ route('admin.packages.index') }}" style="display: flex; gap: 0.5rem; flex: 1; max-width: 400px;">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama paket..." class="form-control" style="margin: 0;">
        <button type="submit" class="btn-admin" style="white-space: nowrap;"><i class="fas fa-search"></i></button>
        @if($search)
        <a href="{{ route('admin.packages.index') }}" class="btn-admin-outline" style="white-space: nowrap;">Reset</a>
        @endif
    </form>
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
                @forelse($packages as $pkg)
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
                            <form action="{{ route('admin.packages.destroy', $pkg->id) }}" method="POST" class="delete-form">
                                @csrf @method('DELETE')
                                <button type="button" class="delete-btn" style="background: none; border: none; color: #dc3545; cursor: pointer;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center; color: #888; padding: 2rem;">
                    {{ $search ? 'Paket dengan kata kunci "'.$search.'" tidak ditemukan.' : 'Belum ada paket.' }}
                </td></tr>
                @endforelse
            </tbody>
        </table>
        @if($packages->hasPages())
        <div class="mt-3 d-flex justify-content-end">{{ $packages->links() }}</div>
        @endif
    </div>
</div>
@endsection
