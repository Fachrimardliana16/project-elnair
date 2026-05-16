@extends('landing.layouts.app')

@section('content')
    @include('landing.sections.hero.index')
    @include('landing.sections.experience.index')
    @include('landing.sections.packages.index')
    @include('landing.sections.testimonials.index')
    @include('landing.sections.location.index')
    @include('landing.sections.cta.index')
@endsection

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "itemListElement": [
    @foreach($packages as $index => $pkg)
    {
      "@type": "ListItem",
      "position": {{ $index + 1 }},
      "item": {
        "@type": "Product",
        "name": "{{ $pkg->title }}",
        "image": "{{ asset($pkg->image) }}",
        "description": "{{ Str::limit(strip_tags($pkg->description), 160) }}",
        "offers": {
          "@type": "Offer",
          "priceCurrency": "IDR",
          "price": "{{ preg_replace('/[^0-9]/', '', $pkg->price_value) }}",
          "availability": "https://schema.org/InStock",
          "url": "{{ url('/') }}#paket"
        }
      }
    }{!! $loop->last ? '' : ',' !!}
    @endforeach
  ]
}
</script>
@endpush


