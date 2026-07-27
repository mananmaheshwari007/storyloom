@extends('layouts.admin')

@section('title', 'Manage Pricing Plans')
@section('page_title', 'Pricing Plans')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Pricing Plans</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-dark">Pricing Plans List</h5>
    <a href="{{ route('admin.pricing.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add Plan</a>
  </div>

  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Tier Name</th>
              <th>Base Price</th>
              <th>Duration</th>
              <th>Features</th>
              <th>Popular / Featured</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($plans as $plan)
              <tr>
                <td><div class="fw-semibold text-dark">{{ $plan->name }}</div></td>
                <td><div class="fw-bold text-dark">₹{{ number_format($plan->price, 0) }}</div></td>
                <td>{{ $plan->duration }}</td>
                <td>
                  @if(!empty($plan->features))
                    <span class="badge bg-light text-dark border">{{ count($plan->features) }} Features</span>
                  @else
                    <span class="text-muted small">No Features</span>
                  @endif
                </td>
                <td>
                  <span class="badge bg-{{ $plan->popular ? 'warning text-dark' : 'light text-muted border' }}">
                    {{ $plan->popular ? 'Popular' : 'Standard' }}
                  </span>
                </td>
                <td>
                  <span class="badge bg-{{ $plan->status ? 'success' : 'secondary' }}">
                    {{ $plan->status ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.pricing.edit', $plan->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.pricing.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this pricing plan?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">No pricing plans found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $plans->links() }}
      </div>
    </div>
  </div>
@endsection
