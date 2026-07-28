<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{-- Load web fonts without blocking first paint: fetch as a low-priority
     preload, then swap it in as the real stylesheet once it arrives. --}}
@php $fontsHref = 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&family=Edu+SA+Hand:wght@400..700&display=swap'; @endphp
<link rel="preload" href="{{ $fontsHref }}" as="style">
<link rel="stylesheet" href="{{ $fontsHref }}" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="{{ $fontsHref }}"></noscript>
<script>document.documentElement.classList.add("js");</script>
{{-- ?v=<file mtime> so a deploy busts the long-lived immutable cache set in
     public/.htaccess; without it returning visitors keep stale CSS for a month. --}}
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ @filemtime(public_path('assets/css/main.css')) ?: '1' }}">
@stack('styles')
