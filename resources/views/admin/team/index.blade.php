@extends('layouts.admin')

@section('title', 'Manage Team Members')
@section('page_title', 'Team Profiles')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Team Members</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-dark">Team Members List</h5>
    <a href="{{ route('admin.team.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add Member</a>
  </div>

  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Photo</th>
              <th>Name</th>
              <th>Designation</th>
              <th>Socials</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($team as $member)
              <tr>
                <td>
                  <img src="{{ asset($member->photo ?: 'assets/img/logo-emblem.png') }}" class="rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;" alt="">
                </td>
                <td><div class="fw-semibold text-dark">{{ $member->name }}</div></td>
                <td>{{ $member->designation }}</td>
                <td>
                  @if(!empty($member->social_links))
                    @foreach($member->social_links as $platform => $url)
                      <span class="badge bg-light text-dark border text-capitalize small me-1">
                        {{ $platform }}
                      </span>
                    @endforeach
                  @else
                    <span class="text-muted small">None</span>
                  @endif
                </td>
                <td>
                  <span class="badge bg-{{ $member->status ? 'success' : 'secondary' }}">
                    {{ $member->status ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.team.edit', $member->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.team.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this team member?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-4">No team members found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $team->links() }}
      </div>
    </div>
  </div>
@endsection
