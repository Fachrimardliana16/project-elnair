@extends('landing.layouts.app')

@section('content')
<!-- Sales Page Header -->
<header class="sales-header" style="position: relative; padding: 15rem 0 8rem; text-align: center; color: white; overflow: hidden;">
    <div class="hero-bg-img" style="background-image: url('{{ asset($page->hero_image ?? 'assets/img/hero.png') }}'); position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background-size: cover; background-position: center;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7);"></div>
    </div>

    <div class="container">
        <span class="cta-tag reveal" style="color: var(--brand-gold);">Exclusive Campaign</span>
        <h1 class="reveal" style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 8vw, 4.5rem); margin: 1.5rem 0;">{{ $page->title }}</h1>
        <div class="reveal" style="width: 80px; height: 3px; background: var(--brand-gold); margin: 0 auto 2rem;"></div>
    </div>
</header>

<!-- Sales Page Content -->
<section class="sales-content" style="padding: 8rem 0; background: #fff;">
    <div class="container">
        <div class="reveal" style="max-width: 900px; margin: 0 auto; color: var(--text-dark); line-height: 2; font-size: 1.2rem;">
            <div class="content-body">
                {!! $page->content !!}
            </div>
            
            <div style="margin-top: 5rem; text-align: center;">
                @php
                    $wa_number = $page->custom_wa_number ?? ($settings['wa_number'] ?? '');
                    $wa_message = $page->custom_wa_message ?? ("Halo Elnair, saya ingin bertanya tentang " . $page->title);
                    $wa_link = "https://wa.me/" . preg_replace('/[^0-9]/', '', $wa_number) . "?text=" . urlencode($wa_message);
                @endphp
                <a href="{{ $wa_link }}" class="btn btn-gold" style="padding: 1.5rem 4rem; font-size: 1.2rem; border-radius: 100px; box-shadow: 0 15px 30px rgba(193, 155, 101, 0.3);">
                    <i class="fab fa-whatsapp" style="margin-right: 15px; font-size: 1.5rem;"></i> Amankan Kursi Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

@include('landing.sections.cta.index')
@endsection
