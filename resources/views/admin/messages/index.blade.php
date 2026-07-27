@extends('layouts.admin')

@section('title', 'Inbox')

@section('content')
<div class="page-header">
    <h1 class="page-title">Contact Messages</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Inbox</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 200px;">Sender</th>
                        <th>Subject</th>
                        <th>Message Preview</th>
                        <th>Received Date</th>
                        <th class="text-center" style="width: 100px;">Status</th>
                        <th class="text-end pe-3" style="width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                        <tr @if(!$msg->is_read) class="fw-bold bg-light-subtle" @endif>
                            <td class="ps-3">
                                <div class="text-dark">{{ $msg->name }}</div>
                                <small class="text-muted">{{ $msg->email }}</small>
                                @if($msg->phone)
                                    <div><small class="text-muted"><i class="bi bi-telephone"></i> {{ $msg->phone }}</small></div>
                                @endif
                            </td>
                            <td>{{ $msg->subject }}</td>
                            <td class="text-muted">{{ Str::limit($msg->message, 80) }}</td>
                            <td>{{ $msg->created_at->format('M d, Y H:i') }}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-{{ $msg->is_read ? 'success' : 'danger' }}-subtle text-{{ $msg->is_read ? 'success' : 'danger' }} py-1 px-2">
                                    {{ $msg->is_read ? 'Read' : 'Unread' }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No messages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($messages->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection
