<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] ?? 'Elnair Travel' }} - Perjalanan Suci Eksklusif</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @if(isset($settings['favicon']))
    <link rel="shortcut icon" href="{{ asset($settings['favicon']) }}" type="image/x-icon">
    @endif
</head>
<body>

    <!-- Elite Navbar -->
    <nav id="navbar">
        <div class="container nav-content">
            <div class="logo">
                <picture>
                    <source srcset="{{ asset('assets/img/logo-mobile.png') }}" media="(max-width: 768px)">
                    <img src="{{ asset($settings['logo'] ?? 'assets/img/logo-full.png') }}" alt="Elnair Logo" class="brand-logo">
                </picture>
            </div>
            <div class="nav-links">
                <a href="#paket">Haji</a>
                <a href="#paket">Umroh</a>
            </div>
            <div class="nav-cta">
                <a href="https://wa.me/{{ $settings['wa_number'] ?? '' }}" class="btn btn-gold" style="padding: 0.8rem 2rem; font-size: 0.7rem;">Book Now</a>
            </div>
        </div>
    </nav>

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
                    <a href="{{ $hero->btn_secondary_url ?? '#paket' }}" class="btn btn-outline" style="border-color: white; color: white;">{{ $hero->btn_secondary_text ?? 'Eksplorasi Paket' }}</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Section Experience -->
    <section id="why-us">
        <div class="container">
            <div class="section-header reveal">
                <span>The Art of Pilgrimage</span>
                <h2>Mengapa Memilih Kami?</h2>
                <p>Keunggulan layanan yang dirancang khusus untuk memastikan setiap detik ibadah Anda bernilai ibadah dan berkesan.</p>
            </div>
            <div class="grid">
                @foreach($features as $feature)
                <div class="card reveal">
                    <i class="{{ $feature->icon }} card-icon"></i>
                    <h3>{{ $feature->title }}</h3>
                    <p>{{ $feature->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Packages Elite -->
    <section id="paket" style="background: #fff;">
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
                <a href="#" class="btn btn-outline" style="color: var(--brand-dark); border-color: var(--brand-dark);">Lihat Semua Paket <i class="fas fa-arrow-right" style="margin-left: 10px;"></i></a>
            </div>
        </div>
    </section>

    <!-- Testimonials Luxury -->
    <section id="testimoni" class="testi-luxury">
        <div class="container">
            <div class="section-header reveal">
                <span>Echoes of Faith</span>
                <h2>Kisah Perjalanan Jamaah</h2>
            </div>
            <div class="testi-grid">
                @foreach($testimonials as $testi)
                <div class="testi-card-elite reveal">
                    <div class="testi-video-box" style="background: url('{{ asset($testi->thumbnail ?? 'assets/img/hero.png') }}') center/cover;"></div>
                    <p class="testi-quote">{{ $testi->quote }}</p>
                    <div class="testi-profile">
                        <div class="testi-avatar" style="background: url('{{ str_starts_with($testi->avatar, 'http') ? $testi->avatar : asset($testi->avatar) }}') center/cover;"></div>
                        <div>
                            <h4 style="font-size: 0.9rem; font-weight: 700;">{{ $testi->name }}</h4>
                            <small style="color: #888;">{{ $testi->role_label }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Location -->
    <section id="lokasi" class="address-section">
        <div class="container">
            <div class="address-grid reveal">
                <div class="address-info">
                    <span class="cta-tag">Our Presence</span>
                    <h2 style="font-family: 'Playfair Display', serif; font-size: 4rem; margin: 1.5rem 0; color: var(--brand-dark);">Kunjungi Kantor Kami</h2>
                    <p style="font-size: 1.2rem; color: #666; margin-bottom: 3rem; line-height: 1.8;">
                        Rasakan kehangatan layanan kami secara langsung di pusat bisnis Jakarta. Tim kami siap menyambut Anda dengan bimbingan personal.
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <i class="fas fa-map-marker-alt" style="color: var(--brand-gold);"></i>
                            <span>{{ $settings['address'] ?? 'Jl. Premium No. 123, SCBD, Jakarta Pusat' }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <i class="fas fa-phone-alt" style="color: var(--brand-gold);"></i>
                            <span>{{ $settings['phone'] ?? '(021) 1234 5678' }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <i class="fas fa-envelope" style="color: var(--brand-gold);"></i>
                            <span>{{ $settings['email'] ?? 'info@elnairtravel.com' }}</span>
                        </div>
                    </div>
                </div>
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.255167098418!2d106.8209867!3d-6.2293867!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3f480399407%3A0x67398188182f06b!2sSCBD!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Grand -->
    <section id="cta" class="cta-grand">
        <div class="container">
            <div class="cta-grid">
                <div class="cta-text reveal">
                    <span class="cta-tag">Premium Consultation</span>
                    <h2>Rencanakan Ibadah Anda Bersama Kami</h2>
                    <p style="font-size: 1.2rem; opacity: 0.8;">Tim konsultan ahli kami siap mendampingi Anda merancang perjalanan suci yang personal, khusyuk, dan berkesan.</p>
                    
                    <div class="cta-features">
                        <div class="cta-feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Respon Cepat 24/7 via WhatsApp</span>
                        </div>
                        <div class="cta-feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Konsultasi Gratis Tanpa Biaya Pendaftaran</span>
                        </div>
                        <div class="cta-feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Panduan Lengkap Persiapan Dokumen</span>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                        <a href="https://wa.me/{{ $settings['wa_number'] ?? '' }}" class="btn btn-gold" style="padding: 1.2rem 2.5rem;">
                            <i class="fab fa-whatsapp" style="margin-right: 10px; font-size: 1.2rem;"></i> WhatsApp Kami
                        </a>
                        <a href="tel:{{ $settings['phone'] ?? '' }}" class="btn btn-outline" style="padding: 1.2rem 2.5rem;">Hubungi Call Center</a>
                    </div>
                </div>
                <div class="cta-image reveal">
                    <div class="cta-image-wrapper">
                        <img src="{{ asset('assets/img/cs.png') }}" alt="Customer Service Team" class="cs-img-elite">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <img src="{{ asset($settings['logo'] ?? 'assets/img/logo-full.png') }}" alt="Elnair Logo" class="footer-brand-logo">
                    <p>Mewujudkan perjalanan suci yang aman, nyaman, dan berkesan bagi setiap hamba Allah yang merindukan Baitullah.</p>
                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                        <a href="{{ $settings['instagram_url'] ?? '#' }}" style="color: white; font-size: 1.2rem;"><i class="fab fa-instagram"></i></a>
                        <a href="{{ $settings['facebook_url'] ?? '#' }}" style="color: white; font-size: 1.2rem;"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
                <div>
                    <h4>Discover</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#why-us">Experience</a></li>
                        <li><a href="#paket">Packages</a></li>
                        <li><a href="#testimoni">Stories</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Services</h4>
                    <ul>
                        @foreach($packages as $pkg)
                        <li><a href="#">{{ $pkg->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4>Contact</h4>
                    <ul>
                        <li>{{ $settings['email'] ?? 'info@elnairtravel.com' }}</li>
                        <li>{{ $settings['phone'] ?? '(021) 1234 5678' }}</li>
                        <li>{{ $settings['address'] ?? 'SCBD, Jakarta Pusat' }}</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} {{ strtoupper($settings['site_name'] ?? 'ELNAIR TRAVEL') }} SERVICES. ALL RIGHTS RESERVED.
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
