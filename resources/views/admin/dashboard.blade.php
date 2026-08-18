@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<!-- ================= EXECUTIVE HEADER ================= -->
<div class="card border-0 shadow-sm rounded-3 mb-4 p-4" style="background-color: #1C222B !important; color: #ffffff !important;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-warning text-dark font-monospace px-2.5 py-1 fw-bold" style="letter-spacing: 0.5px;">STORYLOOM CMS</span>
                <span class="small" style="color: rgba(255, 255, 255, 0.7) !important;"><i class="bi bi-clock me-1"></i> {{ date('F j, Y') }}</span>
            </div>
            <h2 class="fw-bold mb-1" style="color: #ffffff !important;">Welcome back to Command Center</h2>
            <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.75) !important;">Manage your library books, journal posts, customer inquiries, and brand settings from one place.</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-light d-inline-flex align-items-center">
                <i class="bi bi-box-arrow-up-right me-1.5"></i> View Site
            </a>
            
            <form action="{{ Route::has('admin.clear-cache') ? route('admin.clear-cache') : url('admin/clear-cache') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-warning text-dark fw-semibold d-inline-flex align-items-center">
                    <i class="bi bi-arrow-repeat me-1.5"></i> Clear Cache
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Action Launch Bar -->
    <div class="mt-4 pt-3 border-top border-secondary border-opacity-50 d-flex flex-wrap align-items-center gap-2">
        <span class="me-2 small fw-bold text-uppercase" style="color: rgba(255, 255, 255, 0.6) !important; letter-spacing: 0.05em; font-size: 0.75rem;">Quick Launch:</span>
        
        @if(Route::has('admin.library.create'))
            <a href="{{ route('admin.library.create') }}" class="btn btn-sm btn-light text-dark fw-medium px-3">
                <i class="bi bi-journal-plus text-primary me-1"></i> + New Library Book
            </a>
        @elseif(Route::has('admin.library.index'))
            <a href="{{ route('admin.library.index') }}" class="btn btn-sm btn-light text-dark fw-medium px-3">
                <i class="bi bi-journal-plus text-primary me-1"></i> Library Books
            </a>
        @endif

        @if(Route::has('admin.blog.create'))
            <a href="{{ route('admin.blog.create') }}" class="btn btn-sm btn-light text-dark fw-medium px-3">
                <i class="bi bi-pencil-square text-success me-1"></i> + Write Journal Article
            </a>
        @elseif(Route::has('admin.blog.index'))
            <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-light text-dark fw-medium px-3">
                <i class="bi bi-pencil-square text-success me-1"></i> Journal Posts
            </a>
        @endif

        @if(Route::has('admin.hero.edit'))
            <a href="{{ route('admin.hero.edit') }}" class="btn btn-sm btn-secondary text-white border-secondary fw-medium px-3">
                <i class="bi bi-window-sidebar text-warning me-1"></i> Hero Banners
            </a>
        @endif

        @if(Route::has('admin.settings.index'))
            <a href="{{ route('admin.settings.index') }}" class="btn btn-sm btn-secondary text-white border-secondary fw-medium px-3">
                <i class="bi bi-sliders text-info me-1"></i> Site Settings
            </a>
        @endif
    </div>
</div>

