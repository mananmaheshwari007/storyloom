<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    /**
     * Show the form for editing the About section.
     */
    public function edit()
    {
        $about = About::first() ?: new About();
        return view('admin.about.edit', compact('about'));
    }

    /**
     * Update the About section.
     */
    public function update(Request $request)
    {
        $request->validate([
            'heading' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:3072',
            'experience_years' => 'nullable|integer',
            'skills' => 'nullable|array',
            'statistics' => 'nullable|array',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_file')) {
            $destinationPath = public_path('assets/img/uploads');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $data['image'] = 'assets/img/uploads/' . $filename;
        }

        $about = About::first();
        if ($about) {
            $about->update($data);
        } else {
            About::create($data);
        }

        return back()->with('success', 'About section content updated successfully.');
    }
}
