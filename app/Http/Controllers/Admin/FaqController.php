<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ordered exactly as the public page groups them, so the list here reads
        // in the same order a visitor sees. Not paginated: sections only make
        // sense when the whole set is on one screen.
        $faqs = Faq::orderBy('section_order')->orderBy('section')
            ->orderBy('display_order')->orderBy('id')->get();
        $sections = Faq::sections();

        return view('admin.faqs.index', compact('faqs', 'sections'));
    }

    /**
     * Update FAQ Page Hero & CTA Settings.
     */
    public function updateSettings(Request $request)
    {
        $keys = [
            'faq_hero_eyebrow',
            'faq_hero_heading',
            'faq_hero_lede',
            'faq_cta_heading',
            'faq_cta_desc',
            'faq_cta_btn1_text',
            'faq_cta_btn1_link',
            'faq_cta_bg',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
                Cache::forget("setting.{$key}");
            }
        }

        if ($request->hasFile('faq_cta_bg_file')) {
            $destinationPath = public_path('assets/img/uploads');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file = $request->file('faq_cta_bg_file');
            $filename = 'faq_cta_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            Setting::updateOrCreate(['key' => 'faq_cta_bg'], ['value' => 'assets/img/uploads/' . $filename]);
            Cache::forget('setting.faq_cta_bg');
        }

        return redirect()->back()->with('success', 'FAQ page hero header & CTA settings updated successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'section' => 'nullable|string|max:120',
            'section_order' => 'nullable|integer',
            'display_order' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        Faq::create($request->all());

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'section' => 'nullable|string|max:120',
            'section_order' => 'nullable|integer',
            'display_order' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        $faq->update($request->all());

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully.');
    }
}
