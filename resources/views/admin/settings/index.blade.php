@extends('admin.layouts.app')

@section('title', 'Website Settings')
@section('page_title', 'Global Website Branding & Payment Settings')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid-2">
            <div>
                <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-palette"></i> Branding</h3>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Site Name</label>
                    <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Website Logo</label>
                    <input type="file" name="logo" class="form-control">
                    @if(isset($settings['logo']))
                        <div style="margin-top: 1rem; background: #eee; padding: 1rem; border-radius: 8px;">
                            <img src="{{ asset($settings['logo']) }}" style="height: 50px; width: auto;">
                        </div>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Favicon</label>
                    <input type="file" name="favicon" class="form-control">
                    @if(isset($settings['favicon']))
                        <div style="margin-top: 1rem; background: #eee; padding: 1rem; border-radius: 8px;">
                            <img src="{{ asset($settings['favicon']) }}" style="height: 30px; width: auto;">
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-certificate"></i> Dokumen Perizinan PPIU (Kemenag)</h3>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Nomor Izin PPIU</label>
                    <input type="text" name="ppiu_number" class="form-control" value="{{ $settings['ppiu_number'] ?? '' }}" placeholder="Contoh: No. 123 Tahun 2024">
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">URL Scan Bukti / Link Siskopatuh Kemenag</label>
                    <input type="text" name="ppiu_url" class="form-control" value="{{ $settings['ppiu_url'] ?? '' }}" placeholder="https://simpu.kemenag.go.id/...">
                </div>
            </div>
        </div>

        <div style="margin-top: 2.5rem; border-top: 1px solid #eee; padding-top: 2rem;">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-credit-card"></i> Payment Gateway (Midtrans)</h3>
            <div class="grid-2">
                <div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Midtrans Merchant ID</label>
                        <input type="text" name="midtrans_merchant_id" class="form-control" value="{{ $settings['midtrans_merchant_id'] ?? '' }}" placeholder="Contoh: M123456">
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Midtrans Client Key</label>
                        <input type="text" name="midtrans_client_key" class="form-control" value="{{ $settings['midtrans_client_key'] ?? '' }}" placeholder="SB-Mid-client-...">
                    </div>
                </div>
                <div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Midtrans Server Key</label>
                        <input type="text" name="midtrans_server_key" class="form-control" value="{{ $settings['midtrans_server_key'] ?? '' }}" placeholder="SB-Mid-server-...">
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Environment Mode</label>
                        <select name="midtrans_environment" class="form-control">
                            <option value="sandbox" {{ ($settings['midtrans_environment'] ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox (Mode Testing / Uji Coba)</option>
                            <option value="production" {{ ($settings['midtrans_environment'] ?? 'sandbox') == 'production' ? 'selected' : '' }}>Production (Mode Live / Riil)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn-admin" style="padding: 10px 24px; font-weight: 600; border-radius: 6px;"><i class="fas fa-save"></i> Save Website Settings</button>
        </div>
    </form>
</div>
@endsection
