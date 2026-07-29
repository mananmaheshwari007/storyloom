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
     * Update the About page settings and section copy.
     */
    public function update(Request $request)
    {
        // Process About Page settings
        $aboutSettingsKeys = [
            // Section 1: Hero & Story Prose
            'about_hero_eyebrow',
            'about_hero_heading',
            'about_hero_p1',
            'about_hero_p2',
            'about_hero_p3',
            'about_artwork_img',
            'about_artwork_caption',

            // Section 2: What We Stand For
            'stand_eyebrow',
            'stand_heading',
            'stand_card1_title', 'stand_card1_desc',
            'stand_card2_title', 'stand_card2_desc',
            'stand_card3_title', 'stand_card3_desc',
            'stand_card4_title', 'stand_card4_desc',

            // Section 3: The Mark We Make
            'mark_eyebrow',
            'mark_heading',
            'mark_p1',
            'mark_p2',

            // Section 4: A Note from the Founder
            'founder_eyebrow',
            'founder_quote',
            'founder_author',

            // Section 5: About Page Final CTA
            'about_cta_heading',
            'about_cta_desc',
            'about_cta_btn1',
            'about_cta_bg',
        ];

        foreach ($aboutSettingsKeys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
                Cache::forget("setting.{$key}");
            }
        }

        // Handle Image File Upload for Polaroid Artwork Card
        if ($request->hasFile('about_artwork_img_file')) {
            $destinationPath = public_path('assets/img/uploads');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file = $request->file('about_artwork_img_file');
            $filename = 'about_art_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            Setting::updateOrCreate(['key' => 'about_artwork_img'], ['value' => 'assets/img/uploads/' . $filename]);
            Cache::forget('setting.about_artwork_img');
        }

        // Handle Image File Upload for Final CTA Background
        if ($request->hasFile('about_cta_bg_file')) {
            $destinationPath = public_path('assets/img/uploads');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file = $request->file('about_cta_bg_file');
            $filename = 'about_cta_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            Setting::updateOrCreate(['key' => 'about_cta_bg'], ['value' => 'assets/img/uploads/' . $filename]);
            Cache::forget('setting.about_cta_bg');
        }

        return back()->with('success', 'About page content, cards, and CTA updated successfully.');
    }
}
