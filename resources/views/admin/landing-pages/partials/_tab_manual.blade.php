<!-- ==========================================
     TAB 4: MANUAL SPEND ENTRY
     ========================================== -->
<div id="tab-manual" class="tab-content">
    <div class="admin-card" style="max-width: 600px; margin: 0 auto;">
        <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-pencil-alt"></i> Input Biaya Iklan Manual (Endorse / Iklan Cetak / Offline)</h3>
        <form action="{{ route('admin.landing-pages.leads.store-manual-spend') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label style="font-weight: 600;">Landing Page Tertarget</label>
                <select name="landing_page_id" class="form-control" required>
                    <option value="">-- Pilih Landing Page --</option>
                    @foreach($landingPages as $p)
                        <option value="{{ $p->id }}">{{ $p->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600;">Tanggal Biaya Dikeluarkan</label>
                <input type="date" name="report_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
            </div>
            <div class="form-group mb-3">
                <label style="font-weight: 600;">Nominal Pengeluaran (Spent Rp)</label>
                <input type="number" name="ad_spend" class="form-control" placeholder="Contoh: 500000" min="0" required>
            </div>
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label style="font-weight: 600;">Total Tayangan / Impressions (Opsional)</label>
                    <input type="number" name="impressions" class="form-control" placeholder="Contoh: 10000" min="0">
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label style="font-weight: 600;">Total Klik Iklan / Clicks (Opsional)</label>
                    <input type="number" name="clicks" class="form-control" placeholder="Contoh: 250" min="0">
                </div>
            </div>
            <div style="text-align: right; margin-top: 1.5rem;">
                <button type="submit" class="btn-admin" style="padding: 10px 24px;"><i class="fas fa-save"></i> Simpan Pengeluaran</button>
            </div>
        </form>
    </div>

    <!-- Log Riwayat Transaksi Manual (NEW!) -->
    <div class="admin-card" style="margin-top: 2rem; max-width: 800px; margin-left: auto; margin-right: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <h3 style="margin-top: 0; margin-bottom: 1.25rem; font-size: 1.05rem; color: var(--brand-dark);"><i class="fas fa-history"></i> Riwayat Input Biaya Manual (5 Terakhir)</h3>
        
        @if($recentManualSpends->isEmpty())
            <p style="text-align: center; color: #64748b; font-size: 0.85rem; padding: 2.5rem 0; margin: 0; border: 2px dashed #cbd5e1; border-radius: 8px; background-color: #f8fafc;">Belum ada input pengeluaran manual untuk periode ini.</p>
        @else
            <div class="table-responsive">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0; font-size: 0.85rem;">
                <thead>
                    <tr style="background-color: #f8fafc;">
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: left;">Tanggal</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: left;">Landing Page</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: right;">Spent (Biaya)</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center;">Impressions</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center;">Clicks</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: bold; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentManualSpends as $log)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; font-weight: 600; color: #0f172a; vertical-align: middle;">
                            {{ \Carbon\Carbon::parse($log->report_date)->format('d M Y') }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; color: #475569; vertical-align: middle;">
                            {{ $log->landingPage ? $log->landingPage->title : 'N/A' }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 700; color: #0d4c54; vertical-align: middle;">
                            Rp {{ number_format($log->ad_spend, 0, ',', '.') }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; text-align: center; color: #64748b; vertical-align: middle;">
                            {{ number_format($log->impressions, 0, ',', '.') }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; text-align: center; color: #64748b; vertical-align: middle;">
                            {{ number_format($log->clicks, 0, ',', '.') }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; text-align: center; vertical-align: middle;">
                            <form action="{{ route('admin.landing-pages.leads.destroy-manual-spend', $log->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan biaya manual ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 4px; font-size: 0.85rem;" title="Hapus Riwayat">
                                    <i class="fas fa-trash-alt"></i>
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
