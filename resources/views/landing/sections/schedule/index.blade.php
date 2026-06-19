<!-- Departure Schedule -->
<section id="jadwal" class="pattern-bg" style="background: var(--bg-light); height: auto !important; min-height: 100vh !important; padding: 6rem 0 !important; overflow: visible !important; display: flex; flex-direction: column; justify-content: center; position: relative;">
    <div class="container">
        <div class="section-header reveal">
            <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.7rem;">Jadwal Resmi 2025–2026</span>
            <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 6vw, 3.5rem); margin: 1rem 0; color: var(--brand-dark);">Kursi Terbatas — Segera Amankan Tempat Anda</h2>
            <p style="font-size: clamp(0.9rem, 2.5vw, 1.1rem); max-width: 600px; margin: 0 auto; opacity: 0.8;">Kuota setiap keberangkatan kami batasi agar ibadah Anda tetap khusyuk dan mendapat perhatian penuh dari tim kami.</p>
        </div>

        <div class="schedule-grid" style="display: grid; gap: 1rem; margin-top: 3rem; max-width: 900px; margin-left: auto; margin-right: auto;">
            @forelse($schedules as $schedule)
            @php
                $isExtra = $loop->index >= 5;
            @endphp
            <div class="schedule-card reveal {{ $isExtra ? 'schedule-card-extra collapsed' : '' }}" style="display: flex; align-items: center; justify-content: space-between; background: var(--card-bg); padding: 1.5rem 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); border: 1px solid rgba(13, 76, 84, 0.07); flex-wrap: wrap; gap: 1.5rem; transition: background 0.3s ease; {{ $isExtra ? 'opacity: 0; transform: translateY(24px);' : '' }}">
                
                <div class="schedule-date" style="display: flex; flex-direction: column; min-width: 120px;">
                    <span style="font-size: 0.8rem; color: var(--brand-gold); font-weight: 700; text-transform: uppercase;">Berangkat</span>
                    <strong style="font-size: 1.4rem; color: var(--brand-dark); font-family: 'Playfair Display', serif;">{{ $schedule->departure_date->translatedFormat('d M Y') }}</strong>
                </div>

                <div class="schedule-package" style="flex: 1; min-width: 200px;">
                    <h4 style="font-size: 1.1rem; color: var(--brand-dark); margin-bottom: 0.3rem;">{{ $schedule->package->title }}</h4>
                    <span style="font-size: 0.8rem; opacity: 0.7;">{{ $schedule->package->price_label }} {{ $schedule->package->price_value }}</span>
                </div>

                <div class="schedule-status" style="display: flex; flex-direction: column; align-items: center; min-width: 100px;">
                    @php
                        $statusColor = $schedule->status == 'Tersedia' ? '#25d366' : ($schedule->status == 'Penuh' ? '#dc3545' : '#ffc107');
                    @endphp
                    <span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; padding: 0.3rem 0.8rem; border-radius: 50px; background: {{ $statusColor }}20; color: {{ $statusColor }}; margin-bottom: 0.3rem;">
                        {{ $schedule->status }}
                    </span>
                    <span style="font-size: 0.7rem; opacity: 0.6;">Sisa {{ $schedule->available_seats }} Seat</span>
                </div>

                <div class="schedule-action">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['wa_number'] ?? '') }}?text=Halo Elnair, saya mau tanya ketersediaan jadwal {{ $schedule->package->title }} tanggal {{ $schedule->departure_date->translatedFormat('d M Y') }}" class="btn btn-outline" style="border-color: var(--brand-dark); color: var(--brand-dark); padding: 0.8rem 1.5rem; font-size: 0.75rem;">
                        Tanya Jadwal
                    </a>
                </div>

            </div>
            @empty
            <div style="text-align: center; padding: 3rem; background: var(--card-bg); border-radius: 15px; border: 1px dashed rgba(102,165,173,0.3);">
                <p style="opacity: 0.6; margin: 0;">Belum ada jadwal keberangkatan terbaru.</p>
            </div>
            @endforelse
        </div>

        @if($schedules->count() > 5)
        <div style="text-align: center; margin-top: 3rem;" class="reveal">
            <button id="btn_toggle_schedules" class="btn btn-outline" style="border: 2px solid var(--brand-gold); color: var(--brand-gold); background: transparent; padding: 1rem 2.8rem; border-radius: 50px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 0.8rem; cursor: pointer; transition: 0.3s; display: inline-flex; align-items: center; justify-content: center; gap: 10px;">
                <span id="btn_toggle_schedule_text">Lihat Selanjutnya</span> 
                <i id="btn_toggle_schedule_icon" class="fas fa-chevron-down"></i>
            </button>
        </div>
        @endif
    </div>
</section>

<style>
    .schedule-card-extra {
        transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), background 0.3s ease !important;
    }
    .schedule-card-extra.collapsed {
        display: none !important;
    }
    @media (max-width: 768px) {
        #jadwal {
            height: auto !important;
            min-height: unset !important;
            padding: 80px 0 40px !important;
            overflow: visible !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: flex-start !important;
        }
        .schedule-grid {
            margin-top: 1.5rem !important;
            gap: 0.8rem !important;
        }
        .schedule-card {
            display: grid !important;
            grid-template-columns: 1fr auto !important;
            grid-template-areas: 
                "date status"
                "package package"
                "action action" !important;
            padding: 1.2rem !important;
            gap: 0.8rem !important;
            border-radius: 18px !important;
            align-items: center !important;
        }
        .schedule-date {
            grid-area: date;
            min-width: unset !important;
        }
        .schedule-date strong {
            font-size: 1.1rem !important;
        }
        .schedule-package {
            grid-area: package;
            min-width: unset !important;
        }
        .schedule-package h4 {
            font-size: 0.95rem !important;
            margin-bottom: 0.2rem !important;
        }
        .schedule-package span {
            font-size: 0.75rem !important;
        }
        .schedule-status {
            grid-area: status;
            min-width: unset !important;
            align-items: flex-end !important;
            justify-content: center !important;
        }
        .schedule-status span:first-child {
            font-size: 0.65rem !important;
            padding: 0.2rem 0.6rem !important;
            margin-bottom: 0.1rem !important;
        }
        .schedule-status span:last-child {
            font-size: 0.65rem !important;
        }
        .schedule-action {
            grid-area: action;
            width: 100% !important;
            margin-top: 0.2rem;
        }
        .schedule-action .btn {
            width: 100% !important;
            padding: 0.8rem !important;
            font-size: 0.75rem !important;
            text-align: center !important;
            justify-content: center !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btn_toggle_schedules');
    if (!btn) return;
    
    const extraCards = document.querySelectorAll('.schedule-card-extra');
    const textSpan = document.getElementById('btn_toggle_schedule_text');
    const icon = document.getElementById('btn_toggle_schedule_icon');
    let isExpanded = false;
    
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        isExpanded = !isExpanded;
        
        if (isExpanded) {
            extraCards.forEach(card => {
                card.classList.remove('collapsed');
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    });
                });
            });
            textSpan.textContent = 'Lihat Lebih Sedikit';
            icon.className = 'fas fa-chevron-up';
        } else {
            extraCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(24px)';
                setTimeout(() => {
                    if (!isExpanded) {
                        card.classList.add('collapsed');
                    }
                }, 500);
            });
            textSpan.textContent = 'Lihat Selanjutnya';
            icon.className = 'fas fa-chevron-down';
            
            document.getElementById('jadwal').scrollIntoView({ behavior: 'smooth' });
        }
    });
});
</script>
