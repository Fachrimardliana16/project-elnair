<!-- Testimonials Luxury -->
<section id="testimoni" class="testi-luxury">
    <div class="container">
        <div class="section-header reveal">
            <span>Echoes of Faith</span>
            <h2>Kisah Perjalanan Jamaah</h2>
        </div>
        <div class="testi-grid">
            @foreach($testimonials as $testi)
            <div class="testi-card-luxury reveal">
                <div class="testi-glass-bg"></div>
                <div class="testi-content-wrap">
                    <div class="testi-header-luxury">
                        <div class="testi-avatar-luxury" style="background-image: url('{{ str_starts_with($testi->avatar, 'http') ? $testi->avatar : asset($testi->avatar) }}')"></div>
                        <div class="testi-meta">
                            <h4>{{ $testi->name }}</h4>
                            <small>{{ $testi->role_label }}</small>
                            <div class="testi-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="testi-body-luxury">
                        <i class="fas fa-quote-left quote-icon-gold"></i>
                        <p>{{ $testi->quote }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
