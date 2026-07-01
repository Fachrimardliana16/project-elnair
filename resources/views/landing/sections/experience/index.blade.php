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
