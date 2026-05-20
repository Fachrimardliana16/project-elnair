<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware (runs on every request)
        $middleware->prepend(\App\Http\Middleware\TrustLoadBalancerProxies::class);
        $middleware->append(\App\Http\Middleware\CaptureUtmParameters::class);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 404 — Show a branded Islamic-themed "page not found" view
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            if (!$request->expectsJson()) {
                return response()->view('errors.404', [], 404);
            }
        });

        // 403 — Unauthorized access
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, $request) {
            if (!$request->expectsJson()) {
                return response()->view('errors.403', [], 403);
            }
        });

        // 429 — Rate limit exceeded
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException $e, $request) {
            if (!$request->expectsJson()) {
                return response()->view('errors.429', [], 429);
            }
        });

        // 500 / QueryException / Generic server errors — log internally, show clean view to user
        $exceptions->render(function (\Illuminate\Database\QueryException $e, $request) {
            \Illuminate\Support\Facades\Log::error('Database QueryException: ' . $e->getMessage(), [
                'sql'      => $e->getSql(),
                'bindings' => $e->getBindings(),
                'trace'    => $e->getTraceAsString(),
            ]);
            if (!$request->expectsJson()) {
                return response()->view('errors.500', [], 500);
            }
        });

        $exceptions->render(function (\Throwable $e, $request) {
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                $code = $e->getStatusCode();
                if (view()->exists("errors.{$code}") && !$request->expectsJson()) {
                    return response()->view("errors.{$code}", [], $code);
                }
            }
        });

        // Report: ensure all unhandled exceptions are written to Log::error
        $exceptions->report(function (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage(), [
                'exception' => get_class($e),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
            ]);
        });
    })->create();
