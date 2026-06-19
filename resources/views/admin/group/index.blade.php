@extends('admin.layouts.app')

@section('title', 'Grup Keberangkatan')
@section('page_title', 'Manajemen Grup Keberangkatan')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark);">Daftar Rombongan Jemaah</h3>
            <p style="color: #666; font-size: 0.9rem;">Kelola pengelompokan jemaah, manifest penerbangan, dan penempatan kamar hotel.</p>
        </div>
        <a href="{{ route('admin.groups.create') }}" class="btn-admin">
            <i class="fas fa-plus"></i> Tambah Grup Baru
        </a>
    </div>

    @if(session('success'))
        <div style="background: rgba(22, 163, 74, 0.1); color: #16a34a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.9rem;">
            <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Grup</th>
                    <th>Jadwal Keberangkatan</th>
                    <th>Muthowif / Pembimbing</th>
                    <th>Jumlah Jemaah</th>
                    <th>Kode Booking</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groups as $group)
                <tr>
                    <td style="font-weight: 600; color: var(--brand-dark);">{{ $group->name }}</td>
                    <td>
                        @if($group->departureSchedule)
                            <span style="font-weight: 500;">
                                {{ $group->departureSchedule->departure_date->format('d M Y') }}
                            </span>
                            <br>
                            <small style="color: #888;">{{ $group->departureSchedule->package->title ?? '' }}</small>
                        @else
                            <span style="color: #bbb;">Belum Ditentukan</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-size: 0.9rem;"><i class="fas fa-user-shield" style="color: var(--brand-gold); width: 18px;"></i> {{ $group->muthowif ?? '-' }}</span>
                        <br>
                        <small style="color: #666;"><i class="fas fa-user-tie" style="color: #888; width: 18px;"></i> {{ $group->pembimbing ?? '-' }}</small>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-weight: 700; color: var(--brand-dark);">{{ $group->jamaahs_count }}</span>
                            <span style="color: #aaa;">/</span>
                            <span style="color: #888;">{{ $group->capacity }} Seat</span>
                        </div>
                        <div style="width: 100px; height: 6px; background: #eee; border-radius: 10px; overflow: hidden; margin-top: 4px;">
                            <div style="width: {{ min(100, ($group->jamaahs_count / $group->capacity) * 100) }}%; height: 100%; background: var(--brand-gold);"></div>
                        </div>
                    </td>
                    <td>
                        <code style="background: rgba(139, 94, 60, 0.1); color: var(--brand-gold); padding: 2px 6px; border-radius: 4px; font-weight: 600; font-size: 0.85rem;">
                            {{ $group->booking_code ?? 'BELUM ADA' }}
                        </code>
                    </td>
                    <td>
                        <div class="action-buttons-group">
                            <a href="{{ route('admin.groups.show', $group->id) }}" class="btn-action btn-action-view" title="Kelola Rombongan">
                                <i class="fas fa-folder-open"></i> Kelola
                            </a>
                            <a href="{{ route('admin.groups.edit', $group->id) }}" class="btn-action btn-action-edit" title="Edit Grup">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus grup ini? Jemaah di dalamnya akan dilepas kembali.')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-action-delete" title="Hapus Grup">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #888; padding: 3rem;">
                        <i class="fas fa-users" style="font-size: 2.5rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
                        Belum ada grup keberangkatan yang dibuat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $groups->links() }}
    </div>
</div>
@endsection
