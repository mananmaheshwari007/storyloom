<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'main_image_file' => 'nullable|image|max:3072',
            'category' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'gallery_files.*' => 'nullable|image|max:3072'
        ]);

        $data = $request->except(['main_image_file', 'gallery_files']);

        if ($request->hasFile('main_image_file')) {
            $path = $request->file('main_image_file')->store('products', 'public');
            $data['main_image'] = 'storage/' . $path;
        }

        $gallery = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $path = $file->store('products', 'public');
                $gallery[] = 'storage/' . $path;
            }
        }
        $data['gallery_images'] = $gallery;

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'main_image_file' => 'nullable|image|max:3072',
            'category' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'gallery_files.*' => 'nullable|image|max:3072'
        ]);

        $data = $request->except(['main_image_file', 'gallery_files']);

        if ($request->hasFile('main_image_file')) {
            if ($product->main_image && str_starts_with($product->main_image, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->main_image));
            }
            $path = $request->file('main_image_file')->store('products', 'public');
            $data['main_image'] = 'storage/' . $path;
        }

        $gallery = $product->gallery_images ?: [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $path = $file->store('products', 'public');
                $gallery[] = 'storage/' . $path;
            }
        }

        if ($request->has('remove_gallery')) {
            foreach ($request->input('remove_gallery') as $removedIdx) {
                if (isset($gallery[$removedIdx])) {
                    $img = $gallery[$removedIdx];
                    if (str_starts_with($img, 'storage/')) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $img));
                    }
                    unset($gallery[$removedIdx]);
                }
            }
            $gallery = array_values($gallery);
        }

        $data['gallery_images'] = $gallery;

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->main_image && str_starts_with($product->main_image, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->main_image));
        }

        if ($product->gallery_images) {
            foreach ($product->gallery_images as $img) {
                if (str_starts_with($img, 'storage/')) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $img));
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
