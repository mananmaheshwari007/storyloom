@extends('layouts.admin')

@section('title', 'View Message')

@section('content')
<div class="page-header">
    <h1 class="page-title">Message Details</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.messages.index') }}">Inbox</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Message</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm max-w-4xl">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-envelope-open me-2 text-primary"></i> {{ $message->subject }}</h5>
        <span class="text-muted" style="font-size: 0.85rem;">Received: {{ $message->created_at->format('M d, Y h:i A') }}</span>
    </div>
    <div class="card-body">
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="p-3 border rounded bg-light-subtle">
                    <h6 class="text-muted small text-uppercase mb-1">Sender Name</h6>
                    <p class="mb-0 fw-semibold text-dark">{{ $message->name }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 border rounded bg-light-subtle">
                    <h6 class="text-muted small text-uppercase mb-1">Sender Email</h6>
                    <p class="mb-0 fw-semibold text-dark"><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></p>
                </div>
            </div>
            @if($message->phone)
                <div class="col-12">
                    <div class="p-3 border rounded bg-light-subtle">
                        <h6 class="text-muted small text-uppercase mb-1">Phone Number</h6>
                        <p class="mb-0 fw-semibold text-dark">{{ $message->phone }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="mb-4">
            <h6 class="text-muted small text-uppercase mb-2">Message Body</h6>
            <div class="p-4 border rounded bg-light" style="white-space: pre-wrap; font-size: 1rem; color: #1e293b; line-height: 1.6;">{{ $message->message }}</div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary px-4"><i class="bi bi-arrow-left me-1"></i> Back to Inbox</a>
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger px-4"><i class="bi bi-trash me-1"></i> Delete Message</button>
            </form>
        </div>
    </div>
</div>
@endsection
