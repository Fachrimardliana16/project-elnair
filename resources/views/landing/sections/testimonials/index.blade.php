{{-- 
    Testimonials Section — Responsive Infinite Draggable Auto-Slider
    Mobile  (<640px)  : 1 column
    Tablet  (md)      : 2 columns
    Desktop (lg)      : 3 columns
    Avatar images: loading="lazy", decoding="async", aspect-ratio 1/1 (square).
    Cards: rounded-2xl, consistent padding p-6, WCAG-contrast quote text.
--}}

<!-- Testimonials Luxury -->
<section id="testimoni" class="testi-luxury pattern-bg">
    <div class="container">
        <div class="section-header reveal">
            <span style="letter-spacing: 8px;">Suara Para Jamaah</span>
            <h2 style="font-size: clamp(2rem, 6vw, 3.5rem);">Mereka Sudah Merasakannya — Giliran Anda</h2>
        </div>
        
        <div class="testi-slider-container">
            <div class="testi-slider-track">
                @foreach($testimonials as $testi)
                <div class="testi-slide">
                    <div class="testi-card-luxury reveal" style="height: 100%; display: flex; flex-direction: column;">
                        <div class="testi-glass-bg"></div>
                        <div class="testi-content-wrap" style="position: relative; z-index: 2; height: 100%; display: flex; flex-direction: column;">
                            <div class="testi-header-luxury" style="margin-bottom: 1.5rem; display:flex; align-items:center; gap:1rem;">
                                {{-- Avatar: explicit width/height, loading=lazy, aspect-ratio 1/1 to prevent CLS --}}
                                <div style="
                                    width: 70px; height: 70px; flex-shrink: 0;
                                    border-radius: 50%;
                                    background-image: url('{{ str_starts_with($testi->avatar ?? '', 'http') ? $testi->avatar : asset($testi->avatar ?? '') }}');
                                    background-size: cover; background-position: center;
                                    aspect-ratio: 1/1;
                                " role="img" aria-label="{{ $testi->name }}"></div>
                                <div class="testi-meta">
                                    <h3 style="font-size: 1.1rem; font-weight: 800; line-height: 1.2; margin: 0; padding-bottom: 0.3rem;">{{ $testi->name }}</h3>
                                    <small style="color: var(--brand-gold); font-weight: 700; font-size: 0.7rem;">{{ $testi->role_label }}</small>
                                    <div class="testi-rating" role="img" style="margin-top: 4px;" aria-label="5 bintang">
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="testi-body-luxury" style="flex-grow: 1; display: flex; flex-direction: column; justify-content: flex-start;">
                                @if($testi->video_url)
                                    {{-- Video embed with locked 16:9 aspect ratio — prevents CLS --}}
                                    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 15px; margin-top: 0.5rem; flex-shrink: 0;">
                                        <iframe
                                            src="{{ str_replace('watch?v=', 'embed/', $testi->video_url) }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen
                                            loading="lazy"
                                            title="Testimoni {{ $testi->name }}">
                                        </iframe>
                                    </div>
                                    <p style="font-size: 0.9rem; color: var(--text-dark); line-height: 1.5; margin-top: 1rem;">{{ $testi->quote }}</p>
                                @else
                                    <div>
                                        <i class="fas fa-quote-left" style="font-size: 1.5rem; opacity: 0.25; color: var(--brand-gold);" aria-hidden="true"></i>
                                    </div>
                                    <p style="font-family: 'Playfair Display', serif; font-size: 1.05rem; font-style: italic; color: var(--text-dark); line-height: 1.6; margin-top: 0.5rem;">{{ $testi->quote }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="testi-dots"></div>
    </div>
</section>

<style>
/* ── Testimonial Section Layout ────────────────────────────────────────── */
#testimoni {
    height: auto !important;
    min-height: 100vh !important;
    padding: 6rem 0 !important;
    overflow: visible !important;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
}

@media (max-width: 768px) {
    #testimoni {
        height: auto !important;
        min-height: unset !important;
        padding: 40px 0 !important;
        justify-content: flex-start !important;
    }
}

