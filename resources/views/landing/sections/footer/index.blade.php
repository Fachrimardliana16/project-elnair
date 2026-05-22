<!-- Footer -->
<footer>
    <div class="container">
        <div class="footer-grid">
            <div>
                <picture>
                    <source srcset="{{ asset(str_replace('.png', '.webp', $settings['logo'] ?? 'assets/img/logo-full.webp')) }}" type="image/webp">
                    <img src="{{ asset($settings['logo'] ?? 'assets/img/logo-full.png') }}" alt="Elnair Logo" class="footer-brand-logo" width="160" height="50" loading="lazy" decoding="async">
                </picture>
                <p>Mewujudkan perjalanan suci yang aman, nyaman, dan berkesan bagi setiap hamba Allah yang merindukan Baitullah.</p>
                <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                    <a href="{{ $settings['instagram_url'] ?? '#' }}" style="color: white; font-size: 1.2rem;" aria-label="Ikuti kami di Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    <a href="{{ $settings['facebook_url'] ?? '#' }}" style="color: white; font-size: 1.2rem;" aria-label="Ikuti kami di Facebook"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                </div>
            </div>
            <div>
                <h4>Discover</h4>
                <ul>
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                    <li><a href="{{ url('/') }}#paket">Packages</a></li>
                    <li><a href="{{ route('artikel.index') }}">Artikel & Kajian</a></li>
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
