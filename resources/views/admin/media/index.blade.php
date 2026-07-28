@extends('layouts.admin')

@section('title', 'Media Manager')

@section('content')
<div class="page-header">
    <h1 class="page-title">Media Manager</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Media</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <!-- Upload Card -->
    <div class="col-md-4">
        <div class="card shadow-sm sticky-top" style="top: 90px; z-index: 10;">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-cloud-upload me-2 text-primary"></i> Upload New Media</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Choose Image File</label>
                        <input class="form-control" type="file" id="file" name="file" accept="image/*" required>
                        <div class="form-text">Supported formats: JPG, PNG, WEBP, GIF, AVIF. Max file size: <strong>10 MB</strong>.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-upload me-1"></i> Upload File</button>
                </form>
            </div>
        </div>

        <!-- Image Optimization Specifications Table -->
        <div class="card shadow-sm mt-4 border-0">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-image me-2 text-info"></i> Image Optimization Specifications</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0" style="font-size: 0.82rem;">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Image Type</th>
                                <th>Max Width</th>
                                <th>Quality</th>
                                <th class="pe-3">Expected Size</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 fw-medium text-dark">Hero Carousel Cards</td>
                                <td><code>600px</code></td>
                                <td>75</td>
                                <td class="pe-3 text-success font-monospace">50–80 KB</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium text-dark">Story-grid / Page Spreads</td>
                                <td><code>800px</code></td>
                                <td>72–75</td>
                                <td class="pe-3 text-success font-monospace">60–95 KB</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium text-dark">Library Book Spreads</td>
                                <td><code>900px</code></td>
                                <td>78–80</td>
                                <td class="pe-3 text-success font-monospace">60–130 KB</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium text-dark">Book Covers</td>
                                <td><code>900px</code></td>
                                <td>80</td>
                                <td class="pe-3 text-success font-monospace">15–35 KB</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium text-dark">Card Thumbnails</td>
                                <td><code>240px</code></td>
                                <td>75</td>
                                <td class="pe-3 text-success font-monospace">7–18 KB</td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium text-dark">Logos (Transparency)</td>
                                <td><code>2&times; display</code></td>
                                <td>PNG-8 / WebP</td>
                                <td class="pe-3 text-success font-monospace">&lt;10 KB</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Media Library List -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-images me-2 text-success"></i> Media Library</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @forelse($mediaList as $media)
                        <div class="col-sm-6 col-md-4">
                            <div class="card h-100 border p-2 text-center bg-light-subtle">
                                <div class="d-flex align-items-center justify-content-center border rounded bg-white overflow-hidden mb-2" style="height: 120px;">
                                    <img src="{{ asset($media['path']) }}" alt="{{ $media['name'] }}" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                </div>
                                <div class="text-truncate fw-medium text-dark small" title="{{ $media['name'] }}">{{ $media['name'] }}</div>
                                <div class="text-muted small mb-2" style="font-size: 0.75rem;">{{ $media['size'] }}</div>
                                
                                <div class="d-grid gap-1">
                                    <button class="btn btn-sm btn-outline-secondary py-1" onclick="copyPath('{{ $media['path'] }}', this)">
                                        <i class="bi bi-link-45deg"></i> Copy Path
                                    </button>
                                    <form action="{{ route('admin.media.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this media file?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="path" value="{{ $media['raw_path'] }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100 py-1">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-muted">
                            <i class="bi bi-image fs-1 d-block mb-2"></i>
                            No media files found. Upload some assets to begin.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function copyPath(path, btn) {
        navigator.clipboard.writeText(path).then(() => {
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg"></i> Copied!';
            btn.classList.replace('btn-outline-secondary', 'btn-success');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.replace('btn-success', 'btn-outline-secondary');
            }, 2000);
        });
    }
</script>
@endsection
