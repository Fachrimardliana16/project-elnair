@extends('admin.layouts.app')

@section('title', 'Daftar Jamaah')
@section('page_title', 'Manajemen Pendaftar Jamaah')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--brand-dark);"><i class="fas fa-users" style="color: var(--brand-gold);"></i> Database Jamaah</h3>
            <p style="color: #666; font-size: 0.9rem;">Kelola seluruh data pendaftar, pencarian jemaah, verifikasi berkas, dan status pelunasan.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(22, 163, 74, 0.1); color: #16a34a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.9rem;">
            <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Premium Search & Filter Dashboard -->
    <form action="{{ route('admin.jamaahs.index') }}" method="GET" style="background: #fdfcfa; border: 1px solid var(--brand-beige); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.25rem;">
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #555; text-transform: uppercase; margin-bottom: 6px;">Kata Kunci Pencarian</label>
                <input type="text" name="search" class="form-control" placeholder="Nama, NIK, atau Kontak WA..." value="{{ request('search') }}" style="padding: 0.6rem 0.8rem; font-size: 0.88rem;">
            </div>
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #555; text-transform: uppercase; margin-bottom: 6px;">Filter Paket</label>
                <select name="package_id" class="form-control" style="padding: 0.6rem 0.8rem; font-size: 0.88rem; height: auto;">
                    <option value="">-- Semua Paket --</option>
                    @foreach($packages as $pkg)
                        <option value="{{ $pkg->id }}" {{ request('package_id') == $pkg->id ? 'selected' : '' }}>{{ $pkg->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #555; text-transform: uppercase; margin-bottom: 6px;">Filter Jadwal</label>
                <select name="departure_schedule_id" class="form-control" style="padding: 0.6rem 0.8rem; font-size: 0.88rem; height: auto;">
                    <option value="">-- Semua Jadwal --</option>
                    @foreach($schedules as $sch)
                        <option value="{{ $sch->id }}" {{ request('departure_schedule_id') == $sch->id ? 'selected' : '' }}>
                            {{ $sch->departure_date->format('d M Y') }} - {{ $sch->package->title ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #555; text-transform: uppercase; margin-bottom: 6px;">Filter Status</label>
                <select name="status" class="form-control" style="padding: 0.6rem 0.8rem; font-size: 0.88rem; height: auto;">
                    <option value="">-- Semua Status --</option>
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="DP" {{ request('status') === 'DP' ? 'selected' : '' }}>DP (Telah Verifikasi)</option>
                    <option value="Lunas" {{ request('status') === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="Cancelled" {{ request('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin" style="padding: 0.6rem 1.5rem; font-size: 0.88rem;">
                <i class="fas fa-search"></i> Cari Jamaah
            </button>
            <a href="{{ route('admin.jamaahs.index', ['show_all' => 1]) }}" class="btn-admin-outline" style="padding: 0.6rem 1.5rem; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-list-ul"></i> Tampilkan Semua
            </a>
            @if($hasFilters)
                <a href="{{ route('admin.jamaahs.index') }}" class="btn-admin-outline" style="padding: 0.6rem 1.5rem; font-size: 0.88rem; border-color: #dc2626; color: #dc2626; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-undo"></i> Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Content Sections -->
    @if(!$hasFilters)
        <!-- Search Prompt Banner (Show initially instead of records) -->
        <div style="text-align: center; padding: 4rem 2rem; border: 2px dashed rgba(139, 94, 60, 0.2); border-radius: 15px; background: rgba(13, 76, 84, 0.01); margin-top: 1.5rem;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(13, 76, 84, 0.05); color: var(--brand-dark); display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin: 0 auto 1.5rem;">
                <i class="fas fa-search-location" style="color: var(--brand-gold);"></i>
            </div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 0.5rem;">Pusat Pencarian Data Jamaah</h3>
            <p style="color: #666; font-size: 0.92rem; max-width: 500px; margin: 0 auto 1.5rem; line-height: 1.6;">
                Gunakan panel pencarian di atas untuk memfilter data jamaah berdasarkan kata kunci (nama, NIK, kontak WA) atau pilih paket, jadwal keberangkatan, dan status.
            </p>
            <div style="display: flex; justify-content: center; gap: 10px;">
                <a href="{{ route('admin.jamaahs.index', ['show_all' => 1]) }}" class="btn-admin" style="font-size: 0.88rem; padding: 0.6rem 1.5rem;">
                    <i class="fas fa-users"></i> Tampilkan Semua Jamaah
                </a>
            </div>
        </div>
    @else
        <!-- Results Table -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Jamaah</th>
                        <th>Paket & Jadwal</th>
                        <th>Kontak WA & Domisili</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jamaahs as $jamaah)
                        <tr>
                            <td style="font-weight: 600; color: var(--brand-dark);">
                                {{ $jamaah->name }}
                                <br>
                                <small style="color: #666; font-weight: normal;">NIK: {{ $jamaah->nik }}</small>
                            </td>
                            <td>
                                @if($jamaah->package)
                                    <span style="font-weight: 600;">{{ $jamaah->package->title }}</span>
                                @else
                                    <span style="color: #bbb;">Belum pilih paket</span>
                                @endif
                                <br>
                                <small style="color: #888;">
                                    <i class="far fa-calendar-alt"></i> 
                                    {{ $jamaah->departureSchedule ? $jamaah->departureSchedule->departure_date->format('d M Y') : 'Jadwal belum ditentukan' }}
                                </small>
                            </td>
                            <td>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $jamaah->whatsapp) }}" target="_blank" style="color: #16a34a; font-weight: 600; text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fab fa-whatsapp"></i> {{ $jamaah->whatsapp }}
                                </a>
                                <br>
                                <small style="color: #666;">Domisili: {{ $jamaah->city ?? '-' }}</small>
                            </td>
                            <td>
                                <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;
                                    @if($jamaah->status === 'Pending')
                                        background: rgba(245, 158, 11, 0.1); color: #d97706;
                                    @elseif($jamaah->status === 'DP')
                                        background: rgba(59, 130, 246, 0.1); color: #2563eb;
                                    @elseif($jamaah->status === 'Lunas')
                                        background: rgba(16, 185, 129, 0.1); color: #059669;
                                    @else
                                        background: rgba(220, 38, 38, 0.1); color: #dc2626;
                                    @endif
                                ">
                                    {{ $jamaah->status }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons-group" style="justify-content: flex-end;">
                                    <a href="{{ route('admin.jamaahs.show', $jamaah->id) }}" class="btn-action btn-action-view" title="Lihat Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.jamaahs.edit', $jamaah->id) }}" class="btn-action btn-action-edit" title="Update Status">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.jamaahs.destroy', $jamaah->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data jamaah ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-action-delete" title="Hapus">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #888; padding: 3rem;">
                                <i class="fas fa-users-slash" style="font-size: 2.5rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
                                Tidak ditemukan data jamaah yang cocok dengan kriteria pencarian Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jamaahs && $jamaahs->hasPages())
            <div style="margin-top: 1.5rem;">
                {{ $jamaahs->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
