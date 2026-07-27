@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard Overview</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
</div>

<!-- Stats Grid -->
<div class="row g-4 mb-5">
    <!-- Projects Card -->
    <div class="col-md-3 col-sm-6">
        <div class="card h-100 p-3 border-start border-primary border-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.8rem; letter-spacing: 0.5px;">Projects</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_projects'] }}</h3>
                </div>
                <div class="rounded-circle bg-primary-subtle p-3 text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-kanban fs-4"></i>
                </div>
            </div>
            <a href="{{ route('admin.projects.index') }}" class="text-decoration-none text-primary mt-3 d-inline-flex align-items-center" style="font-size: 0.85rem;">
                Manage Projects <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Products Card -->
    <div class="col-md-3 col-sm-6">
        <div class="card h-100 p-3 border-start border-success border-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.8rem; letter-spacing: 0.5px;">Packages</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_products'] }}</h3>
                </div>
                <div class="rounded-circle bg-success-subtle p-3 text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-bag fs-4"></i>
                </div>
            </div>
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-success mt-3 d-inline-flex align-items-center" style="font-size: 0.85rem;">
                Manage Packages <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <!-- FAQs Card -->
    <div class="col-md-3 col-sm-6">
        <div class="card h-100 p-3 border-start border-info border-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.8rem; letter-spacing: 0.5px;">FAQs</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_faqs'] }}</h3>
                </div>
                <div class="rounded-circle bg-info-subtle p-3 text-info d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-question-circle fs-4"></i>
                </div>
            </div>
            <a href="{{ route('admin.faqs.index') }}" class="text-decoration-none text-info mt-3 d-inline-flex align-items-center" style="font-size: 0.85rem;">
                Manage FAQs <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Unread Messages Card -->
    <div class="col-md-3 col-sm-6">
        <div class="card h-100 p-3 border-start border-danger border-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.8rem; letter-spacing: 0.5px;">Unread Messages</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['unread_messages'] }}</h3>
                </div>
                <div class="rounded-circle bg-danger-subtle p-3 text-danger d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-envelope-open fs-4"></i>
                </div>
            </div>
            <a href="{{ route('admin.messages.index') }}" class="text-decoration-none text-danger mt-3 d-inline-flex align-items-center" style="font-size: 0.85rem;">
                View Inbox <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Messages and Projects -->
    <div class="col-lg-7">
        <!-- Messages Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-envelope me-2 text-primary"></i> Recent Messages</h5>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-link text-decoration-none p-0 text-primary" style="font-size: 0.85rem;">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Sender</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_messages as $message)
                                <tr @if(!$message->is_read) class="fw-bold bg-light-subtle" @endif>
                                    <td class="ps-3">
                                        <div>{{ $message->name }}</div>
                                        <small class="text-muted text-wrap">{{ $message->email }}</small>
                                    </td>
                                    <td>{{ Str::limit($message->subject, 24) }}</td>
                                    <td>{{ $message->created_at->format('M d, Y') }}</td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 0.8rem;">
                                            <i class="bi bi-eye"></i> Read
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No recent messages.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Projects Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-kanban me-2 text-success"></i> Recent Projects</h5>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-link text-decoration-none p-0 text-success" style="font-size: 0.85rem;">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Project Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_projects as $project)
                                <tr>
                                    <td class="ps-3 fw-medium text-dark">{{ $project->title }}</td>
                                    <td>{{ $project->category }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{ $project->status === 'published' ? 'success' : 'secondary' }}-subtle text-{{ $project->status === 'published' ? 'success' : 'secondary' }} py-1 px-2">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3 text-muted" style="font-size: 0.85rem;">{{ $project->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No recent projects.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Blogs and Subscribers -->
    <div class="col-lg-5">
        <!-- Blogs Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-newspaper me-2 text-warning"></i> Recent Blog Posts</h5>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-link text-decoration-none p-0 text-warning" style="font-size: 0.85rem;">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Title</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_blogs as $blog)
                                <tr>
                                    <td class="ps-3 fw-medium text-dark">{{ Str::limit($blog->title, 30) }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{ $blog->status === 'published' ? 'success' : 'secondary' }}-subtle text-{{ $blog->status === 'published' ? 'success' : 'secondary' }} py-1 px-2">
                                            {{ ucfirst($blog->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3 text-muted" style="font-size: 0.85rem;">{{ $blog->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No blog posts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Newsletter Subscribers Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-mailbox me-2 text-info"></i> Newsletter Subscribers</h5>
                <a href="{{ route('admin.newsletter.index') }}" class="btn btn-link text-decoration-none p-0 text-info" style="font-size: 0.85rem;">View All</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($latest_subscribers as $subscriber)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2.5 px-3">
                            <span class="text-dark">{{ $subscriber->email }}</span>
                            <span class="text-muted" style="font-size: 0.82rem;">{{ $subscriber->created_at->format('M d') }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4 text-muted">No subscribers yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
