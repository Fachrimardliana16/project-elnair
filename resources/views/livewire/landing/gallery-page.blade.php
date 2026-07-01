<div class="min-h-screen flex flex-col">
    <!-- Hero Gallery -->
    <section class="gallery-hero">
        <div class="container" style="max-width: 1300px; margin: 0 auto; padding: 0 2rem;">
            <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.9rem;">Dokumentasi Perjalanan</span>
            <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 4rem); margin: 1rem 0;">Galeri Kami</h1>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Kumpulan momen indah perjalanan ibadah haji dan umroh jamaah bersama Elnair Tour &amp; Travel.</p>
        </div>
    </section>

    <section class="pattern-bg" style="padding: 4rem 0; flex: 1;">
        <div class="container" style="max-width: 1300px; margin: 0 auto; padding: 0 2rem;">

            @if($folders->isNotEmpty())
                <!-- Filter Tabs -->
                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.75rem; margin-bottom: 3rem;">
                    @foreach($folders as $folder)
                        <button
                            type="button"
                            wire:click="setActiveFolder({{ $folder->id }})"
                            style="
                                border-radius: 9999px;
                                font-size: 0.85rem;
                                font-weight: 700;
                                letter-spacing: 1px;
                                text-transform: uppercase;
                                padding: 0.6rem 1.8rem;
                                cursor: pointer;
                                border: 2px solid {{ $activeFolderId == $folder->id ? 'transparent' : 'var(--brand-dark)' }};
                                background: {{ $activeFolderId == $folder->id ? 'var(--gold-gradient)' : 'transparent' }};
                                color: {{ $activeFolderId == $folder->id ? '#fff' : 'var(--brand-dark)' }};
                                box-shadow: {{ $activeFolderId == $folder->id ? '0 8px 20px rgba(139,94,60,0.3)' : 'none' }};
                                transition: all 0.3s ease;
                            "
                        >
                            {{ $folder->name }}
                        </button>
                    @endforeach
                </div>
            @endif

            <!-- Loading indicator -->
            <div wire:loading style="text-align:center; padding: 2rem 0; color: var(--brand-dark); opacity: 0.6;">
                <i class="fas fa-circle-notch fa-spin" style="font-size: 1.5rem;"></i>
            </div>

            <!-- Photo Grid — mirip layout paket tapi hanya foto -->
            <div wire:loading.remove>
                @if($items->isNotEmpty())
                    <div class="gallery-photo-grid">
                        @foreach($items as $item)
                            @php $imgUrl = str_starts_with($item->image, 'http') ? $item->image : asset($item->image); @endphp
                            <div class="gallery-photo-card" onclick="openGalleryModal('{{ $imgUrl }}', '{{ addslashes($item->title ?? '') }}')">
                                <div class="gallery-photo-img-box">
                                    <img src="{{ $imgUrl }}"
                                         alt="{{ $item->title ?? 'Foto Galeri' }}"
                                         loading="lazy">
                                    <div class="gallery-photo-overlay">
                                        <i class="fas fa-expand" style="color: white; font-size: 1.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($items->hasPages())
                        <div style="margin-top: 3rem; display: flex; justify-content: center;">
                            {{ $items->links('vendor.livewire.custom-pagination') }}
                        </div>
                    @endif

                @else
                    <div style="text-align: center; padding: 5rem 0; color: #888;">
                        <i class="fas fa-images" style="font-size: 4rem; opacity: 0.2; display: block; margin-bottom: 1.5rem;"></i>
                        <p style="font-size: 1.1rem;">Belum ada foto di album ini.</p>
                    </div>
                @endif
            </div>

        </div>
    </section>

    <!-- ── Lightbox Modal ─────────────────────────────────────────── -->
    <div id="galleryModal" onclick="closeGalleryModal()" style="
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0,0,0,0.92);
        align-items: center;
        justify-content: center;
        padding: 1rem;
        backdrop-filter: blur(6px);
    ">
        <!-- Close button -->
        <button onclick="closeGalleryModal()" style="
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            z-index: 10000;
        " onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
            <i class="fas fa-times"></i>
        </button>

        <!-- Image container (stop propagation so clicking image doesn't close) -->
        <div onclick="event.stopPropagation()" style="
            max-width: 90vw;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        ">
            <img id="galleryModalImg" src="" alt="" style="
                max-width: 100%;
                max-height: 85vh;
                object-fit: contain;
                border-radius: 8px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            ">
            <p id="galleryModalCaption" style="color: rgba(255,255,255,0.75); font-size: 0.9rem; text-align: center; margin: 0;"></p>
        </div>
    </div>

    <style>
        /* ── Gallery Hero ───────────────────────────── */
        .gallery-hero {
            position: relative;
            padding: 150px 0 80px;
            background: #0D4C54;
            color: white;
            text-align: center;
        }
        [data-theme="dark"] .gallery-hero {
            background: #0C1517;
            border-bottom: 1px solid rgba(123,191,200,0.1);
        }

        /* ── Photo Grid — 1→2→3 columns ────────────── */
        .gallery-photo-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
            margin-top: 0;
        }
        @media (min-width: 640px) {
            .gallery-photo-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (min-width: 1024px) {
            .gallery-photo-grid { grid-template-columns: repeat(3, 1fr); }
        }

        /* ── Photo Card ─────────────────────────────── */
        .gallery-photo-card {
            border-radius: 1.25rem;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 8px 30px rgba(0,0,0,0.07);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: var(--card-bg, #fff);
        }
        .gallery-photo-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        .gallery-photo-img-box {
            position: relative;
            overflow: hidden;
            /* Rasio 4:3 — fixed regardless of image size */
            width: 100%;
            padding-top: 75%; /* 3/4 = 75% */
        }
        .gallery-photo-img-box img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .gallery-photo-card:hover .gallery-photo-img-box img {
            transform: scale(1.06);
        }
        .gallery-photo-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }
        .gallery-photo-overlay i {
            opacity: 0;
            transition: opacity 0.3s ease;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,0.5));
        }
        .gallery-photo-card:hover .gallery-photo-overlay {
            background: rgba(0,0,0,0.35);
        }
        .gallery-photo-card:hover .gallery-photo-overlay i {
            opacity: 1;
        }
    </style>

    <script>
        function openGalleryModal(url, caption) {
            var modal = document.getElementById('galleryModal');
            var img = document.getElementById('galleryModalImg');
            var cap = document.getElementById('galleryModalCaption');
            img.src = url;
            img.alt = caption || '';
            cap.textContent = caption || '';
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        function closeGalleryModal() {
            var modal = document.getElementById('galleryModal');
            modal.style.display = 'none';
            document.getElementById('galleryModalImg').src = '';
            document.body.style.overflow = '';
        }
        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeGalleryModal();
        });
    </script>
</div>
