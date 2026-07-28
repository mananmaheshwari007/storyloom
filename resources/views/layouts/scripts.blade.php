{{-- ?v=<file mtime> busts the immutable cache from public/.htaccess on deploy. --}}
<script src="{{ asset('assets/js/main.js') }}?v={{ @filemtime(public_path('assets/js/main.js')) ?: '1' }}" defer></script>
@stack('scripts')
