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
