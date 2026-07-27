@props(['seo'])

@php
    $title = $seo['title'] ?? setting('seo_title', 'Storyloom — The Story Only You Could Give');
    $description = $seo['description'] ?? setting('seo_description', 'Storyloom transforms your memories into a hand-illustrated keepsake storybook — a one-of-a-kind gift for the people who shaped your life.');
    $keywords = $seo['keywords'] ?? setting('seo_keywords', 'personalized storybook, keepsake books, customized gifts, illustrated storybook, India gifts, anniversaries, birthdays');
    $url = url()->current();
    $image = asset(setting('site_share_image', 'assets/img/spread-bench-dusk.webp'));
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<link rel="canonical" href="{{ $url }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $url }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $url }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ $image }}">
