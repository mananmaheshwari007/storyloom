<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Baseline security headers (PageSpeed Insights "Best Practices" checks:
 * CSP, HSTS, COOP, clickjacking mitigation). The CSP allows 'unsafe-inline'
 * for script/style because the site currently relies on inline styles and
 * onclick handlers throughout — tightening that further requires auditing
 * every inline usage first, which is a separate follow-up.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        $response->headers->set('Content-Security-Policy', implode('; ', [
            "default-src 'self'",
            // googletagmanager serves the GA4 gtag.js loader; connect.facebook.net
            // serves the Meta Pixel's fbevents.js. Without either host here the
            // CSP silently blocks the tag and no data ever reaches the property.
            "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://www.googletagmanager.com https://connect.facebook.net",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net https://cdn.jsdelivr.net",
            "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net https://cdn.jsdelivr.net data:",
            "img-src 'self' data: https:",
            // GA4 beacons go to google-analytics.com / analytics.google.com;
            // Meta Pixel events post to facebook.com/tr. The noscript fallback
            // <img> is already covered by the https: allowance in img-src.
            "connect-src 'self' https://*.google-analytics.com https://*.analytics.google.com https://www.googletagmanager.com https://www.facebook.com https://facebook.com https://*.facebook.com https://connect.facebook.net",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "object-src 'none'",
        ]));

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
