<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class HeroController extends Controller
{
    /**
     * Show the form for editing the Arc Carousel Hero section.
     */
    public function edit()
    {
        $hero = Hero::first() ?: new Hero();
        
        $rawCards = setting('hero_cards');
        $carouselCards = [];
        if ($rawCards) {
            $carouselCards = is_array($rawCards) ? $rawCards : json_decode($rawCards, true);
        }
        
        if (empty($carouselCards)) {
            $carouselCards = [
                ['image' => 'assets/img/hero-reading-hilltop.webp', 'title' => '"The First Home"', 'caption' => 'a Storyloom for an anniversary'],
                ['image' => 'assets/img/spread-home-morning.webp', 'title' => '"Sunday Morning Chai"', 'caption' => 'a Storyloom for Dad'],
                ['image' => 'assets/img/spread-flower-street.webp', 'title' => '"The Evening Walk"', 'caption' => 'a Storyloom for Mom'],
                ['image' => 'assets/img/spread-shared-fries.webp', 'title' => '"One Plate, Two Forks"', 'caption' => 'a Storyloom for a sister'],
                ['image' => 'assets/img/spread-under-stars.webp', 'title' => '"Under the Stars"', 'caption' => 'a Storyloom for a proposal'],
            ];
        }

        return view('admin.hero.edit', compact('hero', 'carouselCards'));
    }

    /**
     * Update the Arc Carousel Hero section.
     */
    public function update(Request $request)
    {
        $request->validate([
            'heading' => 'required|string',
            'subheading' => 'nullable|string',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|string',
            'hero_cards_file.*' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
        ]);

        $hero = Hero::first();
        if ($hero) {
            $hero->update($request->all());
        } else {
            Hero::create($request->all());
        }

        // Handle Extra Hero Settings
        $extraSettings = [
            'hero_subheading' => $request->input('subheading'),
            'hero_heading' => $request->input('heading'),
            'hero_description' => $request->input('description'),
            'hero_btn1_text' => $request->input('button_text'),
            'hero_btn1_link' => $request->input('button_link'),
            'hero_btn2_text' => $request->input('hero_btn2_text'),
            'hero_btn2_link' => $request->input('hero_btn2_link'),
            'hero_note' => $request->input('hero_note'),
            'hero_carousel_speed' => $request->input('hero_carousel_speed'),
        ];

        foreach ($extraSettings as $key => $val) {
            if ($val !== null) {
                Setting::updateOrCreate(['key' => $key], ['value' => $val]);
                Cache::forget("setting.{$key}");
            }
        }

        // Process Carousel Cards Array
        if ($request->has('hero_cards')) {
            $cards = [];
            foreach ($request->input('hero_cards') as $index => $cardData) {
                $imagePath = $cardData['image'] ?? 'assets/img/hero-reading-hilltop.webp';

                // Check if a direct file was uploaded for this card
                if ($request->hasFile("hero_cards_file.{$index}")) {
                    $file = $request->file("hero_cards_file.{$index}");
                    $filename = 'hero_card_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('assets/img/hero');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    $file->move($destinationPath, $filename);
                    $imagePath = 'assets/img/hero/' . $filename;
                }

                if (!empty($cardData['title']) || !empty($imagePath)) {
                    $cards[] = [
                        'image' => $imagePath,
                        'title' => $cardData['title'] ?? '',
                        'caption' => $cardData['caption'] ?? '',
                    ];
                }
            }
            Setting::updateOrCreate(
                ['key' => 'hero_cards'],
                ['value' => json_encode($cards)]
            );
            Cache::forget('setting.hero_cards');
        }

        Cache::forget('home_hero');

        return back()->with('success', 'Hero Arc Carousel section updated successfully.');
    }

    /**
     * Upload an image for a Hero Arc Carousel card via AJAX.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'hero_card_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('assets/img/hero');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $relativePath = 'assets/img/hero/' . $filename;

            return response()->json([
                'success' => true,
                'url' => $relativePath,
                'asset_url' => asset($relativePath)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded.'], 400);
    }
}
