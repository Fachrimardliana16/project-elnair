@extends('landing.layouts.app')

@section('content')
<header class="sales-header" style="background: var(--bg-dark); padding: 12rem 0 6rem; text-align: center; color: white;">
    <div class="container">
        <h1>{{ $page->title }}</h1>
    </div>
</header>

<section class="sales-content" style="padding: 6rem 0; background: white;">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            {!! $page->content !!}
            
            <div style="margin-top: 4rem; text-align: center;">
                @php
                    $wa_number = $page->custom_wa_number ?? ($settings['wa_number'] ?? '');
                    $wa_message = $page->custom_wa_message ?? ("Halo Elnair, saya ingin bertanya tentang " . $page->title);
                    $wa_link = "https://wa.me/" . preg_replace('/[^0-9]/', '', $wa_number) . "?text=" . urlencode($wa_message);
                @endphp
                <a href="{{ $wa_link }}" class="btn btn-gold">
                    Hubungi WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
