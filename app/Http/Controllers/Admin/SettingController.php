<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display settings list.
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $inputs = $request->except('_token');

        // Handle regular inputs
        foreach ($inputs as $key => $value) {
            if ($request->hasFile($key)) {
                continue; // Process files separately
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value) : $value]
            );
            Cache::forget("setting.{$key}");
        }

        // Handle file uploads
        if ($request->files) {
            foreach ($request->files as $key => $file) {
                if ($request->hasFile($key) && $request->file($key)->isValid()) {
                    $uploadPath = public_path('uploads/settings');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    $extension = $request->file($key)->getClientOriginalExtension();
                    $filename = $key . '_' . time() . '.' . $extension;
                    $request->file($key)->move($uploadPath, $filename);

                    $relativePath = 'uploads/settings/' . $filename;
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $relativePath]
                    );
                    Cache::forget("setting.{$key}");
                }
            }
        }

        return back()->with('success', 'Website settings and page content updated successfully.');
    }
}
