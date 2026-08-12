<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Turns the Journal editor's block array into the exact article markup
 * used by the static Storyloom journal pages (.article-body, .pull-quote,
 * .takeaway, .inline-cta ...), so posts written in the admin render
 * identically to the hand-built ones.
 */
class JournalRenderer
{
    /** Promotional book card used when an article doesn't define its own. */
    public const DEFAULT_PROMO = [
        'enabled'  => true,
        'heading'  => 'This is the entire idea behind Storyloom',
        'body'     => 'We turn the small, specific details of your family — the chai stall, the nickname, the sofa corner — into a hand-illustrated keepsake book. You can read a real one, cover to cover, before you decide anything.',
        'cover'    => 'assets/img/book1/cover.webp',
        'cta_text' => 'Read a real book',
        'cta_url'  => 'library?book=1',
    ];

    /** Sticky book card shown beside the article. */
    public const DEFAULT_SIDEBAR = [
        'enabled'  => true,
        'label'    => 'Give the rare one',
        'heading'  => 'Their story, illustrated by hand.',
        'body'     => 'Written from your memories, painted around your people. Three to five weeks, start to doorstep.',
        'cover'    => 'assets/img/book2/cover.webp',
        'cta_text' => 'Begin Your Story',
        'cta_url'  => 'begin',
    ];

    /**
     * The house default book cards. Editable site-wide in
     * Journal > Default book; the constants above are the fallback.
     */
    public static function defaultPromo(): array
    {
        $saved = json_decode((string) setting('journal_default_promo'), true);
        return is_array($saved) ? array_merge(self::DEFAULT_PROMO, $saved) : self::DEFAULT_PROMO;
    }

    public static function defaultSidebar(): array
    {
        $saved = json_decode((string) setting('journal_default_sidebar'), true);
        return is_array($saved) ? array_merge(self::DEFAULT_SIDEBAR, $saved) : self::DEFAULT_SIDEBAR;
    }

    /** Inline formatting allowed inside text blocks. */
    private const ALLOWED_INLINE = '<strong><b><em><i><a><br><span>';

    public function render(array $blocks, ?array $promo = null, bool $showPromo = true): string
    {
        $html = [];

        foreach ($blocks as $block) {
            $type = $block['type'] ?? null;

            $html[] = match ($type) {
                'heading'   => $this->heading($block),
                'paragraph' => $this->paragraph($block),
                'image'     => $this->image($block),
                'quote'     => $this->quote($block),
                'takeaway'  => $this->takeaway($block),
                'list'      => $this->list($block),
                'table'     => $this->table($block),
                'promo'     => $showPromo ? $this->promo($block['promo'] ?? null) : '',
                'divider'   => '<hr class="article-rule">',
                default     => '',
            };
        }

        return implode("\n", array_filter($html));
    }

    /** Section headings double as table-of-contents anchors. */
    private function heading(array $b): string
    {
        $text  = $this->clean($b['text'] ?? '');
        if ($text === '') return '';
        $level = ($b['level'] ?? 'h2') === 'h3' ? 'h3' : 'h2';
        $id    = Str::slug(strip_tags($text)) ?: Str::random(6);

        return sprintf('<%s id="%s">%s</%s>', $level, $id, $text, $level);
    }

    private function paragraph(array $b): string
    {
        $text = $this->clean($b['text'] ?? '');
        if ($text === '') return '';
        // "lead-in" gives the first paragraph its drop cap.
        $class = !empty($b['lead']) ? ' class="lead-in"' : '';

        return "<p{$class}>{$text}</p>";
    }

