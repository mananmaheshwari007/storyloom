@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
  </nav>
@endsection

@section('content')
  <!-- Statistics Cards -->
  <div class="row g-4 mb-4">
    <!-- Projects -->
    <div class="col-6 col-lg-3">
      <div class="card p-3 border-0 bg-white d-flex flex-row align-items-center">
        <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-3 me-3">
          <i class="bi bi-journal-bookmark fs-3"></i>
        </div>
        <div>
          <h3 class="m-0 fw-bold">{{ $stats['projects'] }}</h3>
          <span class="text-muted fs-7">Projects (Books)</span>
        </div>
      </div>
    </div>
    <!-- Products -->
    <div class="col-6 col-lg-3">
      <div class="card p-3 border-0 bg-white d-flex flex-row align-items-center">
        <div class="rounded-3 bg-success bg-opacity-10 text-success p-3 me-3">
          <i class="bi bi-cart3 fs-3"></i>
        </div>
        <div>
          <h3 class="m-0 fw-bold">{{ $stats['products'] }}</h3>
          <span class="text-muted fs-7">Book Editions</span>
        </div>
      </div>
    </div>
    <!-- Inquiries -->
    <div class="col-6 col-lg-3">
      <div class="card p-3 border-0 bg-white d-flex flex-row align-items-center">
        <div class="rounded-3 bg-danger bg-opacity-10 text-danger p-3 me-3">
          <i class="bi bi-envelope fs-3"></i>
        </div>
        <div>
          <h3 class="m-0 fw-bold">{{ $stats['unread_messages'] }}</h3>
          <span class="text-muted fs-7">Unread Inquiries</span>
        </div>
      </div>
    </div>
    <!-- Newsletter -->
    <div class="col-6 col-lg-3">
      <div class="card p-3 border-0 bg-white d-flex flex-row align-items-center">
        <div class="rounded-3 bg-warning bg-opacity-10 text-warning p-3 me-3">
          <i class="bi bi-envelope-check fs-3"></i>
        </div>
        <div>
          <h3 class="m-0 fw-bold">{{ $stats['subscribers'] }}</h3>
          <span class="text-muted fs-7">Newsletter Subs</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <!-- FAQs -->
    <div class="col-6 col-lg-3">
      <div class="card p-3 border-0 bg-white d-flex flex-row align-items-center">
        <div class="rounded-3 bg-info bg-opacity-10 text-info p-3 me-3">
          <i class="bi bi-question-circle fs-3"></i>
        </div>
        <div>
          <h3 class="m-0 fw-bold">{{ $stats['faqs'] }}</h3>
          <span class="text-muted fs-7">FAQs</span>
        </div>
      </div>
    </div>
    <!-- Testimonials -->
    <div class="col-6 col-lg-3">
      <div class="card p-3 border-0 bg-white d-flex flex-row align-items-center">
        <div class="rounded-3 bg-secondary bg-opacity-10 text-secondary p-3 me-3">
          <i class="bi bi-chat-quote fs-3"></i>
        </div>
        <div>
          <h3 class="m-0 fw-bold">{{ $stats['testimonials'] }}</h3>
          <span class="text-muted fs-7">Testimonials</span>
        </div>
      </div>
    </div>
    <!-- Services -->
    <div class="col-6 col-lg-3">
      <div class="card p-3 border-0 bg-white d-flex flex-row align-items-center">
        <div class="rounded-3 bg-dark bg-opacity-10 text-dark p-3 me-3">
          <i class="bi bi-briefcase fs-3"></i>
        </div>
        <div>
          <h3 class="m-0 fw-bold">{{ $stats['services'] }}</h3>
          <span class="text-muted fs-7">Services</span>
        </div>
      </div>
    </div>
    <!-- Blog posts -->
    <div class="col-6 col-lg-3">
      <div class="card p-3 border-0 bg-white d-flex flex-row align-items-center">
        <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-3 me-3">
          <i class="bi bi-newspaper fs-3"></i>
        </div>
        <div>
          <h3 class="m-0 fw-bold">{{ $stats['blog_posts'] }}</h3>
          <span class="text-muted fs-7">Blog Posts</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Activities Lists -->
  <div class="row g-4">
    <!-- Messages Inquiries -->
    <div class="col-12 col-xl-6">
      <div class="card border-0 bg-white h-100">
        <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3 px-4">
          <h5 class="fw-bold m-0 text-dark">Recent Inquiries</h5>
          <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-primary py-1">View All</a>
        </div>
        <div class="card-body px-4 pb-3">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th>Client</th>
                  <th>For</th>
                  <th>Occasion</th>
                  <th>Channel</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentMessages as $msg)
                  <tr>
                    <td>
                      <div class="fw-semibold">{{ $msg->name }}</div>
                      <div class="text-muted small" style="font-size: 0.8rem;">{{ $msg->email }}</div>
                    </td>
                    <td>{{ $msg->for }}</td>
                    <td>{{ $msg->occasion ?: '—' }}</td>
                    <td>
                      <span class="badge bg-{{ $msg->channel === 'whatsapp' ? 'success' : 'primary' }} text-white text-uppercase" style="font-size: 0.7rem;">
                        {{ $msg->channel }}
                      </span>
                    </td>
                    <td>
                      <span class="badge bg-{{ $msg->is_read ? 'secondary' : 'danger' }}" style="font-size: 0.7rem;">
                        {{ $msg->is_read ? 'Read' : 'Unread' }}
                      </span>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center text-muted py-4">No recent inquiries found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Projects & Quick Links -->
    <div class="col-12 col-xl-6">
      <div class="card border-0 bg-white mb-4">
        <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3 px-4">
          <h5 class="fw-bold m-0 text-dark">Recent Projects (Books)</h5>
          <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-primary py-1">View All</a>
        </div>
        <div class="card-body px-4 pb-3">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Client</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentProjects as $project)
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <img src="{{ asset($project->image) }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;" alt="">
                        <div class="fw-semibold">{{ $project->title }}</div>
                      </div>
                    </td>
                    <td>{{ $project->client_name ?: '—' }}</td>
                    <td>
                      <span class="badge bg-{{ $project->status ? 'success' : 'secondary' }}" style="font-size: 0.7rem;">
                        {{ $project->status ? 'Active' : 'Inactive' }}
                      </span>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center text-muted py-4">No recent projects found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
      <!-- Quick Links Widgets -->
      <div class="card border-0 bg-white">
        <div class="card-body p-4">
          <h5 class="fw-bold text-dark mb-3">Quick Actions</h5>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.settings') }}" class="btn btn-light"><i class="bi bi-gear me-2 text-primary"></i>Update Brand Settings</a>
            <a href="{{ route('admin.media') }}" class="btn btn-light"><i class="bi bi-images me-2 text-success"></i>Browse Media File Library</a>
            <a href="{{ route('admin.blog.create') }}" class="btn btn-light"><i class="bi bi-pencil-square me-2 text-info"></i>Write Blog Post</a>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-light"><i class="bi bi-plus-circle me-2 text-danger"></i>Add Keepsake Book</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
