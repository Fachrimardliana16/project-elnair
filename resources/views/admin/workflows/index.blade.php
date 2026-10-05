@extends('admin.layouts.app')
@section('title', 'Kelola Alur Kerja / Workflow')
@section('page_title', 'Kelola Alur Kerja (Workflow) Layanan')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h3 style="margin: 0; color: var(--brand-dark);">Tahapan Alur Kerja Layanan</h3>
            <p style="margin: 0.2rem 0 0; color: #666; font-size: 0.85rem;">Kelola langkah-langkah alur pemesanan & tagline "Ibadah aman bersama kami".</p>
        </div>
        <a href="{{ route('admin.workflows.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Tambah Langkah</a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 70px;">Step</th>
                    <th style="width: 60px;">Icon</th>
                    <th>Judul Langkah</th>
                    <th>Tagline / Subtitle</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($workflows as $item)
                    <tr>
                        <td style="font-weight: 800; color: var(--brand-gold); text-align: center; font-size: 1.1rem;">
                            #{{ $item->step_number }}
                        </td>
                        <td style="text-align: center;">
                            <div style="width: 36px; height: 36px; background: rgba(13,76,84,0.1); color: var(--brand-dark); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas {{ $item->icon }}"></i>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $item->title }}</strong>
                            <br><small style="color: #888;">{{ \Illuminate\Support\Str::limit($item->description, 60) }}</small>
                        </td>
                        <td>
                            @if($item->tagline)
                                <span style="background: rgba(139,94,60,0.1); color: var(--brand-gold); padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                    {{ $item->tagline }}
                                </span>
                            @else
                                <span style="color: #aaa;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($item->is_active)
                                <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Aktif</span>
                            @else
                                <span style="background: #ffebee; color: #c62828; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Nonaktif</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div class="action-buttons-group">
                                <a href="{{ route('admin.workflows.edit', $item->id) }}" class="btn-action btn-action-edit" title="Edit"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.workflows.destroy', $item->id) }}" method="POST" class="delete-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-action btn-action-delete delete-btn" title="Hapus"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #888; padding: 2rem;">Belum ada langkah alur kerja. Silakan tambah data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
