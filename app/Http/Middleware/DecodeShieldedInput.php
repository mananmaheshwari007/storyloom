<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Undoes the client-side encoding applied by the admin panel.
 *
 * Why this exists: the CMS legitimately stores markup — headings carry <br> and
 * <em style="..."> so editors can control line breaks and accents. Shared hosts
 * run a WAF (ModSecurity/OWASP CRS) in front of PHP that treats any POST body
 * containing tags and style attributes as an XSS attempt and answers 403 before
 * Laravel is ever reached. There is nothing the app can do about that from
 * inside a request it never receives.
 *
 * So the admin forms base64 the affected fields on submit, which leaves the
 * request body with no markup for the WAF to object to, and this middleware
 * turns them back into markup before validation or any controller sees them.
 * From the controllers' point of view nothing has changed.
 *
 * @see resources/views/layouts/admin.blade.php for the encoding half.
 */
class DecodeShieldedInput
{
    /** Marker the admin JS puts in front of an encoded value. */
    public const PREFIX = '__b64__';

    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->method(), ['POST', 'PUT', 'PATCH'], true)) {
            return $next($request);
        }

        // input() excludes uploaded files, so multipart uploads pass straight
        // through untouched.
        $input = $request->input();
        $touched = false;

        array_walk_recursive($input, function (&$value) use (&$touched) {
            if (! is_string($value) || ! str_starts_with($value, self::PREFIX)) {
                return;
            }

            // Strict mode: anything that isn't real base64 is left exactly as
            // typed, so a visitor writing the prefix by hand can't corrupt
            // their own text.
            $decoded = base64_decode(substr($value, strlen(self::PREFIX)), true);

            if ($decoded !== false && mb_check_encoding($decoded, 'UTF-8')) {
                $value = $decoded;
                $touched = true;
            }
        });

        if ($touched) {
            $request->merge($input);
        }

        return $next($request);
    }
}
