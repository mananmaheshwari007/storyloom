@extends('layouts.admin')

@section('title', '6. Pricing Page Manager')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="page-title h3 mb-1"><i class="bi bi-tags me-2 text-primary"></i> 6. Pricing Page Manager</h1>
        <p class="text-muted small mb-0">Manage pricing page hero copy, tier packages, bespoke order CTAs, and feature checklists.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.pricing.create') }}" class="btn btn-primary shadow-sm" style="background-color: var(--primary-active); border-color: var(--primary-active);">
            <i class="bi bi-plus-lg me-1"></i> Add Pricing Tier Plan
        </a>
    </div>
</div>

<!-- Page Header & Bespoke CTA Settings Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-fonts me-2 text-primary"></i> Pricing Page Hero Header &amp; Bespoke Order CTA</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pricing.settings') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Hero Eyebrow</label>
                    <input type="text" name="pricing_hero_eyebrow" class="form-control form-control-sm" value="{{ setting('pricing_hero_eyebrow', 'SIMPLE, TRANSPARENT PRICING') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Hero Heading <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="pricing_hero_heading" class="form-control form-control-sm" value="{{ setting('pricing_hero_heading', 'One story. <em>One price.</em> No surprises.') }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Hero Description / Lede</label>
                    <textarea name="pricing_hero_lede" class="form-control form-control-sm" rows="2">{{ setting('pricing_hero_lede', 'Every Storyloom is built as a complete, hand-illustrated keepsake book — written from your memories, painted spread by spread, printed on archival art paper, and bound in hardcover.') }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Bottom Note Tagline</label>
                    <input type="text" name="pricing_note_text" class="form-control form-control-sm" value="{{ setting('pricing_note_text', 'Includes unlimited writing revisions, high-resolution proof prints, archival printing, and worldwide shipping.') }}">
                </div>
            </div>

            <hr class="my-4">

            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-gift me-1 text-primary"></i> Bespoke / Custom Storyloom Order CTA Card:</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Bespoke CTA Title <span class="badge bg-info text-dark ms-1">HTML Allowed</span></label>
                    <input type="text" name="pricing_custom_title" class="form-control form-control-sm" value="{{ setting('pricing_custom_title', 'Need something <em>bespoke?</em>') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Bespoke CTA Button Label & Link</label>
                    <div class="input-group input-group-sm">
                        <input type="text" name="pricing_custom_btn_text" class="form-control" value="{{ setting('pricing_custom_btn_text', 'TALK TO AN EDITOR') }}">
                        <input type="text" name="pricing_custom_btn_link" class="form-control" value="{{ setting('pricing_custom_btn_link', '/begin') }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">Bespoke CTA Description</label>
                    <textarea name="pricing_custom_desc" class="form-control form-control-sm" rows="2">{{ setting('pricing_custom_desc', 'For milestone corporate gifts, multi-volume family histories, or custom size requests, talk to our studio directly.') }}</textarea>
                </div>
            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-sm btn-primary fw-bold px-4">
                    <i class="bi bi-save me-1"></i> Save Pricing Header &amp; CTA Settings
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Pricing Tier Plans Table -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-list-stars me-2 text-primary"></i> Pricing Tier Plans</h5>
        <span class="badge bg-primary rounded-pill px-3 py-1.5">{{ count($plans) }} Active Packages</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Plan Name</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Features List</th>
                        <th>Popular</th>
                        <th>Status</th>
                        <th class="text-end pe-3" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr>
                            <td class="ps-3 fw-semibold text-dark">{{ $plan->plan_name }}</td>
                            <td>₹{{ number_format($plan->price, 2) }}</td>
                            <td>{{ $plan->duration }}</td>
                            <td>
                                @if($plan->features)
                                    <ul class="mb-0 small ps-3">
                                        @foreach($plan->features as $feat)
                                            <li>{{ $feat }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->popular_plan)
                                    <span class="badge bg-warning text-dark py-1 px-2"><i class="bi bi-star-fill me-1"></i> Popular</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $plan->status === 'active' ? 'success' : 'secondary' }} py-1 px-2.5">
                                    {{ ucfirst($plan->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.pricing.edit', $plan) }}" class="btn btn-sm btn-outline-secondary me-1" title="Edit Plan">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.pricing.destroy', $plan) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this pricing plan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Plan">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No pricing plans found. Click "Add Pricing Tier Plan" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($plans->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $plans->links() }}
        </div>
    @endif
</div>
@endsection
