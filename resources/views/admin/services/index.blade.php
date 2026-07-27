@extends('layouts.admin')

@section('title', 'Manage Services')
@section('page_title', 'Services')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Services</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-dark">Services List</h5>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add Service</a>
  </div>

  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Image</th>
              <th>Title</th>
              <th>Icon (SVG/Class)</th>
              <th>Display Order</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($services as $service)
              <tr>
                <td>
                  @if($service->image)
                    <img src="{{ asset($service->image) }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                  @else
                    <span class="badge bg-light text-muted">No Image</span>
                  @endif
                </td>
                <td>
                  <div class="fw-semibold text-dark">{{ $service->title }}</div>
                  <div class="text-muted small" style="max-width: 300px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $service->description }}</div>
                </td>
                <td><code>{{ $service->icon }}</code></td>
                <td>{{ $service->display_order }}</td>
                <td>
                  <span class="badge bg-{{ $service->status ? 'success' : 'secondary' }}">
                    {{ $service->status ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-4">No services found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $services->links() }}
      </div>
    </div>
  </div>
@endsection
