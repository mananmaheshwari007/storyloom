<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Faq extends Model
{
    protected $table = 'faqs';

    /** Where questions land when no section has been chosen. */
    public const DEFAULT_SECTION = 'General';

    protected $fillable = [
        'question',
        'answer',
        'section',
        'section_order',
        'display_order',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Active questions grouped under their section heading.
     *
     * Groups are ordered by section_order, then alphabetically so a new section
     * left at the default order still lands somewhere predictable. Questions
     * keep their own display_order within each group.
     *
     * @return Collection<string, Collection<int, Faq>>
     */
    public static function grouped(): Collection
    {
        return static::active()
            ->orderBy('section_order')
            ->orderBy('section')
            ->orderBy('display_order')
            ->orderBy('id')
            ->get()
            ->groupBy(fn (self $faq) => trim((string) $faq->section) ?: self::DEFAULT_SECTION);
    }

    /**
     * The #anchor of the first section matching a keyword, for linking straight
     * to a topic from elsewhere on the site.
     *
     * Matched loosely on purpose: the footer link should survive the section
     * being renamed from "Shipping" to "Shipping & Delivery" to "Delivery and
     * Shipping". Returns an empty string when nothing matches, so the caller
     * falls back to the top of the FAQ page rather than a dead anchor.
     */
    public static function sectionAnchor(string $needle): string
    {
        $needle = \Illuminate\Support\Str::slug($needle);

        $match = static::sections()->first(
            fn ($section) => str_contains(\Illuminate\Support\Str::slug($section), $needle)
        );

        return $match ? '#' . \Illuminate\Support\Str::slug($match) : '';
    }

    /** Section names already in use, for the admin's suggestion list. */
    public static function sections(): Collection
    {
        return static::query()
            ->whereNotNull('section')
            ->where('section', '!=', '')
            ->orderBy('section_order')
            ->orderBy('section')
            ->pluck('section')
            ->unique()
            ->values();
    }
}
