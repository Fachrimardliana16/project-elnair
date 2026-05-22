<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * GzipResponse Middleware
 *
 * Compresses HTML/text responses at the PHP application layer.
 * Required because cPanel shared hosting with PHP-FPM bypasses
 * Apache mod_deflate — output filters don't apply to FastCGI responses.
 *
 * Only compresses when:
 *   1. Client sends Accept-Encoding: gzip
 *   2. Response is text-based (text/html, text/css, application/json, etc.)
 *   3. Response content is large enough to benefit from compression
 *   4. PHP's zlib extension is available
 */
class GzipResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Skip if client doesn't support gzip
        if (!str_contains($request->header('Accept-Encoding', ''), 'gzip')) {
            return $response;
        }

        // Skip if already encoded
        if ($response->headers->has('Content-Encoding')) {
            return $response;
        }

        // Skip if zlib not available
        if (!extension_loaded('zlib')) {
            return $response;
        }

        // Only compress text-based responses
        $contentType = $response->headers->get('Content-Type', '');
        $compressible = str_contains($contentType, 'text/html')
            || str_contains($contentType, 'text/css')
            || str_contains($contentType, 'text/javascript')
            || str_contains($contentType, 'application/javascript')
            || str_contains($contentType, 'application/json')
            || str_contains($contentType, 'text/plain')
            || str_contains($contentType, 'application/xml')
            || str_contains($contentType, 'text/xml');

        if (!$compressible) {
            return $response;
        }

        $content = $response->getContent();

        // Only compress if content is large enough to benefit
        if (!$content || strlen($content) < 860) {
            return $response;
        }

        $compressed = gzencode($content, 6);

        if ($compressed === false || strlen($compressed) >= strlen($content)) {
            return $response;
        }

        $response->setContent($compressed);
        $response->headers->set('Content-Encoding', 'gzip');
        $response->headers->set('Content-Length', (string) strlen($compressed));
        $response->headers->remove('Transfer-Encoding');
        $response->headers->set('Vary', 'Accept-Encoding');

        return $response;
    }
}
