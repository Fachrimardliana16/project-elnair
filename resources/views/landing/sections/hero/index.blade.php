<!-- Luxury Hero -->
<header class="hero" id="home">
    <div class="hero-bg-img" style="background-image: url('{{ asset($hero->background_image ?? 'assets/img/hero.png') }}');"></div>
    <div class="container">
        <div class="hero-content">
            <span class="cta-tag" style="color: var(--brand-beige);">{{ $hero->tagline ?? 'Welcome to Elnair' }}</span>
            <h1>{{ $hero->title ?? 'Wujudkan Perjalanan Suci Impian Anda' }}</h1>
            <p>{{ $hero->subtitle ?? 'Menghadirkan harmoni antara ibadah yang khusyuk dan kenyamanan yang tak tertandingi di Tanah Suci.' }}</p>
            <div class="hero-btns">
                <a href="{{ $hero->btn_primary_url ?? '#cta' }}" class="btn btn-gold">{{ $hero->btn_primary_text ?? 'Konsultasi Gratis' }}</a>
                <a href="{{ $hero->btn_secondary_url ?? '#paket' }}" class="btn btn-outline">{{ $hero->btn_secondary_text ?? 'Eksplorasi Paket' }}</a>
            </div>
        </div>
    </div>
</header>
