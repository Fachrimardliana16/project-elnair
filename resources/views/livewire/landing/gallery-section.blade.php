<section id="gallery" class="pattern-bg" style="padding: 5rem 0;">
    <div class="container" style="max-width: 1300px; margin: 0 auto; padding: 0 2rem;">

        <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 3rem); margin: 0.5rem 0; color: var(--brand-dark);">Galeri Kami</h2>
            <p style="opacity: 0.8; max-width: 600px; margin: 0 auto; color: var(--text-dark);">Dokumentasi perjalanan ibadah dan momen berkesan bersama jamaah.</p>
        </div>

        @if($folders->isNotEmpty())
            <!-- Filter Tabs -->
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.75rem; margin-bottom: 2.5rem;">
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

            <!-- Loading spinner -->
            <div wire:loading style="text-align:center; padding: 3rem 0; color: var(--brand-dark); opacity: 0.5;">
                <i class="fas fa-circle-notch fa-spin" style="font-size: 2rem;"></i>
            </div>

            <!-- Photo Grid -->
            <div wire:loading.remove>
                @if($items->isNotEmpty())
                    <div class="gs-photo-grid">
                        @foreach($items as $item)
                            @php $imgUrl = str_starts_with($item->image, 'http') ? $item->image : asset($item->image); @endphp
                            <div class="gs-photo-card" onclick="openGalleryModal('{{ $imgUrl }}', '{{ addslashes($item->title ?? '') }}')">
                                <div class="gs-photo-img-box">
                                    <img src="{{ $imgUrl }}"
                                         alt="{{ $item->title ?? 'Foto Galeri' }}"
                                         loading="lazy">
                                    <div class="gs-photo-overlay">
                                        <i class="fas fa-expand" style="color:white; font-size:1.3rem;"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 3rem 0; color: #888;">
                        <i class="fas fa-images" style="font-size: 3rem; opacity: 0.25; display: block; margin-bottom: 1rem;"></i>
                        <p>Belum ada foto di album ini.</p>
                    </div>
                @endif
            </div>

            <!-- CTA Button -->
            <div style="text-align: center; margin-top: 3rem;">
                <a href="{{ route('gallery.index') }}" class="btn btn-gold">
                    Lihat Semua Foto <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
                </a>
            </div>
        @else
            <div style="text-align: center; padding: 3rem 0; color: #888;">
                Galeri belum tersedia saat ini.
            </div>
        @endif
    </div>

    <!-- ── Lightbox Modal ─────────────────────────────────────── -->
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
        <button onclick="closeGalleryModal()" style="
            position: absolute; top: 1.25rem; right: 1.25rem;
            width: 44px; height: 44px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            color: white; font-size: 1.2rem;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.2s; z-index: 10000;
        " onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
            <i class="fas fa-times"></i>
        </button>

        <div onclick="event.stopPropagation()" style="
            max-width: 90vw; max-height: 90vh;
            display: flex; flex-direction: column; align-items: center; gap: 1rem;
        ">
            <img id="galleryModalImg" src="" alt="" style="
                max-width: 100%; max-height: 85vh;
                object-fit: contain; border-radius: 8px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            ">
            <p id="galleryModalCaption" style="color: rgba(255,255,255,0.7); font-size: 0.9rem; text-align: center; margin: 0;"></p>
        </div>
    </div>

    <style>
        /* Photo Grid — 1→2→3 columns */
        .gs-photo-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        @media (min-width: 640px) {
            .gs-photo-grid { grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
        }
        @media (min-width: 1024px) {
            .gs-photo-grid { grid-template-columns: repeat(3, 1fr); }
        }

        /* Photo Card */
        .gs-photo-card {
            border-radius: 1.25rem;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 8px 30px rgba(0,0,0,0.07);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .gs-photo-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }

        /* Aspect ratio 4:3 via padding-top trick */
        .gs-photo-img-box {
            position: relative;
            width: 100%;
            padding-top: 75%; /* 4:3 ratio */
            overflow: hidden;
        }
        .gs-photo-img-box img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .gs-photo-card:hover .gs-photo-img-box img {
            transform: scale(1.06);
        }
        .gs-photo-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }
        .gs-photo-overlay i {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .gs-photo-card:hover .gs-photo-overlay { background: rgba(0,0,0,0.35); }
        .gs-photo-card:hover .gs-photo-overlay i { opacity: 1; }
    </style>

    <script>
        if (typeof openGalleryModal === 'undefined') {
            window.openGalleryModal = function(url, caption) {
                var modal = document.getElementById('galleryModal');
                document.getElementById('galleryModalImg').src = url;
                document.getElementById('galleryModalCaption').textContent = caption || '';
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            };
            window.closeGalleryModal = function() {
                document.getElementById('galleryModal').style.display = 'none';
                document.getElementById('galleryModalImg').src = '';
                document.body.style.overflow = '';
            };
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') window.closeGalleryModal();
            });
        }
    </script>
</section>
