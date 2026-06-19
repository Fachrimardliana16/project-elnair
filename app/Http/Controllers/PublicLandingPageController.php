<?php

namespace App\Http\Controllers;

use App\Http\Requests\Public\StoreLeadRequest;
use App\Jobs\SendCapiEventJob;
use App\Mail\NewLeadNotification;
use App\Models\LandingPage;
use App\Models\LandingPageLead;
use App\Models\SiteSetting;
use App\Services\ActivityLogger;
use App\Services\WhatsAppRotator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PublicLandingPageController extends Controller
{
    public function show($slug)
    {
        $page = LandingPage::where('slug', $slug)->where('is_active', true)->latest()->firstOrFail();
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        // 1. Generate unique page_view_event_id for deduplication
        $pageViewEventId = 'pv_'.uniqid().'_'.time();

        // Resolusi prioritas Meta Pixel (Page-specific vs Global fallback)
        $pixelId = $page->fb_pixel_id ?? ($settings['facebook_pixel_id'] ?? null);
        $capiToken = $page->fb_capi_token ?? ($settings['facebook_capi_token'] ?? null);

        if ($pixelId && $capiToken) {
            // Trigger PageView via Server-Side CAPI with PageView Event ID
            $this->sendMetaCAPIEvent($pixelId, $capiToken, 'PageView', $page, request(), $pageViewEventId);

            // Trigger custom page events if defined
            if (is_array($page->fb_pixel_events)) {
                foreach ($page->fb_pixel_events as $event) {
                    if (! empty($event['event_name'])) {
                        // Generate a unique event_id for each custom event
                        $customEventId = 'ce_'.strtolower($event['event_name']).'_'.uniqid();
                        $this->sendMetaCAPIEvent($pixelId, $capiToken, $event['event_name'], $page, request(), $customEventId);
                    }
                }
            }
        }

        // Resolusi prioritas TikTok Pixel (Page-specific vs Global fallback)
        $ttPixelId = $page->tiktok_pixel_id ?? ($settings['tiktok_pixel_id'] ?? null);
        $ttCapiToken = $page->tiktok_capi_token ?? ($settings['tiktok_capi_token'] ?? null);

        if ($ttPixelId && $ttCapiToken) {
            $this->sendTikTokCAPIEvent($ttPixelId, $ttCapiToken, 'PageView', $page, request(), $pageViewEventId);
        }

        return view('landing.page', compact('page', 'settings', 'pageViewEventId'));
    }

    public function storeLead(StoreLeadRequest $request, $slug)
    {
        $page = LandingPage::where('slug', $slug)->where('is_active', true)->latest()->firstOrFail();
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        // 1. Save Lead to database — include UTM attribution and forensic data
        $lead = LandingPageLead::create([
            'landing_page_id' => $page->id,
            'name' => strip_tags($request->input('name')),
            'phone' => preg_replace('/[^0-9\+]/', '', $request->input('phone')),
            'package' => $request->input('package') ? strip_tags($request->input('package')) : null,
            'status' => 'pending',
            // UTM attribution — from session (captured by CaptureUtmParameters middleware)
            'utm_source' => session('utm_source'),
            'utm_medium' => session('utm_medium'),
            'utm_campaign' => session('utm_campaign'),
            'utm_content' => session('utm_content'),
            'utm_term' => session('utm_term'),
            // Forensic
            'ip_address' => $request->ip(),
            'user_agent' => mb_substr($request->userAgent() ?? '', 0, 500),
            'referrer' => session('referrer'),
        ]);

        // 1a. Audit trail log
        ActivityLogger::log($lead, 'lead_submitted', null, [
            'name' => $lead->name,
            'phone' => $lead->phone,
            'landing_page' => $page->slug,
            'utm_source' => $lead->utm_source,
            'utm_campaign' => $lead->utm_campaign,
        ]);

        // 1b. Notify admin via email (queued, non-blocking)
        try {
            $adminEmail = env('ADMIN_NOTIFICATION_EMAIL', config('mail.from.address'));
            if ($adminEmail) {
                Mail::to($adminEmail)->queue(new NewLeadNotification($lead, $page));
            }
        } catch (\Exception $e) {
            Log::error('Lead notification email failed: '.$e->getMessage());
        }

        // 2. WhatsApp Sequential Rotator (round-robin, load-balancer-safe via shared Cache)
        $waInput = $page->custom_wa_number ?? ($settings['wa_number'] ?? '');
        $waNumbers = WhatsAppRotator::parseNumbers($waInput);

        if (empty($waNumbers)) {
            return response()->json(['success' => false, 'message' => 'CS WhatsApp number is not configured.'], 422);
        }

        // Build WA message
        $customMsg = $page->custom_wa_message ?? 'Halo Elnair, saya ingin bertanya tentang '.$page->title;
        $leadDetails = "\n\n*Detail Pendaftaran:*\n- Nama: ".$lead->name."\n- No. WA: ".$lead->phone
                     .($lead->package ? "\n- Pilihan Paket: ".$lead->package : '');
        $fullMessage = urlencode($customMsg.$leadDetails);

        $waLink = WhatsAppRotator::getLink($waNumbers, $fullMessage, 'lp_'.$page->id)
                ?? ('https://wa.me/'.preg_replace('/[^0-9]/', '', $waNumbers[0]));

        // 3. Trigger Lead & Contact via Server-Side CAPI (Meta)
        $pixelId = $page->fb_pixel_id ?? ($settings['facebook_pixel_id'] ?? null);
        $capiToken = $page->fb_capi_token ?? ($settings['facebook_capi_token'] ?? null);
        $leadEventId = $request->input('lead_event_id') ?? ('ld_'.uniqid().'_'.time());

        if ($pixelId && $capiToken) {
            $this->sendMetaCAPIEvent($pixelId, $capiToken, 'Lead', $page, $request, $leadEventId);
            $this->sendMetaCAPIEvent($pixelId, $capiToken, 'Contact', $page, $request, $leadEventId.'_contact');
        }

        // 4. TikTok Lead & Contact CAPI Trigger
        $ttPixelId = $page->tiktok_pixel_id ?? ($settings['tiktok_pixel_id'] ?? null);
        $ttCapiToken = $page->tiktok_capi_token ?? ($settings['tiktok_capi_token'] ?? null);
        if ($ttPixelId && $ttCapiToken) {
            $this->sendTikTokCAPIEvent($ttPixelId, $ttCapiToken, 'SubmitForm', $page, $request, $leadEventId);
            $this->sendTikTokCAPIEvent($ttPixelId, $ttCapiToken, 'Contact', $page, $request, $leadEventId.'_contact');
        }

        return response()->json([
            'success' => true,
            'redirect_url' => $waLink,
        ]);
    }

    public function whatsappRedirect(Request $request, $slug)
    {
        $page = LandingPage::where('slug', $slug)->where('is_active', true)->latest()->firstOrFail();
        $settings = Cache::remember('site_settings_global', 300, fn () => SiteSetting::pluck('value', 'key')->toArray()
        );

        // WhatsApp Sequential Rotator
        $waInput = $page->custom_wa_number ?? ($settings['wa_number'] ?? '');
        $waNumbers = WhatsAppRotator::parseNumbers($waInput);

        if (empty($waNumbers)) {
            abort(404, 'WhatsApp number not configured.');
        }

        $rawMessage = $request->query('text') ?? ($page->custom_wa_message ?? ('Halo Elnair, saya ingin bertanya tentang '.$page->title));
        $waLink = WhatsAppRotator::getLink($waNumbers, urlencode($rawMessage), 'lp_direct_'.$page->id)
                    ?? ('https://wa.me/'.preg_replace('/[^0-9]/', '', $waNumbers[0]));

        // 3. Trigger Lead / Contact via Server-Side CAPI (Facebook)
        $pixelId = $page->fb_pixel_id ?? ($settings['facebook_pixel_id'] ?? null);
        $capiToken = $page->fb_capi_token ?? ($settings['facebook_capi_token'] ?? null);
        $eventId = 'ld_direct_'.uniqid().'_'.time();

        if ($pixelId && $capiToken) {
            $this->sendMetaCAPIEvent($pixelId, $capiToken, 'Lead', $page, $request, $eventId);
            $this->sendMetaCAPIEvent($pixelId, $capiToken, 'Contact', $page, $request, $eventId.'_contact');
        }

        // TikTok Lead CAPI
        $ttPixelId = $page->tiktok_pixel_id ?? ($settings['tiktok_pixel_id'] ?? null);
        $ttCapiToken = $page->tiktok_capi_token ?? ($settings['tiktok_capi_token'] ?? null);
        if ($ttPixelId && $ttCapiToken) {
            $this->sendTikTokCAPIEvent($ttPixelId, $ttCapiToken, 'SubmitForm', $page, $request, $eventId);
        }

        return redirect()->away($waLink);
    }

    private function sendMetaCAPIEvent($pixelId, $capiToken, $eventName, $page, Request $request, $eventId)
    {
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        $data = [
            'data' => [
                [
                    'event_name' => $eventName,
                    'event_time' => time(),
                    'event_source_url' => route('landing.page', $page->slug),
                    'action_source' => 'website',
                    'event_id' => $eventId,
                    'user_data' => [
                        'client_ip_address' => $ipAddress,
                        'client_user_agent' => $userAgent,
                    ],
                    'custom_data' => [
                        'content_name' => $page->title,
                        'content_category' => 'Landing Page Campaign',
                    ],
                ],
            ],
        ];

        $url = "https://graph.facebook.com/v19.0/{$pixelId}/events?access_token={$capiToken}";

        // Dispatch background queue job instead of running synchronously
        SendCapiEventJob::dispatch($url, $data, ['Content-Type: application/json']);
    }

    private function sendTikTokCAPIEvent($pixelId, $token, $eventName, $page, Request $request, $eventId)
    {
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        $data = [
            'pixel_code' => $pixelId,
            'event' => $eventName,
            'event_id' => $eventId,
            'timestamp' => date('Y-m-d\TH:i:s.v\Z'),
            'context' => [
                'ip' => $ipAddress,
                'user_agent' => $userAgent,
                'page' => [
                    'url' => route('landing.page', $page->slug),
                    'referrer' => $request->headers->get('referer') ?? '',
                ],
            ],
        ];

        $url = 'https://business-api.tiktok.com/open_api/v1.3/event/track/';

        // Dispatch background queue job instead of running synchronously
        SendCapiEventJob::dispatch($url, $data, [
            'Access-Token: '.$token,
            'Content-Type: application/json',
        ]);
    }
}
