@extends('landing.layouts.app')

@section('content')
<!-- Hero Schedules -->
<section class="schedules-hero">
    <div class="container">
        <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.9rem;">Elnair Tour & Travel</span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 4rem); margin: 1rem 0;">Jadwal Keberangkatan Resmi</h1>
        <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Pilih jadwal keberangkatan yang sesuai dengan rencana ibadah Anda. Kuota setiap keberangkatan terbatas.</p>
    </div>
</section>

<!-- Schedules List -->
<section class="pattern-bg" style="padding: 5rem 0;">
    <div class="container">
        <div class="schedule-grid" style="display: grid; gap: 2rem; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
            @forelse($schedules as $schedule)
            <div class="schedule-card reveal" style="border-radius: 1.25rem; overflow: hidden; background: var(--card-bg, #fff); box-shadow: 0 8px 30px rgba(0,0,0,0.07); display: flex; flex-direction: column; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                
                <div class="schedule-img-box" style="position: relative; overflow: hidden; aspect-ratio: 4/3;">
                    <div class="schedule-img" style="
                        background-image: url('{{ $schedule->package && str_starts_with($schedule->package->image ?? '', 'http') ? $schedule->package->image : asset($schedule->package->image ?? '') }}');
                        background-size: cover;
                        background-position: center;
                        position: absolute; inset: 0;
                    "></div>
                    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.65) 0%,transparent 60%);pointer-events:none;"></div>
                    
                    @php
                        $statusColor = $schedule->status == 'Tersedia' ? '#25d366' : ($schedule->status == 'Penuh' ? '#dc3545' : '#ffc107');
                    @endphp
                    <div style="position: absolute; top: 1rem; right: 1rem; background: {{ $statusColor }}; color: white; padding: 0.3rem 0.8rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                        {{ $schedule->status }}
                    </div>
                    
                    <div style="position: absolute; bottom: 1rem; left: 1rem; color: white;">
                        <span style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; opacity: 0.9;">Berangkat</span>
                        <div style="font-size: 1.2rem; font-weight: 700;">{{ $schedule->departure_date->translatedFormat('d M Y') }}</div>
                    </div>
                </div>

                <div class="schedule-content" style="padding: 1.5rem; background: var(--card-bg); flex: 1; display: flex; flex-direction: column;">
                    <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem; line-height: 1.3;">
                        <a href="{{ route('jadwal.show', $schedule->id) }}" style="color: var(--brand-dark); text-decoration: none;">
                            {{ $schedule->package->title ?? 'Paket Haji/Umroh' }}
                        </a>
                    </h3>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span style="font-size: 0.9rem; font-weight: 700; color: var(--brand-gold);">
                            {{ $schedule->package->price_label ?? '' }} {{ $schedule->package->price_value ?? '' }}
                        </span>
                        <span style="font-size: 0.8rem; opacity: 0.7;">
                            Sisa <strong style="color: var(--brand-dark);">{{ $schedule->available_seats }} Seat</strong>
                        </span>
                    </div>

                    <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(0,0,0,0.05);">
                        <a href="{{ route('jadwal.show', $schedule->id) }}" class="btn btn-outline" style="width: 100%; text-align: center; border-radius: 10px; min-height: 48px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; border: 1px solid var(--brand-dark); color: var(--brand-dark);">
                            Lihat Detail Jadwal
                        </a>
                    </div>
                </div>

            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 2rem; background: var(--card-bg); border-radius: 20px; border: 1px solid rgba(13, 76, 84, 0.05);">
                <i class="fas fa-calendar-times" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                <h3 style="color: var(--brand-dark); margin-bottom: 0.5rem;">Belum Ada Jadwal</h3>
                <p style="color: var(--text-dark); opacity: 0.8;">Jadwal keberangkatan akan segera diperbarui.</p>
            </div>
            @endforelse
        </div>

        <div style="margin-top: 4rem; display: flex; justify-content: center;">
            {{ $schedules->links() }}
        </div>
    </div>
</section>

<style>
    .schedules-hero {
        position: relative;
        padding: 150px 0 80px 0;
        background: #0D4C54;
        color: white;
        text-align: center;
    }
    
    [data-theme="dark"] .schedules-hero {
        background: #0C1517;
        border-bottom: 1px solid rgba(123, 191, 200, 0.1);
    }
    
    .schedule-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    [data-theme="dark"] .schedule-card {
        border-color: rgba(123, 191, 200, 0.1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }

    @media (max-width: 480px) {
        .schedule-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
