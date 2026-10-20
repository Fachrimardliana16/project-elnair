@extends('admin.layouts.app')

@section('title', 'Edit Package')
@section('page_title', 'Edit Package: ' . $package->title)

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Package Title <span style="color:#dc3545;">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $package->title) }}" required>
            @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="grid-2" style="gap: 1rem;">
            <div class="form-group">
                <label>Price Label <span style="color:#dc3545;">*</span></label>
                <input type="text" name="price_label" class="form-control @error('price_label') is-invalid @enderror" value="{{ old('price_label', $package->price_label) }}" required>
                @error('price_label') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Price Value <span style="color:#dc3545;">*</span></label>
                <input type="text" name="price_value" class="form-control @error('price_value') is-invalid @enderror" value="{{ old('price_value', $package->price_value) }}" required>
                @error('price_value') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Description <span style="color:#dc3545;">*</span></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $package->description) }}</textarea>
            @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Package Image (Thumbnail)</label>
            @if($package->image)
            <div style="margin-bottom: 0.8rem; display: flex; align-items: center; gap: 1rem; padding: 0.6rem; background: rgba(0,0,0,0.02); border: 1px solid #eee; border-radius: 8px;">
                <img src="{{ str_starts_with($package->image, 'http') ? $package->image : asset($package->image) }}" style="width: 120px; height: 80px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                <div>
                    <span class="badge" style="background: rgba(39, 174, 96, 0.15); color: #27ae60; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">
                        <i class="fas fa-check"></i> Gambar Thumbnail Aktif
                    </span>
                    <p style="font-size:0.8rem; color:#666; margin:0.3rem 0 0 0;">Upload file baru hanya jika ingin mengganti thumbnail saat ini.</p>
                </div>
            </div>
            @endif
            <input type="file" name="image" id="input_edit_image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'preview_edit_image')">
            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            <small style="color:#888; font-size:0.8rem;">Format: JPG, PNG, WebP. Biarkan kosong jika tidak ingin mengganti. Ukuran bebas (otomatis dikompres).</small>
            <div id="preview_edit_image" style="margin-top: 0.6rem; display: none;">
                <img src="" style="max-height: 120px; border-radius: 8px; border: 1px solid #ddd; object-fit: cover;">
            </div>
        </div>
        <div class="grid-2" style="gap: 1rem;">
            <div class="form-group">
                <label>Hotel Makkah</label>
                <input type="text" name="hotel_makkah" class="form-control @error('hotel_makkah') is-invalid @enderror" value="{{ old('hotel_makkah', $package->hotel_makkah) }}">
                @error('hotel_makkah') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Hotel Madinah</label>
                <input type="text" name="hotel_madinah" class="form-control @error('hotel_madinah') is-invalid @enderror" value="{{ old('hotel_madinah', $package->hotel_madinah) }}">
                @error('hotel_madinah') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Maskapai</label>
            <input type="text" name="maskapai" class="form-control @error('maskapai') is-invalid @enderror" value="{{ old('maskapai', $package->maskapai) }}">
            @error('maskapai') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Fasilitas</label>
            <textarea name="fasilitas" class="form-control @error('fasilitas') is-invalid @enderror" rows="4">{{ old('fasilitas', $package->fasilitas) }}</textarea>
            @error('fasilitas') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Itinerary Text</label>
            <textarea name="itinerary" class="form-control @error('itinerary') is-invalid @enderror" rows="6">{{ old('itinerary', $package->itinerary) }}</textarea>
            @error('itinerary') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        <div class="grid-2" style="gap: 1rem;">
            {{-- Itinerary File --}}
            <div class="form-group">
                <label>File Itinerary (PDF)</label>
                @if($package->itinerary_pdf)
                    <div style="margin-bottom: 0.75rem; padding: 0.75rem 1rem; background: rgba(13, 76, 84, 0.05); border: 1px solid rgba(13, 76, 84, 0.15); border-radius: 8px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center; gap: 0.6rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; background: #e74c3c; color: #fff; font-size: 1rem;">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                                <div>
                                    <div style="font-weight: 600; font-size: 0.88rem; color: var(--brand-dark);">File Itinerary Tersimpan</div>
                                    <small style="color: #666; font-size: 0.78rem;">Sudah aktif di website.</small>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <a href="{{ asset($package->itinerary_pdf) }}" target="_blank" class="btn-admin-outline" style="padding: 4px 10px; font-size: 0.78rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fas fa-external-link-alt"></i> Buka / Unduh
                                </a>
                                <button type="button" onclick="if(confirm('Apakah Anda yakin ingin menghapus file Itinerary ini dari paket? File akan dihapus permanen.')) document.getElementById('form_delete_itinerary').submit();" style="padding: 4px 10px; font-size: 0.78rem; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;" title="Hapus File Itinerary">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div style="margin-bottom: 0.5rem; font-size: 0.8rem; color: #888;">
                        <i class="fas fa-info-circle"></i> Belum ada file itinerary yang diunggah.
                    </div>
                @endif
                <input type="file" name="itinerary_pdf" id="input_edit_itinerary" class="form-control @error('itinerary_pdf') is-invalid @enderror" accept=".pdf" onchange="previewPdfFile(this, 'preview_edit_itinerary_info')">
                <small style="color:#888; font-size:0.8rem;">
                    <i class="fas fa-check-circle" style="color: #27ae60;"></i> Kosongkan jika tidak ingin mengganti file Itinerary (Ukuran bebas).
                </small>
                @error('itinerary_pdf') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                <div id="preview_edit_itinerary_info" style="margin-top: 0.5rem; display: none; font-size: 0.82rem; color: #27ae60; font-weight: 500;"></div>
            </div>

            {{-- Flyer File --}}
            <div class="form-group">
                <label>File Flyer Paket (PDF / Gambar)</label>
                @php
                    $isFlyerImage = $package->flyer_pdf && !str_ends_with(strtolower($package->flyer_pdf), '.pdf');
                @endphp
                @if($package->flyer_pdf)
                    <div style="margin-bottom: 0.75rem; padding: 0.75rem 1rem; background: rgba(13, 76, 84, 0.05); border: 1px solid rgba(13, 76, 84, 0.15); border-radius: 8px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap; margin-bottom: {{ $isFlyerImage ? '0.6rem' : '0' }};">
                            <div style="display: flex; align-items: center; gap: 0.6rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; background: {{ $isFlyerImage ? 'var(--brand-dark)' : '#e74c3c' }}; color: #fff; font-size: 1rem;">
                                    <i class="fas {{ $isFlyerImage ? 'fa-image' : 'fa-file-pdf' }}"></i>
                                </span>
                                <div>
                                    <div style="font-weight: 600; font-size: 0.88rem; color: var(--brand-dark);">
                                        Flyer Paket Tersimpan ({{ $isFlyerImage ? 'Gambar' : 'PDF' }})
                                    </div>
                                    <small style="color: #666; font-size: 0.78rem;">Sudah aktif di website.</small>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <a href="{{ asset($package->flyer_pdf) }}" target="_blank" class="btn-admin-outline" style="padding: 4px 10px; font-size: 0.78rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fas fa-external-link-alt"></i> Lihat Penuh
                                </a>
                                <button type="button" onclick="if(confirm('Apakah Anda yakin ingin menghapus file Flyer ini dari paket? File akan dihapus permanen.')) document.getElementById('form_delete_flyer').submit();" style="padding: 4px 10px; font-size: 0.78rem; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;" title="Hapus File Flyer">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </div>
                        </div>
                        @if($isFlyerImage)
                            <div style="margin-top: 0.5rem;">
                                <a href="{{ asset($package->flyer_pdf) }}" target="_blank" title="Klik untuk memperbesar">
                                    <img src="{{ asset($package->flyer_pdf) }}" alt="Preview Flyer" style="max-height: 130px; border-radius: 6px; border: 1px solid #ddd; object-fit: contain; background: #fff; padding: 2px;">
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div style="margin-bottom: 0.5rem; font-size: 0.8rem; color: #888;">
                        <i class="fas fa-info-circle"></i> Belum ada flyer yang diunggah.
                    </div>
                @endif
                <input type="file" name="flyer_pdf" id="input_edit_flyer" class="form-control @error('flyer_pdf') is-invalid @enderror" accept=".pdf,image/*" onchange="previewFlyerFile(this)">
                <small style="color:#888; font-size:0.8rem;">
                    <i class="fas fa-check-circle" style="color: #27ae60;"></i> Kosongkan jika tidak ingin mengganti. Ukuran bebas, gambar otomatis dikompres di latar belakang.
                </small>
                @error('flyer_pdf') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                <div id="preview_edit_flyer_box" style="margin-top: 0.5rem; display: none;"></div>
            </div>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}> Active / Visible on Website
            </label>
        </div>
        
        <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Update Package</button>
            <a href="{{ route('admin.packages.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>

    {{-- Hidden Delete Forms for Itinerary & Flyer --}}
    @if($package->itinerary_pdf)
    <form id="form_delete_itinerary" action="{{ route('admin.packages.delete_file', [$package->id, 'itinerary']) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endif

    @if($package->flyer_pdf)
    <form id="form_delete_flyer" action="{{ route('admin.packages.delete_file', [$package->id, 'flyer']) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endif
