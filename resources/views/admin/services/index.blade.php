@extends('layouts.admin')

@section('title', 'Manage Services')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Services & Occasions</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Services</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add Service
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 80px;">Order</th>
                        <th>Service / Occasion Title</th>
                        <th>Description</th>
                        <th>Icon Name</th>
                        <th>Status</th>
                        <th class="text-end pe-3" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $service->display_order }}</td>
                            <td>
                                <div class="fw-medium text-dark">{{ $service->title }}</div>
                                @if($service->image)
                                    <small class="text-muted"><i class="bi bi-image me-1"></i> Has Image</small>
                                @endif
                            </td>
                            <td>{{ Str::limit($service->description, 60) }}</td>
                            <td><code>{{ $service->icon }}</code></td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $service->status === 'active' ? 'success' : 'secondary' }}-subtle text-{{ $service->status === 'active' ? 'success' : 'secondary' }} py-1 px-2.5">
                                    {{ ucfirst($service->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">No services found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($services->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $services->links() }}
        </div>
    @endif
</div>
@endsection
