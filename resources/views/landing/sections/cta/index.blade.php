<!-- CTA Grand -->
<style>
/* ── CTA Section — Mobile-first Responsive ────────────────────────────── */
.cta-grand {
    background: var(--brand-dark);
    color: white;
    position: relative;
    overflow: hidden;
}

.cta-grid {
    display: grid;
    grid-template-columns: 1fr;          /* Mobile: single column */
    gap: 3rem;
    padding: 5rem 0;
    align-items: center;
}

.cta-image { display: none; }           /* Mobile: hide image to save vertical space */

.cta-text h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 6vw, 4rem);
    margin: 1.25rem 0;
    line-height: 1.15;
    color: white;
}

.cta-features {
    display: grid;
    grid-template-columns: 1fr;         /* Mobile: stacked features */
    gap: 1rem;
    margin-bottom: 2.5rem;
}

/* CTA buttons: full-width on mobile, auto on desktop */
.cta-btn-row {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.cta-btn-row .btn {
    width: 100%;
    justify-content: center;
    min-height: 52px;                   /* Tap target compliant */
}

/* ── Tablet (sm: 640px+) ───────────────────────────────────────────────── */
@media (min-width: 640px) {
    .cta-features {
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    .cta-btn-row {
        flex-direction: row;
        flex-wrap: wrap;
    }
    .cta-btn-row .btn {
        width: auto;
        min-width: 180px;
    }
}

/* ── Desktop (lg: 1024px+) ─────────────────────────────────────────────── */
@media (min-width: 1024px) {
    .cta-grid {
        grid-template-columns: 1.2fr 0.8fr;
        gap: 5rem;
        min-height: 70vh;
        padding: 0;
    }
    .cta-image {
        display: block;
        position: relative;
    }
    .cta-btn-row .btn {
        padding: 1.4rem 3rem;
    }
}
</style>

<section id="cta" class="cta-grand pattern-bg">
    <div class="container">
        <div class="cta-grid">
            <div class="cta-text reveal">
                <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.8rem;">Konsultasi Gratis, Tanpa Tekanan</span>
                <h2>Satu Langkah Lagi Menuju Baitullah</h2>
                <p style="font-size: clamp(1rem, 2.5vw, 1.2rem); opacity: 0.8; margin-bottom: 2.5rem; max-width: 55ch;">
                    Ceritakan keinginan Anda, tim kami akan merancang perjalanan suci yang sesuai anggaran, jadwal, dan kebutuhan ibadah Anda.
                </p>
                
                <div class="cta-features">
                    <div class="cta-feature-item" style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-check-circle" style="color: var(--brand-gold); flex-shrink:0;" aria-hidden="true"></i>
                        <span style="font-size: 0.9rem;">Balas Chat dalam 5 Menit</span>
                    </div>
                    <div class="cta-feature-item" style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-check-circle" style="color: var(--brand-gold); flex-shrink:0;" aria-hidden="true"></i>
                        <span style="font-size: 0.9rem;">Konsultasi Gratis Tanpa Syarat</span>
                    </div>
                    <div class="cta-feature-item" style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-check-circle" style="color: var(--brand-gold); flex-shrink:0;" aria-hidden="true"></i>
                        <span style="font-size: 0.9rem;">Bantu Urus Semua Dokumen</span>
                    </div>
                    <div class="cta-feature-item" style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-check-circle" style="color: var(--brand-gold); flex-shrink:0;" aria-hidden="true"></i>
                        <span style="font-size: 0.9rem;">Uang Kembali Jika Gagal Berangkat</span>
                    </div>
                </div>

                <div class="cta-btn-row">
                    <a href="#" id="waRotatorBtn" class="btn btn-gold" aria-label="Hubungi tim konsultan Elnair via WhatsApp">
                        <i class="fab fa-whatsapp" style="margin-right: 10px; font-size: 1.2rem;" aria-hidden="true"></i> Mulai Konsultasi Gratis
                    </a>
                </div>
            </div>
            <div class="cta-image reveal">
                <div class="cta-image-wrapper" style="border-radius: 40px; overflow: hidden; box-shadow: 0 50px 100px rgba(0,0,0,0.4);">
                    <picture>
                        <source srcset="{{ asset('assets/img/cs.webp') }}" type="image/webp">
                        <img src="{{ asset('assets/img/cs.png') }}"
                             alt="Tim Customer Service Elnair Travel"
                             class="cs-img-elite"
                             loading="lazy"
                             decoding="async"
                             width="600"
                             height="750"
                             style="width: 100%; height: auto; display: block; transition: transform 0.5s;">
                    </picture>
                </div>
            </div>
        </div>
    </div>
</section>
