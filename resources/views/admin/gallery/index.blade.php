@extends('admin.layouts.app')

@section('title', 'Galeri Foto')
@section('page_title', 'Manajemen Galeri')

@section('styles')
<style>
    .album-btn {
        padding: 0.5rem 1rem;
        background: white;
        border: 1px solid var(--brand-beige);
        border-radius: 20px;
        color: #666;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: 0.3s;
        display: inline-block;
    }
    .album-btn:hover, .album-btn.active {
        background: var(--brand-dark);
        color: white;
        border-color: var(--brand-dark);
    }
    .gallery-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(13, 76, 84, 0.9);
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
</style>
@endsection

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark);"><i class="fas fa-images" style="color: var(--brand-gold);"></i> Album Galeri Foto</h3>
            <p style="color: #666; font-size: 0.9rem;">Kelola dokumentasi perjalanan, kegiatan manasik, hotel, dan testimoni visual jemaah.</p>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="btn-admin">
            <i class="fas fa-plus"></i> Tambah Foto Baru
        </a>
    </div>

    @if(session('success'))
        <div style="background: rgba(22, 163, 74, 0.1); color: #16a34a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.9rem;">
            <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Album Filter Tab Bar -->
    <div style="display: flex; gap: 0.5rem; margin-bottom: 2rem; flex-wrap: wrap; overflow-x: auto; padding-bottom: 0.5rem;">
        <a href="{{ route('admin.gallery.index') }}" class="album-btn {{ !$selectedCategory ? 'active' : '' }}">
            Semua Album
        </a>
        @foreach($categories as $category)
            <a href="{{ route('admin.gallery.index', ['category' => $category]) }}" class="album-btn {{ $selectedCategory === $category ? 'active' : '' }}">
                📁 {{ $category }}
            </a>
        @endforeach
    </div>

    <!-- Gallery Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
        @forelse($galleries as $item)
        <div style="background: white; border: 1px solid var(--brand-beige); border-radius: 12px; overflow: hidden; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            
            <!-- Album/Category Badge -->
            <span class="gallery-badge">
                {{ $item->category ?? 'Lainnya' }}
            </span>
            
            <img src="{{ asset($item->image) }}" style="width: 100%; height: 160px; object-fit: cover;">
            
            <div style="padding: 1rem;">
                <h5 style="margin: 0; font-size: 0.9rem; font-weight: 700; color: var(--brand-dark); min-height: 2.7rem; line-height: 1.3;">
                    {{ $item->title }}
                </h5>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; border-top: 1px solid #f5f5f5; padding-top: 0.75rem;">
                    <a href="{{ route('admin.gallery.edit', $item->id) }}" style="color: var(--brand-gold); font-size: 0.8rem; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    
                    <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 0.8rem; padding: 0; font-weight: 600; font-family: inherit;">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align: center; color: #888; padding: 4rem;">
            <i class="fas fa-images" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
            Belum ada foto yang diunggah ke dalam album ini.
        </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
    <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
        {{ $galleries->links() }}
    </div>
    @endif
</div>
@endsection
