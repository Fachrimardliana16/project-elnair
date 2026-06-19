@extends('admin.layouts.app')

@section('title', 'Jadwal Keberangkatan')
@section('page_title', 'Manajemen Jadwal Keberangkatan')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark);"><i class="fas fa-calendar-alt" style="color: var(--brand-gold);"></i> Jadwal Keberangkatan</h3>
            <p style="color: #666; font-size: 0.9rem;">Kelola rilis tanggal keberangkatan, ketersediaan seat, dan status kloter untuk tiap paket umrah/haji.</p>
        </div>
        <a href="{{ route('admin.schedules.create') }}" class="btn-admin">
            <i class="fas fa-plus"></i> Tambah Jadwal Baru
        </a>
    </div>

    <!-- Search Box -->
    <div style="margin-bottom: 1.5rem;">
        <form action="{{ route('admin.schedules.index') }}" method="GET" style="display: flex; gap: 0.5rem; max-width: 500px;">
            <input type="text" name="search" class="form-control" placeholder="Cari paket atau tanggal keberangkatan..." value="{{ $search }}" style="padding: 0.6rem 1rem;">
            <button type="submit" class="btn-admin" style="padding: 0.6rem 1.5rem;"><i class="fas fa-search"></i> Cari</button>
            @if($search)
                <a href="{{ route('admin.schedules.index') }}" class="btn-admin-outline" style="padding: 0.6rem 1.2rem; text-decoration: none; display: flex; align-items: center; justify-content: center;">Reset</a>
            @endif
        </form>
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
                    <th>Paket Umrah / Haji</th>
                    <th>Tanggal Keberangkatan</th>
                    <th>Ketersediaan Seat</th>
                    <th>Status Kloter</th>
                    <th>Status Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                <tr>
                    <td style="font-weight: 600; color: var(--brand-dark);">
                        {{ $schedule->package->title ?? 'Tanpa Paket' }}
                        <br>
                        <small style="color: #888; font-weight: normal;">Harga: {{ $schedule->package->price_label ?? '' }} {{ $schedule->package->price_value ?? '-' }}</small>
                    </td>
                    <td style="font-weight: 600;">
                        {{ $schedule->departure_date->format('d M Y') }}
                    </td>
                    <td>
                        <span style="font-weight: 700; color: var(--brand-dark);">{{ $schedule->available_seats }} Seat</span>
                    </td>
                    <td>
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;
                            @if($schedule->status === 'Tersedia')
                                background: rgba(22, 163, 74, 0.1); color: #16a34a;
                            @elseif($schedule->status === 'Hampir Penuh')
                                background: rgba(234, 179, 8, 0.1); color: #ca8a04;
                            @else
                                background: rgba(220, 38, 38, 0.1); color: #dc2626;
                            @endif
                        ">
                            {{ $schedule->status }}
                        </span>
                    </td>
                    <td>
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;
                            background: {{ $schedule->is_active ? 'rgba(13, 76, 84, 0.1)' : '#eee' }};
                            color: {{ $schedule->is_active ? 'var(--brand-dark)' : '#888' }};
                        ">
                            {{ $schedule->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons-group">
                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn-action btn-action-edit" title="Edit Jadwal">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal keberangkatan ini?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-action-delete" title="Hapus Jadwal">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #888; padding: 3rem;">
                        <i class="fas fa-calendar-times" style="font-size: 2.5rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
                        Belum ada jadwal keberangkatan yang didaftarkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $schedules->links() }}
    </div>
</div>
@endsection
