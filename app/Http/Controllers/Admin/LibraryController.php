<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryBook;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    /**
     * Display a listing of library books and page text settings.
     */
    public function index()
    {
        $books = LibraryBook::orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        return view('admin.library.index', compact('books'));
    }

    /**
     * Show form to create a new book.
     */
    public function create()
    {
        return view('admin.library.create');
    }

    /**
     * Store a newly created library book.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|in:featured,shelf',
            'relation_tag' => 'nullable|string|max:255',
            'occasion_tag' => 'nullable|string|max:255',
            'spreads_count' => 'nullable|string|max:255',
            'read_time' => 'nullable|string|max:255',
            'synopsis' => 'nullable|string',
            'caption' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'back_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'pages_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'order' => 'nullable|integer',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('uploads/library', 'public');
            $validated['cover_image'] = 'storage/' . $path;
        }

        if ($request->hasFile('back_image')) {
            $path = $request->file('back_image')->store('uploads/library', 'public');
            $validated['back_image'] = 'storage/' . $path;
        }

        $pagesJson = [];
        if ($request->hasFile('pages_files')) {
            foreach ($request->file('pages_files') as $idx => $file) {
                $pPath = $file->store('uploads/library/pages', 'public');
                $pagesJson[] = [
                    'src' => 'storage/' . $pPath,
                    'alt' => $validated['title'] . ' — spread ' . ($idx + 1)
                ];
            }
        } elseif ($request->filled('pages_json_raw')) {
            $pagesJson = json_decode($request->input('pages_json_raw'), true) ?? [];
        }

        $validated['pages_json'] = $pagesJson;
        $validated['status'] = $request->has('status');

        LibraryBook::create($validated);

        return redirect()->route('admin.library.index')->with('success', 'Library Book created successfully!');
    }

    /**
     * Show form to edit a book.
     */
    public function edit(LibraryBook $library)
    {
        return view('admin.library.edit', ['book' => $library]);
    }

    /**
     * Update the specified library book.
     */
    public function update(Request $request, LibraryBook $library)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|in:featured,shelf',
            'relation_tag' => 'nullable|string|max:255',
            'occasion_tag' => 'nullable|string|max:255',
            'spreads_count' => 'nullable|string|max:255',
            'read_time' => 'nullable|string|max:255',
            'synopsis' => 'nullable|string',
            'caption' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'back_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'pages_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'order' => 'nullable|integer',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('uploads/library', 'public');
            $validated['cover_image'] = 'storage/' . $path;
        }

        if ($request->hasFile('back_image')) {
            $path = $request->file('back_image')->store('uploads/library', 'public');
            $validated['back_image'] = 'storage/' . $path;
        }

        $pagesJson = $library->pages_json ?? [];

        if ($request->hasFile('pages_files')) {
            $newPages = [];
            foreach ($request->file('pages_files') as $idx => $file) {
                $pPath = $file->store('uploads/library/pages', 'public');
                $newPages[] = [
                    'src' => 'storage/' . $pPath,
                    'alt' => $validated['title'] . ' — spread ' . ($idx + 1)
                ];
            }
            $pagesJson = $newPages;
        } elseif ($request->filled('pages_json_raw')) {
            $pagesJson = json_decode($request->input('pages_json_raw'), true) ?? [];
        }

        $validated['pages_json'] = $pagesJson;
        $validated['status'] = $request->has('status');

        $library->update($validated);

        return redirect()->route('admin.library.index')->with('success', 'Library Book updated successfully!');
    }

    /**
     * Remove the specified library book.
     */
    public function destroy(LibraryBook $library)
    {
        $library->delete();
        return redirect()->route('admin.library.index')->with('success', 'Library Book deleted successfully!');
    }

    /**
     * Reorder books via drag-and-drop or up/down controls.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:library_books,id',
        ]);

        foreach ($request->input('order') as $position => $id) {
            LibraryBook::where('id', $id)->update(['order' => $position + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Library books reordered successfully!']);
    }

    /**
     * Update page hero text, section headings, and copy settings.
     */
    public function updateSettings(Request $request)
    {
        $settings = $request->only([
            'library_hero_eyebrow',
            'library_hero_heading',
            'library_hero_lede',
            'shelf_eyebrow',
            'shelf_heading',
            'shelf_handnote',
            'library_cta_heading',
            'library_cta_desc',
            'library_cta_btn',
        ]);

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            Cache::forget('setting.' . $key);
        }

        return redirect()->route('admin.library.index')->with('success', 'Library Page Text & Settings updated successfully!');
    }
}
