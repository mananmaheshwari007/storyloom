<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @hasSection('seo')
    @yield('seo')
  @else
    <x-seo-tags :seo="$seo ?? null" />
  @endif

  <link rel="icon" type="image/png" href="{{ asset(setting('site_favicon', 'assets/img/favicon.png')) }}">
  @include('layouts.styles')
</head>
<body>
  <a class="skip-link" href="#main">Skip to main content</a>

  @include('layouts.header')

  <main id="main">
    @yield('content')
  </main>

  @include('layouts.footer')

  @include('layouts.scripts')
</body>
</html>
