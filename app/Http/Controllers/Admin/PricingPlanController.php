<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PricingPlanController extends Controller
{
    /**
     * Display a listing of pricing plans & page settings.
     */
    public function index()
    {
        $plans = PricingPlan::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pricing.index', compact('plans'));
    }

    /**
     * Update Pricing Page Hero, Stats, Essay & CTA Settings.
     */
    public function updateSettings(Request $request)
    {
        $keys = [
            'pricing_hero_eyebrow',
            'pricing_hero_title',
            'pricing_hero_lede',
            'pricing_stat1_num',
            'pricing_stat1_lbl',
            'pricing_stat2_num',
            'pricing_stat2_lbl',
            'pricing_stat3_num',
            'pricing_stat3_lbl',
            'pricing_grid_subnote',
            'pricing_popular_label',
            'price_note_eyebrow',
            'price_note_heading',
            'price_note_p1',
            'price_note_p2',
            'pricing_cta_heading',
            'pricing_cta_desc',
            'pricing_cta_btn1_text',
            'pricing_cta_btn1_link',
            'pricing_cta_bg',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
                Cache::forget("setting.{$key}");
            }
        }

        if ($request->hasFile('pricing_cta_bg_file')) {
            $destinationPath = public_path('assets/img/uploads');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file = $request->file('pricing_cta_bg_file');
            $filename = 'pricing_cta_' . time() . '_' . \Illuminate\Support\Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            Setting::updateOrCreate(['key' => 'pricing_cta_bg'], ['value' => 'assets/img/uploads/' . $filename]);
            Cache::forget('setting.pricing_cta_bg');
        }

        return redirect()->back()->with('success', 'Pricing page hero, stats, essay, and CTA settings updated successfully.');
    }

    /**
     * Show the form for creating a new pricing plan.
     */
    public function create()
    {
        return view('admin.pricing.create');
    }

    /**
     * Store a newly created pricing plan in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0|gte:price',
            'discount_label' => 'nullable|string|max:40',
            'duration' => 'required|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'popular_plan' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
            'features' => 'required|array',
            'features.*' => 'required|string'
        ]);

        $data = $request->all();
        $data['popular_plan'] = $request->has('popular_plan');
        $data['features'] = array_values(array_filter($request->input('features')));

        // Blank discount inputs must land as NULL, not as an empty string a
        // decimal column would coerce to 0.00 and render as "100% off".
        $data['compare_price'] = filled($request->input('compare_price'))
            ? $request->input('compare_price')
            : null;
        $data['discount_label'] = filled($request->input('discount_label'))
            ? trim($request->input('discount_label'))
            : null;

        PricingPlan::create($data);

        return redirect()->route('admin.pricing.index')->with('success', 'Pricing plan created successfully.');
    }

    /**
     * Show the form for editing the specified pricing plan.
     */
    public function edit(PricingPlan $pricing)
    {
        return view('admin.pricing.edit', compact('pricing'));
    }

    /**
     * Update the specified pricing plan in storage.
     */
    public function update(Request $request, PricingPlan $pricing)
    {
        $request->validate([
            'plan_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0|gte:price',
            'discount_label' => 'nullable|string|max:40',
            'duration' => 'required|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'popular_plan' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
            'features' => 'required|array',
            'features.*' => 'required|string'
        ]);

        $data = $request->all();
        $data['popular_plan'] = $request->has('popular_plan');
        $data['features'] = array_values(array_filter($request->input('features')));

        // Blank discount inputs must land as NULL, not as an empty string a
        // decimal column would coerce to 0.00 and render as "100% off".
        $data['compare_price'] = filled($request->input('compare_price'))
            ? $request->input('compare_price')
            : null;
        $data['discount_label'] = filled($request->input('discount_label'))
            ? trim($request->input('discount_label'))
            : null;

        $pricing->update($data);

        return redirect()->route('admin.pricing.index')->with('success', 'Pricing plan updated successfully.');
    }

    /**
     * Remove the specified pricing plan from storage.
     */
    public function destroy(PricingPlan $pricing)
    {
        $pricing->delete();
        return redirect()->route('admin.pricing.index')->with('success', 'Pricing plan deleted successfully.');
    }
}
