<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BeginController extends Controller
{
    /**
     * Show the form for editing the Begin a Story page content.
     */
    public function edit()
    {
        return view('admin.begin.edit');
    }

    /**
     * Update the Begin a Story page content & settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'begin_hero_heading' => 'nullable|string',
            'begin_hero_subheading' => 'nullable|string',
            'begin_hero_description' => 'nullable|string',
            'begin_step1_title' => 'nullable|string',
            'begin_step2_title' => 'nullable|string',
            'begin_step3_title' => 'nullable|string',
            'begin_step4_title' => 'nullable|string',
            'begin_contact_note' => 'nullable|string',
            'begin_direct_title' => 'nullable|string',
            'begin_direct_sub' => 'nullable|string',
        ]);

        $settings = $request->only([
            'begin_hero_heading',
            'begin_hero_subheading',
            'begin_hero_description',
            'begin_step1_title',
            'begin_step2_title',
            'begin_step3_title',
            'begin_step4_title',
            'begin_contact_note',
            'begin_direct_title',
            'begin_direct_sub',
        ]);

        foreach ($settings as $key => $val) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $val]
            );
            Cache::forget("setting.{$key}");
        }

        return redirect()->back()->with('success', 'Begin a Story page settings updated successfully.');
    }
}
