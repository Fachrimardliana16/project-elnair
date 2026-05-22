@extends('landing.layouts.app')

@section('content')
<!-- Hero Articles -->
<section style="position: relative; padding: 150px 0 80px 0; background: var(--brand-dark); color: white; text-align: center;">
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
            <article class="reveal" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s; border: 1px solid rgba(13, 76, 84, 0.05);">
                <a href="{{ route('artikel.show', $article->slug) }}" style="display: block;">
                    <div style="height: 220px; background-image: url('{{ $article->thumbnail ? (str_starts_with($article->thumbnail, 'http') ? $article->thumbnail : asset($article->thumbnail)) : asset('assets/img/hero-bg.jpg') }}'); background-size: cover; background-position: center;"></div>
                </a>
                <div style="padding: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; font-size: 0.8rem; color: #888;">
                        <span><i class="fas fa-calendar-days" aria-hidden="true"></i> {{ $article->created_at->translatedFormat('d M Y') }}</span>
                        <span><i class="fas fa-user" aria-hidden="true"></i> {{ $article->author->name ?? 'Admin' }}</span>
                    </div>
                    <h3 style="font-size: 1.3rem; margin-bottom: 1rem; line-height: 1.4;">
                        <a href="{{ route('artikel.show', $article->slug) }}" style="color: var(--brand-dark); text-decoration: none; font-family: 'Playfair Display', serif;">
                            {{ $article->title }}
                        </a>
                    </h3>
                    <p style="color: var(--text-dark); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                        {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}
                    </p>
                    <a href="{{ route('artikel.show', $article->slug) }}" style="color: var(--brand-gold); text-decoration: none; font-weight: 700; font-size: 0.9rem;">
                        Baca Selengkapnya <i class="fas fa-arrow-right" style="margin-left: 5px;"></i>
                    </a>
                </div>
            </article>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 2rem; background: rgba(255,255,255,0.8); border-radius: 20px;">
                <i class="fas fa-newspaper" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                <h3 style="color: var(--brand-dark); margin-bottom: 0.5rem;">Belum Ada Artikel</h3>
                <p style="color: var(--text-dark);">Artikel dan kajian inspiratif akan segera hadir di sini.</p>
            </div>
            @endforelse
        </div>

        <div style="margin-top: 4rem; display: flex; justify-content: center;">
            {{ $articles->links() }}
        </div>
    </div>
</section>
@endsection
