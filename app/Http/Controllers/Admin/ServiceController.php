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
     * Update Occasions Page Hero & Header Settings.
     */
    public function updateSettings(Request $request)
    {
        $keys = [
            'occasions_hero_eyebrow',
            'occasions_hero_heading',
            'occasions_hero_lede',
            'festivals_eyebrow',
            'festivals_heading',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
                Cache::forget("setting.{$key}");
            }
        }

        return redirect()->back()->with('success', 'Occasions page header & section settings updated successfully.');
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
