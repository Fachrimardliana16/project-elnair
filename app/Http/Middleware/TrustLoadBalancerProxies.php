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
        // Trust all proxies — adjust to specific CIDR ranges if your infra is known
        // e.g. ['10.0.0.0/8', '172.16.0.0/12', '192.168.0.0/16'] for private subnets
        $request->setTrustedProxies(
            ['REMOTE_ADDR'],    // Use the connecting IP as the trusted proxy address sentinel
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_PREFIX
        );

        return $next($request);
    }
}
