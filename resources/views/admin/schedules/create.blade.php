@extends('admin.layouts.app')

@section('title', 'Tambah Jadwal Keberangkatan')
@section('page_title', 'Tambah Jadwal Baru')

@section('content')
<div class="admin-card" style="max-width: 700px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.schedules.index') }}" style="color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 4px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Jadwal
        </a>
    </div>

    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1.5rem;">Form Jadwal Keberangkatan Baru</h3>

    <form action="{{ route('admin.schedules.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="package_id">Pilih Paket Umrah / Haji <span style="color: red;">*</span></label>
            <select name="package_id" id="package_id" class="form-control @error('package_id') is-invalid @enderror" required style="padding: 0.75rem 1rem;">
                <option value="" disabled selected>-- Pilih Paket --</option>
                @foreach($packages as $package)
                    <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                        {{ $package->title }} (Harga: {{ $package->price_label }} {{ $package->price_value }})
                    </option>
                @endforeach
            </select>
            @error('package_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="departure_date">Tanggal Keberangkatan <span style="color: red;">*</span></label>
                <input type="date" name="departure_date" id="departure_date" class="form-control @error('departure_date') is-invalid @enderror" value="{{ old('departure_date') }}" required style="padding: 0.75rem 1rem;">
                @error('departure_date')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="available_seats">Ketersediaan Seat / Kuota <span style="color: red;">*</span></label>
                <input type="number" name="available_seats" id="available_seats" class="form-control @error('available_seats') is-invalid @enderror" value="{{ old('available_seats', 45) }}" min="0" required style="padding: 0.75rem 1rem;">
                @error('available_seats')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="status">Status Kloter <span style="color: red;">*</span></label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required style="padding: 0.75rem 1rem;">
                    <option value="Tersedia" {{ old('status') === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Hampir Penuh" {{ old('status') === 'Hampir Penuh' ? 'selected' : '' }}>Hampir Penuh</option>
                    <option value="Penuh" {{ old('status') === 'Penuh' ? 'selected' : '' }}>Penuh / Sold Out</option>
                </select>
                @error('status')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="display: flex; align-items: center; margin-top: 2rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer; user-select: none;">
                    <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: var(--brand-dark);">
                    Aktifkan Jadwal Keberangkatan (Ditampilkan ke Publik)
                </label>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.schedules.index') }}" class="btn-admin-outline" style="text-decoration: none;">Batal</a>
            <button type="submit" class="btn-admin">
                <i class="fas fa-save"></i> Simpan Jadwal
            </button>
        </div>
    </form>
</div>
@endsection
