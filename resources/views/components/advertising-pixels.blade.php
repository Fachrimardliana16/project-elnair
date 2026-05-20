{{--
    advertising-pixels.blade.php
    ─────────────────────────────────────────────────────────────────────────
    Modular blade component that loads ALL advertising & analytics base scripts
    asynchronously so they never block First Contentful Paint.

    All pixel IDs are read from .env via the $settings array (injected globally
    by AppServiceProvider's View Composer) or can be overridden by passing
    $page-specific pixel IDs from a landing page context.

    Usage:
        <!-- In layout head (after </title>) -->
        <x-advertising-pixels />

        <!-- On a landing page with page-specific overrides -->
        <x-advertising-pixels
            :meta-pixel-id="$page->fb_pixel_id ?? null"
            :gtm-id="null"
            :page-view-event-id="$pageViewEventId"
        />

    Environment Variables (.env):
        META_PIXEL_ID          — Meta (Facebook) Pixel ID
        GOOGLE_TAG_MANAGER_ID  — Google Tag Manager container ID (GTM-XXXXXX)
        GA4_MEASUREMENT_ID     — Google Analytics 4 Measurement ID (G-XXXXXXXX)
        TIKTOK_PIXEL_ID        — TikTok Pixel ID

    All scripts are injected with async/defer to guarantee non-blocking load.
--}}

@props([
    'metaPixelId'      => null,   // Override: page-specific Meta Pixel ID
    'gtmId'            => null,   // Override: page-specific GTM container
    'ga4Id'            => null,   // Override: page-specific GA4 measurement ID
    'tiktokPixelId'    => null,   // Override: page-specific TikTok Pixel ID
    'pageViewEventId'  => null,   // Deduplication event_id for Meta server-side matching
])

@php
    // Resolve pixel IDs: prop override > .env fallback
    $resolvedMeta    = $metaPixelId    ?? config('services.pixels.meta_pixel_id');
    $resolvedGtm     = $gtmId         ?? config('services.pixels.gtm_id');
    $resolvedGa4     = $ga4Id         ?? config('services.pixels.ga4_id');
    $resolvedTiktok  = $tiktokPixelId ?? config('services.pixels.tiktok_pixel_id');
    $resolvedEventId = $pageViewEventId ?? ('pv_' . uniqid());
@endphp

{{-- ─────────────────── GOOGLE TAG MANAGER (GTM) ─────────────────── --}}
@if($resolvedGtm)
<!-- Google Tag Manager (async) -->
<script>
(function(w,d,s,l,i){
    w[l]=w[l]||[];
    w[l].push({'gtm.start': new Date().getTime(), event:'gtm.js'});
    var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s), dl=l!='dataLayer'?'&l='+l:'';
    j.async=true;
    j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
    f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{{ $resolvedGtm }}');
</script>
<!-- End Google Tag Manager -->
@endif

{{-- ───────────────────── GOOGLE ANALYTICS 4 (GA4) ──────────────────── --}}
@if($resolvedGa4 && !$resolvedGtm)
<!-- Google Analytics 4 (async, standalone — only loaded when GTM is not present) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $resolvedGa4 }}"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '{{ $resolvedGa4 }}', { 'send_page_view': true });
</script>
<!-- End Google Analytics 4 -->
@endif

{{-- ─────────────────────── META PIXEL (FBQ) ─────────────────────── --}}
@if($resolvedMeta)
<!-- Meta Pixel (async, non-blocking) -->
<script>
!function(f,b,e,v,n,t,s){
    if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)
}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $resolvedMeta }}');
fbq('track', 'PageView', {}, {eventID: '{{ $resolvedEventId }}'});
</script>
<noscript>
    <img height="1" width="1" style="display:none" alt="pixel"
         src="https://www.facebook.com/tr?id={{ $resolvedMeta }}&ev=PageView&noscript=1" />
</noscript>
<!-- End Meta Pixel -->
@endif

{{-- ─────────────────────── TIKTOK PIXEL ─────────────────────── --}}
@if($resolvedTiktok)
<!-- TikTok Pixel (async) -->
<script>
!function (w, d, t) {
    w.TiktokAnalyticsObject=t;
    var ttq=w[t]=w[t]||[];
    ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"];
    ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};
    for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);
    ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e};
    ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";
    ttq._i=ttq._i||{};ttq._i[e]=[];ttq._i[e]._u=i;ttq._t=ttq._t||{};
    ttq._t[e]=+new Date;ttq._o=ttq._o||{};ttq._o[e]=n||{};
    var o=document.createElement("script");o.type="text/javascript";o.async=!0;o.src=i+"?sdkid="+e+"&lib="+t;
    var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};
    ttq.load('{{ $resolvedTiktok }}');
    ttq.page();
}(window, document, 'ttq');
</script>
<!-- End TikTok Pixel -->
@endif

{{-- GTM noscript body tag (must be placed immediately after <body>) --}}
{{-- Inject via @stack('gtm_body') in your layout if needed --}}
@if($resolvedGtm)
@push('gtm_body')
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id={{ $resolvedGtm }}"
            height="0" width="0" style="display:none;visibility:hidden" title="gtm"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
@endpush
@endif
