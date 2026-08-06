<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * One screen for every section on every page.
 *
 * The homepage editor has its own copy of the homepage switches; both write the
 * same `section_*` settings, so they can't disagree.
 */
class SectionVisibilityController extends Controller
{
    public function index()
    {
        return view('admin.sections.index');
    }

    public function update(Request $request)
    {
        foreach (Sections::PAGES as $page) {
            foreach (array_keys($page['sections']) as $key) {
                $field = 'section_' . $key;

                if (! $request->has($field)) {
                    continue;
                }

                Setting::updateOrCreate(
                    ['key' => $field],
                    ['value' => $request->input($field) === '1' ? '1' : '0']
                );
                Cache::forget("setting.{$field}");
            }
        }

        return redirect()->back()->with('success', 'Section visibility updated.');
    }
}
