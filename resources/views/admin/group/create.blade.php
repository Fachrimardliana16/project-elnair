@extends('admin.layouts.app')

@section('title', 'Tambah Grup Keberangkatan')
@section('page_title', 'Buat Grup Keberangkatan Baru')

@section('content')
<div class="admin-card" style="max-width: 700px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.groups.index') }}" style="color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 4px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Grup
        </a>
    </div>

    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1.5rem;">Form Pembuatan Grup</h3>

    <form action="{{ route('admin.groups.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nama Rombongan / Grup <span style="color: red;">*</span></label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Group Umrah Ramadhan Syawal 2026" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="departure_schedule_id">Pilih Jadwal Keberangkatan <span style="color: red;">*</span></label>
            <select name="departure_schedule_id" id="departure_schedule_id" class="form-control @error('departure_schedule_id') is-invalid @enderror" required>
                <option value="" disabled selected>-- Pilih Tanggal & Paket --</option>
                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}" {{ old('departure_schedule_id') == $schedule->id ? 'selected' : '' }}>
                        {{ $schedule->departure_date->format('d F Y') }} - {{ $schedule->package->title ?? 'Tanpa Paket' }} (Sisa {{ $schedule->available_seats }} Kursi)
                    </option>
                @endforeach
            </select>
            @error('departure_schedule_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="capacity">Kapasitas Maksimal Seat <span style="color: red;">*</span></label>
                <input type="number" name="capacity" id="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity', 45) }}" min="1" required>
                @error('capacity')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="bus_number">Nomor Bus (Opsional)</label>
                <input type="text" name="bus_number" id="bus_number" class="form-control" placeholder="Contoh: Bus A / Bus 1" value="{{ old('bus_number') }}">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="muthowif">Nama Muthowif (Opsional)</label>
                <input type="text" name="muthowif" id="muthowif" class="form-control" placeholder="Contoh: Ustadz Syarifudin" value="{{ old('muthowif') }}">
            </div>

            <div class="form-group">
                <label for="pembimbing">Pilih Pembimbing (Opsional)</label>
                <select name="pembimbing" id="pembimbing" class="form-control" style="padding: 0.8rem 1rem;">
                    <option value="">-- Pilih Pembimbing --</option>
                    @foreach($guides as $guide)
                        <option value="{{ $guide->name }}" {{ old('pembimbing') == $guide->name ? 'selected' : '' }}>
                            {{ $guide->name }} ({{ $guide->role ?? 'Pembimbing' }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.groups.index') }}" class="btn-admin-outline" style="text-decoration: none;">Batal</a>
            <button type="submit" class="btn-admin">
                <i class="fas fa-save"></i> Simpan Grup
            </button>
        </div>
    </form>
</div>
@endsection
