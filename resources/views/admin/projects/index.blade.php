@extends('layouts.admin')

@section('title', 'Manage Keepsake Books')
@section('page_title', 'Featured Projects')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Projects</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-dark">Projects List</h5>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add Project Book</a>
  </div>

  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Cover</th>
              <th>Book Title / Slug</th>
              <th>Relationship Category</th>
              <th>Client</th>
              <th>Featured</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($projects as $project)
              <tr>
                <td>
                  <img src="{{ asset($project->image) }}" class="rounded shadow-sm" style="width: 50px; height: 65px; object-fit: cover;" alt="">
                </td>
                <td>
                  <div class="fw-semibold text-dark">{{ $project->title }}</div>
                  <div class="text-muted small"><code>{{ $project->slug }}</code></div>
                </td>
                <td><span class="badge bg-light text-dark border">{{ $project->category }}</span></td>
                <td>{{ $project->client_name ?: '—' }}</td>
                <td>
                  <span class="badge bg-{{ $project->featured ? 'warning text-dark' : 'light text-muted border' }}">
                    {{ $project->featured ? 'Featured' : 'Standard' }}
                  </span>
                </td>
                <td>
                  <span class="badge bg-{{ $project->status ? 'success' : 'secondary' }}">
                    {{ $project->status ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">No projects found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $projects->links() }}
      </div>
    </div>
  </div>
@endsection
