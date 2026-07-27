@extends('layouts.admin')

@section('title', 'Inquiry Details')
@section('page_title', 'View Inquiry')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.messages.index') }}">Inquiries</a></li>
      <li class="breadcrumb-item active" aria-current="page">View Details</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="row g-4">
    <!-- Story Content Card -->
    <div class="col-lg-8">
      <div class="card border-0 bg-white shadow-sm h-100">
        <div class="card-header bg-transparent border-bottom p-4">
          <h5 class="fw-bold m-0 text-dark">The Client's Memory Story</h5>
        </div>
        <div class="card-body p-4">
          <p class="text-muted small mb-2">Memory shared by client:</p>
          <div class="p-3 bg-light rounded text-dark fs-5" style="white-space: pre-wrap; font-family: var(--bs-font-sans-serif); line-height: 1.6;">
            {{ $message->message }}
          </div>
          
          <div class="mt-4 pt-3 border-top d-flex gap-2">
            @php
              // Construct redirection handoff text
              $lines = [
                  "Hello Storyloom — I'd like to begin a story.",
                  "",
                  "My name: " . ($message->name),
                  "Email: " . ($message->email),
                  "Phone: " . ($message->phone ?: '—'),
                  "The story is for: " . ($message->for),
                  "Occasion: " . ($message->occasion ?: '—'),
                  "When I need it: " . ($message->timeline ?: 'Flexible'),
                  "",
                  "A little about them: " . ($message->message)
              ];
              $msgText = implode("\n", $lines);
              
              $waUrl = "https://wa.me/" . setting('contact_whatsapp', '919999999999') . "?text=" . rawurlencode($msgText);
              $emailUrl = "mailto:" . $message->email . "?subject=" . rawurlencode("Re: Storyloom Inquiry — " . $message->name) . "&body=" . rawurlencode("Hi " . $message->name . ",\n\nThanks for reaching out! We loved reading your memory story. Let's begin...");
            @endphp
            
            <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn btn-success px-3">
              <i class="bi bi-whatsapp me-2"></i>Reply via WhatsApp
            </a>
            <a href="{{ $emailUrl }}" class="btn btn-primary px-3">
              <i class="bi bi-envelope me-2"></i>Reply via Email
            </a>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary">Back to List</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Client Meta Card -->
    <div class="col-lg-4">
      <div class="card border-0 bg-white shadow-sm h-100">
        <div class="card-header bg-transparent border-bottom p-4">
          <h5 class="fw-bold m-0 text-dark">Metadata & Info</h5>
        </div>
        <div class="card-body p-4">
          <ul class="list-group list-group-flush">
            <li class="list-group-item px-0 pt-0 pb-3">
              <span class="text-muted d-block small mb-1">Client Name</span>
              <strong class="text-dark">{{ $message->name }}</strong>
            </li>
            <li class="list-group-item px-0 py-3">
              <span class="text-muted d-block small mb-1">Email Address</span>
              <strong class="text-dark"><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></strong>
            </li>
            <li class="list-group-item px-0 py-3">
              <span class="text-muted d-block small mb-1">Phone Number</span>
              <strong class="text-dark">{{ $message->phone ?: '—' }}</strong>
            </li>
            <li class="list-group-item px-0 py-3">
              <span class="text-muted d-block small mb-1">Book For</span>
              <strong class="text-dark">{{ $message->for }}</strong>
            </li>
            <li class="list-group-item px-0 py-3">
              <span class="text-muted d-block small mb-1">Occasion</span>
              <strong class="text-dark">{{ $message->occasion ?: '—' }}</strong>
            </li>
            <li class="list-group-item px-0 py-3">
              <span class="text-muted d-block small mb-1">Required Timeline</span>
              <strong class="text-dark text-capitalize">{{ $message->timeline ?: 'Flexible' }}</strong>
            </li>
            <li class="list-group-item px-0 py-3">
              <span class="text-muted d-block small mb-1">Handoff channel</span>
              <span class="badge bg-{{ $message->channel === 'whatsapp' ? 'success' : 'primary' }} text-white text-uppercase" style="font-size:0.75rem;">
                {{ $message->channel }}
              </span>
            </li>
            <li class="list-group-item px-0 py-3">
              <span class="text-muted d-block small mb-1">Date Received</span>
              <strong class="text-dark">{{ $message->created_at->format('M d, Y H:i:s') }}</strong>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection
