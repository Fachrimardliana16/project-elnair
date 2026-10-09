@extends('admin.layouts.app')

@section('title', 'Hero Content & Ribbon Badges')
@section('page_title', 'Manage Hero Section')

@section('content')
<form action="{{ route('admin.hero.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- ── 1. Hero Content & Media Card ────────────────────────────────────── --}}
    <div class="admin-card">
        <h3 style="margin-bottom: 1.5rem; color: var(--brand-dark);"><i class="fas fa-sliders"></i> Informasi Utama Hero Banner</h3>
        <div class="grid-2">
            <div>
                <div class="form-group">
                    <label>Tagline (Teks kecil di atas judul)</label>
                    <input type="text" name="tagline" class="form-control @error('tagline') is-invalid @enderror" value="{{ old('tagline', $hero->tagline ?? '') }}" placeholder="e.g. Terpercaya · Resmi · Berizin Kemenag RI">
                    @error('tagline') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Main Title <span style="color:#dc3545;">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $hero->title ?? '') }}" required placeholder="Judul Utama Banner Hero">
                    @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Subtitle / Deskripsi Singkat</label>
                    <textarea name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" rows="4" placeholder="Deskripsi lengkap layanan umrah & haji...">{{ old('subtitle', $hero->subtitle ?? '') }}</textarea>
                    @error('subtitle') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
            <div>
                <div class="grid-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label>Tombol Utama (Text)</label>
                        <input type="text" name="btn_primary_text" class="form-control @error('btn_primary_text') is-invalid @enderror" value="{{ old('btn_primary_text', $hero->btn_primary_text ?? '') }}" placeholder="e.g. Konsultasi Gratis Sekarang">
                        @error('btn_primary_text') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Tombol Utama (URL)</label>
                        <input type="text" name="btn_primary_url" class="form-control @error('btn_primary_url') is-invalid @enderror" value="{{ old('btn_primary_url', $hero->btn_primary_url ?? '') }}" placeholder="e.g. #cta">
                        @error('btn_primary_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="grid-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label>Tombol Kedua (Text)</label>
                        <input type="text" name="btn_secondary_text" class="form-control @error('btn_secondary_text') is-invalid @enderror" value="{{ old('btn_secondary_text', $hero->btn_secondary_text ?? '') }}" placeholder="e.g. Lihat Paket">
                        @error('btn_secondary_text') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Tombol Kedua (URL)</label>
                        <input type="text" name="btn_secondary_url" class="form-control @error('btn_secondary_url') is-invalid @enderror" value="{{ old('btn_secondary_url', $hero->btn_secondary_url ?? '') }}" placeholder="e.g. #paket">
                        @error('btn_secondary_url') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Gambar Background 1 (Desktop & Mobile)</label>
                    <input type="file" name="background_image" class="form-control @error('background_image') is-invalid @enderror" accept="image/*">
                    @error('background_image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    @if(isset($hero->background_image))
                        <div style="margin-top: 0.5rem;">
                            <img src="{{ asset($hero->background_image) }}" style="width: 160px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Gambar Background 2 (Slideshow)</label>
                    <input type="file" name="background_image_2" class="form-control @error('background_image_2') is-invalid @enderror" accept="image/*">
                    @error('background_image_2') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    @if(isset($hero->background_image_2))
                        <div style="margin-top: 0.5rem;">
                            <img src="{{ asset($hero->background_image_2) }}" style="width: 160px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Gambar Background 3 (Slideshow)</label>
                    <input type="file" name="background_image_3" class="form-control @error('background_image_3') is-invalid @enderror" accept="image/*">
                    @error('background_image_3') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    @if(isset($hero->background_image_3))
                        <div style="margin-top: 0.5rem;">
                            <img src="{{ asset($hero->background_image_3) }}" style="width: 160px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Card 1 Quick Save --}}
        <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #eee; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn-admin">
                <i class="fas fa-save"></i> Simpan Informasi Utama
            </button>
        </div>
    </div>

    {{-- ── 2. Dynamic Trust Items / Hero Ribbon Card ────────────────────────────────────── --}}
    <div class="admin-card" style="margin-top: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 style="color: var(--brand-dark); margin: 0;"><i class="fas fa-shield-halved"></i> Trust Items / Hero Footer Ribbon</h3>
                <p style="font-size: 0.85rem; color: #666; margin: 0.3rem 0 0 0;">
                    Atur item keunggulan & legalitas di ribbon bawah hero banner. Bebas menambah atau mengurangi item (selalu tampil 1 baris di hero banner).
                </p>
            </div>
            <button type="button" class="btn-admin" onclick="addTrustItemRow()">
                <i class="fas fa-plus"></i> Tambah Item Baru
            </button>
        </div>

        @php
            $defaultTrustItems = [
                ['icon' => 'fas fa-file-circle-check', 'title' => 'Izin Resmi Kemenag', 'description' => 'Terdaftar di Kemenag RI', 'url' => '', 'url_label' => ''],
                ['icon' => 'fas fa-shield-heart', 'title' => 'Dana 100% Aman', 'description' => 'Rekening Terpisah & Transparan', 'url' => '', 'url_label' => ''],
                ['icon' => 'fas fa-person-dress', 'title' => 'Muthawwif & Muthawwifah Bersertifikat', 'description' => 'Bimbingan Khusyuk Sepenuh Hati', 'url' => '', 'url_label' => ''],
                ['icon' => 'fas fa-spa', 'title' => 'Kenyamanan Jamaah', 'description' => 'Fokus Kenyamanan & Khusyuk', 'url' => '', 'url_label' => ''],
                ['icon' => 'fas fa-hotel', 'title' => 'Hotel Dekat Pintu Perempuan', 'description' => 'Akses Mudah ke Pelataran Wanita', 'url' => '', 'url_label' => ''],
                ['icon' => 'fas fa-bag-shopping', 'title' => 'Woman Travel Kit (Perlengkapan Perempuan)', 'description' => 'Perlengkapan Lengkap Jamaah Wanita', 'url' => '', 'url_label' => ''],
            ];
            $trustItems = old('trust_items', (!empty($hero->trust_items) ? $hero->trust_items : $defaultTrustItems));
        @endphp

        <div id="trust-items-container">
            @forelse($trustItems as $index => $item)
            <div class="trust-item-row" data-index="{{ $index }}" style="background: #fdfdfd; padding: 1.25rem; border-radius: 12px; margin-bottom: 1.2rem; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px dashed #e2e8f0;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="badge" style="background: var(--brand-dark); color: #fff; border-radius: 50%; width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem;">{{ $index + 1 }}</span>
                        <strong style="color: var(--brand-dark); font-size: 0.95rem;">Item #<span class="item-number">{{ $index + 1 }}</span></strong>
                    </div>
                    <button type="button" class="btn-remove-trust" onclick="removeTrustRow(this)" style="background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; padding: 5px 14px; border-radius: 6px; cursor: pointer; font-size: 0.8rem; font-weight: 600; transition: all 0.2s;">
                        <i class="fas fa-trash-can"></i> Hapus
                    </button>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem; font-weight:600;">Icon FontAwesome <span style="color: #dc3545;">*</span></label>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <input type="text" name="trust_items[{{ $index }}][icon]" class="form-control trust-icon-input" value="{{ $item['icon'] ?? 'fas fa-check-circle' }}" placeholder="fas fa-file-circle-check" oninput="updateIconPreview(this)">
                            <div class="icon-preview" style="width: 38px; height: 38px; background: var(--brand-dark); color: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                                <i class="{{ $item['icon'] ?? 'fas fa-check-circle' }}"></i>
                            </div>
                        </div>
                        <small style="color: #888; font-size:0.75rem;">Contoh: <code>fas fa-shield-halved</code>, <code>fas fa-hotel</code>, <code>fas fa-bag-shopping</code></small>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem; font-weight:600;">Judul / Title <span style="color: #dc3545;">*</span></label>
                        <input type="text" name="trust_items[{{ $index }}][title]" class="form-control" value="{{ $item['title'] ?? '' }}" placeholder="e.g. Izin Resmi Kemenag" required>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem; font-weight:600;">Deskripsi (Opsional)</label>
                        <input type="text" name="trust_items[{{ $index }}][description]" class="form-control" value="{{ $item['description'] ?? '' }}" placeholder="e.g. Terdaftar di Kemenag RI">
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem; font-weight:600;">Tautan URL (Opsional)</label>
                        <input type="text" name="trust_items[{{ $index }}][url]" class="form-control" value="{{ $item['url'] ?? '' }}" placeholder="https://...">
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem; font-weight:600;">Label Tautan (Opsional)</label>
                        <input type="text" name="trust_items[{{ $index }}][url_label]" class="form-control" value="{{ $item['url_label'] ?? '' }}" placeholder="Cek Izin">
                    </div>
                </div>
            </div>
            @empty
            <div style="color: #888; text-align: center; padding: 2.5rem 1rem; background: #fafafa; border-radius: 12px; border: 1px dashed #ccc;" id="no-trust-items-msg">
                <i class="fas fa-shield-halved" style="font-size: 2rem; color: #ccc; margin-bottom: 0.75rem; display: block;"></i>
                <p style="margin-bottom: 1rem; font-weight: 500;">Belum ada trust item. Klik tombol di bawah untuk menambah keunggulan hero banner.</p>
                <button type="button" class="btn-admin" onclick="addTrustItemRow()">
                    <i class="fas fa-plus"></i> Tambah Item Baru
                </button>
            </div>
            @endforelse
        </div>

        {{-- Bottom Action Buttons --}}
        <div style="display: flex; gap: 1rem; align-items: center; justify-content: flex-end; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #eee; flex-wrap: wrap;">
            <button type="submit" class="btn-admin" style="background: var(--brand-gold);">
                <i class="fas fa-save"></i> Simpan Perubahan Hero Section
            </button>
        </div>

        {{-- Template for JS dynamic addition --}}
        <template id="trust-item-template">
            <div class="trust-item-row" data-index="__INDEX__" style="background: #fdfdfd; padding: 1.25rem; border-radius: 12px; margin-bottom: 1.2rem; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px dashed #e2e8f0;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="badge" style="background: var(--brand-dark); color: #fff; border-radius: 50%; width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem;">__NUMBER__</span>
                        <strong style="color: var(--brand-dark); font-size: 0.95rem;">Item #<span class="item-number">__NUMBER__</span></strong>
                    </div>
                    <button type="button" class="btn-remove-trust" onclick="removeTrustRow(this)" style="background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; padding: 5px 14px; border-radius: 6px; cursor: pointer; font-size: 0.8rem; font-weight: 600; transition: all 0.2s;">
                        <i class="fas fa-trash-can"></i> Hapus
                    </button>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem; font-weight:600;">Icon FontAwesome <span style="color: #dc3545;">*</span></label>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <input type="text" name="trust_items[__INDEX__][icon]" class="form-control trust-icon-input" value="fas fa-check-circle" placeholder="fas fa-file-circle-check" oninput="updateIconPreview(this)">
                            <div class="icon-preview" style="width: 38px; height: 38px; background: var(--brand-dark); color: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <small style="color: #888; font-size:0.75rem;">Contoh: <code>fas fa-hotel</code>, <code>fas fa-bag-shopping</code></small>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem; font-weight:600;">Judul / Title <span style="color: #dc3545;">*</span></label>
                        <input type="text" name="trust_items[__INDEX__][title]" class="form-control" placeholder="e.g. Layanan 24 Jam" required>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem; font-weight:600;">Deskripsi (Opsional)</label>
                        <input type="text" name="trust_items[__INDEX__][description]" class="form-control" placeholder="e.g. CS Siap Membantu">
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem; font-weight:600;">Tautan URL (Opsional)</label>
                        <input type="text" name="trust_items[__INDEX__][url]" class="form-control" placeholder="https://...">
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:0.85rem; font-weight:600;">Label Tautan (Opsional)</label>
                        <input type="text" name="trust_items[__INDEX__][url_label]" class="form-control" placeholder="Lihat Detail">
                    </div>
                </div>
            </div>
        </template>
    </div>
</form>

<script>
let trustIndex = {{ count($trustItems) }};

function addTrustItemRow() {
    const container = document.getElementById('trust-items-container');
    const template = document.getElementById('trust-item-template');
    if (!container || !template) return;

    const noMsg = document.getElementById('no-trust-items-msg');
    if (noMsg) noMsg.remove();

    const currentRows = container.querySelectorAll('.trust-item-row').length;
    const itemNumber = currentRows + 1;

    let html = template.innerHTML
        .replace(/__INDEX__/g, trustIndex)
        .replace(/__NUMBER__/g, itemNumber);

    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = html;
    const newRow = tempDiv.firstElementChild;
    container.appendChild(newRow);
    trustIndex++;
    renumberTrustRows();

    // Scroll smoothly to the newly added row
    newRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function removeTrustRow(btn) {
    const row = btn.closest('.trust-item-row');
    if (row) {
        row.remove();
        renumberTrustRows();
    }
}

function renumberTrustRows() {
    const rows = document.querySelectorAll('#trust-items-container .trust-item-row');
    rows.forEach((r, idx) => {
        const numSpan = r.querySelector('.badge');
        const textNumSpan = r.querySelector('.item-number');
        if (numSpan) numSpan.textContent = idx + 1;
        if (textNumSpan) textNumSpan.textContent = idx + 1;
    });
}

function updateIconPreview(input) {
    const parent = input.closest('.form-group');
    const preview = parent ? parent.querySelector('.icon-preview i') : null;
    if (preview) {
        preview.className = input.value.trim() || 'fas fa-check-circle';
    }
}
</script>
@endsection
