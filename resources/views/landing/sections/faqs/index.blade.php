@if(isset($faqs) && count($faqs) > 0)
<section id="faq" class="pattern-bg" style="padding: 6rem 0; height: auto !important; min-height: unset !important; overflow: visible !important;">
    <div class="container">
        <div class="section-header reveal" style="text-align: center;">
            <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.7rem;">Pusat Bantuan</span>
            <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 3rem); margin: 1rem 0; color: var(--text-dark);">Frequently Asked Questions</h2>
            <p style="font-size: 1rem; max-width: 600px; margin: 0 auto; opacity: 0.8; color: var(--text-dark);">Jawaban untuk pertanyaan-pertanyaan yang sering ditanyakan oleh calon tamu Allah.</p>
        </div>

        <div style="max-width: 800px; margin: 3rem auto 0; overflow: visible !important;">
            @foreach($faqs as $index => $faq)
            <div class="faq-item reveal" style="background: var(--card-bg); border-radius: 12px; margin-bottom: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid rgba(128, 128, 128, 0.2); overflow: hidden; {{ $index >= 5 ? 'display: none;' : '' }}">
                <button class="faq-toggle" style="width: 100%; display: flex; align-items: center; justify-content: space-between; background: none; border: none; padding: 1.5rem; text-align: left; cursor: pointer; color: var(--text-dark); font-family: 'Outfit', sans-serif;">
                    <span style="font-weight: 600; font-size: 1.05rem; padding-right: 1rem;">{{ $faq->question }}</span>
                    <i class="fas fa-chevron-down" style="color: var(--brand-gold); transition: transform 0.3s;"></i>
                </button>
                <div class="faq-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
                    <div style="padding: 0 1.5rem 1.5rem; color: var(--text-dark); opacity: 0.85; line-height: 1.6; font-size: 0.95rem;">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            </div>
            @endforeach

            @if(count($faqs) > 5)
            <div style="text-align: center; margin-top: 2rem;">
                <button id="toggleFaqsBtn" class="btn btn-gold">
                    Lihat Semua FAQ <i class="fas fa-chevron-down" style="margin-left: 8px;"></i>
                </button>
            </div>
            @endif
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.faq-toggle');
    
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const icon = this.querySelector('.fa-chevron-down');
            const isActive = content.style.maxHeight && content.style.maxHeight !== '0px';
            
            // Close all
            document.querySelectorAll('.faq-content').forEach(c => c.style.maxHeight = '0px');
            document.querySelectorAll('.faq-toggle .fa-chevron-down').forEach(i => i.style.transform = 'rotate(0deg)');
            
            // Open clicked if it was not active
            if (!isActive) {
                content.style.maxHeight = content.scrollHeight + "px";
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

    const toggleFaqsBtn = document.getElementById('toggleFaqsBtn');
    if (toggleFaqsBtn) {
        let isExpanded = false;
        // Select all faq-items starting from the 6th element
        const hiddenFaqs = document.querySelectorAll('.faq-item:nth-child(n+6)');
        
        toggleFaqsBtn.addEventListener('click', function() {
            isExpanded = !isExpanded;
            
            if (isExpanded) {
                hiddenFaqs.forEach(item => {
                    item.style.display = 'block';
                    item.animate([
                        { opacity: 0, transform: 'translateY(-10px)' },
                        { opacity: 1, transform: 'translateY(0)' }
                    ], { duration: 300, easing: 'ease-out' });
                });
                toggleFaqsBtn.innerHTML = 'Sembunyikan <i class="fas fa-chevron-up" style="margin-left: 8px;"></i>';
            } else {
                // READ layout FIRST (before any style writes) to avoid forced synchronous layout
                const faqSection = document.getElementById('faq');
                const scrollTarget = faqSection
                    ? faqSection.getBoundingClientRect().top + window.pageYOffset - 100
                    : null;

                // THEN write styles
                hiddenFaqs.forEach(item => {
                    const content = item.querySelector('.faq-content');
                    if(content) content.style.maxHeight = '0px';
                    const icon = item.querySelector('.fa-chevron-down');
                    if(icon) icon.style.transform = 'rotate(0deg)';
                    item.style.display = 'none';
                });
                toggleFaqsBtn.innerHTML = 'Lihat Semua FAQ <i class="fas fa-chevron-down" style="margin-left: 8px;"></i>';
                
                if (scrollTarget !== null) {
                    window.scrollTo({top: scrollTarget, behavior: 'smooth'});
                }
            }
        });
    }
});
</script>
@endif
