@extends('layouts.admin')

@section('title', 'Manage Blog Posts')
@section('page_title', 'Blog Posts')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Blog Posts</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-dark">Articles List</h5>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>New Blog Post</a>
  </div>

  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Image</th>
              <th>Post Title / Slug</th>
              <th>Publish Date</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($posts as $post)
              <tr>
                <td>
                  @if($post->featured_image)
                    <img src="{{ asset($post->featured_image) }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                  @else
                    <span class="badge bg-light text-muted">No Image</span>
                  @endif
                </td>
                <td>
                  <div class="fw-semibold text-dark">{{ $post->title }}</div>
                  <div class="text-muted small"><code>{{ $post->slug }}</code></div>
                </td>
                <td>{{ $post->created_at->format('M d, Y') }}</td>
                <td>
                  <span class="badge bg-{{ $post->status ? 'success' : 'secondary' }}">
                    {{ $post->status ? 'Published' : 'Draft' }}
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">No blog posts found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $posts->links() }}
      </div>
    </div>
  </div>
@endsection
