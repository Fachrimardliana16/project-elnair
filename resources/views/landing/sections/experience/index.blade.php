<!-- Section Experience (Bento Grid) -->
<section id="why-us" class="pattern-bg">
    <div class="container">
        <div class="section-header reveal">
            <span>Keunggulan Elnair Travel</span>
            <h2>Ribuan Jamaah Telah Mempercayakan Perjalanan Sucinya</h2>
            <p>Setiap detail perjalanan kami rancang dengan seksama — karena ibadah Anda terlalu berharga untuk diserahkan sembarangan.</p>
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
