<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Search and share metadata for every page.
 *
 * Previously only the homepage had editable meta; every other page's title and
 * description were hard-coded in FrontendController, so they could not be
 * tuned without a deploy.
 */
class SeoController extends Controller
{
    public function index()
    {
        return view('admin.seo.index');
    }

    public function update(Request $request)
    {
        foreach (array_keys(Seo::PAGES) as $page) {
            foreach (Seo::keysFor($page) as $key) {
                if (! $request->has($key)) {
                    continue;
                }

                Setting::updateOrCreate(['key' => $key], ['value' => trim((string) $request->input($key))]);
                Cache::forget("setting.{$key}");
            }

            // Optional per-page share image.
            $fileKey = "seo_{$page}_image_file";

            if ($request->hasFile($fileKey) && $request->file($fileKey)->isValid()) {
                $dir = public_path('assets/img/uploads');

                if (! file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }

                $file = $request->file($fileKey);
                $name = 'share_' . $page . '_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->move($dir, $name);

                Setting::updateOrCreate(
                    ['key' => "seo_{$page}_image"],
                    ['value' => 'assets/img/uploads/' . $name]
                );
                Cache::forget("setting.seo_{$page}_image");
            }
        }

        return redirect()->back()->with('success', 'Page SEO updated successfully.');
    }
}
