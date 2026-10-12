<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * TrustLoadBalancerProxies
 *
 * Ensures that IP addresses logged in the system reflect the actual visitor
 * IP forwarded via the X-Forwarded-For header from a load balancer or CDN
 * (e.g. Nginx proxy, AWS ALB, Cloudflare).
 *
 * WARNING: Only enable this in production environments behind a trusted proxy.
 * Trusting all proxies blindly in a direct-access setup allows IP spoofing.
 */
class TrustLoadBalancerProxies
{
    public function handle(Request $request, Closure $next): Response
    {
        $trustedProxies = array_filter(array_map('trim', explode(',', (string) env('TRUSTED_PROXIES', ''))));

        if (! empty($trustedProxies)) {
            $request->setTrustedProxies(
                $trustedProxies,
                Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_HOST |
                Request::HEADER_X_FORWARDED_PORT |
                Request::HEADER_X_FORWARDED_PROTO |
                Request::HEADER_X_FORWARDED_PREFIX
            );
        }

        return $next($request);
    }
}
