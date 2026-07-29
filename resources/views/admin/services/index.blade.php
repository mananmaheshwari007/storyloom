@extends('layouts.admin')

@section('title', '4. Occasions Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-heart me-2 text-primary"></i> 4. Occasions Page Manager</h1>
        <p class="text-muted small mb-0">Manage hero copy, festival section headers, and milestone occasion cards for the Occasions page (/occasions).</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary shadow-sm" style="background-color: var(--primary-active); border-color: var(--primary-active);">
            <i class="bi bi-plus-lg me-1"></i> Add New Occasion Card
        </a>
    </div>
</div>

<!-- Page Header & Festival Section Settings Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-fonts me-2 text-primary"></i> Occasions Page Hero Header &amp; Section Titles</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.services.settings') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Hero Eyebrow</label>
                    <input type="text" name="occasions_hero_eyebrow" class="form-control form-control-sm" value="{{ setting('occasions_hero_eyebrow', 'OCCASIONS') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Hero Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="occasions_hero_heading" class="form-control form-control-sm" value="{{ setting('occasions_hero_heading', 'For the days that<br>deserve more than a <em>gift.</em>') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Hero Description / Lede</label>
                    <textarea name="occasions_hero_lede" class="form-control form-control-sm" rows="2">{{ setting('occasions_hero_lede', 'Some occasions come with easy answers — a cake, a card, a voucher. And some deserve the one gift that could only ever belong to one person.') }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Festivals Section Eyebrow</label>
                    <input type="text" name="festivals_eyebrow" class="form-control form-control-sm" value="{{ setting('festivals_eyebrow', 'FESTIVALS & CELEBRATIONS') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Festivals Section Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="festivals_heading" class="form-control form-control-sm" value="{{ setting('festivals_heading', 'Gifts for the days the<br>whole family <em>gathers.</em>') }}">
                </div>
            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-sm btn-primary fw-bold px-4">
                    <i class="bi bi-save me-1"></i> Save Occasions Header Settings
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Occasion Cards Table -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-grid me-2 text-primary"></i> Occasion Cards Library</h5>
        <span class="badge bg-primary rounded-pill px-3 py-1.5">{{ count($services) }} Occasions</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3" style="width: 80px;">Order</th>
                        <th>Occasion Title</th>
                        <th>Description</th>
                        <th>Icon Identifier</th>
                        <th>Status</th>
                        <th class="text-end pe-3" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $service->display_order }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $service->title }}</div>
                                @if($service->image)
                                    <small class="text-muted"><i class="bi bi-image me-1"></i> Custom Artwork Uploaded</small>
                                @endif
                            </td>
                            <td>{{ Str::limit($service->description, 60) }}</td>
                            <td><code>{{ $service->icon ?: 'gift' }}</code></td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $service->status === 'active' ? 'success' : 'secondary' }} py-1 px-2.5">
                                    {{ ucfirst($service->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-secondary me-1" title="Edit Occasion">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this occasion card?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Occasion">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No occasion cards found. Click "Add New Occasion Card" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($services->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $services->links() }}
        </div>
    @endif
</div>
@endsection