    private function resolveUrl(string $url): string
    {
        $url = trim($url);
        if ($url === '') return '';
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, 'data:') || str_starts_with($url, '//')) {
            return $url;
        }
        return asset(ltrim($url, '/'));
    }

    private function image(array $b): string
    {
        $src = trim($b['src'] ?? '');
        if ($src === '') return '';
        $srcUrl  = $this->resolveUrl($src);
        $alt     = e($b['alt'] ?? '');
        $caption = $this->clean($b['caption'] ?? '');
        $figcap  = $caption !== '' ? "\n  <figcaption>{$caption}</figcaption>" : '';

        return '<figure class="article-figure plate">' . "\n"
            . '  <img src="' . e($srcUrl) . '" alt="' . $alt . '" loading="lazy">'
            . $figcap . "\n" . '</figure>';
    }

    private function quote(array $b): string
    {
        $text = $this->clean($b['text'] ?? '');
        if ($text === '') return '';
        $cite = $this->clean($b['cite'] ?? '');
        $c    = $cite !== '' ? "\n  <cite>{$cite}</cite>" : '';

        return '<blockquote class="pull-quote">' . "\n  " . $text . $c . "\n" . '</blockquote>';
    }

    private function takeaway(array $b): string
    {
        $text = $this->clean($b['text'] ?? '');
        if ($text === '') return '';
        $label = e($b['label'] ?? 'The takeaway');
        $icon  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 12.5l5 5L20 6.5"/></svg>';

        return '<div class="takeaway">' . "\n"
            . '  <p class="tk-label">' . $icon . ' ' . $label . '</p>' . "\n"
            . '  <p>' . $text . '</p>' . "\n"
            . '</div>';
    }

    private function list(array $b): string
    {
        $items = array_filter(
            $b['items'] ?? [],
            fn ($i) => trim(strip_tags(($i['lead'] ?? '') . ($i['text'] ?? ''))) !== ''
        );
        if (!$items) return '';

        $newline    = !empty($b['newline']);
        $isNumbered = (($b['list_style'] ?? 'bulleted') === 'numbered');
        $tag        = $isNumbered ? 'ol' : 'ul';
        $class      = $isNumbered ? 'article-list is-numbered' : 'article-list';

        $out = [];
        foreach ($items as $item) {
            $lead = $this->clean($item['lead'] ?? '');
            $text = $this->clean($item['text'] ?? '');
            if ($lead !== '') {
                $leadMarkup = (str_starts_with(strtolower($lead), '<strong') || str_starts_with(strtolower($lead), '<b'))
                    ? $lead
                    : "<strong>{$lead}</strong>";
                if ($newline) {
                    $out[] = '  <li>' . $leadMarkup . '<br>' . $text . '</li>';
                } else {
                    $out[] = '  <li>' . $leadMarkup . ' ' . $text . '</li>';
                }
            } else {
                $out[] = '  <li>' . $text . '</li>';
            }
        }

        return "<{$tag} class=\"{$class}\">\n" . implode("\n", $out) . "\n</{$tag}>";
    }

    private function table(array $b): string
    {
        $head = $b['head'] ?? [];
        $rows = $b['rows'] ?? [];
        if (!$head && !$rows) return '';

        $out = ['<div class="table-wrap">', '<table class="article-table">'];

        if (array_filter($head, fn ($c) => trim((string) $c) !== '')) {
            $out[] = '  <thead><tr>';
            foreach ($head as $cell) $out[] = '    <th>' . $this->clean($cell) . '</th>';
            $out[] = '  </tr></thead>';
        }

        if ($rows) {
            $out[] = '  <tbody>';
            foreach ($rows as $row) {
                if (!array_filter($row, fn ($c) => trim((string) $c) !== '')) continue;
                $out[] = '    <tr>';
                foreach ($row as $cell) $out[] = '      <td>' . $this->clean($cell) . '</td>';
                $out[] = '    </tr>';
            }
            $out[] = '  </tbody>';
        }

        $out[] = '</table>';
        $out[] = '</div>';

        if (!empty($b['caption'])) {
            $out[] = '<p class="table-caption">' . $this->clean($b['caption']) . '</p>';
        }

        return implode("\n", $out);
    }

    /** The promotional book card — per-article, falling back to the default. */
    private function promo(?array $p): string
    {
        $p = array_merge(self::defaultPromo(), array_filter((array) $p, fn ($v) => $v !== null && $v !== ''));

        if (isset($p['enabled']) && !$p['enabled']) return '';

        // Auto-fetch targeted LibraryBook cover image if specified
        $bookId = null;
        if (!empty($p['cta_url']) && preg_match('/book[=_](\d+)/i', $p['cta_url'], $matches)) {
            $bookId = (int)$matches[1];
        }
        if (!$bookId && !empty($p['library_book_id'])) {
            $bookId = (int)$p['library_book_id'];
        }

        if ($bookId) {
            $book = \App\Models\LibraryBook::find($bookId);
            if ($book && !empty($book->cover_image)) {
                $p['cover'] = $book->cover_image;
            }
        }

        $arrow = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg>';

        $coverUrl  = $this->resolveUrl($p['cover'] ?? '');
        $ctaUrl    = $this->resolveUrl($p['cta_url'] ?? '');
        $ctaText   = !empty($p['cta_text']) ? $p['cta_text'] : 'Read a real book';

        return '<aside class="inline-cta">' . "\n"
            . '  <a class="ic-cover" href="' . e($ctaUrl) . '" style="display:block;" title="' . e($p['heading']) . '">' . "\n"
            . '    <img src="' . e($coverUrl) . '" alt="' . e($p['heading']) . '" loading="lazy">' . "\n"
            . '  </a>' . "\n"
            . '  <div>' . "\n"
            . '    <h3>' . $this->clean($p['heading']) . '</h3>' . "\n"
            . '    <p>' . $this->clean($p['body']) . '</p>' . "\n"
            . '    <a class="btn btn-primary" href="' . e($ctaUrl) . '">' . $this->clean($ctaText) . ' ' . $arrow . '</a>' . "\n"
            . '  </div>' . "\n"
            . '</aside>';
    }

    /** The sticky sidebar book card. */
    public function renderSidebar(?array $s): string
    {
        $s = array_merge(self::defaultSidebar(), array_filter((array) $s, fn ($v) => $v !== null && $v !== ''));
        if (isset($s['enabled']) && !$s['enabled']) return '';

        $ctaUrl = preg_replace('/\.html$/i', '', trim($s['cta_url'] ?? ''));
        if ($ctaUrl === '' || $ctaUrl === 'library' || $ctaUrl === '/library') {
            $ctaUrl = 'library?book=2';
        }
        $url = str_starts_with($ctaUrl, 'http') ? $ctaUrl : url($ctaUrl);

        return '<div class="aside-card">' . PHP_EOL
            . '  <a href="' . e($url) . '" class="ac-cover-link" style="display:block;" title="Read this book">' . PHP_EOL
            . '    <img class="ac-cover" src="' . e($s['cover']) . '" alt="' . e($s['heading'] ?? '') . '" loading="lazy" style="cursor:pointer;">' . PHP_EOL
            . '  </a>' . PHP_EOL
            . '  <p class="ac-label">' . e($s['label']) . '</p>' . PHP_EOL
            . '  <h4>' . $this->clean($s['heading']) . '</h4>' . PHP_EOL
            . '  <p>' . $this->clean($s['body']) . '</p>' . PHP_EOL
            . '  <a class="btn btn-primary" href="' . e($url) . '">' . e($s['cta_text']) . '</a>' . PHP_EOL
            . '</div>';
    }

    /** Strip everything except the inline formatting the editor offers. */
    private function clean(string $html): string
    {
        $html = trim(strip_tags($html, self::ALLOWED_INLINE));

        return $this->linksOpenInNewTab($html);
    }

    /**
     * Send every link in article copy to a new tab.
     *
     * rel="noopener" goes with it: without it the opened page gets a handle on
     * this one through window.opener. Existing target/rel attributes are left
     * alone so a deliberate same-tab link stays same-tab.
     */
    private function linksOpenInNewTab(string $html): string
    {
        if (! str_contains($html, '<a ')) {
            return $html;
        }

        return preg_replace_callback('/<a\b([^>]*)>/i', function ($m) {
            $attrs = $m[1];

            if (! preg_match('/\btarget\s*=/i', $attrs)) {
                $attrs .= ' target="_blank"';
            }
            if (! preg_match('/\brel\s*=/i', $attrs)) {
                $attrs .= ' rel="noopener"';
            }

            return '<a' . $attrs . '>';
        }, $html) ?? $html;
    }

    /** Headings collected for the article's table of contents. */
    public function tableOfContents(array $blocks): array
    {
        $toc = [];

        foreach ($blocks as $b) {
            if (($b['type'] ?? '') !== 'heading') continue;

            $text = trim(strip_tags($b['text'] ?? ''));
            if ($text === '') continue;

            // H3s are included too: a listicle keeps its points at h3, and
            // skipping them left the rail showing only two or three entries for
            // an article with ten numbered items.
            $level = ($b['level'] ?? 'h2') === 'h3' ? 'h3' : 'h2';

            $toc[] = [
                'id'    => Str::slug($text),
                'text'  => $text,
                'level' => $level,
            ];
        }

        return $toc;
    }

    /** Rough read time from the article's words. */
    public function readTime(array $blocks): int
    {
        $words = 0;
        foreach ($blocks as $b) {
            $bag = [$b['text'] ?? '', $b['caption'] ?? '', $b['cite'] ?? ''];
            foreach (($b['items'] ?? []) as $i) {
                $bag[] = ($i['lead'] ?? '') . ' ' . ($i['text'] ?? '');
            }
            foreach (($b['rows'] ?? []) as $r) $bag[] = implode(' ', (array) $r);
            $words += str_word_count(strip_tags(implode(' ', $bag)));
        }
        return max(1, (int) round($words / 200));
    }
}
