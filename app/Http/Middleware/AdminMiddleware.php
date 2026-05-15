<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        if (!$request->user()->hasAnyRole(['superadmin', 'admin', 'marketing'])) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
