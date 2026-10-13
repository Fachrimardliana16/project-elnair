<!-- Footer -->
<footer>
    <div class="container">
        <div class="footer-grid">
            <div>
                <picture>
                    <source srcset="{{ asset(str_replace('.png', '.webp', $settings['logo'] ?? 'assets/img/logo-full.webp')) }}" type="image/webp">
                    <img src="{{ asset($settings['logo'] ?? 'assets/img/logo-full.webp') }}" alt="Elnair Logo" class="footer-brand-logo" width="160" height="50" loading="lazy" decoding="async">
                </picture>
                <p style="color: #666; line-height: 1.6; font-size: 0.92rem;">Mewujudkan perjalanan suci yang aman, nyaman, dan berkesan dengan perhatian khusus bagi jamaah wanita, keluarga, serta seluruh tamu Allah yang merindukan Baitullah.</p>
                <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                    <a href="{{ $settings['instagram_url'] ?? '#' }}" style="color: #8B5E3C; font-size: 1.2rem;" aria-label="Ikuti kami di Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    <a href="{{ $settings['facebook_url'] ?? '#' }}" style="color: #8B5E3C; font-size: 1.2rem;" aria-label="Ikuti kami di Facebook"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                </div>
            </div>
            <div>
                <h3>Discover</h3>
                <ul>
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ route('about') }}">Tentang</a></li>
                    <li><a href="{{ route('about') }}#legalitas">Legal</a></li>
                    <li><a href="{{ url('/') }}#paket">Informasi paket murah</a></li>
                    <li><a href="{{ route('artikel.index') }}">Artikel dan inspirasi</a></li>
                </ul>
            </div>
            <div>
                <h3>Services</h3>
                <ul>
                    <li><a href="{{ url('/') }}#paket">Paket Murah</a></li>
                </ul>
            </div>
            <div>
                <h3>Contact</h3>
                <ul>
                    <li>{{ $settings['address'] ?? 'Jl. Premium No. 123, SCBD, Jakarta Pusat' }}</li>
                    <li>{{ $settings['phone'] ?? '(021) 1234 5678' }}</li>
                    <li>{{ $settings['email'] ?? 'info@elnairtravel.com' }}</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom" style="color: #888 !important;">
            &copy; {{ date('Y') }} {{ strtoupper($settings['site_name'] ?? 'ELNAIR TRAVEL') }} SERVICES. ALL RIGHTS RESERVED.
        </div>
    </div>
</footer>

<style>
footer {
    background: linear-gradient(180deg,#F5EDE5 0%,#E8D5C4 100%) !important;
    border-top: 3px solid #C08261 !important;
    color: #4A4A4A !important;
    padding: 120px 0 60px;
}
footer h3, footer h4 {
    color: #0D4C54 !important;
    font-family: 'Playfair Display','Playfair Display Fallback',serif;
    font-size: 1.4rem;
    margin-bottom: 2.5rem;
}
footer ul {
    list-style: none;
}
footer ul li {
    margin-bottom: 1rem;
}
footer ul li a {
    color: #666 !important;
    text-decoration: none;
    transition: var(--transition-elite);
}
footer ul li a:hover {
    color: var(--brand-gold) !important;
    padding-left: 10px;
}
.footer-bottom {
    margin-top: 4rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(139,94,60,0.2) !important;
    text-align: center;
    font-size: 0.85rem;
    color: #888 !important;
}
[data-theme="dark"] footer {
    background: linear-gradient(180deg,#0C1517 0%,#0A1214 100%) !important;
    color: #E2E8E9 !important;
}
[data-theme="dark"] footer h3, [data-theme="dark"] footer h4 {
    color: var(--brand-teal) !important;
}
[data-theme="dark"] footer ul li a {
    color: #aaa !important;
}
[data-theme="dark"] footer ul li a:hover {
    color: var(--brand-gold) !important;
}
[data-theme="dark"] .footer-bottom {
    border-top-color: rgba(123,191,200,0.2) !important;
    color: #aaa !important;
}
@media (max-width: 768px) {
    footer {
        padding: 40px 0 20px !important;
        height: auto !important;
    }
}
</style>
