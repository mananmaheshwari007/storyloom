@extends('layouts.admin')

@section('title', 'Manage Book Products')
@section('page_title', 'Book Products')

@section('breadcrumbs')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Products</li>
    </ol>
  </nav>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-dark">Book Products List</h5>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add Product</a>
  </div>

  <div class="card border-0 bg-white">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Image</th>
              <th>Edition Name</th>
              <th>Slug</th>
              <th>Category</th>
              <th>Base Price</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $product)
              <tr>
                <td>
                  <img src="{{ asset($product->main_image) }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                </td>
                <td><div class="fw-semibold text-dark">{{ $product->name }}</div></td>
                <td><code>{{ $product->slug }}</code></td>
                <td>{{ $product->category ?: '—' }}</td>
                <td>
                  <div class="fw-bold text-dark">₹{{ number_format($product->price, 2) }}</div>
                  @if($product->discount_price)
                    <div class="text-muted small text-decoration-line-through">₹{{ number_format($product->discount_price, 2) }}</div>
                  @endif
                </td>
                <td>
                  <span class="badge bg-{{ $product->status ? 'success' : 'secondary' }}">
                    {{ $product->status ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">No products found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $products->links() }}
      </div>
    </div>
  </div>
@endsection
