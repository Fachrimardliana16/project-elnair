@extends('landing.layouts.app')

@section('content')
    @include('landing.sections.hero.index')
    @include('landing.sections.experience.index')
    @include('landing.sections.schedule.index')
    @include('landing.sections.packages.index')
    @include('landing.sections.articles.index')
    @include('landing.sections.testimonials.index')
    @include('landing.sections.location.index')
    @include('landing.sections.cta.index')

    <!-- SEO Schema.org (JSON-LD) -->
    <script type="application/ld+json">
    {!! $packageSchema !!}
    </script>
@endsection
