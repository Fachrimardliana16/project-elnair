@extends('admin.layouts.app')
@section('title', 'Tambah Langkah Alur Kerja')
@section('page_title', 'Tambah Tahapan Alur Kerja Baru')

@section('content')
<div class="admin-card">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.workflows.index') }}" class="btn-admin-outline"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
    </div>

    <form action="{{ route('admin.workflows.store') }}" method="POST">
        @csrf
        
        <div class="grid-2">
            <div class="form-group">
                <label for="step_number">Nomor Langkah (Step) <span style="color:red;">*</span></label>
                <input type="number" name="step_number" id="step_number" class="form-control @error('step_number') is-invalid @enderror" value="{{ old('step_number', $nextStep) }}" required>
                @error('step_number')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="icon">Class Icon (FontAwesome)</label>
                <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', 'fa-check-circle') }}" placeholder="fa-kaaba, fa-whatsapp, fa-heart">
                <small style="color: #888;">Gunakan class FontAwesome 6 (contoh: <code>fa-kaaba</code>, <code>fa-brands fa-whatsapp</code>, <code>fa-heart</code>)</small>
            </div>
        </div>

        <div class="form-group">
            <label for="title">Judul Tahapan <span style="color:red;">*</span></label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Pilih Layanan, Pesan melalui Whatsapp, Ibadah Aman dan Lancar" required>
            @error('title')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tagline">Tagline / Subtitle Khusus (Opsional)</label>
            <input type="text" name="tagline" id="tagline" class="form-control" value="{{ old('tagline') }}" placeholder="Contoh: Ibadah aman bersama kami">
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Penjelasan Langkah</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Jelaskan detail yang perlu dilakukan konsumen pada tahap ini...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <span>Aktifkan Tahap ini di Website</span>
            </label>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Simpan Tahap Alur Kerja</button>
        </div>
    </form>
</div>
@endsection
