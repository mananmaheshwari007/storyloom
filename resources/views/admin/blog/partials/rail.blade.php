{{--
    Right column of the article — lives in the page sidebar, under
    Cover Media and Status, so the main editor gets the full width.
--}}
@php
    $editorSidebar = old('sidebar_promo', $blog->sidebar_promo ?? null);
    if (is_string($editorSidebar)) { $editorSidebar = json_decode($editorSidebar, true); }
    $defaultSidebar = \App\Support\JournalRenderer::defaultSidebar();
    $showToc  = old('show_toc', $blog->show_toc ?? true);
    $tocLabel = old('toc_label', $blog->toc_label ?? 'On this page');
@endphp

<input type="hidden" name="sidebar_promo" id="sidebarField" value='@json($editorSidebar ?: $defaultSidebar)'>

<div class="jw-shell jw-rail-standalone">
    <p class="jw-col-title"><i class="bi bi-layout-sidebar-reverse"></i> Right column of the article</p>
    <p class="jw-rail-note">What readers see beside the article as they scroll.</p>
<div class="jw-rail-stack">
            
            

            {{-- Inline Article Promotional Book Card --}}
            @php
                $editorPromo = old('promo', $blog->promo ?? null);
                if (is_string($editorPromo)) { $editorPromo = json_decode($editorPromo, true); }
                $defaultPromo = \App\Support\JournalRenderer::defaultPromo();
                $promoData = array_merge($defaultPromo, (array)($editorPromo ?: []));
                $showPromo = old('show_promo', $blog->show_promo ?? true);
                $libraryBooks = \App\Models\LibraryBook::orderBy('id', 'asc')->get();

                // Automatically fetch cover image of targeted library book if available
                $promoCover = $promoData['cover'] ?? '';
                if (preg_match('/book[=_](\d+)/i', $promoData['cta_url'] ?? '', $m)) {
                    $targetBook = $libraryBooks->firstWhere('id', (int)$m[1]);
                    if ($targetBook && !empty($targetBook->cover_image)) {
                        $promoCover = $targetBook->cover_image;
                    }
                }
            @endphp
            <input type="hidden" name="promo" id="promoField" value='@json($promoData)'>

            <section class="jw-panel is-accent mb-3">
                <header class="jw-panel-head">
                    <span class="jw-panel-title"><i class="bi bi-book"></i> Article Body Promo Book</span>
                    <label class="jw-switch" title="Show or hide the article body promo book card">
                        <input type="checkbox" name="show_promo" value="1" id="promoEnabled" @checked($showPromo)>
                        <span></span>
                    </label>
                </header>
                <div class="jw-panel-body">
                    <p class="jw-hint mb-2">Select a library book to promote automatically, or customize the fields below.</p>

                    <script>
                    window.libraryBooksData = @json($libraryBooks);
                    </script>
                    <label class="jw-label mt-2" for="promoBookSelect">Pick Library Book to Promote</label>
                    <select class="jw-input mb-2" id="promoBookSelect" onchange="
                        var opt = this.options[this.selectedIndex];
                        if (opt.value) {
                            var cover = opt.getAttribute('data-cover');
                            document.getElementById('promoCover').value = cover;
                            document.getElementById('promoCtaUrl').value = 'library?book=' + opt.value;
                            if (document.getElementById('promoCoverPreview')) {
                                document.getElementById('promoCoverPreview').src = '{{ asset('') }}' + cover.replace(/^\//, '');
                            }
                        }
                    ">
                        @foreach($libraryBooks as $lb)
                            <option value="{{ $lb->id }}" data-cover="{{ $lb->cover_image }}"
                                @selected(($promoData['cta_url'] ?? '') === 'library?book=' . $lb->id)>
                                Book #{{ $lb->id }}: {{ $lb->title }} ({{ $lb->subtitle }})
                            </option>
                        @endforeach
                    </select>

                    <label class="jw-label mt-2" for="promoHeading">Heading</label>
                    <input type="text" class="jw-input" id="promoHeading" value="{{ $promoData['heading'] ?? '' }}">

                    <label class="jw-label mt-2" for="promoBody">Description Text</label>
                    <textarea class="jw-input" id="promoBody" rows="3">{{ $promoData['body'] ?? '' }}</textarea>

                    <div class="d-flex align-items-center gap-2 mt-2">
                        <img id="promoCoverPreview" src="{{ asset($promoCover ?: 'assets/img/book1/cover.webp') }}" alt="Cover" style="width:44px; height:62px; object-fit:cover; border-radius:4px; border:1px solid #ccc;">
                        <div class="flex-grow-1">
                            <label class="jw-label mb-1" for="promoCover">Book Cover Image</label>
                            <input type="text" class="jw-input" id="promoCover" value="{{ $promoCover }}" placeholder="assets/img/book1/cover.webp">
                        </div>
                    </div>

                    <div class="jw-row two mt-2">
                        <div>
                            <label class="jw-label" for="promoCtaText">Button Text</label>
                            <input type="text" class="jw-input" id="promoCtaText" value="{{ $promoData['cta_text'] ?? 'Read a real book' }}">
                        </div>
                        <div>
                            <label class="jw-label" for="promoCtaUrl">Button Link</label>
                            <input type="text" class="jw-input" id="promoCtaUrl" value="{{ $promoData['cta_url'] ?? 'library?book=1' }}">
                        </div>
                    </div>
                </div>
            </section>

            {{-- Contents list --}}
            <section class="jw-panel">
                <header class="jw-panel-head">
                    <span class="jw-panel-title"><i class="bi bi-list-nested"></i> Contents list</span>
                    <label class="jw-switch" title="Show or hide the contents list">
                        <input type="checkbox" name="show_toc" value="1" id="tocEnabled" @checked($showToc)>
                        <span></span>
                    </label>
                </header>
                <div class="jw-panel-body">
                    <p class="jw-hint mb-2">Lets readers jump around the article. Every <strong>H2 heading</strong> you add appears here automatically.</p>
                    <label class="jw-label" for="toc_label">Title above the list</label>
                    <input type="text" class="jw-input" id="toc_label" name="toc_label" value="{{ $tocLabel }}" placeholder="On this page">

                    <p class="jw-label mt-3 mb-1">Jump links so far</p>
                    <ul class="jw-toc-preview" id="tocPreview">
                        <li class="jw-toc-empty">Add an H2 heading and it will show up here.</li>
                    </ul>
                </div>
            </section>

            {{-- Sidebar book --}}
            <section class="jw-panel is-accent">
                <header class="jw-panel-head">
                    <span class="jw-panel-title"><i class="bi bi-bookmark-star"></i> Sidebar book</span>
                    <label class="jw-switch" title="Show or hide the sidebar book card">
                        <input type="checkbox" id="sbEnabled" checked>
                        <span></span>
                    </label>
                </header>
                <div class="jw-panel-body">
                    <p class="jw-hint mb-2">The sticky book card that follows the reader down the page. Starts as the house default — change anything to feature a different book.</p>

                    {{-- Same picker as the Article Body Promo Book above, so both
                         cards are changed the same way. Without it there was no
                         obvious way to swap the sidebar book at all. --}}
                    <label class="jw-label mt-2" for="sbBookSelect">Pick Library Book to Feature</label>
                    <select class="jw-input mb-2" id="sbBookSelect">
                        <option value="">— Keep current / custom —</option>
                        @foreach($libraryBooks as $lb)
                            <option value="{{ $lb->id }}"
                                    data-cover="{{ $lb->cover_image }}"
                                    data-title="{{ $lb->title }}"
                                    data-subtitle="{{ $lb->subtitle }}">
                                Book #{{ $lb->id }}: {{ $lb->title }} ({{ $lb->subtitle }})
                            </option>
                        @endforeach
                    </select>

                    <div class="jw-cover-row">
                        <img id="sbCoverPreview" class="jw-cover-thumb" src="" alt="">
                        <div class="jw-cover-fields">
                            <label class="jw-label" for="sbCover">Cover image</label>
                            <div class="jw-input-group">
                                <input type="text" class="jw-input" id="sbCover">
                                <button type="button" class="jw-btn-ghost" data-upload-for="sbCover" title="Upload a cover"><i class="bi bi-upload"></i></button>
                            </div>
                        </div>
                    </div>

                    <label class="jw-label mt-2" for="sbLabel">Small label</label>
                    <input type="text" class="jw-input" id="sbLabel">

                    <label class="jw-label mt-2" for="sbHeading">Heading</label>
                    <input type="text" class="jw-input" id="sbHeading">

                    <label class="jw-label mt-2" for="sbBody">Body text</label>
                    <textarea class="jw-input" id="sbBody" rows="3"></textarea>

                    <div class="jw-row two mt-2">
                        <div>
                            <label class="jw-label" for="sbCtaText">Button text</label>
                            <input type="text" class="jw-input" id="sbCtaText">
                        </div>
                        <div>
                            <label class="jw-label" for="sbCtaUrl">Button link</label>
                            <input type="text" class="jw-input" id="sbCtaUrl">
                        </div>
                    </div>

                    <button type="button" class="jw-btn-ghost w-100 mt-3" id="sbReset">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset to default book
                    </button>
                </div>
            </section>
        </div>
</div>

<script type="application/json" id="jwDefaultSidebar">@json($defaultSidebar)</script>
