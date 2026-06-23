@extends('admin.layouts.app')
@section('title', 'Edit FAQ')
@section('page_title', 'Edit Pertanyaan FAQ')
@section('content')
<div class="admin-card">
    <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label style="font-weight: 600;">Pertanyaan (Question)</label>
            <input type="text" name="question" class="form-control" value="{{ old('question', $faq->question) }}" required>
        </div>
        <div class="form-group mb-3">
            <label style="font-weight: 600;">Jawaban (Answer)</label>
            <textarea name="answer" class="form-control" rows="5" required>{{ old('answer', $faq->answer) }}</textarea>
        </div>
        <div class="grid-2">
            <div class="form-group mb-3">
                <label style="font-weight: 600;">Urutan (Order)</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $faq->order) }}" required>
                <small style="color: #666; font-size: 0.8rem;">Angka lebih kecil akan tampil lebih dulu.</small>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600;">Status Aktif</label>
                <div>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }} style="width: 20px; height: 20px;">
                        <span>Tampilkan di halaman utama</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn-admin" style="background: #95a5a6; border-color: #95a5a6;"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
