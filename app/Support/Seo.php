<?php

namespace App\Support;

class Seo
{
    /**
     * Every page that has its own editable meta, in dashboard order.
     *
     * The values here are the copy that used to be hard-coded in
     * FrontendController — they stay as the defaults, so nothing changes on the
     * site until someone actually edits a field.
     */
    public const PAGES = [
        'home' => [
            'label' => 'Homepage',
            'route' => 'home',
            'title' => 'Storyloom — The Story Only You Could Give',
            'description' => 'Storyloom transforms your memories into a hand-illustrated keepsake storybook — a one-of-a-kind gift for the people who shaped your life.',
            'keywords' => 'personalized storybook, keepsake books, customized gifts, illustrated storybook, India gifts, anniversaries, birthdays',
        ],
        'about' => [
            'label' => 'About',
            'route' => 'about',
            'title' => 'About Storyloom — Our Mission & Craftsmanship',
            'description' => 'Learn how Storyloom weaves family memories into handbound, illustrated keepsake books crafted by master artisans in India.',
            'keywords' => 'about storyloom, keepsake book studio, illustrated family books, India',
        ],
        'how-it-works' => [
            'label' => 'How It Works',
            'route' => 'how-it-works',
            'title' => 'How It Works — The Journey of a Storyloom',
            'description' => 'From sharing a single memory to reviewing hand-painted spreads, learn the step-by-step process of crafting your keepsake book.',
            'keywords' => 'how it works, custom book process, personalised storybook steps',
        ],
        'library' => [
            'label' => 'Read a Storyloom',
            'route' => 'library',
            'title' => 'Read a Storyloom — Illustrated Keepsake Book Library',
            'description' => 'Explore sample hand-drawn pages, watercolor spreads, and heirloom books created from real family memories.',
            'keywords' => 'storyloom library, sample keepsake book, illustrated storybook examples',
        ],
        'occasions' => [
            'label' => 'Occasions',
            'route' => 'occasions',
            'title' => 'Gifting Occasions — Keepsakes for Milestones',
            'description' => 'Personalised books for anniversaries, Mother\'s Day, Father\'s Day, weddings, retirements, birthdays, and farewelling loved ones.',
            'keywords' => 'anniversary gift, diwali gift, raksha bandhan gift, wedding gift, personalised gifts India',
        ],
        'pricing' => [
            'label' => 'Pricing',
            'route' => 'pricing',
            'title' => 'Pricing & Book Formats — Storyloom',
            'description' => 'Compare our Keepsake and Heirloom custom book editions. Clear pricing for handbound, illustrated storytelling.',
            'keywords' => 'storyloom pricing, custom book cost, personalised storybook price India',
        ],
        'faq' => [
            'label' => 'FAQ',
            'route' => 'faq',
            'title' => 'Good Questions — FAQ | Storyloom',
            'description' => 'Answers to questions about writing, image references, international shipping, print proof reviews, and pricing packages.',
            'keywords' => 'storyloom faq, custom book questions, keepsake book shipping',
        ],
        'journal' => [
            'label' => 'Journal',
            'route' => 'blog.index',
            'title' => 'The Storyloom Journal — Reflections on Memory & Keepsakes',
            'description' => 'Essays, family traditions, memory-keeping ideas, and behind-the-scenes stories from the Storyloom writing and art desk.',
            'keywords' => 'gift guides, memory keeping, family traditions, storyloom journal',
        ],
        'begin' => [
            'label' => 'Begin Your Story',
            'route' => 'begin',
            'title' => 'Begin Your Story — Start a Storybook | Storyloom',
            'description' => 'Start with one memory. Tell us who the book is for, and we\'ll send a personalized plan, timeline, and quote.',
            'keywords' => 'begin your story, commission a book, custom storybook enquiry',
        ],
    ];

    /**
     * Meta for a page: whatever the dashboard holds, falling back to the
     * defaults above so an untouched field still ships sensible copy.
     */
    public static function forPage(string $key): array
    {
        $defaults = self::PAGES[$key] ?? [];

        $seo = [
            'title' => setting("seo_{$key}_title", $defaults['title'] ?? ''),
            'description' => setting("seo_{$key}_description", $defaults['description'] ?? ''),
            'keywords' => setting("seo_{$key}_keywords", $defaults['keywords'] ?? ''),
        ];

        // Per-page share image is optional; blank means the site-wide one.
        $image = trim((string) setting("seo_{$key}_image", ''));

        if ($image !== '') {
            $seo['image'] = $image;
        }

        return $seo;
    }

    /** The setting keys for one page, used by the admin form. */
    public static function keysFor(string $key): array
    {
        return [
            "seo_{$key}_title",
            "seo_{$key}_description",
            "seo_{$key}_keywords",
            "seo_{$key}_image",
        ];
    }
}
