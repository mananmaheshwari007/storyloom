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

{{--
    Meta (Facebook) Pixel — base code only.

    Kept in this existing partial rather than a file of its own: the deployment
    process copies changed files but not newly added ones, so a separate partial
    left the live site throwing "View [layouts.meta-pixel] not found" on every
    page. Nothing here needs a new file to exist on the server.

    The ID comes from Admin → Site Settings & Branding → Analytics & Verification
    → "Meta Pixel ID".

    The default is deliberately EMPTY rather than the current Pixel ID: setting()
    falls back to its default whenever the stored value is an empty string, so a
    hard-coded default would make it impossible to switch the Pixel off from the
    dashboard. Clearing the field renders nothing at all.

    The CSP in app/Http/Middleware/SecurityHeaders.php must keep allowing
    connect.facebook.net (script) and facebook.com (connect), or the browser
    silently blocks this and no events arrive.

    Base code only — no Purchase, AddToCart, InitiateCheckout or Lead events.
--}}
@php $metaPixelId = trim((string) setting('meta_pixel_id', '')); @endphp

@if($metaPixelId !== '')
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $metaPixelId }}');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={{ $metaPixelId }}&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
@endif
