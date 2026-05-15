<!-- Location -->
<section id="lokasi" class="address-section">
    <div class="container">
        <div class="address-grid reveal">
            <div class="address-info">
                <span class="cta-tag">Our Presence</span>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 4rem; margin: 1.5rem 0;">Kunjungi Kantor Kami</h2>
                <p style="font-size: 1.2rem; color: var(--text-dark); opacity: 0.8; margin-bottom: 3rem; line-height: 1.8;">
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
