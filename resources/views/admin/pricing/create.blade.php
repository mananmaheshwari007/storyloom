@extends('layouts.admin')

@section('title', 'Add Pricing Plan')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add Pricing Plan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.pricing.index') }}">Pricing</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Plan</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm max-w-4xl">
    <div class="card-body">
        <form action="{{ route('admin.pricing.store') }}" method="POST">
            @csrf
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="plan_name" class="form-label">Plan Name</label>
                    <input type="text" class="form-control @error('plan_name') is-invalid @enderror" id="plan_name" name="plan_name" value="{{ old('plan_name') }}" required>
                    @error('plan_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="duration" class="form-label">Duration Label (e.g. per book, per month)</label>
                    <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration', 'per book') }}" required>
                    @error('duration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="price" class="form-label">Final price (₹)</label>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                    <div class="form-text">What the customer actually pays. Shown large on the card.</div>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="compare_price" class="form-label">Original price (₹) <span class="text-muted">— optional</span></label>
                    <input type="number" step="0.01" class="form-control @error('compare_price') is-invalid @enderror" id="compare_price" name="compare_price" value="{{ old('compare_price') }}">
                    <div class="form-text">Shown struck through above the final price. Leave blank for no discount.</div>
                    @error('compare_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="discount_label" class="form-label">Discount badge <span class="text-muted">— optional</span></label>
                    <input type="text" maxlength="40" class="form-control @error('discount_label') is-invalid @enderror" id="discount_label" name="discount_label" value="{{ old('discount_label') }}" placeholder="e.g. Launch offer">
                    <div class="form-text">Leave blank and the % saving is worked out from the two prices automatically.</div>
                    @error('discount_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="button_text" class="form-label">Button Text</label>
                    <input type="text" class="form-control @error('button_text') is-invalid @enderror" id="button_text" name="button_text" value="{{ old('button_text', 'Begin Your Story') }}">
                </div>
                <div class="col-md-6">
                    <label for="button_url" class="form-label">Button URL / Link</label>
                    <input type="text" class="form-control @error('button_url') is-invalid @enderror" id="button_url" name="button_url" value="{{ old('button_url', '/begin') }}">
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="popular_plan" name="popular_plan" value="1" {{ old('popular_plan') ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="popular_plan">Mark this plan as "Popular Plan"</label>
            </div>

            <!-- Plan Features List -->
            <div class="mb-4">
                <label class="form-label fw-bold d-block">Plan Features</label>
                <div id="features-container">
                    <div class="input-group mb-2 feature-item">
                        <input type="text" class="form-control" name="features[]" placeholder="e.g. 10 Custom Illustrated Spreads" required>
                        <button type="button" class="btn btn-outline-danger remove-feature"><i class="bi bi-dash"></i></button>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="add-feature">
                    <i class="bi bi-plus"></i> Add Feature Line
                </button>
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2"><i class="bi bi-save me-1"></i> Save Plan</button>
            <a href="{{ route('admin.pricing.index') }}" class="btn btn-outline-secondary px-4 py-2 ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('add-feature').addEventListener('click', function() {
        const container = document.getElementById('features-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2 feature-item';
        div.innerHTML = `
            <input type="text" class="form-control" name="features[]" placeholder="e.g. Additional feature text" required>
            <button type="button" class="btn btn-outline-danger remove-feature"><i class="bi bi-dash"></i></button>
        `;
        container.appendChild(div);
    });

    document.getElementById('features-container').addEventListener('click', function(e) {
        if (e.target.closest('.remove-feature')) {
            const items = document.querySelectorAll('.feature-item');
            if (items.length > 1) {
                e.target.closest('.feature-item').remove();
            } else {
                alert('A plan must have at least one feature.');
            }
        }
    });
</script>
@endsection
