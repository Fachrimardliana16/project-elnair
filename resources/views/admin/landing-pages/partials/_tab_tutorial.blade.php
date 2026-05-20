<!-- ==========================================
     TAB 5: API TUTORIAL & GUIDES (NEW!)
     ========================================== -->
<div id="tab-tutorial" class="tab-content">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
        <!-- Meta Ads Guide -->
        <div class="admin-card" style="border-top: 4px solid #1877f2; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="color: #1877f2; margin-top: 0; display: flex; align-items: center; gap: 8px;"><i class="fab fa-facebook"></i> Meta (Facebook & Instagram)</h3>
                <p style="font-size: 0.8rem; color: #64748b; line-height: 1.4; margin-bottom: 1.5rem;">Bagaimana cara mendapatkan <strong>Ad Account ID</strong> dan <strong>Access Token</strong> untuk Meta Ads:</p>
                
                <ol style="padding-left: 1.2rem; font-size: 0.85rem; color: #334155; line-height: 1.6;">
                    <li style="margin-bottom: 8px;">Buka dashboard periklanan Anda di Meta Ads Manager. Copy <strong>Ad Account ID</strong> di URL browser Anda (biasanya berformat angka dengan awalan <code>act_xxxxxxxxxxxx</code>).</li>
                    <li style="margin-bottom: 8px;">Kunjungi <a href="https://developers.facebook.com" target="_blank" style="color: #1877f2; font-weight: bold; text-decoration: underline;">developers.facebook.com</a>, buat akun developer, dan buat aplikasi bertipe <strong>Business</strong>.</li>
                    <li style="margin-bottom: 8px;">Tambahkan produk <strong>Marketing API</strong> di menu kiri aplikasi developer Anda.</li>
                    <li style="margin-bottom: 8px;">Masuk ke <strong>Tools -> Graph API Explorer</strong>. Pilih aplikasi Anda, tambahkan izin (permission) <code>ads_read</code>, lalu klik <strong>Generate Access Token</strong>.</li>
                    <li style="margin-bottom: 8px;">Untuk mendapatkan token abadi, tukarkan token explorer Anda dengan <strong>Long-Lived Access Token</strong> (60 Hari) melalui panel Access Token Tool, atau buatlah <em>System User</em> permanen di Meta Business Manager Anda.</li>
                </ol>
            </div>
            <div style="background-color: #f0f7ff; padding: 10px; border-radius: 8px; border: 1px solid #bfdbfe; font-size: 0.75rem; color: #1e3a8a; margin-top: 1rem;">
                <i class="fas fa-lightbulb"></i> <strong>Penting:</strong> Pastikan akun iklan Meta yang dihubungkan sudah berstatus aktif dan terhubung ke Business Manager yang memegang hak akses halaman terkait.
            </div>
        </div>

        <!-- TikTok Ads Guide -->
        <div class="admin-card" style="border-top: 4px solid #000000; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="color: #000000; margin-top: 0; display: flex; align-items: center; gap: 8px;"><i class="fab fa-tiktok"></i> TikTok Ads Manager</h3>
                <p style="font-size: 0.8rem; color: #64748b; line-height: 1.4; margin-bottom: 1.5rem;">Panduan mendapatkan kredensial spent otomatis dari TikTok Ads:</p>
                
                <ol style="padding-left: 1.2rem; font-size: 0.85rem; color: #334155; line-height: 1.6;">
                    <li style="margin-bottom: 8px;">Buka dashboard <a href="https://ads.tiktok.com" target="_blank" style="color: #000000; font-weight: bold; text-decoration: underline;">ads.tiktok.com</a> Anda.</li>
                    <li style="margin-bottom: 8px;">Klik ikon profil Anda di bagian kanan-atas layar Ads Manager. Salin <strong>Advertiser ID</strong> (10-15 digit angka). Ini adalah <strong>Ad Account ID</strong> Anda!</li>
                    <li style="margin-bottom: 8px;">Kunjungi <strong>TikTok for Business Developer</strong> (business-api.tiktok.com) dan buat developer app untuk mendapatkan Long-Lived Access Token.</li>
                    <li style="margin-bottom: 8px;">Atau, Anda dapat masuk ke bagian <strong>Business Center -> Settings -> Developer Platform</strong> di dalam akun bisnis TikTok Anda untuk men-generate token integrasi secara instan.</li>
                </ol>
            </div>
            <div style="background-color: #f1f5f9; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.75rem; color: #0f172a; margin-top: 1rem;">
                <i class="fas fa-key"></i> <strong>Rekomendasi:</strong> TikTok Developer API sangat aman dan stabil jika ditarik setiap hari menggunakan server scheduler kita!
            </div>
        </div>

        <!-- Google Ads Guide -->
        <div class="admin-card" style="border-top: 4px solid #ea4335; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="color: #ea4335; margin-top: 0; display: flex; align-items: center; gap: 8px;"><i class="fab fa-google"></i> Google Ads</h3>
                <p style="font-size: 0.8rem; color: #64748b; line-height: 1.4; margin-bottom: 1.5rem;">Cara menghubungkan spent kampanye dari Google Ads:</p>
                
                <ol style="padding-left: 1.2rem; font-size: 0.85rem; color: #334155; line-height: 1.6;">
                    <li style="margin-bottom: 8px;">Login ke akun <a href="https://ads.google.com" target="_blank" style="color: #ea4335; font-weight: bold; text-decoration: underline;">ads.google.com</a>.</li>
                    <li style="margin-bottom: 8px;">Salin 10 digit angka <strong>Customer ID</strong> Anda di pojok kanan-atas layar (contoh: <code>123-456-7890</code>). Ini adalah <strong>Ad Account ID</strong> Anda di sistem.</li>
                    <li style="margin-bottom: 8px;">Gunakan akun Google Manager Anda untuk masuk ke menu <strong>Tools & Settings -> API Center</strong> untuk memohon <strong>Developer Token</strong>.</li>
                    <li style="margin-bottom: 8px;">Buat project baru di Google Cloud Console, aktifkan <em>Google Ads API</em>, lalu generate OAuth credentials (Client ID & Client Secret) untuk memperoleh <strong>Refresh / Access Token</strong> permanen.</li>
                </ol>
            </div>
            <div style="background-color: #fef2f2; padding: 10px; border-radius: 8px; border: 1px solid #fecaca; font-size: 0.75rem; color: #991b1b; margin-top: 1rem;">
                <i class="fas fa-shield-alt"></i> <strong>Google Ads API:</strong> Memerlukan verifikasi developer token awal, disarankan berkoordinasi dengan tim teknis saat pendaftaran pertama.
            </div>
        </div>

        <!-- Snack Video Ads Guide -->
        <div class="admin-card" style="border-top: 4px solid #f95c02; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="color: #f95c02; margin-top: 0; display: flex; align-items: center; gap: 8px;"><i class="fas fa-video"></i> Snack Video Ads</h3>
                <p style="font-size: 0.8rem; color: #64748b; line-height: 1.4; margin-bottom: 1.5rem;">Langkah mengambil Advertiser ID dan token Snack Video Ads:</p>
                
                <ol style="padding-left: 1.2rem; font-size: 0.85rem; color: #334155; line-height: 1.6;">
                    <li style="margin-bottom: 8px;">Login ke dashboard <strong>Snack Video Ads Manager</strong> Anda.</li>
                    <li style="margin-bottom: 8px;">Salin <strong>Advertiser ID</strong> di kanan atas dashboard Anda. Tempelkan ke kolom <strong>Ad Account ID</strong>.</li>
                    <li style="margin-bottom: 8px;">Buka Developer platform Snack Video untuk mendaftarkan aplikasi periklanan, atau salin Access Token integrasi instan yang disediakan oleh representatif/agency Snack Video Anda.</li>
                </ol>
            </div>
            <div style="background-color: #fff7ed; padding: 10px; border-radius: 8px; border: 1px solid #ffedd5; font-size: 0.75rem; color: #c2410c; margin-top: 1rem;">
                <i class="fas fa-magic"></i> <strong>Saran Praktis:</strong> Jika dijalankan lewat endorse manual / non-API agency, Anda juga bisa mencatatnya dengan sangat praktis di <strong>Tab 4: Input spent Manual</strong>!
            </div>
        </div>

        <!-- X Ads Guide -->
        <div class="admin-card" style="border-top: 4px solid #0f1419; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="color: #0f1419; margin-top: 0; display: flex; align-items: center; gap: 8px;"><i class="fab fa-twitter"></i> X Ads (Twitter)</h3>
                <p style="font-size: 0.8rem; color: #64748b; line-height: 1.4; margin-bottom: 1.5rem;">Cara menghubungkan spent dan kampanye dari X Ads:</p>
                
                <ol style="padding-left: 1.2rem; font-size: 0.85rem; color: #334155; line-height: 1.6;">
                    <li style="margin-bottom: 8px;">Masuk ke dashboard <strong>ads.x.com</strong> Anda.</li>
                    <li style="margin-bottom: 8px;">Salin Account ID dari URL browser Ads Manager Anda dan masukkan ke kolom <strong>Ad Account ID</strong>.</li>
                    <li style="margin-bottom: 8px;">Kunjungi <strong>developer.x.com</strong>, daftar akun Developer, dan buat aplikasi berizin <code>ads.read</code> untuk memperoleh <strong>Bearer / Access Token</strong>.</li>
                </ol>
            </div>
            <div style="background-color: #f8fafc; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.75rem; color: #475569; margin-top: 1rem;">
                <i class="fas fa-lock"></i> <strong>Akses Keamanan:</strong> Menghubungkan API X Ads memerlukan verifikasi Developer App tingkat dasar di platform X.
            </div>
        </div>
    </div>

    <!-- API Parameter Mapping & JSON Schema Reference (NEW!) -->
    <div class="admin-card" style="margin-top: 2rem; border-top: 4px solid #0d4c54; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h3 style="color: var(--brand-dark); margin-top: 0; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;"><i class="fas fa-file-code"></i> Pemetaan Parameter & Data Rujukan API (Skema JSON)</h3>
        <p style="font-size: 0.82rem; color: #64748b; margin-bottom: 1.5rem; line-height: 1.5;">Untuk memandu tim developer Anda, berikut adalah struktur muatan data (payload) API periklanan riil yang diekstraksi secara terjadwal oleh server Elnair untuk memetakan pengeluaran kampanye ke dalam dashboard:</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
            <!-- Meta Ads API mapping -->
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px; grid-column: span 2;">
                <h4 style="margin-top: 0; color: #1877f2; font-size: 0.95rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                    <span><i class="fab fa-facebook"></i> Pemetaan Parameter Meta Ads Manager (Akurat 100% Sesuai Preset Iklan)</span>
                    <span style="font-family: monospace; font-size: 0.7rem; background-color: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 4px;">Graph API v19.0</span>
                </h4>
                <p style="font-size: 0.8rem; color: #475569; margin: 8px 0 12px 0; line-height: 1.4;">
                    Berikut adalah kecocokan pemetaan parameter antara kolom <strong>Meta Ads Manager</strong>, node <strong>Meta Graph API</strong>, dan field <strong>Database CRM Elnair</strong>:
                </p>
                
                <table style="width: 100%; border-collapse: collapse; font-size: 0.75rem; margin-bottom: 1rem; text-align: left;">
                    <thead>
                        <tr style="background-color: #cbd5e1; color: #1e293b;">
                            <th style="padding: 6px 10px; border: 1px solid #cbd5e1;">Kolom Meta Ads Manager</th>
                            <th style="padding: 6px 10px; border: 1px solid #cbd5e1;">Field API Request Meta</th>
                            <th style="padding: 6px 10px; border: 1px solid #cbd5e1;">Tipe Kembalian JSON</th>
                            <th style="padding: 6px 10px; border: 1px solid #cbd5e1;">Mapping DB Elnair</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-weight: bold;">Jumlah yang dibelanjakan (Spent)</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; color: #2563eb;">spend</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0;">String (float)</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; font-weight: bold; color: #059669;">ad_spend</td>
                        </tr>
                        <tr style="background-color: #f8fafc;">
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-weight: bold;">Penayangan / Impresi</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; color: #2563eb;">impressions</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0;">String (int)</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; font-weight: bold; color: #059669;">impressions</td>
                        </tr>
                        <tr>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-weight: bold;">Klik (Semua)</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; color: #2563eb;">clicks</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0;">String (int)</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; font-weight: bold; color: #059669;">clicks</td>
                        </tr>
                        <tr style="background-color: #f8fafc;">
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-weight: bold;">Klik Outbound (Rasio Tautan)</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; color: #2563eb;">outbound_clicks</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0;">Array of Objects</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; color: #64748b;">(Evaluasi CTR)</td>
                        </tr>
                        <tr>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-weight: bold;">Tayangan Halaman Tujuan</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; color: #2563eb;">actions: [ "action_type": "landing_page_view" ]</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0;">Array of Objects</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; color: #64748b;">(Filter LP Views)</td>
                        </tr>
                        <tr style="background-color: #f8fafc;">
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-weight: bold;">Pembelian / Purchase (Shopee/Web)</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; color: #2563eb;">actions: [ "action_type": "offsite_conversion.fb_pixel_purchase" ]</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0;">Array of Objects</td>
                            <td style="padding: 6px 10px; border: 1px solid #e2e8f0; font-family: monospace; color: #64748b;">(Closing Deal CVR)</td>
                        </tr>
                    </tbody>
                </table>

                <p style="font-size: 0.75rem; color: #475569; margin: 10px 0 5px 0;"><strong>Endpoint Target Request Data Kampanye Harian:</strong></p>
                <code style="background-color: #cbd5e1; color: #0f172a; padding: 4px 8px; border-radius: 4px; font-size: 0.72rem; font-family: monospace; display: block; margin-bottom: 10px; word-break: break-all;">GET https://graph.facebook.com/v19.0/act_{ad_account_id}/insights?fields=spend,impressions,clicks,outbound_clicks,actions&time_increment=1&access_token={token}</code>

                <p style="font-size: 0.75rem; color: #475569; margin: 10px 0 5px 0;"><strong>Contoh Struktur Payload JSON Meta API Nyata (100% Akurat):</strong></p>
                <pre style="background-color: #0f172a; color: #38bdf8; padding: 10px; border-radius: 6px; font-size: 0.72rem; overflow-x: auto; margin: 0; font-family: monospace;">{
  "data": [
    {
      "spend": "683697.00",
      "impressions": "284000",
      "clicks": "6143",
      "outbound_clicks": [
        { "action_type": "outbound_click", "value": "4210" }
      ],
      "actions": [
        { "action_type": "landing_page_view", "value": "3950" },
        { "action_type": "offsite_conversion.fb_pixel_purchase", "value": "14" }
      ],
      "date_start": "2026-05-18",
      "date_stop": "2026-05-18"
    }
  ]
}</pre>
            </div>

            <!-- TikTok Ads API mapping -->
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px;">
                <h4 style="margin-top: 0; color: #000000; font-size: 0.9rem; display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fab fa-tiktok"></i> TIKTOK ADS API Reference</span>
                    <span style="font-family: monospace; font-size: 0.7rem; background-color: #f1f5f9; color: #0f172a; padding: 2px 6px; border-radius: 4px;">POST reports/integrated/get</span>
                </h4>
                <p style="font-size: 0.75rem; color: #475569; margin: 5px 0 10px 0;"><strong>Endpoint Target:</strong> <code>business_api/v1.3/reporting/integrated/get/</code></p>
                <pre style="background-color: #0f172a; color: #38bdf8; padding: 10px; border-radius: 6px; font-size: 0.72rem; overflow-x: auto; margin: 0; font-family: monospace;">{
  "code": 0,
  "message": "OK",
  "data": {
    "list": [
      {
        "metrics": {
          "spend": "980000.00",     // -> ad_spend
          "impressions": "62100",   // -> impressions
          "clicks": "740"           // -> clicks
        },
        "dimensions": {
          "stat_time_day": "2026-05-18"
        }
      }
    ]
  }
}</pre>
            </div>

            <!-- Google Ads API mapping -->
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px;">
                <h4 style="margin-top: 0; color: #ea4335; font-size: 0.9rem; display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fab fa-google"></i> GOOGLE ADS API Reference</span>
                    <span style="font-family: monospace; font-size: 0.7rem; background-color: #fef2f2; color: #991b1b; padding: 2px 6px; border-radius: 4px;">POST googleads.Search</span>
                </h4>
                <p style="font-size: 0.75rem; color: #475569; margin: 5px 0 10px 0;"><strong>Query GAQL:</strong> <code>SELECT metrics.cost_micros, metrics.impressions, metrics.clicks FROM campaign WHERE segments.date = '2026-05-18'</code></p>
                <pre style="background-color: #0f172a; color: #38bdf8; padding: 10px; border-radius: 6px; font-size: 0.72rem; overflow-x: auto; margin: 0; font-family: monospace;">{
  "results": [
    {
      "campaign": {
        "resourceName": "customers/123/campaigns/456"
      },
      "metrics": {
        "costMicros": "1500000000", // micros (div 1M) -> 1,500,000 ad_spend
        "impressions": "94200",     // -> impressions
        "clicks": "1080"            // -> clicks
      }
    }
  ]
}</pre>
            </div>

            <!-- Snack Video & X Ads API mapping -->
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px;">
                <h4 style="margin-top: 0; color: #f95c02; font-size: 0.9rem; display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fas fa-network-wired"></i> SNACK VIDEO & X ADS</span>
                    <span style="font-family: monospace; font-size: 0.7rem; background-color: #fff7ed; color: #c2410c; padding: 2px 6px; border-radius: 4px;">REST API GET</span>
                </h4>
                <p style="font-size: 0.75rem; color: #475569; margin: 5px 0 10px 0;">Data parameter universal yang disinkronkan oleh konektor API:</p>
                <ul style="padding-left: 1rem; font-size: 0.75rem; color: #334155; line-height: 1.6; margin: 0 0 10px 0;">
                    <li><strong>Snack Video:</strong> <code>charge_cost</code> (biaya spent), <code>show_count</code> (impresi), <code>click_count</code> (klik link).</li>
                    <li><strong>X Ads (Twitter):</strong> <code>billed_charge_local_micro</code> (spent micros), <code>impressions</code> (impresi), <code>clicks</code> (klik).</li>
                </ul>
                <div style="background-color: #fffbeb; border: 1px solid #fef3c7; padding: 8px; border-radius: 6px; font-size: 0.7rem; color: #92400e; line-height: 1.4;">
                    <i class="fas fa-info-circle"></i> <strong>Sinkronisasi:</strong> Semua platform API menyalurkan data spent ke database lokal pada tabel <code>daily_ad_reports</code> dengan flag <code>is_manual = false</code> untuk kalkulasi ROAS/CAC otomatis.
                </div>
            </div>
        </div>
    </div>
</div>
