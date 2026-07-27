@extends('layouts.admin')

@section('title', 'Read a Storyloom (Library Manager)')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800" style="font-family: var(--font-family-title); font-weight: 700;">Read a Storyloom — Library Manager</h1>
        <p class="text-muted small mb-0">Manage books, custom 3D spreads, hero copy, shelf cards, and CTA text.</p>
    </div>
    <a href="{{ route('admin.library.create') }}" class="btn btn-primary shadow-sm" style="background-color: var(--primary-active); border-color: var(--primary-active);">
        <i class="bi bi-plus-lg me-1"></i> Add New Storyloom Book
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Left Column: Library Books Table -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-book-half me-2 text-primary"></i> Storyloom Books Library</h5>
                    <small class="text-muted">Use the Up/Down arrows or drag rows to reorder books on the frontend library page.</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">{{ count($books) }} Books</span>
                    <button type="button" id="saveOrderBtn" class="btn btn-sm btn-outline-primary" style="display:none;">
                        <i class="bi bi-save me-1"></i> Save Book Order
                    </button>
                </div>
            </div>
            <div id="reorderAlert" class="alert alert-info py-2 px-3 m-3 mb-0" style="display:none;">
                <i class="bi bi-info-circle me-1"></i> Order changed. Click <strong>"Save Book Order"</strong> to apply changes.
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="libraryBooksTable">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 80px;" class="text-center">Order</th>
                            <th style="width: 70px;">Cover</th>
                            <th>Title / Subtitle</th>
                            <th>Display Mode</th>
                            <th>Tags</th>
                            <th>Status</th>
                            <th style="width: 120px;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortableBookList">
                        @forelse($books as $index => $book)
                            <tr data-id="{{ $book->id }}" draggable="true" class="book-row">
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <i class="bi bi-grip-vertical text-muted drag-handle fs-5" style="cursor: grab;" title="Drag to reorder"></i>
                                        <div class="btn-group-vertical btn-group-sm">
                                            <button type="button" class="btn btn-xs btn-light border py-0 px-1 btn-move-up" title="Move Up" @disabled($index === 0)>
                                                <i class="bi bi-chevron-up" style="font-size: 0.7rem;"></i>
                                            </button>
                                            <button type="button" class="btn btn-xs btn-light border py-0 px-1 btn-move-down" title="Move Down" @disabled($index === count($books) - 1)>
                                                <i class="bi bi-chevron-down" style="font-size: 0.7rem;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($book->cover_image)
                                        <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" style="width: 50px; height: 65px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0;">
                                    @else
                                        <div style="width: 50px; height: 65px; background: #1D2A44; border-radius: 4px; display: grid; place-items: center; color: #fff;">
                                            <i class="bi bi-book"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $book->title }}</div>
                                    <small class="text-muted">{{ $book->subtitle ?: 'No subtitle' }}</small>
                                </td>
                                <td>
                                    @if($book->type === 'featured')
                                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i> Featured Storyloom</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="bi bi-bookshelf me-1"></i> On the Shelf</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="d-block text-primary font-weight-bold">{{ $book->relation_tag }}</small>
                                    @if($book->spreads_count)
                                        <small class="text-muted">{{ $book->spreads_count }} • {{ $book->read_time }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($book->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Disabled</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.library.edit', $book->id) }}" class="btn btn-outline-secondary" title="Edit Book">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('admin.library.destroy', $book->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete Book">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-book fs-1 d-block mb-3"></i>
                                    No books in library yet. Click "Add New Storyloom Book" above to get started!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Page Header & Text Controls -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 sticky-top" style="top: 90px;">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 font-weight-bold text-dark"><i class="bi bi-sliders me-2 text-primary"></i> Library Page Copy Controls</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Hero Section Text -->
                    <h6 class="text-uppercase text-muted fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">Hero Section Text</h6>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Hero Eyebrow</label>
                        <input type="text" name="library_hero_eyebrow" class="form-control form-control-sm" value="{{ setting('library_hero_eyebrow', 'THE STORYLOOM LIBRARY') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Hero Heading (supports &lt;em&gt; and &lt;br&gt;)</label>
                        <textarea name="library_hero_heading" class="form-control form-control-sm" rows="2" required>{{ setting('library_hero_heading', 'Read one. Then<br>imagine <em>yours.</em>') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Hero Sub-description (Lede)</label>
                        <textarea name="library_hero_lede" class="form-control form-control-sm" rows="3" required>{{ setting('library_hero_lede', 'Real books, made for real families, shared with their blessing. Take your time — this room is quiet.') }}</textarea>
                    </div>

                    <hr class="my-4">

                    <!-- On the Shelf Section -->
                    <h6 class="text-uppercase text-muted fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">Shelf Section Text</h6>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Shelf Eyebrow</label>
                        <input type="text" name="shelf_eyebrow" class="form-control form-control-sm" value="{{ setting('shelf_eyebrow', 'ON THE SHELF') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Shelf Heading</label>
                        <input type="text" name="shelf_heading" class="form-control form-control-sm" value="{{ setting('shelf_heading', 'Stories currently on the <em>loom.</em>') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Handwritten Note at Bottom</label>
                        <input type="text" name="shelf_handnote" class="form-control form-control-sm" value="{{ setting('shelf_handnote', '…the next one could be about your family.') }}" required>
                    </div>

                    <hr class="my-4">

                    <!-- Final CTA Section -->
                    <h6 class="text-uppercase text-muted fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">Final CTA Banner Text</h6>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">CTA Heading</label>
                        <input type="text" name="library_cta_heading" class="form-control form-control-sm" value="{{ setting('library_cta_heading', 'Imagine your story <em>here.</em>') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">CTA Description</label>
                        <textarea name="library_cta_desc" class="form-control form-control-sm" rows="3" required>{{ setting('library_cta_desc', 'Every book in this library began with someone saying “I don\'t know where to start.” Start there. We\'ll take it from that sentence.') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">CTA Button Text</label>
                        <input type="text" name="library_cta_btn" class="form-control form-control-sm" value="{{ setting('library_cta_btn', 'BEGIN YOUR STORY') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-2" style="background-color: var(--primary-active); border-color: var(--primary-active);">
                        <i class="bi bi-check-circle me-1"></i> Save All Page Copy
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.getElementById('sortableBookList');
    const saveBtn = document.getElementById('saveOrderBtn');
    const alertBox = document.getElementById('reorderAlert');
    let dragSrcEl = null;

    function updateArrowButtons() {
        const rows = tbody.querySelectorAll('.book-row');
        rows.forEach((row, index) => {
            const upBtn = row.querySelector('.btn-move-up');
            const downBtn = row.querySelector('.btn-move-down');
            if (upBtn) upBtn.disabled = index === 0;
            if (downBtn) downBtn.disabled = index === rows.length - 1;
        });
    }

    function markOrderChanged() {
        if (saveBtn) saveBtn.style.display = 'inline-block';
        if (alertBox) alertBox.style.display = 'block';
        updateArrowButtons();
    }

    // Up/Down button events
    tbody.addEventListener('click', function (e) {
        const upBtn = e.target.closest('.btn-move-up');
        const downBtn = e.target.closest('.btn-move-down');
        
        if (upBtn && !upBtn.disabled) {
            const row = upBtn.closest('tr');
            if (row.previousElementSibling) {
                tbody.insertBefore(row, row.previousElementSibling);
                markOrderChanged();
            }
        } else if (downBtn && !downBtn.disabled) {
            const row = downBtn.closest('tr');
            if (row.nextElementSibling) {
                tbody.insertBefore(row.nextElementSibling, row);
                markOrderChanged();
            }
        }
    });

    // Drag and Drop
    tbody.querySelectorAll('.book-row').forEach(row => {
        row.addEventListener('dragstart', function (e) {
            dragSrcEl = this;
            this.classList.add('table-primary');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        });

        row.addEventListener('dragover', function (e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            const targetRow = e.target.closest('tr');
            if (targetRow && targetRow !== dragSrcEl && targetRow.parentNode === tbody) {
                const bounding = targetRow.getBoundingClientRect();
                const offset = e.clientY - bounding.top;
                if (offset > bounding.height / 2) {
                    tbody.insertBefore(dragSrcEl, targetRow.nextSibling);
                } else {
                    tbody.insertBefore(dragSrcEl, targetRow);
                }
            }
        });

        row.addEventListener('dragend', function () {
            this.classList.remove('table-primary');
            markOrderChanged();
        });
    });

    // Save Order AJAX
    if (saveBtn) {
        saveBtn.addEventListener('click', function () {
            const order = [];
            tbody.querySelectorAll('.book-row').forEach(row => {
                const id = row.getAttribute('data-id');
                if (id) order.push(id);
            });

            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

            fetch("{{ route('admin.library.reorder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ order: order })
            })
            .then(res => res.json())
            .then(data => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="bi bi-check2 me-1"></i> Saved!';
                saveBtn.classList.remove('btn-outline-primary');
                saveBtn.classList.add('btn-success');
                if (alertBox) {
                    alertBox.className = 'alert alert-success py-2 px-3 m-3 mb-0';
                    alertBox.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Book order updated successfully!';
                }
                setTimeout(() => {
                    saveBtn.style.display = 'none';
                    saveBtn.className = 'btn btn-sm btn-outline-primary';
                    saveBtn.innerHTML = '<i class="bi bi-save me-1"></i> Save Book Order';
                    if (alertBox) alertBox.style.display = 'none';
                }, 2500);
            })
            .catch(err => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="bi bi-save me-1"></i> Save Book Order';
                alert('Error saving order. Please try again.');
            });
        });
    }
});
</script>
@endsection
