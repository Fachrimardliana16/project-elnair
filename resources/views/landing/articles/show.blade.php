@extends('landing.layouts.app')

@section('content')
<!-- Hero Article Detail -->
<section style="position: relative; height: 60vh; background-image: url('{{ $article->thumbnail ? (str_starts_with($article->thumbnail, 'http') ? $article->thumbnail : asset($article->thumbnail)) : asset('assets/img/hero-bg.jpg') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(13, 76, 84, 0.7);"></div>
    <div class="container" style="position: relative; z-index: 2; text-align: center; color: white;">
        <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.9rem;">Elnair Insights</span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 3.5rem); margin: 1rem auto; max-width: 900px; line-height: 1.3;">{{ $article->title }}</h1>
        <div style="display: flex; justify-content: center; gap: 2rem; font-size: 1rem; opacity: 0.9; margin-top: 2rem;">
            <span><i class="far fa-calendar-alt"></i> {{ $article->created_at->translatedFormat('d F Y') }}</span>
            <span><i class="far fa-user"></i> Ditulis oleh {{ $article->author->name ?? 'Admin' }}</span>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="pattern-bg" style="padding: 5rem 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 2.5fr 1fr; gap: 4rem; align-items: start;">
            
            <!-- Left: Main Content -->
            <div class="article-content" style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <div class="rich-text" style="font-size: 1.1rem; line-height: 1.9; color: var(--text-dark);">
                    {!! $article->content !!}
                </div>

                <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                    <h4 style="font-family: 'Playfair Display', serif; color: var(--brand-dark); margin: 0;">Bagikan Artikel Ini:</h4>
                    <div style="display: flex; gap: 1rem;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank" style="width: 40px; height: 40px; border-radius: 50%; background: #1877F2; color: white; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}&text={{ urlencode($article->title) }}" target="_blank" style="width: 40px; height: 40px; border-radius: 50%; background: #1DA1F2; color: white; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fab fa-twitter"></i></a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' - ' . Request::fullUrl()) }}" target="_blank" style="width: 40px; height: 40px; border-radius: 50%; background: #25D366; color: white; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>

            <!-- Right: Sidebar (Related) -->
            <aside class="article-sidebar" style="position: sticky; top: 100px;">
                <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <h3 style="font-family: 'Playfair Display', serif; color: var(--brand-dark); margin-bottom: 2rem; border-bottom: 2px solid var(--brand-gold); padding-bottom: 0.5rem; display: inline-block;">Baca Juga</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        @foreach($related as $rel)
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 80px; height: 80px; border-radius: 10px; background-image: url('{{ $rel->thumbnail ? (str_starts_with($rel->thumbnail, 'http') ? $rel->thumbnail : asset($rel->thumbnail)) : asset('assets/img/hero-bg.jpg') }}'); background-size: cover; background-position: center; flex-shrink: 0;"></div>
                            <div>
                                <h4 style="font-size: 1rem; line-height: 1.4; margin-bottom: 0.3rem;">
                                    <a href="{{ route('artikel.show', $rel->slug) }}" style="color: var(--brand-dark); text-decoration: none; font-family: 'Playfair Display', serif;">
                                        {{ \Illuminate\Support\Str::limit($rel->title, 50) }}
                                    </a>
                                </h4>
                                <span style="font-size: 0.75rem; color: #888;">{{ $rel->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Banner CTA -->
                <div style="margin-top: 2rem; background: var(--brand-dark); color: white; padding: 2rem; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(13, 76, 84, 0.2);">
                    <i class="fas fa-kaaba" style="font-size: 3rem; color: var(--brand-gold); margin-bottom: 1rem;"></i>
                    <h3 style="font-family: 'Playfair Display', serif; margin-bottom: 1rem;">Siap Menuju Baitullah?</h3>
                    <p style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 1.5rem;">Dapatkan penawaran eksklusif untuk paket Umrah & Haji Khusus Elnair.</p>
                    <a href="{{ url('/') }}#paket" class="btn btn-gold" style="width: 100%; justify-content: center;">Lihat Paket</a>
                </div>
            </aside>

        </div>
    </div>
</section>

<style>
    .rich-text h2 { font-family: 'Playfair Display', serif; color: var(--brand-dark); font-size: 1.8rem; margin: 2rem 0 1rem; }
    .rich-text h3 { font-family: 'Playfair Display', serif; color: var(--brand-dark); font-size: 1.5rem; margin: 1.5rem 0 1rem; }
    .rich-text p { margin-bottom: 1.5rem; }
    .rich-text ul, .rich-text ol { margin-bottom: 1.5rem; padding-left: 1.5rem; }
    .rich-text li { margin-bottom: 0.5rem; }
    .rich-text img { max-width: 100%; height: auto; border-radius: 10px; margin: 2rem 0; }
    .rich-text blockquote { border-left: 4px solid var(--brand-gold); padding-left: 1.5rem; margin: 2rem 0; font-style: italic; color: #555; background: #f9f9f9; padding: 1.5rem; border-radius: 0 10px 10px 0; }

    @media (max-width: 992px) {
        .article-content, .article-sidebar { grid-column: span 2; }
        .article-sidebar { position: static; margin-top: 2rem; }
        .article-content { padding: 2rem 1.5rem; }
    }
</style>
@endsection
