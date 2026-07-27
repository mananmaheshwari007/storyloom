@extends('layouts.admin')

@section('title', 'Manage FAQs')
@section('page_title', 'FAQ Catalog')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">FAQs</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-dark">FAQs List</h5>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add FAQ</a>
  </div>

  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Question</th>
              <th>Category</th>
              <th>Display Order</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($faqs as $faq)
              <tr>
                <td>
                  <div class="fw-semibold text-dark">{{ $faq->question }}</div>
                  <div class="text-muted small text-truncate" style="max-width: 400px;">{{ $faq->answer }}</div>
                </td>
                <td><span class="badge bg-light text-dark border text-capitalize">{{ $faq->category }}</span></td>
                <td>{{ $faq->display_order }}</td>
                <td>
                  <span class="badge bg-{{ $faq->status ? 'success' : 'secondary' }}">
                    {{ $faq->status ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this FAQ?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">No FAQs found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $faqs->links() }}
      </div>
    </div>
  </div>
@endsection
