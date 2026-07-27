@extends('layouts.admin')

@section('title', 'Brand & Website Settings')
@section('page_title', 'Website Settings')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Website Settings</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      
      <!-- Nav Tabs -->
      <ul class="nav nav-tabs mb-4" id="settingsTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">General Branding</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact Details</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">Social Networks</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false">SEO Default Meta</button>
        </li>
      </ul>

      <!-- Settings Form -->
      <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="tab-content" id="settingsTabContent">
          
          <!-- General Branding Tab -->
          <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Site Name</label>
                <input type="text" name="site_name" class="form-control" value="{{ setting('site_name') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Copyright Text</label>
                <input type="text" name="copyright_text" class="form-control" value="{{ setting('copyright_text') }}">
              </div>
              
              <div class="col-12">
                <label class="form-label fw-semibold">Site Description / Tagline</label>
                <textarea name="site_description" class="form-control" rows="3">{{ setting('site_description') }}</textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Site Emblem (Parchment)</label>
                <input type="file" name="site_emblem" class="form-control">
                @if(setting('site_emblem'))
                  <div class="mt-2 p-2 border rounded bg-light d-inline-block">
                    <img src="{{ asset(setting('site_emblem')) }}" height="40" alt="Emblem logo preview">
                  </div>
                @endif
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Logo Text (Wordmark)</label>
                <input type="file" name="site_wordmark" class="form-control">
                @if(setting('site_wordmark'))
                  <div class="mt-2 p-2 border rounded bg-light d-inline-block">
                    <img src="{{ asset(setting('site_wordmark')) }}" height="40" alt="Wordmark preview">
                  </div>
                @endif
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Favicon (.png)</label>
                <input type="file" name="site_favicon" class="form-control">
                @if(setting('site_favicon'))
                  <div class="mt-2 p-2 border rounded bg-light d-inline-block">
                    <img src="{{ asset(setting('site_favicon')) }}" height="32" alt="Favicon preview">
                  </div>
                @endif
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Site Logo Light (For dark footer)</label>
                <input type="file" name="site_logo_light" class="form-control">
                @if(setting('site_logo_light'))
                  <div class="mt-2 p-2 border rounded bg-dark d-inline-block">
                    <img src="{{ asset(setting('site_logo_light')) }}" height="40" alt="Footer logo preview">
                  </div>
                @endif
              </div>
            </div>
          </div>

          <!-- Contact Details Tab -->
          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Contact Phone Number</label>
                <input type="text" name="contact_phone" class="form-control" value="{{ setting('contact_phone') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">WhatsApp Number (e.g. 919999999999)</label>
                <input type="text" name="contact_whatsapp" class="form-control" value="{{ setting('contact_whatsapp') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Contact Email Address</label>
                <input type="email" name="contact_email" class="form-control" value="{{ setting('contact_email') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Office Address</label>
                <input type="text" name="contact_address" class="form-control" value="{{ setting('contact_address') }}">
              </div>
              
              <div class="col-12">
                <label class="form-label fw-semibold">Google Map URL (Iframe src link)</label>
                <input type="text" name="contact_map" class="form-control" value="{{ setting('contact_map') }}">
                @if(setting('contact_map'))
                  <div class="mt-2 border rounded overflow-hidden" style="max-width: 500px; height: 200px;">
                    <iframe src="{{ setting('contact_map') }}" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                  </div>
                @endif
              </div>
            </div>
          </div>

          <!-- Social Networks Tab -->
          <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Instagram Profile Link</label>
                <input type="text" name="social_instagram" class="form-control" value="{{ setting('social_instagram') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Instagram Display Username (e.g. storyloom.in)</label>
                <input type="text" name="instagram_username" class="form-control" value="{{ setting('instagram_username') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Facebook Page Link</label>
                <input type="text" name="social_facebook" class="form-control" value="{{ setting('social_facebook') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Twitter Account Link</label>
                <input type="text" name="social_twitter" class="form-control" value="{{ setting('social_twitter') }}">
              </div>
            </div>
          </div>

          <!-- SEO Default Meta Tab -->
          <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label fw-semibold">SEO Meta Title</label>
                <input type="text" name="seo_meta_title" class="form-control" value="{{ setting('seo_meta_title') }}">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">SEO Meta Description</label>
                <textarea name="seo_meta_description" class="form-control" rows="3">{{ setting('seo_meta_description') }}</textarea>
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">SEO Meta Keywords (comma separated)</label>
                <input type="text" name="seo_meta_keywords" class="form-control" value="{{ setting('seo_meta_keywords') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Default Open Graph Image</label>
                <input type="file" name="seo_og_image" class="form-control">
                @if(setting('seo_og_image'))
                  <div class="mt-2 p-2 border rounded bg-light d-inline-block">
                    <img src="{{ asset(setting('seo_og_image')) }}" height="80" alt="OG image preview">
                  </div>
                @endif
              </div>
            </div>
          </div>

        </div>
        
        <!-- Submit Button -->
        <div class="mt-4 pt-3 border-top">
          <button type="submit" class="btn btn-primary px-4 py-2"><i class="bi bi-save me-2"></i>Save All Settings</button>
        </div>

      </form>
    </div>
  </div>
@endsection
