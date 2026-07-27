@extends('layouts.admin')

@section('title', 'Manage Pricing Plans')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Pricing Plans</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pricing</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.pricing.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add Plan
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Plan Name</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Features List</th>
                        <th>Popular</th>
                        <th>Status</th>
                        <th class="text-end pe-3" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr>
                            <td class="ps-3 fw-semibold text-dark">{{ $plan->plan_name }}</td>
                            <td>₹{{ number_format($plan->price, 2) }}</td>
                            <td>{{ $plan->duration }}</td>
                            <td>
                                @if($plan->features)
                                    <ul class="mb-0 small ps-3">
                                        @foreach($plan->features as $feat)
                                            <li>{{ $feat }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->popular_plan)
                                    <span class="badge bg-warning-subtle text-warning py-1 px-2">Popular</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $plan->status === 'active' ? 'success' : 'secondary' }}-subtle text-{{ $plan->status === 'active' ? 'success' : 'secondary' }} py-1 px-2.5">
                                    {{ ucfirst($plan->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.pricing.edit', $plan) }}" class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.pricing.destroy', $plan) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this pricing plan?');">
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
                            <td colspan="7" class="text-center py-4 text-muted">No pricing plans found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($plans->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $plans->links() }}
        </div>
    @endif
</div>
@endsection
