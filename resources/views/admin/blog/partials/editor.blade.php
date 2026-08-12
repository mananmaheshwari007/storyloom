{{--
    Storyloom Journal writer.
    Full-width article body. The article's right column (contents list +
    sidebar book) is edited from partials/rail.blade.php, which sits in the
    page sidebar under Cover Media and Status.
--}}
@php
    $editorBlocks = old('blocks', $blog->blocks ?? null);
    if (is_string($editorBlocks)) { $editorBlocks = json_decode($editorBlocks, true); }
    $editorPromo = old('promo', $blog->promo ?? null);
    if (is_string($editorPromo)) { $editorPromo = json_decode($editorPromo, true); }
    $defaultPromo   = \App\Support\JournalRenderer::defaultPromo();
@endphp

<input type="hidden" name="blocks"        id="blocksField"  value='@json($editorBlocks ?: [])'>
<input type="hidden" name="promo"         id="promoField"   value='@json($editorPromo ?: $defaultPromo)'>

<div class="jw-shell">

    {{-- ============ TOOLBAR ============ --}}
    <div class="jw-toolbar">
        <div class="jw-toolbar-info">
            <span class="jw-chip" id="jwStats">0 blocks</span>
            <span class="jw-chip jw-chip-quiet" id="jwWords">0 words</span>
        </div>
        <div class="jw-toolbar-actions">
            <div class="jw-seg" role="group" aria-label="Editor view">
                <button type="button" class="jw-seg-btn is-on" id="jwTabWrite"><i class="bi bi-pencil"></i> Write</button>
                <button type="button" class="jw-seg-btn" id="jwTabPreview"><i class="bi bi-eye"></i> Quick look</button>
            </div>
            <button type="button" class="jw-btn-dark" id="jwFullPreview">
                <i class="bi bi-box-arrow-up-right"></i> Preview whole article
            </button>
        </div>
    </div>

    {{-- ============ ARTICLE BODY (full width) ============ --}}
    <div class="jw-single">

        {{-- ---------- MAIN COLUMN ---------- --}}
        <div class="jw-main">
            <div id="jwWrite">
                <p class="jw-col-title"><i class="bi bi-file-text"></i> Article body</p>

                <div class="jw-blocks" id="jwBlocks"></div>

                <div class="jw-empty" id="jwEmpty" hidden>
                    <i class="bi bi-file-earmark-plus"></i>
                    <p class="mb-1"><strong>Nothing written yet.</strong></p>
                    <p class="text-muted small mb-0">Pick a block below to begin — most articles open with a Paragraph.</p>
                </div>

                <div class="jw-add">
                    <span class="jw-add-label">Add a block</span>
                    <div class="jw-add-buttons">
                        <button type="button" class="jw-add-btn" data-add="paragraph"><i class="bi bi-text-paragraph"></i> Paragraph</button>
                        <button type="button" class="jw-add-btn" data-add="heading"><i class="bi bi-type-h2"></i> Heading</button>
                        <button type="button" class="jw-add-btn" data-add="image"><i class="bi bi-image"></i> Image</button>
                        <button type="button" class="jw-add-btn" data-add="quote"><i class="bi bi-quote"></i> Pull quote</button>
                        <button type="button" class="jw-add-btn" data-add="takeaway"><i class="bi bi-lightbulb"></i> Takeaway</button>
                        <button type="button" class="jw-add-btn" data-add="list"><i class="bi bi-list-ul"></i> List</button>
                        <button type="button" class="jw-add-btn" data-add="divider"><i class="bi bi-hr"></i> Divider</button>
                    </div>
                </div>
            </div>

            {{-- Quick Look renders inside an iframe that loads the site's real
                 stylesheet, rather than the hand-copied approximation this panel
                 used to carry. That copy drifted from main.css — the drop cap
                 went missing and heading spacing was too tight — so what the
                 editor showed was not what got published. --}}
            <div id="jwPreview" hidden>
                <div class="jw-preview-bar">
                    <span class="jw-preview-note-inline">
                        <i class="bi bi-eye"></i> Rendered with the live site stylesheet
                    </span>
                    <div class="jw-preview-widths" role="group" aria-label="Preview width">
                        <button type="button" class="jw-width-btn active" data-width="desktop">
                            <i class="bi bi-laptop"></i> Desktop
                        </button>
                        <button type="button" class="jw-width-btn" data-width="mobile">
                            <i class="bi bi-phone"></i> Mobile
                        </button>
                    </div>
                </div>
                <div class="jw-preview-stage" id="jwPreviewStage">
                    <iframe id="jwPreviewFrame" title="Article preview" sandbox="allow-same-origin"></iframe>
                </div>
            </div>
        </div>

        
    </div>
</div>

<script type="application/json" id="jwDefaultPromo">@json($defaultPromo)</script>
<input type="file" id="jwUploader" accept="image/*" hidden>