<!-- ================= KPI METRIC CARDS GRID ================= -->
<div class="row g-3 mb-4">
    <!-- Library Books -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-left: 4px solid #b55b29 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Library Books</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['total_books'] }}</h3>
                </div>
                <div class="rounded-circle bg-warning-subtle p-2 text-warning d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-book fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                <span class="badge bg-success-subtle text-success" style="font-size: 0.7rem;">{{ $stats['published_books'] }} Published</span>
                <a href="{{ Route::has('admin.library.index') ? route('admin.library.index') : '#' }}" class="text-decoration-none text-muted small fw-medium">View &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Journal Posts -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-left: 4px solid #0d6efd !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Journal Posts</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['total_blogs'] }}</h3>
                </div>
                <div class="rounded-circle bg-primary-subtle p-2 text-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-newspaper fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                <span class="badge bg-primary-subtle text-primary" style="font-size: 0.7rem;">{{ $stats['published_blogs'] }} Live</span>
                <a href="{{ Route::has('admin.blog.index') ? route('admin.blog.index') : '#' }}" class="text-decoration-none text-muted small fw-medium">Manage &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Unread Messages -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-left: 4px solid #dc3545 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Inquiries</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['unread_messages'] }}</h3>
                </div>
                <div class="rounded-circle bg-danger-subtle p-2 text-danger d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-envelope-exclamation fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                @if($stats['unread_messages'] > 0)
                    <span class="badge bg-danger text-white pulse" style="font-size: 0.7rem;">{{ $stats['unread_messages'] }} Unread</span>
                @else
                    <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.7rem;">All Read</span>
                @endif
                <a href="{{ Route::has('admin.messages.index') ? route('admin.messages.index') : '#' }}" class="text-decoration-none text-muted small fw-medium">Inbox &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Newsletter Subscribers -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-left: 4px solid #198754 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Subscribers</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['total_subscribers'] }}</h3>
                </div>
                <div class="rounded-circle bg-success-subtle p-2 text-success d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-people fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                <span class="text-muted" style="font-size: 0.7rem;">Leads List</span>
                <a href="{{ Route::has('admin.newsletter.index') ? route('admin.newsletter.index') : '#' }}" class="text-decoration-none text-muted small fw-medium">Leads &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-left: 4px solid #ffc107 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Testimonials</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['total_testimonials'] }}</h3>
                </div>
                <div class="rounded-circle bg-warning-subtle p-2 text-warning d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-star fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                <span class="text-muted" style="font-size: 0.7rem;">Reviews</span>
                <a href="{{ Route::has('admin.testimonials.index') ? route('admin.testimonials.index') : '#' }}" class="text-decoration-none text-muted small fw-medium">View &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Analytics & Verification -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-left: 4px solid #0dcaf0 !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Google Analytics</span>
                    <h6 class="fw-bold text-dark mb-0 mt-1" style="font-size: 0.85rem;">{{ $stats['ga_id'] }}</h6>
                </div>
                <div class="rounded-circle bg-info-subtle p-2 text-info d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-graph-up-arrow fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                <span class="badge bg-success-subtle text-success" style="font-size: 0.7rem;"><i class="bi bi-check2-circle"></i> Active</span>
                <a href="{{ Route::has('admin.settings.index') ? route('admin.settings.index') : '#' }}" class="text-decoration-none text-muted small fw-medium">Config &rarr;</a>
            </div>
        </div>
    </div>
</div>

