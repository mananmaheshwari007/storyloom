@extends('layouts.admin')

@section('title', 'Manage Shelf Portfolio')
@section('page_title', 'Portfolio Items')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Portfolio Shelf</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-dark">Portfolio List</h5>
    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add Shelf Item</a>
  </div>

  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Thumbnail</th>
              <th>Title</th>
              <th>Category</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($portfolios as $item)
              <tr>
                <td>
                  <img src="{{ asset($item->thumbnail) }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                </td>
                <td>
                  <div class="fw-semibold text-dark">{{ $item->title }}</div>
                  <div class="text-muted small" style="max-width: 300px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $item->description }}</div>
                </td>
                <td><span class="badge bg-light text-dark border">{{ $item->category }}</span></td>
                <td>
                  <span class="badge bg-{{ $item->status ? 'success' : 'secondary' }}">
                    {{ $item->status ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.portfolio.edit', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.portfolio.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this portfolio shelf item?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">No portfolio shelf items found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $portfolios->links() }}
      </div>
    </div>
  </div>
@endsection
