<!-- Section Experience (Bento Grid) -->
<section id="why-us" class="pattern-bg">
    <div class="container">
        <div class="section-header reveal">
            <span>The Art of Pilgrimage</span>
            <h2>Mengapa Memilih Kami?</h2>
            <p>Keunggulan layanan yang dirancang khusus untuk memastikan setiap detik ibadah Anda bernilai dan berkesan.</p>
        </div>
        <div class="bento-grid">
            @foreach($features->take(4) as $index => $loop_feature)
            @php
                $bento_class = 'bento-' . ($index % 4 + 1);
            @endphp
            <div class="bento-card {{ $bento_class }} reveal">
                <div class="card-icon-box">
                    <i class="{{ $loop_feature->icon }} card-icon"></i>
                </div>
                <div class="bento-content">
                    <h3>{{ $loop_feature->title }}</h3>
                    <p>{{ $loop_feature->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
