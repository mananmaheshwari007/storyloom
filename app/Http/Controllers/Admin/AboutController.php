<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    /**
     * Show the form for editing the About page section & content settings.
     */
    public function edit()
    {
        $about = About::first() ?: new About();
        return view('admin.about.edit', compact('about'));
    }

    /**
     * Update the About section and page settings.
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

        // Process About Page settings
        $aboutSettingsKeys = [
            'about_hero_eyebrow',
            'about_hero_heading',
            'about_hero_lede',
            'about_val1_title',
            'about_val1_desc',
            'about_val2_title',
            'about_val2_desc',
            'about_val3_title',
            'about_val3_desc',
            'about_cta_heading',
            'about_cta_desc',
            'about_cta_btn_text',
            'about_cta_btn_link',
        ];

        foreach ($aboutSettingsKeys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
                Cache::forget("setting.{$key}");
            }
        }

        return back()->with('success', 'About page content & settings updated successfully.');
    }
}
