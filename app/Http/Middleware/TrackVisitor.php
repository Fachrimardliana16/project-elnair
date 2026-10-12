<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $ip = $request->ip();
            $date = now()->toDateString();
            
            $cacheKey = 'visitor_hit_flush:'.sha1($date.'|'.$ip.'|'.($request->userAgent() ?? ''));
            $pendingHitsKey = 'visitor_pending_hits:'.sha1($date.'|'.$ip);
            Cache::increment($pendingHitsKey);
            Cache::put($pendingHitsKey, Cache::get($pendingHitsKey, 1), now()->addMinutes(10));

            if (Cache::add($cacheKey, true, now()->addMinutes(5))) {
                $hits = (int) Cache::pull($pendingHitsKey, 1);
                $visitor = \App\Models\Visitor::firstOrCreate(
                    ['ip_address' => $ip, 'visited_date' => $date],
                    ['user_agent' => $request->userAgent(), 'hits' => 0]
                );

                $visitor->increment('hits', max(1, $hits));
            }
        } catch (\Exception $e) {
            // Silently catch exceptions to not block the request
        }

        return $next($request);
    }
}
