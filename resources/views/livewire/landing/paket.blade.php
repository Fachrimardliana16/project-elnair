<div>
    <!-- Hero Packages -->
    <section class="packages-hero">
        <div class="container">
            <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.9rem;">Paket Unggulan</span>
            <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 4rem); margin: 1rem 0;">Paket Haji & Umroh</h1>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Temukan paket ibadah yang dirancang khusus untuk kenyamanan dan kekhusyukan Anda selama di Tanah Suci.</p>
        </div>
    </section>

    <!-- Packages Grid -->
    <section class="pattern-bg" style="padding: 5rem 0;">
        <div class="container">
            <!-- Filter Tabs -->
            <div class="filter-container">
                <button wire:click="setType('')" class="filter-btn {{ $type === '' ? 'active' : '' }}">Semua Paket</button>
                <button wire:click="setType('haji')" class="filter-btn {{ $type === 'haji' ? 'active' : '' }}">Haji</button>
                <button wire:click="setType('umroh')" class="filter-btn {{ $type === 'umroh' ? 'active' : '' }}">Umroh</button>
            </div>

            <div class="pkg-grid-responsive" style="display: grid; gap: 2rem; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
                @forelse($packages as $pkg)
                <div class="pkg-card reveal active" style="border-radius: 1.25rem; overflow: hidden; background: var(--card-bg, #fff); box-shadow: 0 8px 30px rgba(0,0,0,0.07); display: flex; flex-direction: column; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <div class="pkg-img-box" style="position: relative; overflow: hidden; aspect-ratio: 4/3;">
                        <div class="pkg-img" style="
                            background-image: url('{{ str_starts_with($pkg->image ?? '', 'http') ? $pkg->image : asset($pkg->image ?? '') }}');
                            background-size: cover;
                            background-position: center;
                            position: absolute; inset: 0;
                        "></div>
                        <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.55) 0%,transparent 60%);pointer-events:none;"></div>
                        <div class="pkg-price-tag" style="
                            position: absolute; bottom: 1rem; left: 1rem;
                            background: var(--brand-dark); color: white;
                            padding: 0.3rem 0.8rem; border-radius: 6px;
                            font-size: 0.8rem; font-weight: 700;
                        ">{{ $pkg->price_label }} {{ $pkg->price_value }}</div>
                    </div>

                    <div class="pkg-content" style="padding: 1.5rem 1.5rem 1.25rem; background: var(--card-bg); flex: 1; display: flex; flex-direction: column;">
                        <h3 style="font-size: clamp(1.1rem, 2.5vw, 1.5rem); margin-bottom: 0.65rem; line-height: 1.3;">{{ $pkg->title }}</h3>
                        <p style="font-size: 0.9rem; line-height: 1.6; opacity: 0.8; max-width: 42ch;">
                            {{ \Illuminate\Support\Str::limit(strip_tags($pkg->description), 120) }}
                        </p>

                        <div class="pkg-cta-row" style="display: flex; gap: 0.75rem; margin-top: auto; padding-top: 1.25rem;">
                            <a href="{{ route('paket.show', $pkg->slug) }}" class="btn btn-outline pkg-btn" style="flex: 1; text-align: center; border-radius: 10px; min-height: 48px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; border: 1px solid var(--brand-dark); color: var(--brand-dark);">Lihat Detail</a>
                            <a href="#"
                               class="btn btn-gold pkg-btn btn-wa-rotator"
                               data-wa-text="Halo Elnair, saya tertarik dengan paket {{ $pkg->title }}"
                               aria-label="Pesan paket {{ $pkg->title }} via WhatsApp" style="flex: 1; text-align: center; border-radius: 10px; min-height: 48px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700;">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 2rem; background: var(--card-bg); border-radius: 20px; border: 1px solid rgba(13, 76, 84, 0.05);">
                    <i class="fas fa-box-open" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                    <h3 style="color: var(--brand-dark); margin-bottom: 0.5rem;">Belum Ada Paket</h3>
                    <p style="color: var(--text-dark); opacity: 0.8;">Paket ibadah haji dan umroh akan segera hadir di sini.</p>
                </div>
                @endforelse
            </div>

            <div style="margin-top: 4rem; display: flex; justify-content: center;">
                {{ $packages->links() }}
            </div>
        </div>
    </section>

    <style>
        .packages-hero {
            position: relative;
            padding: 150px 0 80px 0;
            background: #0D4C54;
            color: white;
            text-align: center;
        }
        
        [data-theme="dark"] .packages-hero {
            background: #0C1517;
            border-bottom: 1px solid rgba(123, 191, 200, 0.1);
        }

        .pkg-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        }
        
        [data-theme="dark"] .pkg-card {
            border: 1px solid rgba(123, 191, 200, 0.1);
        }
        
        @media (max-width: 480px) {
            .pkg-cta-row {
                flex-direction: column !important;
            }
        }

        /* Filter Tabs */
        .filter-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3.5rem;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            background: transparent;
            border: 2px solid var(--brand-dark);
            color: var(--brand-dark);
            padding: 0.65rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: var(--brand-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 76, 84, 0.15);
        }
        
        [data-theme="dark"] .filter-btn {
            border-color: var(--brand-teal);
            color: var(--brand-teal);
        }
        
        [data-theme="dark"] .filter-btn:hover, [data-theme="dark"] .filter-btn.active {
            background: var(--brand-teal);
            color: #050B0C;
            box-shadow: 0 8px 20px rgba(102, 165, 173, 0.2);
        }
    </style>
</div>
