<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

/**
 * Serves /sitemap.xml and /robots.txt from routes rather than static files, so
 * both are part of the codebase (present in every deployment) and the sitemap
 * always reflects what is actually published — no regeneration step to forget.
 */
class SitemapController extends Controller
{
    /** Static pages, with a crawl priority and how often they really change. */
    private const PAGES = [
        'home'         => ['1.0', 'weekly'],
        'library'      => ['0.9', 'weekly'],
        'how-it-works' => ['0.8', 'monthly'],
        'occasions'    => ['0.8', 'monthly'],
        'pricing'      => ['0.8', 'monthly'],
        'begin'        => ['0.8', 'monthly'],
        'about'        => ['0.6', 'monthly'],
        'faq'          => ['0.6', 'monthly'],
        'blog.index'   => ['0.7', 'weekly'],
    ];

    public function sitemap()
    {
        $xml = Cache::remember('sitemap.xml', now()->addHour(), function () {
            $urls = [];

            foreach (self::PAGES as $routeName => [$priority, $changefreq]) {
                $urls[] = [
                    'loc'        => route($routeName),
                    'lastmod'    => now()->toAtomString(),
                    'changefreq' => $changefreq,
                    'priority'   => $priority,
                ];
            }

            foreach (Blog::where('status', 'published')->latest('updated_at')->get() as $post) {
                $urls[] = [
                    'loc'        => route('blog.show', $post->slug),
                    'lastmod'    => ($post->updated_at ?? $post->created_at)->toAtomString(),
                    'changefreq' => 'yearly',
                    'priority'   => '0.6',
                ];
            }

            $body = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
                . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

            foreach ($urls as $url) {
                $body .= "  <url>\n"
                    . '    <loc>' . htmlspecialchars($url['loc'], ENT_XML1) . "</loc>\n"
                    . '    <lastmod>' . $url['lastmod'] . "</lastmod>\n"
                    . '    <changefreq>' . $url['changefreq'] . "</changefreq>\n"
                    . '    <priority>' . $url['priority'] . "</priority>\n"
                    . "  </url>\n";
            }

            return $body . '</urlset>';
        });

        return Response::make($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function robots()
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            '',
            '# Nothing here is useful to a crawler and some of it is private.',
            'Disallow: /admin',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /dashboard',
            'Disallow: /profile',
            '',
            'Sitemap: ' . route('sitemap'),
            '',
        ];

        return Response::make(implode("\n", $lines), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
