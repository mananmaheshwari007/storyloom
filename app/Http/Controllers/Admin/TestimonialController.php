<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|max:2048',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except('image_file');

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('testimonials', 'public');
            $data['image'] = 'storage/' . $path;
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|max:2048',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except(['image_file', 'remove_image']);

        if ($request->hasFile('image_file')) {
            if ($testimonial->image && str_starts_with($testimonial->image, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $testimonial->image));
            }
            $path = $request->file('image_file')->store('testimonials', 'public');
            $data['image'] = 'storage/' . $path;
        } elseif ($request->boolean('remove_image')) {
            // Drop the stored file too, so removing a photo doesn't leave orphans.
            if ($testimonial->image && str_starts_with($testimonial->image, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $testimonial->image));
            }
            $data['image'] = null;
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image && str_starts_with($testimonial->image, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $testimonial->image));
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }
}
