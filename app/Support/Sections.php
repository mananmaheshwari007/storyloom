<?php

namespace App\Support;

/**
 * Show/hide page sections from the dashboard, without leaving a hole behind.
 *
 * Hiding a section is the easy half. The hard half is that the page's rhythm
 * comes from alternating tinted and plain backgrounds, and those were hard-coded
 * per section — so removing one could leave two tinted sections touching, which
 * reads as a single oversized block. Rather than fixing the classes by hand for
 * every combination, the tint is decided at render time from what is actually
 * being shown.
 */
class Sections
{
    /**
     * Every toggleable section, by page, in the order it appears on that page.
     *
     * Single source of truth: the templates read from it and the dashboard
     * builds its switches from it, so a section can never be listed in one and
     * missing from the other.
     */
    public const PAGES = [
        'home' => ['label' => 'Homepage', 'route' => 'home', 'sections' => [
            'problem'     => 'The trouble with gifts',
            'reveal'      => 'Your story, woven into a book',
            'story'       => 'Who is your story for?',
            'process'     => 'The plan (three steps)',
            'why'         => 'Why Storyloom',
            'testimonial' => 'Testimonial band',
            'marquee'     => 'For every occasion',
            'faqteaser'   => 'FAQ teaser',
            'cta'         => 'Final call to action',
        ]],
        'about' => ['label' => 'About', 'route' => 'about', 'sections' => [
            'about_hero'    => 'Hero & story prose',
            'about_stand'   => 'What we stand for',
            'about_mark'    => 'The mark we make',
            'about_founder' => 'A note from the founder',
            'about_cta'     => 'Final call to action',
        ]],
        'how-it-works' => ['label' => 'How It Works', 'route' => 'how-it-works', 'sections' => [
            'how_hero'     => 'Hero',
            'how_timeline' => 'The timeline',
            'how_stats'    => 'Stats strip',
            'how_craft'    => 'Quality you can feel',
            'how_cta'      => 'Final call to action',
        ]],
        'library' => ['label' => 'Read a Storyloom', 'route' => 'library', 'sections' => [
            'library_hero'     => 'Hero',
            'library_featured' => 'Featured books',
            'library_shelf'    => 'On the shelf',
            'library_cta'      => 'Final call to action',
        ]],
        'occasions' => ['label' => 'Occasions', 'route' => 'occasions', 'sections' => [
            'occasions_hero'          => 'Hero',
            'occasions_festivals'     => 'Festivals & celebrations',
            'occasions_milestones'    => 'Milestones',
            'occasions_relationships' => 'By relationship',
            'occasions_cta'           => 'Final call to action',
        ]],
        'pricing' => ['label' => 'Pricing', 'route' => 'pricing', 'sections' => [
            'pricing_hero'  => 'Hero',
            'pricing_cards' => 'Stats & pricing tiers',
            'pricing_note'  => 'A note on price',
            'pricing_cta'   => 'Final call to action',
        ]],
        'faq' => ['label' => 'FAQ', 'route' => 'faq', 'sections' => [
            'faq_hero' => 'Hero',
            'faq_list' => 'The questions',
            'faq_cta'  => 'Final call to action',
        ]],
        'journal' => ['label' => 'Journal', 'route' => 'blog.index', 'sections' => [
            'journal_hero' => 'Hero & topic filters',
            'journal_list' => 'Featured article & grid',
            'journal_cta'  => 'Final call to action',
        ]],
        'begin' => ['label' => 'Begin Your Story', 'route' => 'begin', 'sections' => [
            'begin_hero' => 'Hero',
            'begin_form' => 'Contact card & enquiry form',
        ]],
    ];

    /**
     * Sections that empty the page if switched off — the dashboard warns before
     * letting one go, rather than silently leaving a blank page.
     */
    public const CRITICAL = ['faq_list', 'begin_form', 'pricing_cards', 'journal_list'];

    /** Next light section gets the tint. Flips on each tint() call. */
    private static bool $tintNext = true;

    /**
     * Is this section switched on?
     *
     * Absent means visible — a section only disappears if someone deliberately
     * turned it off, never because a setting hasn't been created yet.
     */
    public static function enabled(string $key): bool
    {
        return setting('section_' . $key, '1') !== '0';
    }

    /**
     * Background classes for the next light section, alternating so no two
     * tinted sections ever end up side by side.
     */
    public static function tint(): string
    {
        $class = self::$tintNext ? 'section-tint grain' : 'grain';
        self::$tintNext = ! self::$tintNext;

        return $class;
    }

    /**
     * Call after a full-bleed or dark section. Those break the run visually, so
     * the next light section should start the alternation over rather than
     * continue it and land on plain-next-to-plain.
     */
    public static function breakTint(): void
    {
        self::$tintNext = true;
    }
}
