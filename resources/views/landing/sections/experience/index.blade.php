<!-- Section Experience -->
<section id="why-us">
    <div class="container">
        <div class="section-header reveal">
            <span>The Art of Pilgrimage</span>
            <h2>Mengapa Memilih Kami?</h2>
            <p>Keunggulan layanan yang dirancang khusus untuk memastikan setiap detik ibadah Anda bernilai ibadah dan berkesan.</p>
        </div>
        <div class="grid">
            @foreach($features as $loop_feature)
            <div class="card reveal">
                <span class="card-index">{{ sprintf('%02d', $loop->iteration) }}</span>
                <div class="card-icon-box">
                    <i class="{{ $loop_feature->icon }} card-icon"></i>
                </div>
                <h3>{{ $loop_feature->title }}</h3>
                <p>{{ $loop_feature->description }}</p>
                <div class="card-line"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>
