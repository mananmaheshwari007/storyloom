<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

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
            'experience_years' => 'nullable|integer',
            'skills' => 'nullable|array',
            'statistics' => 'nullable|array',
        ]);

        $about = About::first();
        if ($about) {
            $about->update($request->all());
        } else {
            About::create($request->all());
        }

        return back()->with('success', 'About section content updated successfully.');
    }
}
