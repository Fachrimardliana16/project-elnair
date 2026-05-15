<!-- Packages Elite -->
<section id="paket">
    <div class="container">
        <div class="section-header reveal">
            <span>Curated Journeys</span>
            <h2>Paket Ibadah Pilihan</h2>
        </div>
        <div class="grid">
            @foreach($packages as $pkg)
            <div class="pkg-card reveal">
                <div class="pkg-img-box">
                    <div class="pkg-img" style="background-image: url('{{ str_starts_with($pkg->image, 'http') ? $pkg->image : asset($pkg->image) }}');"></div>
                    <div class="pkg-price-tag">{{ $pkg->price_label }} {{ $pkg->price_value }}</div>
                </div>
                <div class="pkg-content">
                    <h3>{{ $pkg->title }}</h3>
                    <p>{{ $pkg->description }}</p>
                    <a href="https://wa.me/{{ $settings['wa_number'] ?? '' }}?text=Halo Elnair, saya tertarik dengan paket {{ $pkg->title }}" class="btn btn-gold" style="width: 100%; margin-top: 2rem; justify-content: center;">Inquire Now</a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div style="text-align: center; margin-top: 2rem;" class="reveal">
            <a href="#" class="btn btn-outline" style="color: var(--text-dark); border-color: var(--brand-gold);">Lihat Semua Paket <i class="fas fa-arrow-right" style="margin-left: 10px;"></i></a>
        </div>
    </div>
</section>
