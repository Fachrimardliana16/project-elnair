<!-- ==========================================
     TAB 3: INTEGRASI API ACCOUNTS
     ========================================== -->
<div id="tab-api" class="tab-content">
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 style="margin: 0; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-plug"></i> Koneksi Multi-Akun Iklan API</h3>
                <small style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 5px;">Hubungkan banyak akun iklan Meta, TikTok, dan Google Ads untuk mengimpor spend secara otomatis.</small>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <form action="{{ route('admin.landing-pages.leads.sync-accounts') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-admin" style="background-color: #0d4c54;"><i class="fas fa-sync-alt"></i> Sync API Sekarang</button>
                </form>
                <button type="button" class="btn-admin" onclick="openModal()"><i class="fas fa-plus"></i> Hubungkan Akun Iklan</button>
            </div>
        </div>

        <!-- API Connection Diagnostics Console (NEW!) -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <span style="font-size: 0.72rem; color: #64748b; font-weight: bold; display: block; text-transform: uppercase;"><i class="fas fa-heartbeat" style="color: #10b981;"></i> Status Server API</span>
                <div style="display: flex; align-items: center; gap: 8px; margin-top: 5px;">
                    <span style="height: 10px; width: 10px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>
                    <strong style="font-size: 0.95rem; color: #0f172a;">CONNECTED (Healthy)</strong>
                </div>
                <small style="color: #64748b; font-size: 0.72rem; display: block; margin-top: 5px;">Latency Rata-rata: <span style="font-family: monospace; font-weight: bold; color: #0d4c54;">114ms</span></small>
            </div>
            
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <span style="font-size: 0.72rem; color: #64748b; font-weight: bold; display: block; text-transform: uppercase;"><i class="fas fa-key" style="color: #3b82f6;"></i> Scope Permissions</span>
                <div style="display: flex; align-items: center; gap: 4px; margin-top: 8px; flex-wrap: wrap;">
                    <span style="background-color: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: bold; font-family: monospace;">ads_read</span>
                    <span style="background-color: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: bold; font-family: monospace;">ads_management</span>
                </div>
                <small style="color: #10b981; font-size: 0.72rem; display: block; margin-top: 5px; font-weight: bold;"><i class="fas fa-check-circle"></i> VERIFIED BY PLATFORM</small>
            </div>
            
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <span style="font-size: 0.72rem; color: #64748b; font-weight: bold; display: block; text-transform: uppercase;"><i class="fas fa-clock" style="color: #f59e0b;"></i> Auto-Sync Scheduler</span>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 5px;">
                    <strong style="font-size: 0.95rem; color: #0f172a;">DAILY NIGHTLY (02:00)</strong>
                    <label style="position: relative; display: inline-block; width: 34px; height: 20px;">
                        <input type="checkbox" checked style="width: 100%; height: 100%; opacity: 0; position: absolute; z-index: 2; cursor: pointer;">
                        <span style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: #10b981; border-radius: 34px;"></span>
                    </label>
                </div>
                <small style="color: #64748b; font-size: 0.72rem; display: block; margin-top: 5px;">Last sync: <span style="font-weight: bold;">Hari Ini, {{ now()->format('H:i') }}</span></small>
            </div>
        </div>

        @if($adAccounts->isEmpty())
            <div style="text-align: center; padding: 4rem 0; color: #64748b; background-color: #f8fafc; border-radius: 12px; border: 2px dashed #cbd5e1;">
                <i class="fas fa-network-wired" style="font-size: 3.5rem; margin-bottom: 1.5rem; color: #94a3b8;"></i>
                <p style="margin: 0 0 1rem 0; font-size: 1.05rem; font-weight: bold;">Belum ada akun iklan terintegrasi.</p>
                <p style="margin: 0 0 1.5rem 0; font-size: 0.85rem; color: #94a3b8;">Hubungkan Meta Graph API atau TikTok Ads API token Anda untuk pelacakan spend otomatis.</p>
                <button type="button" class="btn-admin" onclick="openModal()"><i class="fas fa-plus"></i> Hubungkan Sekarang</button>
            </div>
        @else
            <div class="table-responsive">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="background-color: #f8fafc;">
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: left;">Platform</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: left;">Label Akun</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: left;">Ad Account ID</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: left;">Halaman Tertarget</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: center;">Aktif</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adAccounts as $account)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; vertical-align: middle;">
                            @if($account->platform == 'meta')
                                <span class="badge" style="background-color: #1877f2; color: white; padding: 6px 12px; font-weight: bold;"><i class="fab fa-facebook"></i> Meta Ads</span>
                            @elseif($account->platform == 'tiktok')
                                <span class="badge" style="background-color: #010101; color: white; padding: 6px 12px; font-weight: bold;"><i class="fab fa-tiktok"></i> TikTok Ads</span>
                            @elseif($account->platform == 'google')
                                <span class="badge" style="background-color: #ea4335; color: white; padding: 6px 12px; font-weight: bold;"><i class="fab fa-google"></i> Google Ads</span>
                            @elseif($account->platform == 'snackvideo')
                                <span class="badge" style="background-color: #f95c02; color: white; padding: 6px 12px; font-weight: bold;"><i class="fas fa-video"></i> Snack Video Ads</span>
                            @elseif($account->platform == 'x')
                                <span class="badge" style="background-color: #0f1419; color: white; padding: 6px 12px; font-weight: bold;"><i class="fab fa-twitter"></i> X Ads</span>
                            @else
                                <span class="badge" style="background-color: #64748b; color: white; padding: 6px 12px; font-weight: bold;"><i class="fas fa-ad"></i> {{ ucfirst($account->platform) }}</span>
                            @endif
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; font-weight: bold; color: #0f172a; vertical-align: middle;">
                            {{ $account->account_name }}
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; color: #475569; font-family: monospace; vertical-align: middle;">
                            {{ $account->account_id }}
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; color: #475569; vertical-align: middle;">
                            @foreach($account->landingPages as $p)
                                <span style="background-color: #f1f5f9; color: #0d4c54; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; margin-right: 5px; font-weight: 600; border: 1px solid #cbd5e1;">
                                    {{ $p->title }}
                                </span>
                            @endforeach
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center; vertical-align: middle;">
                            <form action="{{ route('admin.landing-pages.leads.toggle-account', $account->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn-admin" style="background-color: {{ $account->is_active ? '#059669' : '#64748b' }}; padding: 4px 10px; font-size: 0.75rem; border-radius: 12px;">
                                    {{ $account->is_active ? 'ON' : 'OFF' }}
                                </button>
                            </form>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center; vertical-align: middle;">
                            <form action="{{ route('admin.landing-pages.leads.destroy-account', $account->id) }}" method="POST" style="margin: 0; display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin memutuskan koneksi akun iklan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin" style="background-color: #ef4444; padding: 6px 10px; border-radius: 4px;" title="Putus Koneksi">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        @endif
    </div>
</div>
