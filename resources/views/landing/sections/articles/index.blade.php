<!-- Latest Articles Section -->
@if($articles->count() > 0)
<section id="artikel" class="pattern-bg" style="padding: 5rem 0;">
    <div class="container">
        <div class="section-header reveal" style="text-align: center; margin-bottom: 3rem;">
            <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.7rem;">Elnair Insights</span>
            <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 3rem); margin: 0.5rem 0; color: var(--brand-dark);">Artikel & Kajian</h2>
            <p style="opacity: 0.8; max-width: 600px; margin: 0 auto;">Inspirasi dan panduan ibadah terbaru untuk menemani persiapan perjalanan suci Anda.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
            @foreach($articles as $article)
            <article class="reveal" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s; border: 1px solid rgba(13, 76, 84, 0.05);">
                <a href="{{ route('artikel.show', $article->slug) }}" style="display: block;">
                    <div style="height: 200px; background-image: url('{{ $article->thumbnail ? (str_starts_with($article->thumbnail, 'http') ? $article->thumbnail : asset($article->thumbnail)) : asset('assets/img/hero-bg.jpg') }}'); background-size: cover; background-position: center;"></div>
                </a>
                <div style="padding: 1.5rem;">
                    <div style="font-size: 0.75rem; color: #888; margin-bottom: 0.8rem;">
                        <i class="far fa-calendar-alt"></i> {{ $article->created_at->translatedFormat('d M Y') }}
                    </div>
                    <h3 style="font-size: 1.1rem; margin-bottom: 0.8rem; line-height: 1.4;">
                        <a href="{{ route('artikel.show', $article->slug) }}" style="color: var(--brand-dark); text-decoration: none; font-family: 'Playfair Display', serif;">
                            {{ $article->title }}
                        </a>
                    </h3>
                    <p style="color: var(--text-dark); font-size: 0.85rem; line-height: 1.6; margin-bottom: 1rem;">
                        {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 80) }}
                    </p>
                    <a href="{{ route('artikel.show', $article->slug) }}" style="color: var(--brand-gold); text-decoration: none; font-weight: 700; font-size: 0.8rem;">
                        Baca Selengkapnya <i class="fas fa-arrow-right" style="margin-left: 5px;"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('artikel.index') }}" class="btn btn-outline" style="border-color: var(--brand-dark); color: var(--brand-dark);">
                Lihat Semua Artikel <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
            </a>
        </div>
    </div>
</section>
@endif
