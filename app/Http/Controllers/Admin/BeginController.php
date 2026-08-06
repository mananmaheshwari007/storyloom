<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BeginController extends Controller
{
    /**
     * Every piece of copy on /begin, in the order it appears on the page.
     *
     * This list previously held keys the page never read (begin_hero_subheading,
     * begin_step1_title and friends), so edits saved successfully and then had
     * no visible effect. These are the keys begin.blade.php actually uses.
     */
    private const KEYS = [
        // Page hero
        'begin_hero_eyebrow',
        'begin_hero_heading',
        'begin_hero_lede',

        // "Prefer to just talk?" card
        'begin_box_eyebrow',
        'begin_box_heading',
        'begin_box_subtext',
        'begin_box_wa_text',
        'begin_box_note',

        // Form labels, placeholders and options
        'begin_label_name',
        'begin_label_for',
        'begin_ph_for',
        'begin_label_email',
        'begin_label_phone',
        'begin_label_occasion',
        'begin_ph_occasion',
        'begin_occasions',
        'begin_label_story',
        'begin_ph_story',
        'begin_label_channel',
        'begin_channel_whatsapp',
        'begin_channel_email',
        'begin_btn_text',
        'begin_success_note',

        // Where new enquiries are emailed
        'enquiry_notify_email',
    ];

    public function edit()
    {
        return view('admin.begin.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'enquiry_notify_email' => 'nullable|email',
        ], [
            'enquiry_notify_email.email' => 'That does not look like a valid email address.',
        ]);

        foreach (self::KEYS as $key) {
            // Only touch what was actually submitted, so a partial form can
            // never blank out a field it doesn't contain.
            if (! $request->has($key)) {
                continue;
            }

            Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
            Cache::forget("setting.{$key}");
        }

        return redirect()->back()->with('success', 'Begin a Story page updated successfully.');
    }
}
