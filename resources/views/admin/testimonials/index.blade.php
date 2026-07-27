@extends('layouts.admin')

@section('title', 'Manage Testimonials')
@section('page_title', 'Client Testimonials')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-dark">Testimonials List</h5>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add Testimonial</a>
  </div>

  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Client Avatar</th>
              <th>Client Name / Designation</th>
              <th>Review Snippet</th>
              <th>Rating</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($testimonials as $t)
              <tr>
                <td>
                  <img src="{{ asset($t->image ?: 'assets/img/logo-emblem.png') }}" class="rounded-circle shadow-sm" style="width: 45px; height: 45px; object-fit: cover;" alt="">
                </td>
                <td>
                  <div class="fw-semibold text-dark">{{ $t->client_name }}</div>
                  <div class="text-muted small">{{ $t->designation }} {{ $t->company ? '· ' . $t->company : '' }}</div>
                </td>
                <td><div class="text-muted small text-truncate" style="max-width: 350px;">{{ $t->review }}</div></td>
                <td>
                  <span class="text-warning fw-bold">
                    @for($i = 0; $i < $t->rating; $i++)
                      ★
                    @endfor
                  </span>
                </td>
                <td>
                  <span class="badge bg-{{ $t->status ? 'success' : 'secondary' }}">
                    {{ $t->status ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-4">No testimonials found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $testimonials->links() }}
      </div>
    </div>
  </div>
@endsection
