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
                    <img src="{{ asset('assets/img/cs.png') }}" alt="Customer Service Team" class="cs-img-elite" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>
