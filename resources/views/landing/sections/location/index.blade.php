<!-- Location -->
<section id="lokasi" class="address-section pattern-bg">
    <div class="container">
        <div class="address-grid reveal" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: clamp(2rem, 5vw, 6rem); align-items: center; min-height: 80vh;">
            <div class="address-info">
                <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.7rem;">Our Presence</span>
                <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 8vw, 4.5rem); margin: 1rem 0; line-height: 1.1; color: var(--brand-dark);">Kunjungi Kantor Kami</h2>
                <p style="font-size: clamp(0.9rem, 2.5vw, 1.2rem); color: var(--text-dark); opacity: 0.8; margin-bottom: clamp(1.5rem, 4vw, 4rem); line-height: 1.6;">
                    Rasakan kehangatan layanan kami secara langsung di pusat bisnis Jakarta. Tim kami siap menyambut Anda dengan bimbingan personal.
                </p>
                <div class="location-details" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1.5rem;">
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <strong style="font-size: 0.7rem; letter-spacing: 2px; text-transform: uppercase; color: var(--brand-gold);">Alamat Utama</strong>
                        <p style="font-size: 0.8rem; line-height: 1.4; font-weight: 500;">{{ $settings['address'] ?? 'Jl. Premium No. 123, SCBD, Jakarta Pusat' }}</p>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <strong style="font-size: 0.7rem; letter-spacing: 2px; text-transform: uppercase; color: var(--brand-gold);">Hubungi Kami</strong>
                        <p style="font-size: 0.8rem; line-height: 1.4; font-weight: 500;">
                            {{ $settings['phone'] ?? '(021) 1234 5678' }}<br>
                            {{ $settings['email'] ?? 'info@elnairtravel.com' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="map-container" style="height: clamp(200px, 40vh, 600px); border-radius: 30px; box-shadow: 0 40px 80px rgba(13, 76, 84, 0.15); overflow: hidden;">
                <iframe 
                    src="{{ $settings['google_maps_url'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.255167098418!2d106.8209867!3d-6.2293867!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3f480399407%3A0x67398188182f06b!2sSCBD!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid' }}" 
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    title="Peta Lokasi Kantor Elnair Travel"></iframe>
            </div>
        </div>
    </div>
</section>
