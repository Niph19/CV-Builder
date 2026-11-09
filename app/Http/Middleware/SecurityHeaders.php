<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Content-Security-Policy', $this->contentSecurityPolicy());

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }

    private function contentSecurityPolicy(): string
    {
        $vite = app()->environment('local') && file_exists(public_path('hot'));
        $script = "script-src 'self'".($vite ? " 'unsafe-inline' http://localhost:5173 ws://localhost:5173" : '');
        $style = "style-src 'self' 'unsafe-inline' https://fonts.bunny.net".($vite ? ' http://localhost:5173' : '');
        $connect = "connect-src 'self'".($vite ? ' http://localhost:5173 ws://localhost:5173' : '');

        return implode('; ', [
            "default-src 'self'",
            $script,
            $style,
            "font-src 'self' https://fonts.bunny.net",
            "img-src 'self' data:",
            $connect,
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "object-src 'none'",
        ]);
    }
}
