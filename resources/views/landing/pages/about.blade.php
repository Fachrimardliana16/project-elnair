@extends('landing.layouts.app')

@section('content')
<!-- Hero About -->
<section style="position: relative; height: 50vh; background-image: url('{{ asset('assets/img/hero-bg.jpg') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(13, 76, 84, 0.8);"></div>
    <div class="container" style="position: relative; z-index: 2; text-align: center; color: white;">
        <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.9rem;">Company Profile</span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 4rem); margin: 1rem 0;">Tentang Elnair</h1>
        <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Melayani tamu Allah dengan standar Spiritual Luxury.</p>
    </div>
</section>

<!-- Vision Mission -->
<section class="pattern-bg" style="padding: 5rem 0; background: white;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
            <div class="about-image" style="position: relative;">
                <div style="position: absolute; top: -20px; left: -20px; width: 100px; height: 100px; background: var(--brand-gold); border-radius: 20px; z-index: 1;"></div>
                <img src="{{ asset('assets/img/hero-bg.jpg') }}" style="width: 100%; border-radius: 20px; position: relative; z-index: 2; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
            </div>
            <div class="about-text">
                <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--brand-dark); margin-bottom: 1.5rem;">Visi & Misi Kami</h2>
                <p style="line-height: 1.8; color: var(--text-dark); margin-bottom: 1.5rem;">Elnair Travel hadir sebagai biro perjalanan Umrah dan Haji Khusus yang mengedepankan pelayanan premium. Kami memahami bahwa ibadah ke Tanah Suci adalah momen paling berharga dalam hidup seorang Muslim.</p>
                <div style="margin-bottom: 1.5rem;">
                    <h4 style="color: var(--brand-gold); font-size: 1.2rem; margin-bottom: 0.5rem;"><i class="fas fa-eye"></i> Visi</h4>
                    <p style="line-height: 1.6; color: var(--text-dark);">Menjadi biro perjalanan ibadah terdepan di Indonesia yang memberikan pengalaman Spiritual Luxury secara profesional dan amanah.</p>
                </div>
                <div>
                    <h4 style="color: var(--brand-gold); font-size: 1.2rem; margin-bottom: 0.5rem;"><i class="fas fa-bullseye"></i> Misi</h4>
                    <ul style="line-height: 1.6; color: var(--text-dark); padding-left: 1.2rem;">
                        <li>Memberikan bimbingan ibadah sesuai sunnah dengan Asatidz kompeten.</li>
                        <li>Menyediakan fasilitas akomodasi dan transportasi premium.</li>
                        <li>Memastikan keamanan dan kenyamanan legalitas perizinan PPIU.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

    @include('landing.sections.legality.index')

<!-- Asatidz -->
<section class="pattern-bg" style="padding: 5rem 0;">
    <div class="container">
        <div class="section-header reveal" style="text-align: center;">
            <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.7rem;">Spiritual Guides</span>
            <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 6vw, 3.5rem); margin: 1rem 0; color: var(--brand-dark);">Pembimbing Ibadah</h2>
            <p style="font-size: clamp(0.9rem, 2.5vw, 1.1rem); max-width: 600px; margin: 0 auto; opacity: 0.8;">Dibimbing oleh Ustadz dan Ustadzah tersertifikasi untuk menjaga kekhusyukan ibadah Anda sesuai sunnah.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 3rem;">
            @forelse($guides as $guide)
            <div class="guide-card reveal" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; padding-bottom: 2rem; border: 1px solid rgba(13, 76, 84, 0.05);">
                <div style="height: 250px; background-image: url('{{ $guide->image ? (str_starts_with($guide->image, 'http') ? $guide->image : asset($guide->image)) : asset('assets/img/hero-bg.jpg') }}'); background-size: cover; background-position: center; margin-bottom: 1.5rem;"></div>
                <h4 style="font-size: 1.2rem; color: var(--brand-dark); margin-bottom: 0.3rem; padding: 0 1rem;">{{ $guide->name }}</h4>
                <span style="color: var(--brand-gold); font-size: 0.8rem; font-weight: 700; display: block; margin-bottom: 1rem;">{{ $guide->role }}</span>
                @if($guide->description)
                <p style="font-size: 0.9rem; color: var(--text-dark); padding: 0 1.5rem; line-height: 1.6;">{{ \Illuminate\Support\Str::limit($guide->description, 100) }}</p>
                @endif
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: rgba(13, 76, 84, 0.02); border-radius: 15px; border: 1px dashed #ccc;">
                <p style="opacity: 0.6; margin: 0;">Data pembimbing belum ditambahkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    @media (max-width: 768px) {
        .about-text, .about-image {
            grid-column: span 2;
        }
        .about-image {
            order: -1;
        }
    }
</style>
@endsection
