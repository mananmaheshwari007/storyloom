<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HowItWorksController extends Controller
{
    /**
     * Show form to edit How It Works page copy & timeline steps.
     */
    public function edit()
    {
        return view('admin.how.edit');
    }

    /**
     * Update How It Works page settings in database.
     */
    public function update(Request $request)
    {
        $data = $request->only([
            'how_hero_eyebrow',
            'how_hero_heading',
            'how_hero_lede',
            'how_step1_badge',
            'how_step1_title',
            'how_step1_desc',
            'how_step2_badge',
            'how_step2_title',
            'how_step2_desc',
            'how_step3_badge',
            'how_step3_title',
            'how_step3_desc',
            'how_step4_badge',
            'how_step4_title',
            'how_step4_desc',
            'how_step5_badge',
            'how_step5_title',
            'how_step5_desc',
            'how_step6_badge',
            'how_step6_title',
            'how_step6_desc',
            'how_stat1_num',
            'how_stat1_label',
            'how_stat2_num',
            'how_stat2_label',
            'how_stat3_num',
            'how_stat3_label',
            'craft_eyebrow',
            'craft_heading',
            'craft_synopsis',
            'craft_feature_1',
            'craft_feature_2',
            'craft_feature_3',
            'craft_feature_4',
            'craft_artwork_caption',
            'how_timeline_note',
            'how_cta_heading',
            'how_cta_desc',
            'how_cta_btn1',
            'how_cta_btn1_link',
            'how_cta_btn2',
            'how_cta_btn2_link',
        ]);

        if ($request->hasFile('craft_artwork_img_file')) {
            $path = $request->file('craft_artwork_img_file')->store('uploads/how', 'public');
            $data['craft_artwork_img'] = 'storage/' . $path;
        }

        if ($request->hasFile('how_cta_bg_file')) {
            $path = $request->file('how_cta_bg_file')->store('uploads/how', 'public');
            $data['how_cta_bg'] = 'storage/' . $path;
        }

        foreach ($data as $key => $value) {
            if ($value !== null) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
                Cache::forget('setting.' . $key);
            }
        }

        return redirect()->route('admin.how.edit')->with('success', 'How It Works page updated successfully!');
    }
}
