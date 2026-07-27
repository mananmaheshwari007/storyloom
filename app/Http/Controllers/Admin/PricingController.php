<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::latest()->paginate(10);
        return view('admin.pricing.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.pricing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'features' => 'required|array',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'popular' => 'required|boolean',
            'status' => 'required|boolean'
        ]);

        $data = $request->only(['name', 'price', 'duration', 'button_text', 'button_url', 'popular', 'status']);
        
        $features = array_filter(array_map('trim', $request->input('features')));
        $data['features'] = array_values($features);

        PricingPlan::create($data);

        return redirect()->route('admin.pricing.index')->with('success', 'Pricing plan created successfully.');
    }

    public function edit(PricingPlan $pricing)
    {
        return view('admin.pricing.edit', compact('pricing'));
    }

    public function update(Request $request, PricingPlan $pricing)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'features' => 'required|array',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'popular' => 'required|boolean',
            'status' => 'required|boolean'
        ]);

        $data = $request->only(['name', 'price', 'duration', 'button_text', 'button_url', 'popular', 'status']);
        
        $features = array_filter(array_map('trim', $request->input('features')));
        $data['features'] = array_values($features);

        $pricing->update($data);

        return redirect()->route('admin.pricing.index')->with('success', 'Pricing plan updated successfully.');
    }

    public function destroy(PricingPlan $pricing)
    {
        $pricing->delete();
        return redirect()->route('admin.pricing.index')->with('success', 'Pricing plan deleted successfully.');
    }
}
