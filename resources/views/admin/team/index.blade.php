@extends('layouts.admin')

@section('title', 'Manage Team')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Team Members</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Team</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.team.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add Member
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 80px;">Photo</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Biographic Note</th>
                        <th>Socials</th>
                        <th>Status</th>
                        <th class="text-end pe-3" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td class="ps-3">
                                <div class="border rounded bg-white overflow-hidden text-center" style="width: 50px; height: 50px;">
                                    @if($member->photo)
                                        <img src="{{ asset($member->photo) }}" alt="Photo" style="max-height: 100%; max-width: 100%; object-fit: cover;">
                                    @else
                                        <i class="bi bi-person text-muted fs-4"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="fw-semibold text-dark">{{ $member->name }}</td>
                            <td>{{ $member->designation }}</td>
                            <td class="text-muted">{{ Str::limit($member->description, 60) }}</td>
                            <td>
                                @if($member->social_links)
                                    @foreach($member->social_links as $platform => $url)
                                        <a href="{{ $url }}" target="_blank" class="text-secondary me-1" title="{{ ucfirst($platform) }}">
                                            <i class="bi bi-{{ $platform }}"></i>
                                        </a>
                                    @endforeach
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $member->status === 'active' ? 'success' : 'secondary' }}-subtle text-{{ $member->status === 'active' ? 'success' : 'secondary' }} py-1 px-2.5">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this team member?');">
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
                            <td colspan="7" class="text-center py-4 text-muted">No team members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($members->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $members->links() }}
        </div>
    @endif
</div>
@endsection
