<!-- ==========================================
     MODAL CONNECT AD ACCOUNT POP-UP (TAB 3)
     ========================================== -->
<div id="connectAccountModal" class="modal-backdrop" onclick="closeModalOnBackdrop(event)">
    <div class="modal-card">
        <div class="modal-header">
            <h3 style="margin: 0; font-size: 1.1rem; color: #0d4c54; font-weight: bold;"><i class="fas fa-network-wired"></i> Hubungkan Akun Iklan Baru</h3>
            <button type="button" onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>
        <form action="{{ route('admin.landing-pages.leads.store-account') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label style="font-weight: 600; display: block; margin-bottom: 5px;">Platform Periklanan</label>
                    <select name="platform" class="form-control" required>
                        <option value="meta">Meta Ads (Facebook & Instagram)</option>
                        <option value="tiktok">TikTok Ads Manager</option>
                        <option value="google">Google Ads (YouTube & Search)</option>
                        <option value="snackvideo">Snack Video Ads</option>
                        <option value="x">X Ads (Twitter)</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600; display: block; margin-bottom: 5px;">Label / Nama Akun Iklan</label>
                    <input type="text" name="account_name" class="form-control" placeholder="Contoh: Meta Iklan Haji Utama" required>
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600; display: block; margin-bottom: 5px;">Ad Account ID</label>
                    <input type="text" name="account_id" class="form-control" placeholder="Meta: act_1234567890 | TikTok: 7123456789" required>
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600; display: block; margin-bottom: 5px;">API Access Token (Long-Lived)</label>
                    <textarea name="access_token" class="form-control" rows="3" placeholder="Tempel token integrasi / developers di sini..." required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600; display: block; margin-bottom: 5px;">Kaitkan ke Landing Page Kampanye</label>
                    <div style="max-height: 150px; overflow-y: auto; border: 1px solid #cbd5e1; padding: 10px; border-radius: 6px; background-color: #f8fafc;">
                        @foreach($landingPages as $p)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="landing_page_ids[]" value="{{ $p->id }}" id="page_chk_{{ $p->id }}" checked>
                                <label class="form-check-label" for="page_chk_{{ $p->id }}" style="font-size: 0.85rem; font-weight: 500;">
                                    {{ $p->title }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <small style="color: #64748b; font-size: 0.72rem; display: block; margin-top: 5px;"><i class="fas fa-info-circle"></i> spent biaya dari akun iklan ini akan dialokasikan ke landing page terpilih.</small>
                </div>
            </div>
            <div style="padding: 1.25rem 1.5rem; border-top: 1px solid #e2e8f0; text-align: right; background-color: #f8fafc;">
                <button type="button" class="btn-admin" style="background-color: #64748b;" onclick="closeModal()">Batalkan</button>
                <button type="submit" class="btn-admin"><i class="fas fa-plug"></i> Hubungkan Akun</button>
            </div>
        </form>
    </div>
</div>
