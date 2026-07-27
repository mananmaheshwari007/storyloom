<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Support\JournalRenderer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog post.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created blog post.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:blogs,slug|max:255',
            'category' => 'nullable|string|max:100',
            'featured_image_file' => 'nullable|image|max:3072',
            'short_description' => 'nullable|string|max:500',
            'dek' => 'nullable|string|max:255',
            'blocks' => 'required|json',
            'read_time' => 'nullable|string|max:100',
            'toc_label' => 'nullable|string|max:80',
            'title_html' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
        ]);

        $data = $this->composeArticle($request);

        if ($request->hasFile('featured_image_file')) {
            $path = $request->file('featured_image_file')->store('blogs', 'public');
            $data['featured_image'] = 'storage/' . $path;
        }

        Blog::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog article created successfully.');
    }

    /**
     * Show the form for editing the specified blog post.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified blog post in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
            'category' => 'nullable|string|max:100',
            'featured_image_file' => 'nullable|image|max:3072',
            'short_description' => 'nullable|string|max:500',
            'dek' => 'nullable|string|max:255',
            'blocks' => 'required|json',
            'read_time' => 'nullable|string|max:100',
            'toc_label' => 'nullable|string|max:80',
            'title_html' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
        ]);

        $data = $this->composeArticle($request, $blog);

        if ($request->hasFile('featured_image_file')) {
            if ($blog->featured_image && str_starts_with($blog->featured_image, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $blog->featured_image));
            }
            $path = $request->file('featured_image_file')->store('blogs', 'public');
            $data['featured_image'] = 'storage/' . $path;
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog article updated successfully.');
    }

    /**
     * Turn the editor's block JSON into the saved article: structured
     * blocks (editable source of truth), rendered HTML for the front end,
     * the article's promotional book card, and an estimated read time.
     */
    private function composeArticle(Request $request, ?Blog $blog = null): array
    {
        $data = $request->except(['featured_image_file', 'blocks', 'promo', 'sidebar_promo', 'title_html', '_token', '_method', 'publish_date_tag']);

        $blocks = json_decode($request->input('blocks', '[]'), true);
        if (!is_array($blocks)) {
            $blocks = [];
        }

        $promoInput = $request->input('promo');
        if (is_string($promoInput)) {
            $promo = json_decode($promoInput, true);
        } elseif (is_array($promoInput)) {
            $promo = $promoInput;
        } else {
            $promo = null;
        }

        $renderer = new JournalRenderer;

        $data['blocks']           = $blocks;
        $data['promo']            = $promo;
        $data['show_promo']       = $request->has('show_promo') ? $request->boolean('show_promo') : true;

        $date = ($blog && $blog->created_at) ? $blog->created_at : now();
        $data['publish_date_tag'] = 'PUBLISHED ' . strtoupper($date->format('F Y'));
        $data['content']          = $renderer->render($blocks, $promo);

        // Manual read time wins; blank falls back to the calculated one.
        $manual = $request->input('read_time');
        $data['read_time'] = ($manual !== null && $manual !== '')
            ? (is_numeric($manual) ? (int)$manual : $manual)
            : $renderer->readTime($blocks);

        // Headline keeps its <em> accent; plain title drives lists and meta.
        $titleHtml = trim((string) $request->input('title_html', ''));
        if ($titleHtml !== '') {
            $data['title_html'] = strip_tags($titleHtml, '<em><i>');
            $data['title']      = trim(strip_tags($titleHtml));
        }

        $sidebar = json_decode($request->input('sidebar_promo', 'null'), true);
        $data['sidebar_promo'] = is_array($sidebar) ? $sidebar : null;
        $data['show_toc'] = $request->boolean('show_toc');

        return $data;
    }

    /** Inline image upload used by the editor (returns a usable path). */
    public function upload(Request $request)
    {
        $request->validate(['file' => 'required|image|max:5120']);
        $path = $request->file('file')->store('journal', 'public');

        return response()->json(['url' => 'storage/' . $path]);
    }

    /**
     * Full-article preview of unsaved editor content.
     *
     * Renders through the exact same frontend.blog.show view real articles
     * use — fed an in-memory, never-persisted Blog model built from the
     * posted draft — instead of a hand-maintained duplicate template that
     * could quietly drift out of sync with the live page.
     */
    public function preview(Request $request)
    {
        $renderer = new JournalRenderer;
        $blocks   = json_decode($request->input('blocks', '[]'), true) ?: [];
        $promo    = json_decode($request->input('promo', 'null'), true);
        $sidebar  = json_decode($request->input('sidebar_promo', 'null'), true);

        $titleHtml = trim((string) $request->input('title_html', ''));
        $title = $titleHtml !== '' ? trim(strip_tags($titleHtml)) : (string) $request->input('title');
        $title = $title !== '' ? $title : 'Untitled draft';

        $article = new Blog([
            'title'             => $title,
            'title_html'        => $titleHtml !== '' ? strip_tags($titleHtml, '<em><i>') : null,
            'slug'              => 'preview',
            'category'          => $request->input('category'),
            'featured_image'    => $request->input('featured_image') ?: null,
            'short_description' => $request->input('short_description'),
            'dek'               => $request->input('dek'),
            'read_time'         => $request->input('read_time') ?: $renderer->readTime($blocks),
            'publish_date_tag'  => $request->input('publish_date_tag') ?: null,
            'blocks'            => $blocks,
            'content'           => $renderer->render($blocks),
            'promo'             => is_array($promo) ? $promo : null,
            'show_promo'        => $request->boolean('show_promo'),
            'sidebar_promo'     => is_array($sidebar) ? $sidebar : null,
            'show_toc'          => $request->boolean('show_toc'),
            'toc_label'         => $request->input('toc_label'),
            'status'            => 'draft',
        ]);
        // Deliberately never saved — ->exists stays false, nothing hits the database.

        return view('frontend.blog.show', [
            'article'   => $article,
            'related'   => collect(),
            'seo'       => ['title' => $title . ' — Preview | Storyloom Journal', 'description' => null],
            'isPreview' => true,
        ]);
    }

    /** The site-wide default book cards shown on every article. */
    public function defaultBook()
    {
        return view('admin.blog.default-book', [
            'promo'   => JournalRenderer::defaultPromo(),
            'sidebar' => JournalRenderer::defaultSidebar(),
        ]);
    }

    public function updateDefaultBook(Request $request)
    {
        if ($request->filled('restore')) {
            \Illuminate\Support\Facades\Cache::forget('setting.journal_default_promo');
            \Illuminate\Support\Facades\Cache::forget('setting.journal_default_sidebar');
            \App\Models\Setting::whereIn('key', ['journal_default_promo', 'journal_default_sidebar'])->delete();

            return redirect()->route('admin.blog.defaultBook')
                ->with('success', 'Restored the original Storyloom default book.');
        }

        foreach ([
            'journal_default_promo'   => $request->input('promo', []),
            'journal_default_sidebar' => $request->input('sidebar', []),
        ] as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => json_encode($value)]);
            \Illuminate\Support\Facades\Cache::forget("setting.{$key}");
        }

        return redirect()->route('admin.blog.defaultBook')
            ->with('success', 'Default book updated — it now applies to every article that has not set its own.');
    }

    /**
     * Remove the specified blog post from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->featured_image && str_starts_with($blog->featured_image, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $blog->featured_image));
        }

        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog article deleted successfully.');
    }
}
