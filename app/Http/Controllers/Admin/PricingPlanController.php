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
     * Update Pricing Page Hero & Custom CTA Settings.
     */
    public function updateSettings(Request $request)
    {
        $keys = [
            'pricing_hero_eyebrow',
            'pricing_hero_heading',
            'pricing_hero_lede',
            'pricing_note_text',
            'pricing_custom_title',
            'pricing_custom_desc',
            'pricing_custom_btn_text',
            'pricing_custom_btn_link',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
                Cache::forget("setting.{$key}");
            }
        }

        return redirect()->back()->with('success', 'Pricing page header & CTA settings updated successfully.');
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
