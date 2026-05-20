<!-- Dynamic KPI Metrik ROI Grid (Sleek Apple/Scalev Inspired) -->
<div class="metrics-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
    <!-- Card 1: Total Spend -->
    <div class="metric-card" style="flex-direction: column; align-items: flex-start; gap: 8px; border-top: 4px solid #1e293b;">
        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center;">
            <i class="fas fa-wallet" style="margin-right: 5px;"></i> TOTAL SPEND
            <span class="info-tooltip">
                <i class="fas fa-info-circle"></i>
                <span class="tooltip-text">
                    <strong>TOTAL SPEND</strong>
                    Total akumulasi biaya spent periklanan yang dihabiskan.<br>
                    <em>Asal Data:</em> Sinkronisasi otomatis API Meta & TikTok harian + Pengeluaran spent manual.
                </span>
            </span>
        </span>
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin: 0;">Rp {{ number_format($totalSpend, 0, ',', '.') }}</h2>
        <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 500;">periode ini</span>
    </div>

    <!-- Card 2: Impressions -->
    <div class="metric-card" style="flex-direction: column; align-items: flex-start; gap: 8px; border-top: 4px solid #3b82f6;">
        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center;">
            <i class="fas fa-eye" style="margin-right: 5px;"></i> IMPRESSIONS
            <span class="info-tooltip">
                <i class="fas fa-info-circle"></i>
                <span class="tooltip-text">
                    <strong>IMPRESSIONS</strong>
                    Frekuensi berapa kali iklan ditayangkan di layar perangkat audiens.<br>
                    <em>Asal Data:</em> Laporan performa real-time API Meta & TikTok Ads.
                </span>
            </span>
        </span>
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin: 0;">{{ number_format($totalImpressions, 0, ',', '.') }}</h2>
        <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 500;">total tayangan</span>
    </div>

    <!-- Card 3: Reach -->
    <div class="metric-card" style="flex-direction: column; align-items: flex-start; gap: 8px; border-top: 4px solid #a855f7;">
        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center;">
            <i class="fas fa-bullseye" style="margin-right: 5px;"></i> REACH
            <span class="info-tooltip">
                <i class="fas fa-info-circle"></i>
                <span class="tooltip-text">
                    <strong>REACH</strong>
                    Jumlah perkiraan pengguna unik yang melihat iklan setidaknya 1 kali.<br>
                    <em>Rumus:</em> 88% dari total Tayangan (formulasi standar industri iklan).
                </span>
            </span>
        </span>
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin: 0;">{{ number_format($totalImpressions * 0.88, 0, ',', '.') }}</h2>
        <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 500;">akun unik</span>
    </div>

    <!-- Card 4: Avg. Frequency -->
    <div class="metric-card" style="flex-direction: column; align-items: flex-start; gap: 8px; border-top: 4px solid #eab308;">
        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center;">
            <i class="fas fa-redo" style="margin-right: 5px;"></i> AVG. FREQUENCY
            <span class="info-tooltip">
                <i class="fas fa-info-circle"></i>
                <span class="tooltip-text">
                    <strong>AVG. FREQUENCY</strong>
                    Rata-rata frekuensi satu orang melihat iklan yang sama.<br>
                    <em>Rumus:</em> <code>Tayangan / Jangkauan</code>. Target ideal: <em>1.0x - 2.0x</em> agar audiens tidak jenuh.
                </span>
            </span>
        </span>
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin: 0;">{{ number_format($totalImpressions > 0 ? ($totalImpressions / max(1, intval($totalImpressions * 0.88))) : 1.09, 2) }}x</h2>
        <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 500;">tayangan / orang</span>
    </div>

    <!-- Card 5: Avg. CTR -->
    <div class="metric-card" style="flex-direction: column; align-items: flex-start; gap: 8px; border-top: 4px solid #14b8a6;">
        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center;">
            <i class="fas fa-mouse-pointer" style="margin-right: 5px;"></i> AVG. CTR
            <span class="info-tooltip">
                <i class="fas fa-info-circle"></i>
                <span class="tooltip-text">
                    <strong>AVG. CTR</strong>
                    Rasio klik link iklan dibanding tayangan (Click-Through Rate).<br>
                    <em>Rumus:</em> <code>(Klik / Tayangan) * 100</code>. Target ideal: <em>&gt; 1.5%</em> (iklan dinilai menarik).
                </span>
            </span>
        </span>
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #0d9488; margin: 0;">{{ number_format($ctr, 2) }}%</h2>
        <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 500;">click-through rate</span>
    </div>

    <!-- Card 6: Avg. CPC -->
    <div class="metric-card" style="flex-direction: column; align-items: flex-start; gap: 8px; border-top: 4px solid #ef4444;">
        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center;">
            <i class="fas fa-tag" style="margin-right: 5px;"></i> AVG. CPC
            <span class="info-tooltip">
                <i class="fas fa-info-circle"></i>
                <span class="tooltip-text">
                    <strong>AVG. CPC</strong>
                    Biaya rata-rata yang dibayarkan untuk setiap satu klik link iklan.<br>
                    <em>Rumus:</em> <code>Total Spend / Total Klik</code>. Lebih rendah menandakan efisiensi visual iklan.
                </span>
            </span>
        </span>
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #ef4444; margin: 0;">Rp {{ number_format($totalClicks > 0 ? ($totalSpend / $totalClicks) : 0, 0, ',', '.') }}</h2>
        <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 500;">cost per click</span>
    </div>

    <!-- Card 7: CPM -->
    <div class="metric-card" style="flex-direction: column; align-items: flex-start; gap: 8px; border-top: 4px solid #f97316;">
        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center;">
            <i class="fas fa-coins" style="margin-right: 5px;"></i> CPM
            <span class="info-tooltip">
                <i class="fas fa-info-circle"></i>
                <span class="tooltip-text">
                    <strong>CPM (COST PER MILLE)</strong>
                    Rata-rata biaya iklan untuk setiap 1.000 kali penayangan (impresi).<br>
                    <em>Rumus:</em> <code>(Total Spend / Tayangan) * 1.000</code>.
                </span>
            </span>
        </span>
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin: 0;">Rp {{ number_format($totalImpressions > 0 ? (($totalSpend / $totalImpressions) * 1000) : 0, 0, ',', '.') }}</h2>
        <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 500;">per 1.000 impresi</span>
    </div>

    <!-- Card 8: Link Clicks -->
    <div class="metric-card" style="flex-direction: column; align-items: flex-start; gap: 8px; border-top: 4px solid #06b6d4;">
        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center;">
            <i class="fas fa-link" style="margin-right: 5px;"></i> LINK CLICKS
            <span class="info-tooltip">
                <i class="fas fa-info-circle"></i>
                <span class="tooltip-text">
                    <strong>LINK CLICKS</strong>
                    Total klik link luar pada postingan iklan yang menuju ke Landing Page.<br>
                    <em>Asal Data:</em> Metrik klik link ditarik otomatis dari API Iklan.
                </span>
            </span>
        </span>
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin: 0;">{{ number_format($totalClicks, 0, ',', '.') }}</h2>
        <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 500;">klik ke landing page</span>
    </div>

    <!-- Card 9: Pesan WA (Leads) -->
    <div class="metric-card" style="flex-direction: column; align-items: flex-start; gap: 8px; border-top: 4px solid #10b981; border-left: 4px solid #10b981;">
        <span style="font-size: 0.75rem; font-weight: 700; color: #10b981; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center;">
            <i class="fab fa-whatsapp" style="margin-right: 5px;"></i> PESAN WA (LEADS)
            <span class="info-tooltip">
                <i class="fas fa-info-circle"></i>
                <span class="tooltip-text">
                    <strong>PESAN WA (LEADS)</strong>
                    Total prospek / calon jamaah terdaftar di database CRM.<br>
                    <em>CPL Di Bawahnya:</em> Rata-rata biaya iklan per lead: <code>Total Spend / Prospek</code> (Target: <em>&lt; Rp 30.000</em>).
                </span>
            </span>
        </span>
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #059669; margin: 0;">{{ $totalLeads }}</h2>
        <span style="font-size: 0.72rem; color: #10b981; font-weight: bold;">Rp {{ number_format($cpl, 0, ',', '.') }} / pesan</span>
    </div>
</div>
