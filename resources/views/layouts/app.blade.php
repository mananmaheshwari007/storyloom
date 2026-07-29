<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ setting('promo_bar_enabled', '0') === '1' ? 'has-promo-bar' : '' }}">
<head>
  @include('layouts.analytics')
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <x-seo-tags :seo="$seo ?? null" />

  {{-- Ownership verification for Search Console / Merchant Center.
       Set in Admin → Site Settings → Analytics & Site Verification. --}}
  @if(setting('google_site_verification'))
    <meta name="google-site-verification" content="{{ setting('google_site_verification') }}">
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

  <!-- ============ READER MODAL ============ -->
  <div class="reader-modal" role="dialog" aria-modal="true" aria-label="Storyloom reader">
    <div class="reader-dialog">
      <div class="reader-top">
        <span class="reader-title">Storyloom</span>
        <button class="reader-close" aria-label="Close reader">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 5l14 14M19 5L5 19"/></svg>
        </button>
      </div>
      <div class="reader-stage">
        <div class="reader-book">
          <div class="half half-left"></div>
          <div class="half half-right"></div>
          <div class="leaf" style="display:none">
            <div class="leaf-front"></div>
            <div class="leaf-back"></div>
          </div>
        </div>
      </div>
      <div class="reader-bottom">
        <span class="reader-caption" aria-live="polite"></span>
        <div class="reader-nav">
          <button class="reader-arrow prev" aria-label="Previous page">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M21 12H4m0 0 6-6m-6 6 6 6"/></svg>
          </button>
          <span class="page-ind">1 / 1</span>
          <button class="reader-arrow next" aria-label="Next page">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  @include('layouts.scripts')
</body>
</html>
