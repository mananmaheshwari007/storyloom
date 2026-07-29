<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of Occasions & page settings.
     */
    public function index()
    {
        $services = Service::orderBy('display_order')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Update Occasions Page Hero, Festival Cards, Milestone Cards, Relationship & CTA Settings.
     */
    public function updateSettings(Request $request)
    {
        $keys = [
            // Hero
            'occasions_hero_eyebrow',
            'occasions_hero_heading',
            'occasions_hero_lede',

            // Festivals
            'festivals_eyebrow',
            'festivals_heading',
            'fest1_title', 'fest1_tag', 'fest1_desc', 'fest1_img',
            'fest2_title', 'fest2_tag', 'fest2_desc', 'fest2_img',
            'fest3_title', 'fest3_tag', 'fest3_desc', 'fest3_img',
            'fest4_title', 'fest4_tag', 'fest4_desc', 'fest4_img',

            // Milestones
            'milestones_eyebrow',
            'milestones_heading',
            'ms1_title', 'ms1_desc', 'ms1_img',
            'ms2_title', 'ms2_desc', 'ms2_img',
            'ms3_title', 'ms3_desc', 'ms3_img',
            'ms4_title', 'ms4_desc', 'ms4_img',
            'ms5_title', 'ms5_desc', 'ms5_img',
            'ms6_title', 'ms6_desc', 'ms6_img',
            'ms7_title', 'ms7_desc', 'ms7_img',
            'ms8_title', 'ms8_desc', 'ms8_img',

            // Relationship
            'rel_eyebrow',
            'rel_heading',
            'rel_chips',
            'rel_subnote',

            // CTA Banner
            'occasion_banner_heading',
            'occasion_banner_desc',
            'cta_btn1_text',
            'occasion_cta_bg',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
                Cache::forget("setting.{$key}");
            }
        }

        // Handle Image File Uploads for Festival Cards (fest1 .. fest4)
        for ($f = 1; $f <= 4; $f++) {
            $fileKey = "fest{$f}_img_file";
            $settingKey = "fest{$f}_img";
            if ($request->hasFile($fileKey)) {
                $destinationPath = public_path('assets/img/uploads');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file = $request->file($fileKey);
                $filename = "fest_{$f}_" . time() . '_' . \Illuminate\Support\Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                Setting::updateOrCreate(['key' => $settingKey], ['value' => 'assets/img/uploads/' . $filename]);
                Cache::forget("setting.{$settingKey}");
            }
        }

        // Handle Image File Uploads for Milestone Cards (ms1 .. ms8)
        for ($m = 1; $m <= 8; $m++) {
            $fileKey = "ms{$m}_img_file";
            $settingKey = "ms{$m}_img";
            if ($request->hasFile($fileKey)) {
                $destinationPath = public_path('assets/img/uploads');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file = $request->file($fileKey);
                $filename = "ms_{$m}_" . time() . '_' . \Illuminate\Support\Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                Setting::updateOrCreate(['key' => $settingKey], ['value' => 'assets/img/uploads/' . $filename]);
                Cache::forget("setting.{$settingKey}");
            }
        }

        // Handle Final CTA Background Upload
        if ($request->hasFile('occasion_cta_bg_file')) {
            $destinationPath = public_path('assets/img/uploads');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file = $request->file('occasion_cta_bg_file');
            $filename = 'occasion_cta_' . time() . '_' . \Illuminate\Support\Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            Setting::updateOrCreate(['key' => 'occasion_cta_bg'], ['value' => 'assets/img/uploads/' . $filename]);
            Cache::forget('setting.occasion_cta_bg');
        }

        return redirect()->back()->with('success', 'Occasions page settings, cards, and CTA updated successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'display_order' => 'required|integer',
        ]);

        $data = $request->except('image_file');

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('services', 'public');
            $data['image'] = 'storage/' . $path;
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Occasion created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'display_order' => 'required|integer',
        ]);

        $data = $request->except('image_file');

        if ($request->hasFile('image_file')) {
            if ($service->image && str_contains($service->image, 'storage/services/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $service->image));
            }
            $path = $request->file('image_file')->store('services', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Occasion updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->image && str_contains($service->image, 'storage/services/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $service->image));
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Occasion deleted successfully.');
    }
}
