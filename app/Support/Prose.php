<?php

namespace App\Support;

use Illuminate\Support\Str;

class Prose
{
    /**
     * Turn a single admin text box into paragraph markup.
     *
     * Editors write naturally — blank line between paragraphs — and get proper
     * <p> tags out. Anyone who prefers to hand-write HTML can do that instead
     * and it is passed through untouched.
     *
     * @param  string|null  $firstClass  class applied to the opening paragraph
     *                                   only (the About page uses it for the
     *                                   drop cap).
     */
    public static function paragraphs(?string $text, ?string $firstClass = null): string
    {
        $text = trim((string) $text);

        if ($text === '') {
            return '';
        }

        // Already marked up — leave the author's HTML alone.
        if (Str::contains($text, ['<p', '<div', '<ul', '<ol'])) {
            return $text;
        }

        // A blank line starts a new paragraph; a single newline is just a wrap.
        $chunks = preg_split('/\R\s*\R/', $text);
        $out = '';

        foreach ($chunks as $i => $chunk) {
            $chunk = trim($chunk);

            if ($chunk === '') {
                continue;
            }

            $class = ($i === 0 && $firstClass) ? ' class="' . e($firstClass) . '"' : '';
            // Inline tags the editor typed (<em>, <strong>, <br>) survive; only
            // the paragraph structure is added.
            $out .= '<p' . $class . '>' . nl2br($chunk) . '</p>';
        }

        return $out;
    }

    /**
     * Collapse legacy per-paragraph settings into one blank-line separated
     * block, so a split-field section can be edited as a single box without
     * losing what was already written.
     */
    public static function join(array $parts): string
    {
        return collect($parts)
            ->map(fn ($p) => trim((string) $p))
            ->filter()
            ->implode("\n\n");
    }
}
