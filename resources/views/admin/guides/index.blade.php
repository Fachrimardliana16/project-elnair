@extends('admin.layouts.app')

@section('title', 'Pembimbing (Asatidz)')
@section('page_title', 'Daftar Pembimbing')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.guides.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Tambah Pembimbing</a>
</div>

<div class="admin-card">
    <div class="table-responsive">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Peran</th>
                <th>Urutan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guides as $guide)
            <tr>
                <td>
                    @if($guide->image)
                        <img src="{{ str_starts_with($guide->image, 'http') ? $guide->image : asset($guide->image) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                    @else
                        <div style="width: 50px; height: 50px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #999;">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </td>
                <td><strong>{{ $guide->name }}</strong></td>
                <td>{{ $guide->role }}</td>
                <td>{{ $guide->order }}</td>
                <td>
                    @if($guide->is_active)
                        <span class="badge" style="background: #e2f5ec; color: #25d366;">Aktif</span>
                    @else
                        <span class="badge" style="background: #ffe5e5; color: #dc3545;">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.guides.edit', $guide->id) }}" class="btn-admin-outline" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.guides.destroy', $guide->id) }}" method="POST" class="delete-form" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-btn btn-admin-outline" style="padding: 0.3rem 0.6rem; font-size: 0.8rem; border-color: #dc3545; color: #dc3545;"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($guides->hasPages())
    <div class="mt-3 d-flex justify-content-end">{{ $guides->links() }}</div>
    @endif
    </div>
</div>
@endsection
