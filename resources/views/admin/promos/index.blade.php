@extends('admin.layouts.app')
@section('title', 'Kelola Promo & Offering')
@section('page_title', 'Kelola Section Promo / Offering')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h3 style="margin: 0; color: var(--brand-dark);">Daftar Promo & Offering Benefit</h3>
            <p style="margin: 0.2rem 0 0; color: #666; font-size: 0.85rem;">Kelola visual promo, fasilitas kit, dan offering woman-centered untuk pengunjung website.</p>
        </div>
        <a href="{{ route('admin.promos.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Tambah Promo</a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 70px;">Gambar</th>
                    <th>Judul Promo</th>
                    <th>Badge / Category</th>
                    <th>Status</th>
                    <th>Urutan</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promos as $promo)
                    <tr>
                        <td>
                            @if($promo->image)
                                <img src="{{ asset($promo->image) }}" alt="{{ $promo->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="width: 50px; height: 50px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #aaa;"><i class="fas fa-image"></i></div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $promo->title }}</strong>
                            @if($promo->pdf_file)
                                <a href="{{ asset($promo->pdf_file) }}" target="_blank" style="margin-left: 6px; background: rgba(231,76,60,0.1); color: #e74c3c; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: 700; text-decoration: none;" title="File PDF Tersedia">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                            @endif
                            <br><small style="color: #888;">{{ \Illuminate\Support\Str::limit($promo->description, 60) }}</small>
                        </td>
                        <td>
                            @if($promo->badge)
                                <span style="background: rgba(139,94,60,0.1); color: var(--brand-gold); padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                    {{ $promo->badge }}
                                </span>
                            @else
                                <span style="color: #aaa;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($promo->is_active)
                                <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Aktif</span>
                            @else
                                <span style="background: #ffebee; color: #c62828; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Nonaktif</span>
                            @endif
                        </td>
                        <td>{{ $promo->sort_order }}</td>
                        <td style="text-align: center;">
                            <div class="action-buttons-group">
                                <a href="{{ route('landing.promo.show', $promo->slug) }}" target="_blank" class="btn-action btn-action-view" title="Pratinjau Halaman Detail"><i class="fas fa-eye"></i> View</a>
                                <a href="{{ route('admin.promos.edit', $promo->id) }}" class="btn-action btn-action-edit" title="Edit"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" class="delete-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-action btn-action-delete delete-btn" title="Hapus"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #888; padding: 2rem;">Belum ada promo yang ditambahkan. Silakan klik tombol "Tambah Promo".</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