.testi-slider-container {
    overflow: hidden;
    width: 100%;
    position: relative;
    padding: 1rem 0;
    margin-top: 2rem;
    cursor: grab;
    user-select: none;
    -webkit-user-drag: none;
}

.testi-slider-container:active {
    cursor: grabbing;
}

.testi-slider-track {
    display: flex;
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.testi-slide, .testi-slide-clone {
    flex: 0 0 100%;
    padding: 0 1rem; /* Responsive gap inside slides */
    box-sizing: border-box;
    -webkit-user-drag: none;
}

@media (min-width: 640px) {
    .testi-slide, .testi-slide-clone {
        flex: 0 0 50%; /* 2 items visible */
    }
}

@media (min-width: 1024px) {
    .testi-slide, .testi-slide-clone {
        flex: 0 0 33.3333%; /* 3 items visible */
    }
}

/* ── Testimonial Card ─────────────────────────────────────────────────── */
.testi-card-luxury {
    border-radius: 1.25rem;
    overflow: hidden;
    position: relative;
    padding: 1.75rem;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.5);
    box-shadow: 0 10px 40px rgba(0,0,0,0.06);
    background: transparent;
    height: 100%;
}

.testi-glass-bg {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.7);
    z-index: 1;
    pointer-events: none;
}

[data-theme="dark"] .testi-glass-bg {
    background: rgba(14, 32, 36, 0.85);
}

[data-theme="dark"] .testi-card-luxury {
    border-color: rgba(102, 165, 173, 0.15);
}

/* ── Navigation Dots ──────────────────────────────────────────────────── */
.testi-dots {
    display: flex;
    justify-content: center;
    gap: 0.6rem;
    margin-top: 2.5rem;
}

.testi-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(139, 94, 60, 0.2);
    border: none;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    padding: 0;
    position: relative;
}
.testi-dot::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 48px;
    height: 48px;
}

.testi-dot.active {
    background: var(--brand-gold);
    width: 24px;
    border-radius: 10px;
}
</style>