<!-- ================= MAIN WORKSPACE GRID ================= -->
<div class="row g-4">
    <!-- Left Column: Messages & Library Books -->
    <div class="col-lg-7">
        
        <!-- Recent Messages / Inquiries -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0 text-dark d-inline-flex align-items-center">
                        <i class="bi bi-envelope me-2 text-danger"></i> Recent Customer Inquiries
                    </h5>
                    <span class="badge bg-danger-subtle text-danger ms-2" style="font-size: 0.75rem;">{{ $stats['unread_messages'] }} Unread</span>
                </div>
                @if(Route::has('admin.messages.index'))
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-primary fw-medium">View All Inbox</a>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light small text-uppercase text-muted">
                            <tr>
                                <th class="ps-3">Sender</th>
                                <th>Subject</th>
                                <th>Received</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_messages as $message)
                                <tr @if(!$message->is_read) class="fw-semibold bg-light-subtle" @endif>
                                    <td class="ps-3 py-3">
                                        <div class="text-dark">{{ $message->name }}</div>
                                        <small class="text-muted">{{ $message->email }}</small>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ Str::limit($message->subject ?? 'General Inquiry', 30) }}</span>
                                        @if(!$message->is_read)
                                            <span class="badge bg-danger ms-1" style="font-size: 0.65rem;">NEW</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">{{ $message->created_at->format('M d, g:i A') }}</td>
                                    <td class="text-end pe-3">
                                        @if(Route::has('admin.messages.show'))
                                            <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-outline-secondary py-1 px-2.5">
                                                <i class="bi bi-eye me-1"></i> Read
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No recent inquiries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Library Books Showcase -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-inline-flex align-items-center">
                    <i class="bi bi-book-half me-2 text-warning"></i> Recent Library Books
                </h5>
                @if(Route::has('admin.library.index'))
                    <a href="{{ route('admin.library.index') }}" class="btn btn-sm btn-outline-warning text-dark fw-medium">Manage Library</a>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light small text-uppercase text-muted">
                            <tr>
                                <th class="ps-3">Book Cover & Title</th>
                                <th>Category / Tag</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_books as $book)
                                <tr>
                                    <td class="ps-3 py-2.5">
                                        <div class="d-flex align-items-center gap-3">
                                            @if(!empty($book->cover_image))
                                                <img src="{{ asset($book->cover_image) }}" alt="Cover" class="rounded shadow-sm object-fit-cover" width="40" height="56">
                                            @else
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center text-muted" style="width: 40px; height: 56px;">
                                                    <i class="bi bi-journal"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $book->title }}</div>
                                                <small class="text-muted">{{ Str::limit($book->subtitle, 35) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $book->relation_tag ?? $book->occasion_tag ?? 'Library Book' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{ $book->status === 'published' ? 'success' : 'secondary' }}-subtle text-{{ $book->status === 'published' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($book->status ?? 'published') }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        @if(Route::has('admin.library.edit'))
                                            <a href="{{ route('admin.library.edit', $book) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        @elseif(Route::has('admin.library.index'))
                                            <a href="{{ route('admin.library.index') }}" class="btn btn-sm btn-outline-secondary">View</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No library books found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column: Shortcuts, Journal & Subscribers -->
    <div class="col-lg-5">
        
        <!-- Quick Management Shortcuts Panel -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-grid-fill me-2 text-primary"></i> Site Management Hub</h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ Route::has('admin.hero.edit') ? route('admin.hero.edit') : '#' }}" class="btn btn-light border w-100 text-start p-2.5 d-flex align-items-center gap-2">
                            <i class="bi bi-window-sidebar fs-5 text-warning"></i>
                            <div>
                                <div class="fw-bold text-dark small">Hero Banners</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Homepage headers</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ Route::has('admin.library.index') ? route('admin.library.index') : '#' }}" class="btn btn-light border w-100 text-start p-2.5 d-flex align-items-center gap-2">
                            <i class="bi bi-book fs-5 text-primary"></i>
                            <div>
                                <div class="fw-bold text-dark small">Library CMS</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Books & Spreads</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ Route::has('admin.settings.index') ? route('admin.settings.index') : '#' }}" class="btn btn-light border w-100 text-start p-2.5 d-flex align-items-center gap-2">
                            <i class="bi bi-sliders fs-5 text-info"></i>
                            <div>
                                <div class="fw-bold text-dark small">Site Branding</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Logo, GA, Favicon</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ Route::has('admin.blog.index') ? route('admin.blog.index') : '#' }}" class="btn btn-light border w-100 text-start p-2.5 d-flex align-items-center gap-2">
                            <i class="bi bi-newspaper fs-5 text-success"></i>
                            <div>
                                <div class="fw-bold text-dark small">Journal Articles</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Blog & Stories</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ Route::has('admin.faqs.index') ? route('admin.faqs.index') : '#' }}" class="btn btn-light border w-100 text-start p-2.5 d-flex align-items-center gap-2">
                            <i class="bi bi-question-circle fs-5 text-danger"></i>
                            <div>
                                <div class="fw-bold text-dark small">FAQs & Info</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Questions</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ Route::has('admin.testimonials.index') ? route('admin.testimonials.index') : '#' }}" class="btn btn-light border w-100 text-start p-2.5 d-flex align-items-center gap-2">
                            <i class="bi bi-star fs-5 text-warning"></i>
                            <div>
                                <div class="fw-bold text-dark small">Testimonials</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Reviews & Quotes</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Blog Posts -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-text me-2 text-info"></i> Recent Journal Posts</h5>
                @if(Route::has('admin.blog.index'))
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-link text-decoration-none p-0">View All</a>
                @endif
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($latest_blogs as $blog)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2.5 px-3">
                            <div>
                                @if(Route::has('admin.blog.edit'))
                                    <a href="{{ route('admin.blog.edit', $blog) }}" class="text-decoration-none fw-medium text-dark">
                                        {{ Str::limit($blog->title, 34) }}
                                    </a>
                                @else
                                    <span class="fw-medium text-dark">{{ Str::limit($blog->title, 34) }}</span>
                                @endif
                                <div class="text-muted small">{{ $blog->created_at->format('M d, Y') }}</div>
                            </div>
                            <span class="badge rounded-pill bg-{{ $blog->status === 'published' ? 'success' : 'secondary' }}-subtle text-{{ $blog->status === 'published' ? 'success' : 'secondary' }}">
                                {{ ucfirst($blog->status) }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4 text-muted">No journal posts found.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Newsletter Subscribers -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-mailbox me-2 text-success"></i> Newsletter Leads</h5>
                @if(Route::has('admin.newsletter.export'))
                    <a href="{{ route('admin.newsletter.export') }}" class="btn btn-sm btn-outline-success">Export CSV</a>
                @endif
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($latest_subscribers as $subscriber)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2.5 px-3">
                            <span class="text-dark font-monospace small">{{ $subscriber->email }}</span>
                            <span class="text-muted small">{{ $subscriber->created_at->format('M d') }}</span>
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
