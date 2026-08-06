@extends('layouts.admin')

@section('title', 'Global Branding & Site Settings')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-sliders me-2 text-primary"></i> Global Branding & Site Settings</h1>
        <p class="text-muted small mb-0">Manage global site parameters, brand identity, logos, contact information, social links, and analytics.</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Global Settings</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card shadow-sm border-0 mb-4 bg-white sticky-top" style="top: 80px; z-index: 100;">
        <div class="card-body py-2.5 px-3 d-flex align-items-center justify-content-between">
            <span class="fw-bold text-dark small"><i class="bi bi-shield-lock me-1.5 text-primary"></i> Global Parameters & Branding</span>
            <button type="submit" class="btn btn-sm btn-primary fw-bold px-4 py-1.5">
                <i class="bi bi-save me-1.5"></i> Save Global Settings
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- General Information -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-info-square me-2 text-primary"></i> Site Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="site_name" class="form-label font-weight-bold">Site Name</label>
                        <input type="text" class="form-control" id="site_name" name="site_name" value="{{ setting('site_name', 'Storyloom') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="copyright_text" class="form-label">Copyright Text</label>
                        <input type="text" class="form-control" id="copyright_text" name="copyright_text" value="{{ setting('copyright_text', 'Storyloom. Every story belongs to its family.') }}">
                    </div>
                    <div class="mb-3">
                        <label for="site_description" class="form-label">Footer Description Text</label>
                        <textarea class="form-control" id="site_description" name="site_description" rows="3">{{ setting('site_description', 'Storyloom transforms your memories into a hand-illustrated keepsake storybook — a one-of-a-kind gift for the people who shaped your life.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Contact Details -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-telephone-fill me-2 text-success"></i> Contact & Support Details</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact_email" class="form-label">Contact Email</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ setting('contact_email', 'hello@storyloom.in') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="contact_phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="{{ setting('contact_phone', '+91 99999 99999') }}">
                        </div>
                        @php
                            $waRaw = (string) setting('contact_whatsapp', '');
                            $waDigits = preg_replace('/\D+/', '', $waRaw);
                            $waIsPlaceholder = $waDigits === '' || $waDigits === '919999999999';
                        @endphp
                        <div class="col-md-6">
                            <label for="contact_whatsapp" class="form-label">WhatsApp Number</label>
                            <input type="text" class="form-control @if($waIsPlaceholder) is-invalid @endif" id="contact_whatsapp" name="contact_whatsapp" value="{{ $waRaw }}">
                            @if($waIsPlaceholder)
                                <div class="invalid-feedback d-block">
                                    <strong>This is still the placeholder number.</strong> Every "WhatsApp us" link on the site
                                    currently sends people to <a href="{{ route('begin') }}" target="_blank">Begin Your Story</a> instead,
                                    rather than to a chat nobody answers. Enter your real number to switch them over.
                                </div>
                            @endif
                            <div class="form-text">
                                Country code first, no <code>+</code> needed — e.g. <code>919876543210</code>.
                                Spaces and dashes are fine, they're stripped automatically.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="whatsapp_prefill" class="form-label">Message pre-typed for the visitor</label>
                            <input type="text" class="form-control" id="whatsapp_prefill" name="whatsapp_prefill" value="{{ setting('whatsapp_prefill', 'Hi Storyloom — I would like to begin a story.') }}">
                            <div class="form-text">Their chat opens with this already written, so they only have to hit send. Leave blank for an empty chat.</div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-light border small mb-0">
                                <i class="bi bi-link-45deg me-1 text-primary"></i>
                                <strong>Share <code>{{ route('whatsapp') }}</code> rather than the number itself</strong> —
                                in your Instagram bio, on cards, in ads. It redirects to whatever number is saved above, so when you
                                move to a dedicated Storyloom number you change it here once and every link already out in the world
                                keeps working.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_address" class="form-label">Studio Address</label>
                            <input type="text" class="form-control" id="contact_address" name="contact_address" value="{{ setting('contact_address', 'New Delhi, India') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="social_instagram" class="form-label">Instagram Profile URL</label>
                            <input type="url" class="form-control" id="social_instagram" name="social_instagram" value="{{ setting('social_instagram', 'https://www.instagram.com/storyloombooks/') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="instagram_username" class="form-label">Instagram Handle (without @)</label>
                            <input type="text" class="form-control" id="instagram_username" name="instagram_username" value="{{ setting('instagram_username', 'storyloombooks') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Default SEO & Meta -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-search me-2 text-info"></i> Default SEO Meta Tags</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="seo_title" class="form-label">Default SEO Meta Title</label>
                        <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{ setting('seo_title', 'Storyloom — The Story Only You Could Give') }}">
                    </div>
                    <div class="mb-3">
                        <label for="seo_description" class="form-label">Default SEO Description</label>
                        <textarea class="form-control" id="seo_description" name="seo_description" rows="3">{{ setting('seo_description', 'Storyloom transforms your memories into a hand-illustrated keepsake storybook — a one-of-a-kind gift for the people who shaped your life.') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="seo_keywords" class="form-label">Default SEO Keywords</label>
                        <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" value="{{ setting('seo_keywords', 'personalized storybook, keepsake books, customized gifts, illustrated storybook, India gifts') }}">
                    </div>
                </div>
            </div>

            <!-- Analytics & Verification -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-graph-up-arrow me-2 text-success"></i> Analytics & Verification</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="google_analytics_id" class="form-label">Google Analytics Measurement ID</label>
                        <input type="text" class="form-control" id="google_analytics_id" name="google_analytics_id" value="{{ setting('google_analytics_id', 'G-1V87JW7B54') }}" placeholder="G-1V87JW7B54">
                    </div>
                    <div class="mb-0">
                        <label for="google_site_verification" class="form-label">Google Site Verification Code</label>
                        <input type="text" class="form-control" id="google_site_verification" name="google_site_verification" value="{{ setting('google_site_verification', '') }}" placeholder="paste verification string">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Brand Assets & Logos -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-image me-2 text-warning"></i> Brand Assets & Logos</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Header Logo (Light)</label>
                        <div class="mb-2 p-2 bg-dark rounded text-center">
                            <img id="logo_light_preview" src="{{ asset(setting('site_logo_light', 'assets/img/logo-light.png')) }}" alt="Logo Light" height="40" style="object-fit: contain;">
                        </div>
                        <input type="file" class="form-control form-control-sm mb-1" name="site_logo_light_file" accept="image/*" onchange="previewImg(this, 'logo_light_preview')">
                        <input type="text" class="form-control form-control-sm" name="site_logo_light" value="{{ setting('site_logo_light', 'assets/img/logo-light.png') }}">
                        <div class="form-text" style="font-size: 0.74rem;"><span class="badge bg-secondary">PNG/SVG</span> Max 1MB</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Header Logo (Dark)</label>
                        <div class="mb-2 p-2 bg-light border rounded text-center">
                            <img id="logo_dark_preview" src="{{ asset(setting('site_logo', 'assets/img/logo.png')) }}" alt="Logo Dark" height="40" style="object-fit: contain;">
                        </div>
                        <input type="file" class="form-control form-control-sm mb-1" name="site_logo_file" accept="image/*" onchange="previewImg(this, 'logo_dark_preview')">
                        <input type="text" class="form-control form-control-sm" name="site_logo" value="{{ setting('site_logo', 'assets/img/logo.png') }}">
                        <div class="form-text" style="font-size: 0.74rem;"><span class="badge bg-secondary">PNG/SVG</span> Max 1MB</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Favicon Icon</label>
                        <div class="mb-2 p-2 bg-light border rounded text-center">
                            <img id="favicon_preview" src="{{ asset(setting('site_favicon', 'assets/img/favicon.png')) }}" alt="Favicon" width="32" height="32">
                        </div>
                        <input type="file" class="form-control form-control-sm mb-1" name="site_favicon_file" accept="image/x-icon,image/png,image/svg+xml" onchange="previewImg(this, 'favicon_preview')">
                        <input type="text" class="form-control form-control-sm" name="site_favicon" value="{{ setting('site_favicon', 'assets/img/favicon.png') }}">
                        <div class="form-text" style="font-size: 0.74rem;"><span class="badge bg-secondary">ICO/PNG</span> 32x32 px</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
function previewImg(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
