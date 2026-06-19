@extends('admin.layouts.app')

@section('title', 'Ubah Grup Keberangkatan')
@section('page_title', 'Ubah Grup Keberangkatan')

@section('content')
<div class="admin-card" style="max-width: 700px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.groups.index') }}" style="color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 4px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Grup
        </a>
    </div>

    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1.5rem;">Ubah Grup: {{ $group->name }}</h3>

    <form action="{{ route('admin.groups.update', $group->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Rombongan / Grup <span style="color: red;">*</span></label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $group->name) }}" required>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="departure_schedule_id">Pilih Jadwal Keberangkatan <span style="color: red;">*</span></label>
            <select name="departure_schedule_id" id="departure_schedule_id" class="form-control @error('departure_schedule_id') is-invalid @enderror" required>
                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}" {{ old('departure_schedule_id', $group->departure_schedule_id) == $schedule->id ? 'selected' : '' }}>
                        {{ $schedule->departure_date->format('d F Y') }} - {{ $schedule->package->title ?? 'Tanpa Paket' }}
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
                <input type="number" name="capacity" id="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity', $group->capacity) }}" min="1" required>
                @error('capacity')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="bus_number">Nomor Bus (Opsional)</label>
                <input type="text" name="bus_number" id="bus_number" class="form-control" value="{{ old('bus_number', $group->bus_number) }}">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="muthowif">Nama Muthowif (Opsional)</label>
                <input type="text" name="muthowif" id="muthowif" class="form-control" value="{{ old('muthowif', $group->muthowif) }}">
            </div>

            <div class="form-group">
                <label for="pembimbing">Pilih Pembimbing (Opsional)</label>
                <select name="pembimbing" id="pembimbing" class="form-control" style="padding: 0.8rem 1rem;">
                    <option value="">-- Pilih Pembimbing --</option>
                    @foreach($guides as $guide)
                        <option value="{{ $guide->name }}" {{ old('pembimbing', $group->pembimbing) == $guide->name ? 'selected' : '' }}>
                            {{ $guide->name }} ({{ $guide->role ?? 'Pembimbing' }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.groups.index') }}" class="btn-admin-outline" style="text-decoration: none;">Batal</a>
            <button type="submit" class="btn-admin">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
