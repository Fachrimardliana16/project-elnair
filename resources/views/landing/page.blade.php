@extends('landing.layouts.app')

@section('content')
<!-- Sales Page Header -->
<header class="sales-header" style="background: var(--bg-dark); padding: 12rem 0 6rem; text-align: center;">
    <div class="container">
        <span class="cta-tag reveal" style="color: var(--brand-gold);">Exclusive Offer</span>
        <h1 class="reveal" style="font-family: 'Playfair Display', serif; font-size: 4rem; color: white; margin: 1.5rem 0;">{{ $page->title }}</h1>
        <div class="reveal" style="width: 60px; height: 2px; background: var(--brand-gold); margin: 0 auto 2rem;"></div>
    </div>
</header>

<!-- Sales Page Content -->
<section class="sales-content" style="padding: 6rem 0; background: white;">
    <div class="container">
        <div class="reveal" style="max-width: 800px; margin: 0 auto; color: var(--text-dark); line-height: 1.8; font-size: 1.1rem;">
            {!! $page->content !!}
            
            <div style="margin-top: 4rem; text-align: center;">
                <a href="https://wa.me/{{ $settings['wa_number'] ?? '' }}?text=Halo Elnair, saya ingin bertanya detail tentang {{ $page->title }}" class="btn btn-gold" style="padding: 1.5rem 3rem; font-size: 1.1rem; border-radius: 50px;">
                    <i class="fab fa-whatsapp" style="margin-right: 15px;"></i> Lihat Detail & Konsultasi
                </a>
            </div>
        </div>
    </div>
</section>

@include('landing.sections.cta.index')
@endsection
