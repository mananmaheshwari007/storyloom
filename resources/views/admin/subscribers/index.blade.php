@extends('layouts.admin')

@section('title', 'Manage Newsletter Subscribers')
@section('page_title', 'Newsletter Subscribers')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Subscribers</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-dark">Subscribers List</h5>
    <a href="{{ route('admin.subscribers.export') }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel me-1"></i>Export to CSV</a>
  </div>

  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Subscriber ID</th>
              <th>Email Address</th>
              <th>Date Subscribed</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($subscribers as $sub)
              <tr>
                <td><code>#{{ $sub->id }}</code></td>
                <td><div class="fw-semibold text-dark">{{ $sub->email }}</div></td>
                <td>{{ $sub->created_at->format('M d, Y H:i:s') }}</td>
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-2">
                    <form action="{{ route('admin.subscribers.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this subscriber?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center text-muted py-4">No subscribers found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $subscribers->links() }}
      </div>
    </div>
  </div>
@endsection
