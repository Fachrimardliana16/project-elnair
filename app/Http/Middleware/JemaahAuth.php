<?php

namespace App\Http\Middleware;

use App\Models\Jamaah;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JemaahAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jemaahId = session('jemaah_id');

        if (! $jemaahId) {
            return redirect()->route('jemaah.login')->with('error', 'Silakan masuk terlebih dahulu untuk mengakses portal jemaah.');
        }

        $jemaah = Jamaah::with(['package', 'departureSchedule', 'group.departureSchedule', 'payments'])->find($jemaahId);

        if (! $jemaah) {
            session()->forget('jemaah_id');

            return redirect()->route('jemaah.login')->with('error', 'Data jemaah tidak ditemukan.');
        }

        // Share the authenticated jemaah model globally with views and save in request attributes
        $request->attributes->set('jemaah', $jemaah);
        view()->share('jemaah', $jemaah);

        return $next($request);
    }
}
