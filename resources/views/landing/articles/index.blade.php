@extends('landing.layouts.app')

@section('content')
<!-- Hero Articles -->
<section class="articles-hero">
    <div class="container">
        <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.9rem;">Elnair Insights</span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 4rem); margin: 1rem 0;">Artikel & Kajian</h1>
        <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Inspirasi, panduan ibadah, dan informasi terkini seputar Umrah & Haji.</p>
    </div>
</section>

<!-- Blog List -->
<section class="pattern-bg" style="padding: 5rem 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
            @forelse($articles as $article)
            <article class="article-card reveal">
                <a href="{{ route('artikel.show', $article->slug) }}" style="display: block;">
                    <div style="height: 220px; background-image: url('{{ $article->thumbnail ? (str_starts_with($article->thumbnail, 'http') ? $article->thumbnail : asset($article->thumbnail)) : asset('assets/img/hero-premium.webp') }}'); background-size: cover; background-position: center;"></div>
                </a>
                <div style="padding: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; font-size: 0.8rem; color: #888;">
                        <span><i class="fas fa-calendar-days" aria-hidden="true"></i> {{ $article->created_at->translatedFormat('d M Y') }}</span>
                        <span><i class="fas fa-user" aria-hidden="true"></i> {{ $article->author->name ?? 'Admin' }}</span>
                    </div>
                    <h3 style="font-size: 1.3rem; margin-bottom: 1rem; line-height: 1.4;">
                        <a href="{{ route('artikel.show', $article->slug) }}" class="article-title-link">
                            {{ $article->title }}
                        </a>
                    </h3>
                    <p style="color: var(--text-dark); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem; opacity: 0.85;">
                        {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}
                    </p>
                    <a href="{{ route('artikel.show', $article->slug) }}" style="color: var(--brand-gold); text-decoration: none; font-weight: 700; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 5px;">
                        Baca Selengkapnya <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </article>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 2rem; background: var(--card-bg); border-radius: 20px; border: 1px solid rgba(13, 76, 84, 0.05);">
                <i class="fas fa-newspaper" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                <h3 style="color: var(--brand-dark); margin-bottom: 0.5rem;">Belum Ada Artikel</h3>
                <p style="color: var(--text-dark); opacity: 0.8;">Artikel dan kajian inspiratif akan segera hadir di sini.</p>
            </div>
            @endforelse
        </div>

        <div style="margin-top: 4rem; display: flex; justify-content: center;">
            {{ $articles->links() }}
        </div>
    </div>
</section>

<style>
    .articles-hero {
        position: relative;
        padding: 150px 0 80px 0;
        background: #0D4C54;
        color: white;
        text-align: center;
    }
    
    [data-theme="dark"] .articles-hero {
        background: #0C1517;
        border-bottom: 1px solid rgba(123, 191, 200, 0.1);
    }
    
    .article-card {
        background: var(--card-bg);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        border: 1px solid rgba(13, 76, 84, 0.05);
        display: flex;
        flex-direction: column;
    }
    
    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    [data-theme="dark"] .article-card {
        border-color: rgba(123, 191, 200, 0.1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }
    
    .article-title-link {
        color: var(--brand-dark);
        text-decoration: none;
        font-family: 'Playfair Display', serif;
        transition: color 0.2s ease;
    }
    
    .article-title-link:hover {
        color: var(--brand-gold);
    }
    
    [data-theme="dark"] .article-title-link {
        color: var(--text-dark);
    }
    
    [data-theme="dark"] .article-title-link:hover {
        color: var(--brand-teal);
    }
</style>
@endsection
