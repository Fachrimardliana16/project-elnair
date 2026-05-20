<!-- ==========================================
     TAB 2: ROI INSIGHTS
     ========================================== -->
<div id="tab-roi" class="tab-content">
    <!-- Dynamic Campaign Type & Business Mode Switcher (NEW!) -->
    <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 12px; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="background-color: var(--brand-dark); color: #ffffff; width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-sliders-h" style="font-size: 1rem;"></i>
            </div>
            <div>
                <strong style="color: var(--brand-dark); font-size: 0.88rem; display: block;">Konfigurasi Model Bisnis & Metrik Kampanye ⚙️</strong>
                <span style="color: #64748b; font-size: 0.76rem; display: block;">Sesuaikan jenis tabel konversi dan kalkulasi ROI sesuai dengan kategori produk iklan Anda.</span>
            </div>
        </div>
        <div style="display: flex; background-color: #cbd5e1; padding: 3px; border-radius: 8px; gap: 4px;">
            <button id="btn-mode-leadgen" onclick="switchBusinessMode('leadgen')" style="border: none; padding: 6px 14px; border-radius: 6px; font-size: 0.78rem; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; background-color: #ffffff; color: var(--brand-dark); box-shadow: 0 2px 4px rgba(0,0,0,0.08);">
                <i class="fas fa-handshake"></i> Lead Gen & Jasa Premium (Umroh)
            </button>
            <button id="btn-mode-retail" onclick="switchBusinessMode('retail')" style="border: none; padding: 6px 14px; border-radius: 6px; font-size: 0.78rem; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s; background-color: transparent; color: #475569;">
                <i class="fas fa-shopping-cart"></i> Retail & Marketplace (Shopee/Shop)
            </button>
        </div>
    </div>

    <div class="analytics-grid">
        <!-- Grafik Tren Biaya vs Lead -->
        <div class="admin-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
                <h3 style="margin: 0; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-chart-line"></i> Grafik Tren & Metrik Pemasaran</h3>
                <div style="display: flex; gap: 6px;">
                    <button class="btn-admin active" id="btn-chart-spend-leads" onclick="switchChartDataset('spend-leads')" style="padding: 4px 10px; font-size: 0.72rem; border-radius: 12px;">Biaya vs Leads</button>
                    <button class="btn-admin" id="btn-chart-spend-clicks" onclick="switchChartDataset('spend-clicks')" style="padding: 4px 10px; font-size: 0.72rem; border-radius: 12px; background-color: #64748b;">Biaya vs Klik</button>
                    <button class="btn-admin" id="btn-chart-ctr-cvr" onclick="switchChartDataset('ctr-cvr')" style="padding: 4px 10px; font-size: 0.72rem; border-radius: 12px; background-color: #64748b;">Rasio CTR vs CVR</button>
                </div>
            </div>
            <div style="height: 350px; position: relative;">
                <canvas id="roiTrendsChart"></canvas>
            </div>
        </div>

        <!-- KPI Sekilas Biaya -->
        <div class="admin-card" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="margin-top: 0; margin-bottom: 1.25rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-bullseye"></i> Kinerja ROI & Kesehatan Iklan</h3>
                
                <!-- Campaign Health Badge -->
                <div style="margin-bottom: 1.5rem; text-align: center;">
                    @if($roas >= 4.0)
                        <span style="background-color: #d1fae5; color: #065f46; border: 1px solid #10b981; padding: 6px 14px; border-radius: 20px; font-weight: 800; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px;"><i class="fas fa-check-circle" style="color: #10b981;"></i>  HIGH ROAS (>4.0x)</span>
                    @elseif($roas >= 2.0)
                        <span style="background-color: #dbeafe; color: #1e40af; border: 1px solid #3b82f6; padding: 6px 14px; border-radius: 20px; font-weight: 800; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px;"><i class="fas fa-chart-line" style="color: #3b82f6;"></i> 📈 STABLE ROAS (2.0x-4.0x)</span>
                    @else
                        <span style="background-color: #fee2e2; color: #991b1b; border: 1px solid #ef4444; padding: 6px 14px; border-radius: 20px; font-weight: 800; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px;"><i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i> ⚠️ EVALUATE ROAS (<2.0x)</span>
                    @endif
                </div>

                <div style="border-bottom: 1px solid #eee; padding-bottom: 0.75rem; margin-bottom: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-size: 0.72rem; color: #64748b; font-weight: bold; display: block; text-transform: uppercase;">Estimasi Nilai Omset</span>
                        <strong style="font-size: 1.15rem; color: #059669;">Rp {{ number_format($totalOmset, 0, ',', '.') }}</strong>
                    </div>
                    <i class="fas fa-wallet" style="font-size: 1.5rem; color: #cbd5e1;"></i>
                </div>
                
                <div style="border-bottom: 1px solid #eee; padding-bottom: 0.75rem; margin-bottom: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-size: 0.72rem; color: #64748b; font-weight: bold; display: block; text-transform: uppercase;">ROAS (Ad Spend Multiplier)</span>
                        <strong style="font-size: 1.15rem; color: #0f172a;">{{ number_format($roas, 1) }}x</strong>
                    </div>
                    <i class="fas fa-expand-arrows-alt" style="font-size: 1.5rem; color: #cbd5e1;"></i>
                </div>

                <div style="border-bottom: 1px solid #eee; padding-bottom: 0.75rem; margin-bottom: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-size: 0.72rem; color: #64748b; font-weight: bold; display: block; text-transform: uppercase;">CAC (Cost to Acquire User)</span>
                        <strong style="font-size: 1.15rem; color: #dc2626;">Rp {{ number_format($cac, 0, ',', '.') }}</strong>
                    </div>
                    <i class="fas fa-user-plus" style="font-size: 1.5rem; color: #cbd5e1;"></i>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-size: 0.72rem; color: #64748b; font-weight: bold; display: block; text-transform: uppercase;">CS Closing CVR (Sales)</span>
                        <strong style="font-size: 1.15rem; color: #2563eb;">{{ number_format($salesCvr, 1) }}%</strong>
                    </div>
                    <i class="fas fa-handshake" style="font-size: 1.5rem; color: #cbd5e1;"></i>
                </div>
            </div>
            <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px; border-radius: 8px; font-size: 0.72rem; color: #166534; margin-top: 1rem; line-height: 1.4;">
                <i class="fas fa-info-circle"></i> <strong>CAC (Customer Acquisition Cost)</strong> menilai efisiensi konversi penutupan deal transaksi per jamaah umroh.
            </div>
        </div>
    </div>

    <!-- Profil Demografi Prospek (Usia & Gender Breakdown) (NEW!) -->
    <div class="admin-card" style="margin-bottom: 2rem; border-left: 4px solid var(--brand-dark); box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
            <div>
                <h3 style="margin: 0; font-size: 1.1rem; color: var(--brand-dark); display: flex; align-items: center; gap: 8px;"><i class="fas fa-users-cog" style="color: var(--brand-dark);"></i> Analisis Profil Demografi Prospek (Gender & Usia Breakdown)</h3>
                <p style="font-size: 0.8rem; color: #64748b; margin: 4px 0 0 0;">Distribusi statistik usia dan jenis kelamin prospek WhatsApp yang masuk ke sistem kampanye.</p>
            </div>
            <span style="font-size: 0.72rem; background-color: #e2e8f0; color: #475569; padding: 4px 10px; border-radius: 20px; font-weight: bold;">
                <i class="fas fa-filter"></i> Berdasarkan 180 Prospek Terakhir
            </span>
        </div>

        <div class="demographics-grid">
            <!-- Gender Breakdown Visualization -->
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 12px; height: 100%;">
                <h4 style="margin: 0 0 1rem 0; font-size: 0.9rem; color: var(--brand-dark); display: flex; align-items: center; gap: 6px;"><i class="fas fa-venus-mars" style="color: #2563eb;"></i> Komposisi Gender (Jenis Kelamin)</h4>
                
                <!-- Progress Bar Gender Laki-laki -->
                <div style="margin-bottom: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: bold; margin-bottom: 5px; color: #1e293b;">
                        <span>Laki-Laki (Bapak)</span>
                        <span style="color: #2563eb;">64.2%</span>
                    </div>
                    <div style="background-color: #e2e8f0; border-radius: 10px; height: 10px; overflow: hidden; display: flex;">
                        <div style="background: linear-gradient(90deg, #3b82f6, #2563eb); width: 64.2%; border-radius: 10px;"></div>
                    </div>
                </div>

                <!-- Progress Bar Gender Perempuan -->
                <div style="margin-bottom: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: bold; margin-bottom: 5px; color: #1e293b;">
                        <span>Perempuan (Ibu)</span>
                        <span style="color: #db2777;">35.8%</span>
                    </div>
                    <div style="background-color: #e2e8f0; border-radius: 10px; height: 10px; overflow: hidden; display: flex;">
                        <div style="background: linear-gradient(90deg, #ec4899, #db2777); width: 35.8%; border-radius: 10px;"></div>
                    </div>
                </div>

                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px; border-radius: 8px; font-size: 0.72rem; color: #166534; line-height: 1.4; display: flex; gap: 8px; align-items: flex-start;">
                    <i class="fas fa-info-circle" style="margin-top: 2px;"></i>
                    <span><strong>Rekomendasi Iklan:</strong> Konten berformat keputusan keluarga (Family Package) sangat optimal karena audien didominasi pria/kepala rumah tangga (64.2%).</span>
                </div>
            </div>

            <!-- Age Range Breakdown Visualization -->
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 12px;">
                <h4 style="margin: 0 0 1rem 0; font-size: 0.9rem; color: var(--brand-dark); display: flex; align-items: center; gap: 6px;"><i class="fas fa-hourglass-half" style="color: #ea580c;"></i> Segmentasi Rentang Usia (Generasi)</h4>
                
                <!-- Age ranges -->
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <!-- 35 - 44 -->
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: bold; color: #1e293b; margin-bottom: 3px;">
                            <span>Usia 35 - 44 Tahun (Puncak Karir & Mapan) <span style="font-weight: 500; color: #ea580c;"> Hot Spot!</span></span>
                            <strong>42.5%</strong>
                        </div>
                        <div style="background-color: #e2e8f0; border-radius: 10px; height: 8px; overflow: hidden;">
                            <div style="background-color: #ea580c; width: 42.5%; border-radius: 10px; height: 100%;"></div>
                        </div>
                    </div>

                    <!-- 45 - 54 -->
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: bold; color: #1e293b; margin-bottom: 3px;">
                            <span>Usia 45 - 54 Tahun (Persiapan Pensiun)</span>
                            <strong>24.8%</strong>
                        </div>
                        <div style="background-color: #e2e8f0; border-radius: 10px; height: 8px; overflow: hidden;">
                            <div style="background-color: #f97316; width: 24.8%; border-radius: 10px; height: 100%;"></div>
                        </div>
                    </div>

                    <!-- 25 - 34 -->
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: bold; color: #1e293b; margin-bottom: 3px;">
                            <span>Usia 25 - 34 Tahun (Keluarga Muda)</span>
                            <strong>18.2%</strong>
                        </div>
                        <div style="background-color: #e2e8f0; border-radius: 10px; height: 8px; overflow: hidden;">
                            <div style="background-color: #3b82f6; width: 18.2%; border-radius: 10px; height: 100%;"></div>
                        </div>
                    </div>

                    <!-- 55+ -->
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: bold; color: #1e293b; margin-bottom: 3px;">
                            <span>Usia 55+ Tahun (Masa Emas)</span>
                            <strong>10.0%</strong>
                        </div>
                        <div style="background-color: #e2e8f0; border-radius: 10px; height: 8px; overflow: hidden;">
                            <div style="background-color: #a855f7; width: 10.0%; border-radius: 10px; height: 100%;"></div>
                        </div>
                    </div>

                    <!-- 18 - 24 -->
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: bold; color: #1e293b; margin-bottom: 3px;">
                            <span>Usia 18 - 24 Tahun (Mahasiswa/First Jobber)</span>
                            <strong>4.5%</strong>
                        </div>
                        <div style="background-color: #e2e8f0; border-radius: 10px; height: 8px; overflow: hidden;">
                            <div style="background-color: #94a3b8; width: 4.5%; border-radius: 10px; height: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analitik Per Landing Page -->
    <div class="admin-card">
        <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-funnel-dollar"></i> Analitik & Kinerja Efisiensi Biaya per Landing Page (ROI Funnel Table)</h3>
        <div class="table-responsive">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: left; font-size: 0.8rem;">Nama Landing Page</th>
                    <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: right; font-size: 0.8rem; white-space: nowrap;">
                        Ad Spend (Biaya)
                        <span class="info-tooltip">
                            <i class="fas fa-info-circle"></i>
                            <span class="tooltip-text">
                                <strong>Ad Spend (Biaya)</strong>
                                Akumulasi total biaya spent dari platform API + Input spent manual marketer.
                            </span>
                        </span>
                    </th>
                    <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: right; font-size: 0.8rem; white-space: nowrap;">
                        Estimasi Omset (Deal)
                        <span class="info-tooltip">
                            <span class="tooltip-text" style="transform: translateX(-80%);">
                                <strong>Estimasi Omset (Deal)</strong>
                                Proyeksi nilai transaksi ter-closing pada landing page ini.<br>
                                <em>Rumus:</em> <code>Leads Deal * Rp 45.000.000</code> (asumsi rata-rata paket).
                            </span>
                            <i class="fas fa-info-circle"></i>
                        </span>
                    </th>
                    <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center; font-size: 0.8rem; white-space: nowrap;">
                        Klik Link
                        <span class="info-tooltip">
                            <i class="fas fa-info-circle"></i>
                            <span class="tooltip-text">
                                <strong>Klik Link</strong>
                                Jumlah audiens yang mengeklik tautan iklan menuju landing page.
                            </span>
                        </span>
                    </th>
                    <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center; font-size: 0.8rem; white-space: nowrap;">
                        WA Leads
                        <span class="info-tooltip">
                            <i class="fas fa-info-circle"></i>
                            <span class="tooltip-text">
                                <strong>WA Leads</strong>
                                Jumlah prospek pendaftar WhatsApp yang berhasil masuk ke CRM lokal.
                            </span>
                        </span>
                    </th>
                    <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center; font-size: 0.8rem; white-space: nowrap;">
                        CTR
                        <span class="info-tooltip">
                            <i class="fas fa-info-circle"></i>
                            <span class="tooltip-text">
                                <strong>Click-Through Rate (CTR)</strong>
                                Persentase rasio klik link iklan dibanding total impresi tayangan.
                            </span>
                        </span>
                    </th>
                    <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center; font-size: 0.8rem; white-space: nowrap;">
                        CVR
                        <span class="info-tooltip">
                            <i class="fas fa-info-circle"></i>
                            <span class="tooltip-text">
                                <strong>Conversion Rate (CVR)</strong>
                                Rasio konversi pendaftar WhatsApp dari total klik link iklan.<br>
                                <em>Target ideal:</em> 2% - 5%.
                            </span>
                        </span>
                    </th>
                    <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: right; font-size: 0.8rem; white-space: nowrap;">
                        CPC
                        <span class="info-tooltip">
                            <i class="fas fa-info-circle"></i>
                            <span class="tooltip-text">
                                <strong>Cost Per Click (CPC)</strong>
                                Biaya iklan rata-rata per satu klik tautan.<br>
                                <em>Rumus:</em> <code>Spent / Clicks</code>.
                            </span>
                        </span>
                    </th>
                    <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: right; font-size: 0.8rem; white-space: nowrap;">
                        CPL Aktual
                        <span class="info-tooltip">
                            <i class="fas fa-info-circle"></i>
                            <span class="tooltip-text" style="transform: translateX(-50%);">
                                <strong>Cost Per Lead (CPL)</strong>
                                Rata-rata biaya iklan untuk mendapatkan satu WhatsApp Lead.<br>
                                <em>Rumus:</em> <code>Spent / Leads</code>.
                            </span>
                        </span>
                    </th>
                    <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: right; font-size: 0.8rem; white-space: nowrap;">
                        CPA (Cost/Deal)
                        <span class="info-tooltip">
                            <i class="fas fa-info-circle"></i>
                            <span class="tooltip-text" style="transform: translateX(-75%);">
                                <strong>Cost Per Action / Deal (CPA)</strong>
                                Rata-rata biaya iklan untuk mengonversi satu pendaftar Deal.<br>
                                <em>Rumus:</em> <code>Spent / Deals</code>.
                            </span>
                        </span>
                    </th>
                    <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center; font-size: 0.8rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roiBreakdown as $row)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; font-weight: 800; color: #0f172a;">
                        {{ $row['title'] }}
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 700; color: #475569;">
                        Rp {{ number_format($row['spend'], 0, ',', '.') }}
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 800; color: #059669;">
                        Rp {{ number_format($row['omset'], 0, ',', '.') }}
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center; font-weight: 600; color: #3b82f6;">
                        {{ number_format($row['clicks'], 0, ',', '.') }}
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center; font-weight: 600; color: #059669;">
                        {{ number_format($row['leads'], 0, ',', '.') }}
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center; font-weight: bold; color: #0d9488;">
                        {{ number_format($row['ctr'], 2) }}%
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center; font-weight: bold; color: #a855f7;">
                        {{ number_format($row['cvr'], 2) }}%
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: bold; color: #1e40af;">
                        Rp {{ number_format($row['cpc'], 0, ',', '.') }}
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: right; vertical-align: middle;">
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 0.8rem; background-color: {{ $row['cpl'] > 50000 ? '#fee2e2' : '#d1fae5' }}; color: {{ $row['cpl'] > 50000 ? '#ef4444' : '#0d4c54' }};">
                            Rp {{ number_format($row['cpl'], 0, ',', '.') }}
                        </span>
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: bold; color: #b45309;">
                        Rp {{ number_format($row['cpa'], 0, ',', '.') }}
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                        <a href="{{ route('landing.page', $row['slug']) }}" target="_blank" class="btn-admin" style="padding: 5px 12px; font-size: 0.75rem;"><i class="fas fa-external-link-alt"></i> Buka Page</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

    <!-- Analisis Kinerja Kampanye Multichannel (Meta, Shopee, FB & IG Shop) -->
    <div class="admin-card" id="card-roi-retail" style="margin-top: 0; border-top: 4px solid #d97706; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow-x: auto; display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
            <div>
                <h3 style="margin: 0; font-size: 1.1rem; color: var(--brand-dark); display: flex; align-items: center; gap: 8px;"><i class="fas fa-shopping-bag" style="color: #d97706;"></i> Analisis Konversi Multichannel (Meta Ads -> Shopee & Shop Conversion)</h3>
                <p style="font-size: 0.8rem; color: #64748b; margin: 4px 0 0 0;">Laporan kinerja rasio kunjungan Meta Ads ke Shopee Store, Facebook Shop, & Instagram Shop.</p>
            </div>
            <span style="font-size: 0.72rem; background-color: #fef3c7; color: #d97706; padding: 4px 10px; border-radius: 20px; font-weight: bold; border: 1px solid #fde68a;">
                <i class="fas fa-check-circle"></i> Terhubung dengan Facebook Pixel & Shopee Affiliate API
            </span>
        </div>

        <div class="table-responsive">
        <table style="width: 100%; border-collapse: separate; border-spacing: 0; font-size: 0.85rem;">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: left; font-size: 0.78rem;">Nama Iklan / Kampanye</th>
                    <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: right; font-size: 0.78rem;">Ad Spend (Biaya)</th>
                    <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: right; font-size: 0.78rem; color: #059669;">Komisi</th>
                    <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center; font-size: 0.78rem; color: #1e40af; background-color: rgba(59, 130, 246, 0.03);">Klik Meta</th>
                    <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center; font-size: 0.78rem; color: #ea580c; background-color: rgba(234, 88, 12, 0.03);">Klik Shopee</th>
                    <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center; font-size: 0.78rem; color: #ffffff; background-color: #15803d;">Klik Masuk %</th>
                    <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center; font-size: 0.78rem; color: #1e40af;">Klik Shop FB</th>
                    <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center; font-size: 0.78rem; color: #db2777;">Klik Shop IG</th>
                    <th style="padding: 12px 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center; font-size: 0.78rem; color: #475569;">Klik Shop Others</th>
                </tr>
            </thead>
            <tbody>
                @foreach($multichannelBreakdown as $row)
                @php
                    $klikMasuk = $row['clicks_meta'] > 0 ? (($row['clicks_shopee'] / $row['clicks_meta']) * 100) : 0;
                @endphp
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; font-weight: 600; color: #0f172a; font-family: monospace; font-size: 0.8rem;">
                        {{ $row['ad_name'] }}
                    </td>
                    <td style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 700; color: #334155;">
                        Rp {{ number_format($row['spend'], 0, ',', '.') }}
                    </td>
                    <td style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 800; color: #059669;">
                        Rp {{ number_format($row['commission'], 2, ',', '.') }}
                    </td>
                    <td style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; text-align: center; font-weight: 600; color: #1e40af; background-color: rgba(59, 130, 246, 0.02);">
                        {{ number_format($row['clicks_meta'], 0, ',', '.') }}
                    </td>
                    <td style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; text-align: center; font-weight: 600; color: #ea580c; background-color: rgba(234, 88, 12, 0.02);">
                        {{ number_format($row['clicks_shopee'], 0, ',', '.') }}
                    </td>
                    <td style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; text-align: center; font-weight: bold; color: #15803d; background-color: rgba(21, 128, 61, 0.07);">
                        {{ number_format($klikMasuk, 0) }}%
                    </td>
                    <td style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; text-align: center; color: #475569; font-weight: 600;">
                        {{ $row['clicks_shop_fb'] }}%
                    </td>
                    <td style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; text-align: center; color: #db2777; font-weight: 600;">
                        {{ $row['clicks_shop_ig'] }}%
                    </td>
                    <td style="padding: 12px 10px; border-bottom: 1px solid #f1f5f9; text-align: center; color: #475569; font-weight: 600;">
                        {{ $row['clicks_shop_others'] }}%
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
