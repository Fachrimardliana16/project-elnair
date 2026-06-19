@extends('landing.layouts.app')

@section('content')
    @if(($settings['show_hero_section'] ?? '1') == '1')
        @include('landing.sections.hero.index')
    @endif

    @if(($settings['show_experience_section'] ?? '1') == '1')
        @include('landing.sections.experience.index')
    @endif

    @if(($settings['show_schedule_section'] ?? '1') == '1')
        @include('landing.sections.schedule.index')
    @endif

    @if(($settings['show_packages_section'] ?? '1') == '1')
        @include('landing.sections.packages.index')
    @endif

    @if(($settings['show_articles_section'] ?? '1') == '1')
        @include('landing.sections.articles.index')
    @endif

    @if(($settings['show_testimonials_section'] ?? '1') == '1')
        @include('landing.sections.testimonials.index')
    @endif

    @if(($settings['show_location_section'] ?? '1') == '1')
        @include('landing.sections.location.index')
    @endif

    @if(($settings['show_cta_section'] ?? '1') == '1')
        @include('landing.sections.cta.index')
    @endif

    <!-- SEO Schema.org (JSON-LD) -->
    <script type="application/ld+json">
    {!! $packageSchema !!}
    </script>
@endsection
