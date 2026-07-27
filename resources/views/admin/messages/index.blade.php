@extends('layouts.admin')

@section('title', 'Manage Inquiries')
@section('page_title', 'Customer Inquiries')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Inquiries</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Client Contact</th>
              <th>Story For</th>
              <th>Occasion</th>
              <th>Timeline</th>
              <th>Channel Choice</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($messages as $msg)
              <tr class="{{ $msg->is_read ? 'text-muted' : 'table-light fw-bold text-dark' }}">
                <td>
                  <div>{{ $msg->name }}</div>
                  <div class="text-muted small" style="font-size:0.8rem;">
                    {{ $msg->email }} @if($msg->phone) · {{ $msg->phone }} @endif
                  </div>
                </td>
                <td>{{ $msg->for }}</td>
                <td>{{ $msg->occasion ?: '—' }}</td>
                <td>{{ $msg->timeline ?: 'Flexible' }}</td>
                <td>
                  <span class="badge bg-{{ $msg->channel === 'whatsapp' ? 'success' : 'primary' }} text-white text-uppercase" style="font-size:0.7rem;">
                    {{ $msg->channel }}
                  </span>
                </td>
                <td>
                  <span class="badge bg-{{ $msg->is_read ? 'secondary' : 'danger' }}" style="font-size:0.7rem;">
                    {{ $msg->is_read ? 'Read' : 'Unread' }}
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.messages.show', $msg->id) }}" class="btn btn-sm btn-outline-primary" title="View Story"><i class="bi bi-eye"></i></a>
                    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this log?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">No inquiries found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $messages->links() }}
      </div>
    </div>
  </div>
@endsection
