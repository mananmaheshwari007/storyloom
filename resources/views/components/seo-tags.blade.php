@props(['seo'])

@php
    $defaultTitle = setting('seo_meta_title', 'Storyloom — The Story Only You Could Give | Personalised Illustrated Keepsake Books, India');
    $defaultDesc = setting('seo_meta_description', "Storyloom transforms your memories into a hand-illustrated keepsake storybook — a one-of-a-kind gift for the people who shaped your life. Crafted in India, treasured forever.");
    $defaultKeywords = setting('seo_meta_keywords', 'keepsake, personalised, illustrated, books, storybooks, India, custom gift');
    $defaultOgImage = setting('seo_og_image', 'assets/img/spread-bench-dusk.webp');

    $title = $seo['title'] ?? $defaultTitle;
    $description = $seo['description'] ?? $defaultDesc;
    $keywords = $seo['keywords'] ?? $defaultKeywords;
    $ogImage = $seo['og_image'] ?? $defaultOgImage;
    $canonicalUrl = $seo['canonical'] ?? request()->url();
    $schema = $seo['schema'] ?? [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => setting('site_name', 'Storyloom'),
        'url' => url('/'),
        'logo' => asset(setting('site_emblem', 'assets/img/logo-emblem.png')),
        'description' => $description,
        'email' => setting('contact_email', 'hello@storyloom.in'),
        'areaServed' => 'IN',
        'slogan' => 'The story only you could give.',
    ];
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ asset($ogImage) }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $canonicalUrl }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ asset($ogImage) }}">

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{!! json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
