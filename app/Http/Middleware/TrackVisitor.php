<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
            
            $visitor = \App\Models\Visitor::firstOrCreate(
                ['ip_address' => $ip, 'visited_date' => $date],
                ['user_agent' => $request->userAgent(), 'hits' => 0]
            );
            
            $visitor->increment('hits');
        } catch (\Exception $e) {
            // Silently catch exceptions to not block the request
        }

        return $next($request);
    }
}
