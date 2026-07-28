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
     * Show the form for editing the Homepage (Hero, Relationship Story Cards, Artwork Spreads, Emblem, and CTA).
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

        // Who Is Your Story For Cards
        $rawStoryCards = setting('story_for_cards');
        $storyForCards = [];
        if ($rawStoryCards) {
            $storyForCards = is_array($rawStoryCards) ? $rawStoryCards : json_decode($rawStoryCards, true);
        }

        if (empty($storyForCards)) {
            $storyForCards = [
                ['image' => 'assets/img/spread-bench-sunset.webp', 'title' => 'For Your Wife', 'hint' => 'anniversaries · birthdays', 'link' => '/occasions'],
                ['image' => 'assets/img/spread-sunday-breakfast.webp', 'title' => 'For Your Mom & Dad', 'hint' => 'parents 50th · retirement', 'link' => '/occasions'],
                ['image' => 'assets/img/spread-bicycle-lesson.webp', 'title' => 'For Your Sister / Brother', 'hint' => 'rakhi · milestone birthdays', 'link' => '/occasions'],
                ['image' => 'assets/img/spread-under-stars.webp', 'title' => 'For Your Husband / Partner', 'hint' => 'proposals · weddings', 'link' => '/occasions'],
                ['image' => 'assets/img/spread-shared-fries.webp', 'title' => 'For Your Daughter / Son', 'hint' => 'graduations · first home', 'link' => '/occasions'],
                ['image' => 'assets/img/spread-flower-street.webp', 'title' => 'For Your Grandmother / Grandfather', 'hint' => '80th birthday · family legacy', 'link' => '/occasions'],
            ];
        }

        return view('admin.hero.edit', compact('hero', 'carouselCards', 'storyForCards'));
    }

    /**
     * Update the Homepage content, artwork images, emblem, and CTA.
     */
    public function update(Request $request)
    {
        $request->validate([
            'heading' => 'required|string',
            'subheading' => 'nullable|string',
            'description' => 'nullable|string',
            'hero_cards_file.*' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'story_for_cards_file.*' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'site_emblem_file' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif,svg|max:2048',
            'cta_bg_image_file' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:4096',
            'reveal_plate1_file' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:3072',
            'reveal_plate2_file' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:3072',
            'reveal_plate3_file' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:3072',
        ]);

        $hero = Hero::first();
        if ($hero) {
            $hero->update($request->all());
        } else {
            Hero::create($request->all());
        }

        // Process File Uploads for Emblem, CTA Background, and Reveal Spreads
        $destinationPath = public_path('assets/img/uploads');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $imageUploadKeys = [
            'site_emblem_file' => 'site_emblem',
            'cta_bg_image_file' => 'cta_bg_image',
            'reveal_plate1_file' => 'reveal_plate1_image',
            'reveal_plate2_file' => 'reveal_plate2_image',
            'reveal_plate3_file' => 'reveal_plate3_image',
        ];

        foreach ($imageUploadKeys as $fileInputName => $settingKey) {
            if ($request->hasFile($fileInputName)) {
                $file = $request->file($fileInputName);
                $filename = $settingKey . '_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                Setting::updateOrCreate(['key' => $settingKey], ['value' => 'assets/img/uploads/' . $filename]);
                Cache::forget("setting.{$settingKey}");
            } elseif ($request->filled($settingKey)) {
                Setting::updateOrCreate(['key' => $settingKey], ['value' => $request->input($settingKey)]);
                Cache::forget("setting.{$settingKey}");
            }
        }

        // Process Text & Copy Homepage Settings
        $extraSettings = [
            // Hero
            'hero_subheading' => $request->input('subheading'),
            'hero_heading' => $request->input('heading'),
            'hero_description' => $request->input('description'),
            'hero_btn1_text' => $request->input('button_text'),
            'hero_btn1_link' => $request->input('button_link'),
            'hero_btn2_text' => $request->input('hero_btn2_text'),
            'hero_btn2_link' => $request->input('hero_btn2_link'),
            'hero_note' => $request->input('hero_note'),
            'hero_carousel_speed' => $request->input('hero_carousel_speed'),

            // Problem
            'problem_eyebrow' => $request->input('problem_eyebrow'),
            'problem_heading' => $request->input('problem_heading'),
            'problem_lede' => $request->input('problem_lede'),

            // Reveal
            'reveal_eyebrow' => $request->input('reveal_eyebrow'),
            'reveal_heading' => $request->input('reveal_heading'),
            'reveal_lede' => $request->input('reveal_lede'),
            'reveal_plate1_caption' => $request->input('reveal_plate1_caption'),
            'reveal_plate2_caption' => $request->input('reveal_plate2_caption'),
            'reveal_plate3_caption' => $request->input('reveal_plate3_caption'),

            // Story For Section
            'story_for_eyebrow' => $request->input('story_for_eyebrow'),
            'story_for_heading' => $request->input('story_for_heading'),

            // Transformation
            'transform_before_quote' => $request->input('transform_before_quote'),
            'transform_before_who' => $request->input('transform_before_who'),
            'transform_after_quote' => $request->input('transform_after_quote'),
            'transform_after_who' => $request->input('transform_after_who'),

            // CTA
            'cta_eyebrow' => $request->input('cta_eyebrow'),
            'cta_heading' => $request->input('cta_heading'),
            'cta_desc' => $request->input('cta_desc'),
            'cta_btn1_text' => $request->input('cta_btn1_text'),
            'cta_btn1_link' => $request->input('cta_btn1_link'),
            'cta_btn2_text' => $request->input('cta_btn2_text'),
            'cta_btn2_link' => $request->input('cta_btn2_link'),
            'cta_subnote_text' => $request->input('cta_subnote_text'),
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

                if ($request->hasFile("hero_cards_file.{$index}")) {
                    $file = $request->file("hero_cards_file.{$index}");
                    $filename = 'hero_card_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $filename);
                    $imagePath = 'assets/img/uploads/' . $filename;
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

        // Process Who Is Your Story For Cards Array
        if ($request->has('story_for_cards')) {
            $sCards = [];
            foreach ($request->input('story_for_cards') as $index => $cardData) {
                $imagePath = $cardData['image'] ?? 'assets/img/spread-bench-sunset.webp';

                if ($request->hasFile("story_for_cards_file.{$index}")) {
                    $file = $request->file("story_for_cards_file.{$index}");
                    $filename = 'story_for_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $filename);
                    $imagePath = 'assets/img/uploads/' . $filename;
                }

                if (!empty($cardData['title']) || !empty($imagePath)) {
                    $sCards[] = [
                        'image' => $imagePath,
                        'title' => $cardData['title'] ?? '',
                        'hint' => $cardData['hint'] ?? '',
                        'link' => $cardData['link'] ?? '/occasions',
                    ];
                }
            }
            Setting::updateOrCreate(
                ['key' => 'story_for_cards'],
                ['value' => json_encode($sCards)]
            );
            Cache::forget('setting.story_for_cards');
        }

        Cache::forget('home_hero');

        return back()->with('success', 'Homepage content, relationship cards, artwork images, and CTA settings updated successfully.');
    }

    /**
     * Upload an image for a Hero Arc Carousel card or Homepage section via AJAX.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,webp,avif,svg|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'home_img_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('assets/img/uploads');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $relativePath = 'assets/img/uploads/' . $filename;

            return response()->json([
                'success' => true,
                'url' => $relativePath,
                'asset_url' => asset($relativePath)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded.'], 400);
    }
}
