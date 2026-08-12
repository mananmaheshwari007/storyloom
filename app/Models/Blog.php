<?php

namespace App\Models;

use App\Support\JournalRenderer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'title_html',
        'slug',
        'category',
        'featured_image',
        'short_description',
        'dek',
        'read_time',
        'publish_date_tag',
        'content',
        'blocks',
        'promo',
        'sidebar_promo',
        'show_promo',
        'show_toc',
        'toc_label',
        'meta_title',
        'meta_description',
        'keywords',
        'status'
    ];

    protected $casts = [
        'blocks' => 'array',
        'promo'  => 'array',
        'sidebar_promo' => 'array',
        'show_toc' => 'boolean',
    ];

    /**
     * The sitemap is cached for an hour; publishing or unpublishing an article
     * should show up straight away rather than whenever that window happens to
     * expire.
     */
    protected static function booted(): void
    {
        $flush = fn () => \Illuminate\Support\Facades\Cache::forget('sitemap.xml');

        static::saved($flush);
        static::deleted($flush);
        static::restored($flush);
    }

    /** Topics offered in the editor and used by the journal filter pills. */
    public const CATEGORIES = [
        'gifts'     => 'Gift Guides',
        'occasions' => 'Occasions',
        'stories'   => 'Real Stories',
        'loom'      => 'Behind the Loom',
    ];

    public function getCategoryLabelAttribute(): string
    {
        if (isset(self::CATEGORIES[$this->category])) {
            return self::CATEGORIES[$this->category];
        }
        // Custom topic typed by the writer — show it in Title Case.
        return $this->category
            ? \Illuminate\Support\Str::title(str_replace(['-', '_'], ' ', $this->category))
            : 'Journal';
    }

    public function getPublishDateTagAttribute($value): string
    {
        if (!empty($value)) {
            return $value;
        }
        $date = $this->created_at ?? now();
        return 'PUBLISHED ' . strtoupper($date->format('F Y'));
    }

    /** The promotional book card for this article, or the house default. */
    public function getPromoCardAttribute(): array
    {
        $custom = array_filter((array) ($this->promo ?? []), fn ($v) => $v !== null && $v !== '');
        $promo  = array_merge(JournalRenderer::defaultPromo(), $custom);

        // Automatically fetch cover image of the targeted library book if defined
        $bookId = null;
        if (!empty($promo['cta_url'])) {
            if (preg_match('/book[=_](\d+)/i', $promo['cta_url'], $matches)) {
                $bookId = (int)$matches[1];
            }
        }
        if (!$bookId && !empty($promo['library_book_id'])) {
            $bookId = (int)$promo['library_book_id'];
        }

        if ($bookId) {
            $book = \App\Models\LibraryBook::find($bookId);
            if ($book && !empty($book->cover_image)) {
                $promo['cover'] = $book->cover_image;
            }
        }

        return $promo;
    }

    public function getTableOfContentsAttribute(): array
    {
        return (new JournalRenderer)->tableOfContents((array) ($this->blocks ?? []));
    }


    /** The sticky sidebar book card, or the house default. */
    public function getSidebarCardAttribute(): array
    {
        $custom  = array_filter((array) ($this->sidebar_promo ?? []), fn ($v) => $v !== null && $v !== '');
        $sidebar = array_merge(JournalRenderer::defaultSidebar(), $custom);

        $bookId = null;
        if (!empty($sidebar['cta_url'])) {
            if (preg_match('/book[=_](\d+)/i', $sidebar['cta_url'], $matches)) {
                $bookId = (int)$matches[1];
            }
        }
        if (!$bookId && !empty($sidebar['library_book_id'])) {
            $bookId = (int)$sidebar['library_book_id'];
        }

        if ($bookId) {
            $book = \App\Models\LibraryBook::find($bookId);
            if ($book && !empty($book->cover_image)) {
                $sidebar['cover'] = $book->cover_image;
            }
        }

        return $sidebar;
    }

    /**
     * Did the writer place a book card inside the article?
     *
     * When they did, the article body already renders it in position and the
     * view must not append a second one after the text — that duplicate is why
     * a card placed mid-article appeared to "move to the end".
     */
    public function getHasInlinePromoAttribute(): bool
    {
        foreach ((array) ($this->blocks ?? []) as $block) {
            if (($block['type'] ?? '') === 'promo') {
                return true;
            }
        }

        return false;
    }

    /** Headline with its <em> accent, falling back to plain text. */
    public function getHeadlineAttribute(): string
    {
        return $this->title_html ?: e($this->title);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
