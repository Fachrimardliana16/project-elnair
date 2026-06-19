<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    // ==========================================
    // 1. WEBSITE SETTINGS (Super Admin Only)
    // ==========================================
    public function index()
    {
        if (! auth()->user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized action. Only Super Admin can access Website Settings.');
        }

        $settings = SiteSetting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (! auth()->user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->only([
            'site_name',
            'ppiu_number',
            'ppiu_url',
            'midtrans_merchant_id',
            'midtrans_client_key',
            'midtrans_server_key',
            'midtrans_environment',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = ImageHelper::uploadAndConvert($request->file('logo'), 'assets/img');
        }

        if ($request->hasFile('favicon')) {
            $data['favicon'] = ImageHelper::uploadAndConvert($request->file('favicon'), 'assets/img');
        }

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Process homepage section controls (checkboxes default to '0' if unchecked/missing)
        $sections = [
            'show_hero_section',
            'show_experience_section',
            'show_schedule_section',
            'show_packages_section',
            'show_articles_section',
            'show_testimonials_section',
            'show_location_section',
            'show_cta_section',
            'show_sticky_cta_bar',
            'show_pendaftaran_feature',
        ];

        foreach ($sections as $sec) {
            $val = $request->has($sec) ? '1' : '0';
            SiteSetting::updateOrCreate(['key' => $sec], ['value' => $val]);
        }

        return back()->with('success', 'Website branding, payments, and homepage section settings updated successfully!');
    }

    // ==========================================
    // 2. MARKETING SETTINGS (Superadmin, Admin, Marketing)
    // ==========================================
    public function marketingIndex()
    {
        // Guarded by manage_settings permission (assigned to Superadmin, Admin, and Marketing roles)
        if (! auth()->user()->hasAnyRole(['superadmin', 'admin', 'marketing'])) {
            abort(403, 'Unauthorized action.');
        }

        $settings = SiteSetting::pluck('value', 'key')->toArray();

        return view('admin.settings.marketing', compact('settings'));
    }

    public function marketingUpdate(Request $request)
    {
        if (! auth()->user()->hasAnyRole(['superadmin', 'admin', 'marketing'])) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->only([
            'wa_number',
            'instagram_url',
            'facebook_url',
            'address',
            'google_maps_url',
            'google_analytics',
            'facebook_pixel',
            'facebook_pixel_id',
            'facebook_capi_token',
            'meta_keywords',
            'meta_description',
            'gtm_id',
            'tiktok_pixel_id',
            'tiktok_capi_token',
            'wa_followup_template',
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Marketing, Pixel, and Social settings updated successfully!');
    }
}
