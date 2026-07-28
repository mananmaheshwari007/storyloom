{{--
    Google Analytics 4.

    Renders nothing at all until a Measurement ID is saved in
    Admin → Site Settings → General & Branding → Analytics & Site Verification,
    so local/staging copies stay out of the reporting data by default.

    Loaded async so it never blocks first paint. Note the CSP in
    app/Http/Middleware/SecurityHeaders.php must keep allowing
    googletagmanager.com (script) and google-analytics.com (connect),
    or the browser will silently block this and no data will arrive.
--}}
@php 
  $host = request()->getHost();
  $isLocal = in_array($host, ['localhost', '127.0.0.1', '::1']) || str_contains($host, '.test') || str_contains($host, '.local');
  $gaId = trim((string) setting('google_analytics_id', 'G-1V87JW7B54')); 
  if (empty($gaId)) {
      $gaId = 'G-1V87JW7B54';
  }
@endphp

@if(!$isLocal && !empty($gaId))
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ $gaId }}');
  </script>
@endif
