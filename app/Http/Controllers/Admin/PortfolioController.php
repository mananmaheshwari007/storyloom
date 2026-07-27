<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = Portfolio::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.portfolio.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.portfolio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|max:3072',
            'status' => 'required|in:draft,published',
            'gallery_files.*' => 'nullable|image|max:3072'
        ]);

        $data = $request->except(['thumbnail_file', 'gallery_files']);

        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('portfolio', 'public');
            $data['thumbnail'] = 'storage/' . $path;
        }

        $gallery = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $path = $file->store('portfolio', 'public');
                $gallery[] = 'storage/' . $path;
            }
        }
        $data['gallery'] = $gallery;

        Portfolio::create($data);

        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio item created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolio.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|max:3072',
            'status' => 'required|in:draft,published',
            'gallery_files.*' => 'nullable|image|max:3072'
        ]);

        $data = $request->except(['thumbnail_file', 'gallery_files']);

        if ($request->hasFile('thumbnail_file')) {
            if ($portfolio->thumbnail && str_starts_with($portfolio->thumbnail, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $portfolio->thumbnail));
            }
            $path = $request->file('thumbnail_file')->store('portfolio', 'public');
            $data['thumbnail'] = 'storage/' . $path;
        }

        $gallery = $portfolio->gallery ?: [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $path = $file->store('portfolio', 'public');
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

        $data['gallery'] = $gallery;

        $portfolio->update($data);

        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->thumbnail && str_starts_with($portfolio->thumbnail, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $portfolio->thumbnail));
        }

        if ($portfolio->gallery) {
            foreach ($portfolio->gallery as $img) {
                if (str_starts_with($img, 'storage/')) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $img));
                }
            }
        }

        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio item deleted successfully.');
    }
}
