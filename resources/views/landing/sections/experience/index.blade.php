<!-- Section Experience (Luxury Cards Grid) -->
<section id="why-us" class="pattern-bg" style="height: auto !important; min-height: 100vh !important; padding: 6rem 0 !important; overflow: visible !important; display: flex; flex-direction: column; justify-content: center; position: relative;">
    <div class="container">
        <div class="section-header reveal" style="margin-bottom: 4rem; text-align: center;">
            <span style="color: var(--brand-gold); text-transform: uppercase; letter-spacing: 5px; font-weight: 800; font-size: 0.75rem; display: block; margin-bottom: 1rem;">Keunggulan Elnair Tour & Travel</span>
            <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 5vw, 2.8rem); color: var(--brand-dark); margin-bottom: 1rem;">Mengapa Harus Memilih Elnair Tour & Travel?</h2>
            <p style="max-width: 700px; margin: 0 auto; color: #666; font-size: 0.95rem; line-height: 1.7;">Setiap detail perjalanan kami rancang dengan sepenuh hati, karena kami memahami betapa berharganya setiap detik ibadah suci Anda.</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
            @foreach($features as $index => $loop_feature)
            @php
                $cardNumber = sprintf('%02d', $index + 1);
            @endphp
            <div class="card reveal" style="padding: 2.5rem; border-radius: 24px; position: relative;">
                <span class="card-index" style="font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 900; color: var(--brand-gold);">
                    {{ $cardNumber }}
                </span>
                
                <div class="card-icon-box">
                    <i class="{{ $loop_feature->icon }} card-icon"></i>
                </div>
                
                <div style="margin-top: 1.25rem;">
                    <h3 style="margin-bottom: 0.75rem; font-size: 1.25rem; font-weight: 700;">
                        {{ $loop_feature->title }}
                    </h3>
                    <p style="font-size: 0.88rem; line-height: 1.6; margin-bottom: 1.5rem;">
                        {{ $loop_feature->description }}
                    </p>
                    <div class="card-line"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
#why-us {
    --women-rose: #D98FA3;
    --women-rose-deep: #8B3A50;
    --women-rose-soft: rgba(217, 143, 163, 0.14);
}

#why-us .card-icon-box {
    width: 64px;
    height: 64px;
    border-radius: 22px;
    background: linear-gradient(135deg, rgba(217,143,163,0.18) 0%, rgba(220,208,192,0.55) 100%);
    border: 1px solid rgba(217,143,163,0.26);
    box-shadow: 0 14px 32px rgba(217,143,163,0.14);
}

#why-us .card-icon {
    font-size: 1.75rem;
    background: linear-gradient(135deg, var(--women-rose-deep) 0%, var(--brand-gold) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

#why-us .card:hover .card-icon-box {
    background: linear-gradient(135deg, rgba(217,143,163,0.28) 0%, rgba(255,255,255,0.14) 100%);
    border-color: rgba(255,255,255,0.22);
}

#why-us .card:hover .card-icon {
    background: linear-gradient(135deg, #F1C4CE 0%, #FFFFFF 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

[data-theme="dark"] #why-us .card-icon-box {
    background: linear-gradient(135deg, rgba(217,143,163,0.18) 0%, rgba(102,165,173,0.12) 100%);
    border-color: rgba(217,143,163,0.24);
}

[data-theme="dark"] #why-us .card-icon {
    background: linear-gradient(135deg, #F1C4CE 0%, var(--brand-teal) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>
