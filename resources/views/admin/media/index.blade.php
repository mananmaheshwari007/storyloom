@extends('layouts.admin')

@section('title', 'Media File Manager')
@section('page_title', 'Media Manager')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Media Manager</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="row g-4">
    
    <!-- Folder List Column -->
    <div class="col-md-3">
      <div class="card border-0 bg-white shadow-sm mb-4">
        <div class="card-header bg-transparent border-bottom p-3">
          <h6 class="fw-bold m-0 text-dark">Directory Folders</h6>
        </div>
        <div class="list-group list-group-flush">
          @foreach($folders as $f)
            <a href="{{ route('admin.media', ['folder' => $f]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-3 {{ $folder === $f ? 'active' : '' }}">
              <span><i class="bi bi-folder-fill me-2 {{ $folder === $f ? 'text-white' : 'text-warning' }}"></i>{{ $f }}</span>
            </a>
          @endforeach
        </div>
      </div>

      <!-- Upload Form Widget -->
      <div class="card border-0 bg-white shadow-sm">
        <div class="card-header bg-transparent border-bottom p-3">
          <h6 class="fw-bold m-0 text-dark">Upload to <code>{{ $folder }}</code></h6>
        </div>
        <div class="card-body p-3">
          <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="folder" value="{{ $folder }}">
            
            <div class="mb-3">
              <label class="form-label small text-muted">Select Image</label>
              <input type="file" name="file" class="form-control form-control-sm" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm w-100"><i class="bi bi-cloud-arrow-up me-1"></i>Upload &amp; Optimize</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Media Library Grid Column -->
    <div class="col-md-9">
      <div class="card border-0 bg-white shadow-sm">
        <div class="card-header bg-transparent border-bottom p-3 d-flex justify-content-between align-items-center">
          <h6 class="fw-bold m-0 text-dark">Folder Content: <code>{{ $folder }}</code></h6>
          <span class="badge bg-light text-dark border">{{ $mediaFiles->total() }} Files</span>
        </div>
        <div class="card-body p-3">
          
          <div class="row g-3">
            @forelse($mediaFiles as $file)
              <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border p-2 bg-light position-relative media-card">
                  <!-- Thumbnail Image -->
                  <div class="ratio ratio-1x1 border rounded bg-white overflow-hidden mb-2">
                    <img src="{{ asset($file->filepath) }}" class="object-fit-cover" alt="{{ $file->filename }}" style="width:100%; height:100%; object-fit:cover;">
                  </div>
                  
                  <!-- File Info -->
                  <div class="small text-truncate text-dark fw-semibold" title="{{ $file->filename }}">{{ $file->filename }}</div>
                  <div class="text-muted small" style="font-size:0.75rem;">
                    {{ number_format($file->filesize / 1024, 1) }} KB
                  </div>

                  <!-- Quick Actions -->
                  <div class="mt-2 pt-2 border-top d-flex gap-1">
                    <!-- Copy Link -->
                    <button type="button" class="btn btn-sm btn-outline-success flex-grow-1 py-0 px-1 copy-link-btn" data-url="{{ asset($file->filepath) }}" title="Copy public URL">
                      <i class="bi bi-link-45deg small"></i> Link
                    </button>
                    
                    <!-- Delete -->
                    <form action="{{ route('admin.media.destroy', $file->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this media file?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-1" title="Delete from disk"><i class="bi bi-trash small"></i></button>
                    </form>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12 py-5 text-center text-muted">
                <i class="bi bi-images fs-1 d-block mb-2"></i>
                No optimized media files found in this folder.
              </div>
            @endforelse
          </div>

          <div class="mt-4">
            {{ $mediaFiles->appends(['folder' => $folder])->links() }}
          </div>

        </div>
      </div>
    </div>

  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Clipboard copy helper
  document.querySelectorAll('.copy-link-btn').forEach(function (button) {
    button.addEventListener('click', function () {
      var url = this.getAttribute('data-url');
      navigator.clipboard.writeText(url).then(function () {
        var originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-check2"></i> Copied';
        button.classList.replace('btn-outline-success', 'btn-success');
        
        setTimeout(function () {
          button.innerHTML = originalText;
          button.classList.replace('btn-success', 'btn-outline-success');
        }, 1500);
      }).catch(function (err) {
        console.error('Could not copy link: ', err);
      });
    });
  });
});
</script>
@endpush
