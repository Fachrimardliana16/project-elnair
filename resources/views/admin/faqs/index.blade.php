@extends('admin.layouts.app')
@section('title', 'Kelola FAQ')
@section('page_title', 'Daftar Frequently Asked Questions (FAQ)')
@section('content')
<div class="admin-card">
    <div style="text-align: right; margin-bottom: 1rem;">
        <a href="{{ route('admin.faqs.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Tambah FAQ</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Pertanyaan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $item)
                    <tr>
                        <td style="width: 80px; text-align: center;">{{ $item->order }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->question, 60) }}</td>
                        <td>
                            @if($item->is_active)
                                <span style="background: #e8f5e9; color: #2e7d32; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem;">Aktif</span>
                            @else
                                <span style="background: #ffebee; color: #c62828; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem;">Nonaktif</span>
                            @endif
                        </td>
                        <td style="width: 100px;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="{{ route('admin.faqs.edit', $item->id) }}" style="color: #4a90e2;" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.faqs.destroy', $item->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0;" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align: center; color: #888; padding: 2rem;">Belum ada FAQ yang ditambahkan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