</div>

<script>
function previewImage(input, previewId) {
    var container = document.getElementById(previewId);
    if (!container) return;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            container.querySelector('img').src = e.target.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        container.style.display = 'none';
    }
}

function previewPdfFile(input, infoId) {
    var info = document.getElementById(infoId);
    if (!info) return;
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        info.innerHTML = '<i class="fas fa-file-pdf" style="color:#e74c3c;"></i> File baru dipilih: <strong>' + file.name + '</strong> (' + sizeMB + ' MB)';
        info.style.display = 'block';
    } else {
        info.style.display = 'none';
    }
}

function previewFlyerFile(input) {
    var box = document.getElementById('preview_edit_flyer_box');
    if (!box) return;
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        if (file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                box.innerHTML = '<div style="font-size:0.82rem; color:#27ae60; margin-bottom:4px;"><i class="fas fa-check-circle"></i> Gambar baru dipilih (' + sizeMB + ' MB - akan otomatis dikompres):</div>' +
                                '<img src="' + e.target.result + '" style="max-height: 140px; border-radius: 6px; border: 1px solid #ddd; object-fit: contain; background: #fff; padding: 2px;">';
                box.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            box.innerHTML = '<div style="font-size:0.82rem; color:#27ae60;"><i class="fas fa-file-pdf" style="color:#e74c3c;"></i> PDF baru dipilih: <strong>' + file.name + '</strong> (' + sizeMB + ' MB)</div>';
            box.style.display = 'block';
        }
    } else {
        box.style.display = 'none';
    }
}
</script>
@endsection
