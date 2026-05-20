<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CaptureUtmParameters
 *
 * Intercepts every incoming request and persists UTM parameters to the
 * session so they survive subsequent page navigations.  When a lead is
 * eventually submitted the StoreLead action reads the session values and
 * writes them to the `landing_page_leads` table, giving marketers a
 * full-funnel attribution trail from ad click to conversion.
 */
class CaptureUtmParameters
{
    private const UTM_KEYS = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'utm_term',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        foreach (self::UTM_KEYS as $key) {
            if ($request->query($key)) {
                // Sanitize: allow only safe alphanumeric / hyphen / underscore / space chars
                $value = strip_tags((string) $request->query($key));
                $value = preg_replace('/[^\w\s\-\.@\/]/u', '', $value);
                $value = mb_substr($value, 0, 255);

                session([$key => $value]);
            }
        }

        // Also capture referrer once per session
        if (!session('referrer') && $request->header('referer')) {
            $referer = mb_substr($request->header('referer'), 0, 500);
            session(['referrer' => $referer]);
        }

        return $next($request);
    }
}
