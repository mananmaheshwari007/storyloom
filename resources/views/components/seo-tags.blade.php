@props(['seo'])

@php
    $title = $seo['title'] ?? setting('seo_title', 'Storyloom — The Story Only You Could Give');
    $description = $seo['description'] ?? setting('seo_description', 'Storyloom transforms your memories into a hand-illustrated keepsake storybook — a one-of-a-kind gift for the people who shaped your life.');
    $keywords = $seo['keywords'] ?? setting('seo_keywords', 'personalized storybook, keepsake books, customized gifts, illustrated storybook, India gifts, anniversaries, birthdays');
    $url = url()->current();
    $imageRaw = !empty($seo['image']) ? $seo['image'] : setting('site_share_image', 'assets/img/spread-bench-dusk.webp');
    $image = \Illuminate\Support\Str::startsWith($imageRaw, ['http://', 'https://']) ? $imageRaw : asset($imageRaw);
    $ext = strtolower(pathinfo(parse_url($imageRaw, PHP_URL_PATH), PATHINFO_EXTENSION));
    $mimeType = match($ext) {
        'png' => 'image/png',
        'webp' => 'image/webp',
        'gif' => 'image/gif',
        default => 'image/jpeg',
    };
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<link rel="canonical" href="{{ $url }}">

<!-- Open Graph / Facebook / WhatsApp -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $url }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:secure_url" content="{{ $image }}">
<meta property="og:image:type" content="{{ $mimeType }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="{{ setting('site_name', 'Storyloom') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $url }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ $image }}">
