@extends('layouts.admin')

@section('title', 'Manage Portfolio')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Portfolio Cards</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Portfolio</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add Portfolio Item
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 100px;">Thumbnail</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-end pe-3" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($portfolios as $portfolio)
                        <tr>
                            <td class="ps-3">
                                <div class="border rounded bg-white overflow-hidden text-center" style="width: 60px; height: 45px;">
                                    @if($portfolio->thumbnail)
                                        <img src="{{ asset($portfolio->thumbnail) }}" alt="Thumbnail" style="max-height: 100%; max-width: 100%; object-fit: cover;">
                                    @else
                                        <i class="bi bi-image text-muted fs-4"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="fw-semibold text-dark">{{ $portfolio->title }}</td>
                            <td>{{ $portfolio->category }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $portfolio->status === 'published' ? 'success' : 'secondary' }}-subtle text-{{ $portfolio->status === 'published' ? 'success' : 'secondary' }} py-1 px-2.5">
                                    {{ ucfirst($portfolio->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.portfolio.edit', $portfolio) }}" class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.portfolio.destroy', $portfolio) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this portfolio item?');">
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
                            <td colspan="5" class="text-center py-4 text-muted">No portfolio items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($portfolios->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $portfolios->links() }}
        </div>
    @endif
</div>
@endsection