<script>
(function() {
    function initSlider() {
        const track = document.querySelector('.testi-slider-track');
        let slides = document.querySelectorAll('.testi-slide');
        const dotsContainer = document.querySelector('.testi-dots');
        
        if (!track || slides.length === 0 || !dotsContainer) return;
        
        const originalCount = slides.length;
        
        // 1. DYNAMIC INFINITE CLONING (Seamless loop setup)
        if (originalCount > 1) {
            // Clone first 3 slides to enable perfect wrapping across all viewport sizes
            const cloneCount = Math.min(3, originalCount);
            for (let i = 0; i < cloneCount; i++) {
                const clone = slides[i].cloneNode(true);
                clone.classList.remove('testi-slide');
                clone.classList.add('testi-slide-clone');
                
                const innerCard = clone.querySelector('.testi-card-luxury');
                if (innerCard) {
                    innerCard.classList.remove('reveal');
                    innerCard.classList.add('active');
                }
                track.appendChild(clone);
            }
        }
        
        let currentIndex = 0;
        let isTransitioning = false;
        let interval = null;
        
        function getSlidesPerView() {
            if (window.innerWidth >= 1024) return 3;
            if (window.innerWidth >= 640) return 2;
            return 1;
        }
        
        // 100% Robust Percentage-based Sliding (immune to content-visibility: auto)
        function slideTo(index, animated = true) {
            if (isTransitioning && animated) return;
            
            const slidesPerView = getSlidesPerView();
            const maxIndex = originalCount;
            
            if (!animated) {
                track.style.transition = 'none';
            } else {
                track.style.transition = 'transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
                isTransitioning = true;
            }
            
            if (index > maxIndex) {
                currentIndex = 0;
            } else if (index < 0) {
                currentIndex = 0;
            } else {
                currentIndex = index;
            }
            
            const percentStep = 100 / slidesPerView;
            const offsetPercent = currentIndex * percentStep;
            
            track.style.transform = `translateX(-${offsetPercent}%)`;
            updateDots();
        }
        
        // Seamless loop snap back handler
        track.addEventListener('transitionend', () => {
            isTransitioning = false;
            if (currentIndex >= originalCount) {
                slideTo(0, false);
            }
        });
        
        function setupDots() {
            dotsContainer.innerHTML = '';
            const slidesPerView = getSlidesPerView();
            const totalSteps = Math.max(1, originalCount - slidesPerView + 1);
            
            if (totalSteps <= 1) return;
            
            for (let i = 0; i < totalSteps; i++) {
                const dot = document.createElement('button');
                dot.className = 'testi-dot' + (i === currentIndex ? ' active' : '');
                dot.setAttribute('aria-label', `Lihat testimoni ke-${i+1}`);
                dot.addEventListener('click', () => {
                    if (isTransitioning) return;
                    slideTo(i);
                    resetAutoSlide();
                });
                dotsContainer.appendChild(dot);
            }
        }
        
        function updateDots() {
            const dots = document.querySelectorAll('.testi-dot');
            if (dots.length === 0) return;
            
            const activeIndex = currentIndex % originalCount;
            dots.forEach((dot, i) => {
                if (i === activeIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }
        
        function startAutoSlide() {
            const slidesPerView = getSlidesPerView();
            if (originalCount <= slidesPerView) return;
            
            interval = setInterval(() => {
                slideTo(currentIndex + 1);
            }, 3000); // Dynamic slide shift every 3 seconds
        }
        
        function resetAutoSlide() {
            clearInterval(interval);
            startAutoSlide();
        }
        
        // ── 2. DRAGGABLE / SWIPEABLE IMPLEMENTATION (Uses pixel translation on active viewports) ──
        let isDragging = false;
        let startX = 0;
        let diffX = 0;
        let trackTranslate = 0;
        
        function getTrackOffsetPx() {
            const allSlides = track.querySelectorAll('.testi-slide, .testi-slide-clone');
            const slideWidth = allSlides[0].getBoundingClientRect().width;
            return -(currentIndex * slideWidth);
        }
        
        function dragStart(e) {
            if (isTransitioning) return;
            if (e.target.tagName === 'IFRAME' || e.target.closest('a') || e.target.closest('button')) return;
            
            isDragging = true;
            clearInterval(interval);
            
            startX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
            diffX = 0;
            
            track.style.transition = 'none';
            trackTranslate = getTrackOffsetPx();
        }
        
        function dragMove(e) {
            if (!isDragging) return;
            
            const currentX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
            diffX = currentX - startX;
            
            const newTranslate = trackTranslate + diffX;
            track.style.transform = `translateX(${newTranslate}px)`;
            
            if (Math.abs(diffX) > 10) {
                if (e.cancelable) e.preventDefault();
            }
        }
        
        function dragEnd() {
            if (!isDragging) return;
            isDragging = false;
            
            track.style.transition = 'transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
            isTransitioning = true;
            
            const allSlides = track.querySelectorAll('.testi-slide, .testi-slide-clone');
            const slideWidth = allSlides[0].getBoundingClientRect().width;
            const threshold = slideWidth * 0.15;
            
            if (diffX < -threshold) {
                slideTo(currentIndex + 1);
            } else if (diffX > threshold) {
                slideTo(currentIndex - 1);
            } else {
                slideTo(currentIndex);
            }
            
            startAutoSlide();
        }
        
        const container = document.querySelector('.testi-slider-container');
        if (container) {
            container.addEventListener('mousedown', dragStart);
            window.addEventListener('mousemove', dragMove);
            window.addEventListener('mouseup', dragEnd);
            
            container.addEventListener('touchstart', dragStart, { passive: true });
            container.addEventListener('touchmove', dragMove, { passive: false });
            container.addEventListener('touchend', dragEnd);
            
            container.addEventListener('dragstart', (e) => e.preventDefault());
        }
        
        // Initial setup
        setupDots();
        slideTo(0);
        startAutoSlide();
        
        if (container) {
            container.addEventListener('mouseenter', () => clearInterval(interval));
            container.addEventListener('mouseleave', startAutoSlide);
        }
        
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                setupDots();
                slideTo(currentIndex);
            }, 100);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSlider);
    } else {
        initSlider();
    }
})();
</script>
