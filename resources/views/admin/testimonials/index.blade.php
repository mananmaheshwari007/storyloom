@extends('layouts.admin')

@section('title', 'Manage Testimonials')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Client Testimonials</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add Testimonial
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 80px;">Client Image</th>
                        <th>Client Name</th>
                        <th>Relationship / Designation</th>
                        <th>Review Quote</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th class="text-end pe-3" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $test)
                        <tr>
                            <td class="ps-3">
                                <div class="border rounded bg-white overflow-hidden text-center" style="width: 50px; height: 50px;">
                                    @if($test->image)
                                        <img src="{{ asset($test->image) }}" alt="Avatar" style="max-height: 100%; max-width: 100%; object-fit: cover;">
                                    @else
                                        <i class="bi bi-person text-muted fs-4"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="fw-semibold text-dark">{{ $test->client_name }}</td>
                            <td>{{ $test->designation }}</td>
                            <td class="text-muted">{{ Str::limit($test->review, 60) }}</td>
                            <td>
                                @for($i = 0; $i < $test->rating; $i++)
                                    <i class="bi bi-star-fill text-warning" style="font-size: 0.85rem;"></i>
                                @endfor
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $test->status === 'active' ? 'success' : 'secondary' }}-subtle text-{{ $test->status === 'active' ? 'success' : 'secondary' }} py-1 px-2.5">
                                    {{ ucfirst($test->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.testimonials.edit', $test) }}" class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.testimonials.destroy', $test) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No testimonials found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($testimonials->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $testimonials->links() }}
        </div>
    @endif
</div>
@endsection
