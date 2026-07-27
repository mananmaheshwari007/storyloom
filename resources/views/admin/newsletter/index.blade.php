@extends('layouts.admin')

@section('title', 'Newsletter Subscribers')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Newsletter Subscribers</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Newsletter</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.newsletter.export') }}" class="btn btn-success">
        <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export to CSV
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 80px;">ID</th>
                        <th>Subscriber Email Address</th>
                        <th>Subscribed Date</th>
                        <th class="text-end pe-3" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $sub)
                        <tr>
                            <td class="ps-3 fw-medium text-dark">{{ $sub->id }}</td>
                            <td class="fw-semibold text-dark">{{ $sub->email }}</td>
                            <td>{{ $sub->created_at->format('M d, Y H:i A') }}</td>
                            <td class="text-end pe-3">
                                <form action="{{ route('admin.newsletter.destroy', $sub) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this subscriber?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No subscribers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($subscribers->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $subscribers->links() }}
        </div>
    @endif
</div>
@endsection
