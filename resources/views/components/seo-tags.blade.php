@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
    'ogImage' => null,
    'ogType' => 'website',
    'canonical' => null,
    'schema' => null,
    'seo' => null,
])

@php
    $defaultTitle = setting('seo_meta_title', 'Storyloom — The Story Only You Could Give | Personalised Illustrated Keepsake Books, India');
    $defaultDesc = setting('seo_meta_description', "Storyloom transforms your memories into a hand-illustrated keepsake storybook — a one-of-a-kind gift for the people who shaped your life. Crafted in India, treasured forever.");
    $defaultKeywords = setting('seo_meta_keywords', 'keepsake, personalised, illustrated, books, storybooks, India, custom gift');
    $defaultOgImage = setting('seo_og_image', 'assets/img/spread-bench-dusk.webp');
    $siteName = setting('site_name', 'Storyloom');

    $finalTitle = $title ?? ($seo['title'] ?? $defaultTitle);
    $finalDescription = $description ?? ($seo['description'] ?? $defaultDesc);
    $finalKeywords = $keywords ?? ($seo['keywords'] ?? $defaultKeywords);
    $rawOgImage = $ogImage ?? ($seo['og_image'] ?? $defaultOgImage);
    $finalOgImage = str_starts_with($rawOgImage, 'http') ? $rawOgImage : asset($rawOgImage);
    $finalCanonical = $canonical ?? ($seo['canonical'] ?? request()->url());
    $finalOgType = $ogType ?? ($seo['og_type'] ?? 'website');

    $finalSchema = $schema ?? ($seo['schema'] ?? [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $siteName,
        'url' => url('/'),
        'logo' => asset(setting('site_emblem', 'assets/img/logo-emblem.png')),
        'description' => $finalDescription,
        'email' => setting('contact_email', 'hello@storyloom.in'),
        'areaServed' => 'IN',
        'slogan' => 'The story only you could give.',
    ]);
@endphp

<title>{{ $finalTitle }}</title>
<meta name="description" content="{{ $finalDescription }}">
<meta name="keywords" content="{{ $finalKeywords }}">
<link rel="canonical" href="{{ $finalCanonical }}">

<!-- Open Graph / Facebook / WhatsApp -->
<meta property="og:type" content="{{ $finalOgType }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:url" content="{{ $finalCanonical }}">
<meta property="og:title" content="{{ $finalTitle }}">
<meta property="og:description" content="{{ $finalDescription }}">
<meta property="og:image" content="{{ $finalOgImage }}">
<meta property="og:locale" content="en_US">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $finalCanonical }}">
<meta name="twitter:title" content="{{ $finalTitle }}">
<meta name="twitter:description" content="{{ $finalDescription }}">
<meta name="twitter:image" content="{{ $finalOgImage }}">

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{!! json_encode($finalSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
