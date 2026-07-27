<style>
/* ============================================================
   Journal writer — calm, grouped, two-column workspace.
   Left = the article body. Right = the article's right rail.
   ============================================================ */
.jw-shell { --jw-line:#e4e7ec; --jw-ink:#1D2A44; --jw-terra:#B55B29; --jw-quiet:#8a9099; }

/* ---- toolbar ---- */
.jw-toolbar {
    position: sticky; top: 0; z-index: 20;
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; flex-wrap: wrap;
    padding: 12px 16px; margin-bottom: 18px;
    background: #fff; border: 1px solid var(--jw-line); border-radius: 10px;
    box-shadow: 0 1px 2px rgba(16,24,40,.04);
}
.jw-toolbar-info { display: flex; gap: 8px; align-items: center; }
.jw-toolbar-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
.jw-chip {
    font-size: .74rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
    background: #eef1f5; color: #4b5563; padding: 5px 11px; border-radius: 999px;
}
.jw-chip-quiet { background: transparent; color: var(--jw-quiet); }

.jw-seg { display: inline-flex; background: #f1f3f6; border-radius: 8px; padding: 3px; }
.jw-seg-btn {
    border: 0; background: transparent; color: #4b5563;
    padding: 7px 14px; border-radius: 6px; font-size: .84rem; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px;
    transition: background .18s ease, color .18s ease;
}
.jw-seg-btn:hover { color: var(--jw-ink); }
.jw-seg-btn.is-on { background: #fff; color: var(--jw-ink); box-shadow: 0 1px 2px rgba(16,24,40,.1); }
.jw-btn-dark {
    border: 0; background: var(--jw-ink); color: #fff;
    padding: 9px 16px; border-radius: 8px; font-size: .84rem; cursor: pointer;
    display: inline-flex; align-items: center; gap: 7px;
    transition: opacity .18s ease, transform .18s ease;
}
.jw-btn-dark:hover { opacity: .9; transform: translateY(-1px); }

/* ---- workspace ---- */
.jw-workspace { display: grid; grid-template-columns: minmax(0,1fr) 340px; gap: 22px; align-items: start; }
@media (max-width: 1199px) { .jw-workspace { grid-template-columns: 1fr; } }

.jw-col-title {
    font-size: .74rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
    color: var(--jw-quiet); margin-bottom: 10px;
    display: flex; align-items: center; gap: 7px;
}
.jw-rail-note { font-size: .8rem; color: var(--jw-quiet); margin: -4px 0 12px; }

/* ---- blocks ---- */
.jw-blocks { display: grid; gap: 12px; }
.jw-block {
    background: #fff; border: 1px solid var(--jw-line); border-radius: 10px; overflow: hidden;
    transition: border-color .18s ease, box-shadow .18s ease;
}
.jw-block:hover { border-color: #cfd5dd; box-shadow: 0 2px 8px rgba(16,24,40,.05); }
.jw-block:focus-within { border-color: var(--jw-terra); box-shadow: 0 0 0 3px rgba(181,91,41,.1); }
.jw-block.is-promo { border-color: rgba(181,91,41,.5); background: #fffdfa; }
.jw-block-head {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px; border-bottom: 1px solid #eef0f3; background: #fcfcfd;
}
.jw-block-kind { font-size: .72rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--jw-quiet); }
.jw-block.is-promo .jw-block-kind { color: var(--jw-terra); }
.jw-block-tools { margin-left: auto; display: flex; gap: 4px; }
.jw-tool {
    width: 30px; height: 30px; display: grid; place-items: center;
    border: 1px solid transparent; background: transparent; border-radius: 6px;
    color: #6b7280; font-size: .85rem; cursor: pointer;
    transition: background .15s ease, color .15s ease;
}
.jw-tool:hover { background: var(--jw-ink); color: #fff; }
.jw-tool.jw-del:hover { background: #dc2626; }
.jw-tool:disabled { opacity: .25; cursor: not-allowed; }
.jw-tool:disabled:hover { background: transparent; color: #6b7280; }
.jw-block-body { padding: 14px; }
.jw-hint { font-size: .78rem; color: var(--jw-quiet); margin-top: 5px; line-height: 1.5; }

/* ---- fields ---- */
.jw-rt-bar { display: flex; gap: 4px; margin-bottom: 6px; }
.jw-rt-btn {
    min-width: 30px; height: 28px; padding: 0 9px;
    border: 1px solid var(--jw-line); background: #fff; border-radius: 6px;
    font-size: .8rem; cursor: pointer; color: #4b5563;
    transition: background .15s ease, border-color .15s ease;
}
.jw-rt-btn:hover { background: #f3f5f8; border-color: #cfd5dd; }
.jw-rich, .jw-input, .jw-cell {
    width: 100%; border: 1px solid #d5d9e0; border-radius: 8px;
    padding: 10px 12px; font-size: .92rem; background: #fff; color: #111827;
    transition: border-color .15s ease, box-shadow .15s ease;
}
.jw-rich { min-height: 76px; line-height: 1.65; font-family: "Libre Caslon Text", Georgia, serif; font-size: .98rem; }
.jw-rich:focus, .jw-input:focus, .jw-cell:focus {
    outline: none; border-color: var(--jw-terra); box-shadow: 0 0 0 3px rgba(181,91,41,.13);
}
.jw-rich[data-empty]:empty::before { content: attr(data-empty); color: #b6bcc5; }
.jw-label {
    display: block; font-size: .72rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #6b7280; margin-bottom: 5px;
}
.jw-row { display: grid; gap: 10px; }
@media (min-width: 768px) { .jw-row.two { grid-template-columns: 1fr 1fr; } }
.jw-input-group { display: flex; gap: 6px; }
.jw-input-group .jw-input { flex: 1; min-width: 0; }

.jw-btn-ghost {
    border: 1px solid var(--jw-line); background: #fff; color: #4b5563;
    border-radius: 8px; padding: 9px 12px; font-size: .82rem; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center; gap: 6px;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.jw-btn-ghost:hover { background: var(--jw-ink); border-color: var(--jw-ink); color: #fff; }

/* ---- list / table editors ---- */
.jw-item { display: grid; gap: 8px; grid-template-columns: minmax(0,1fr) auto; align-items: start; margin-bottom: 8px; }
.jw-item .jw-item-fields { display: grid; gap: 6px; }
.jw-table-grid { overflow-x: auto; }
.jw-table-grid table { border-collapse: separate; border-spacing: 4px; width: 100%; min-width: 400px; }
.jw-cell { padding: 8px 10px; font-size: .88rem; }
.jw-mini { font-size: .78rem; padding: 6px 12px; border-radius: 7px; }

/* ---- add block ---- */
.jw-add { margin-top: 16px; padding: 16px; background: #fff; border: 1px dashed #d5d9e0; border-radius: 10px; }
.jw-add-label { display: block; font-size: .72rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--jw-quiet); margin-bottom: 10px; }
.jw-add-buttons { display: flex; flex-wrap: wrap; gap: 8px; }
.jw-add-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 8px 14px; border: 1px solid var(--jw-line); background: #fff;
    border-radius: 8px; font-size: .84rem; color: #374151; cursor: pointer;
    transition: background .16s ease, border-color .16s ease, color .16s ease, transform .16s ease;
}
.jw-add-btn:hover { background: var(--jw-ink); border-color: var(--jw-ink); color: #fff; transform: translateY(-1px); }
.jw-add-btn.is-accent { border-color: rgba(181,91,41,.45); color: var(--jw-terra); }
.jw-add-btn.is-accent:hover { background: var(--jw-terra); border-color: var(--jw-terra); color: #fff; }

.jw-empty { text-align: center; padding: 34px 16px; color: #6b7280; background: #fff; border: 1px solid var(--jw-line); border-radius: 10px; }
.jw-empty i { font-size: 1.9rem; color: #cfd5dd; display: block; margin-bottom: 8px; }

/* ---- right rail ---- */
.jw-rail { position: sticky; top: 84px; display: grid; gap: 14px; align-content: start; }
@media (max-width: 1199px) { .jw-rail { position: static; } }
.jw-panel { background: #fff; border: 1px solid var(--jw-line); border-radius: 10px; overflow: hidden; }
.jw-panel.is-accent { border-color: rgba(181,91,41,.4); }
.jw-panel-head {
    display: flex; align-items: center; justify-content: space-between; gap: 10px;
    padding: 11px 13px; background: #fcfcfd; border-bottom: 1px solid #eef0f3;
}
.jw-panel.is-accent .jw-panel-head { background: #fffaf6; }
.jw-panel-title { font-size: .8rem; font-weight: 700; color: var(--jw-ink); display: flex; align-items: center; gap: 7px; }
.jw-panel.is-accent .jw-panel-title { color: var(--jw-terra); }
.jw-panel-body { padding: 13px; }

/* switch */
.jw-switch { position: relative; display: inline-block; width: 38px; height: 21px; flex: none; margin: 0; cursor: pointer; }
.jw-switch input { position: absolute; opacity: 0; width: 0; height: 0; }
.jw-switch span { position: absolute; inset: 0; background: #cbd2da; border-radius: 999px; transition: background .2s ease; }
.jw-switch span::before {
    content: ""; position: absolute; width: 15px; height: 15px; left: 3px; top: 3px;
    background: #fff; border-radius: 50%; transition: transform .2s ease;
}
.jw-switch input:checked + span { background: #3F4E3A; }
.jw-switch input:checked + span::before { transform: translateX(17px); }
.jw-switch input:focus-visible + span { box-shadow: 0 0 0 3px rgba(63,78,58,.25); }

/* contents preview */
.jw-toc-preview { list-style: none; margin: 0; padding: 0; display: grid; gap: 5px; }
.jw-toc-preview li {
    font-size: .84rem; color: #4b5563; padding: 7px 10px;
    background: #f7f8fa; border-left: 2px solid var(--jw-terra); border-radius: 0 6px 6px 0;
}
.jw-toc-preview li.jw-toc-empty { color: #9aa1ab; border-left-color: #d5d9e0; font-style: italic; }

/* cover row */
.jw-cover-row { display: grid; grid-template-columns: 54px minmax(0,1fr); gap: 10px; align-items: start; }
.jw-cover-thumb {
    width: 54px; aspect-ratio: 3/4; object-fit: cover;
    border: 1px solid var(--jw-line); border-radius: 5px; background: #f1f3f6;
}


/* main column now spans the full form width */
.jw-single { display: block; }
.jw-single .jw-main { width: 100%; }
.jw-rich { min-height: 96px; }

/* rail rendered standalone inside the page sidebar */
.jw-rail-standalone { display: block; }
.jw-rail-standalone .jw-rail-stack { display: grid; gap: 14px; }
.jw-rail-standalone .jw-col-title { margin-bottom: 4px; }
.jw-rail-standalone .jw-panel-body { padding: 12px; }
.jw-rail-standalone .jw-row.two { grid-template-columns: 1fr; }

/* ---------- Preview (mirrors the live journal styling) ---------- */
.jw-preview-shell { padding: 26px; background: #F8F4EC; border-radius: 0 0 10px 10px; }
.jw-article-body {
    max-width: 39rem; margin-inline: auto;
    font-family: "Libre Caslon Text", Georgia, serif; color: #1D2A44;
}
.jw-article-body > * + * { margin-top: 1.35em; }
.jw-article-body p { font-size: 1.05rem; line-height: 1.85; }
.jw-article-body h2, .jw-article-body h3 { font-family: "Cormorant Garamond", Georgia, serif; font-weight: 600; line-height: 1.15; }
.jw-article-body h2 { font-size: 2rem; margin-top: 1.4em; }
.jw-article-body h3 { font-size: 1.45rem; }
.jw-article-body .lead-in::first-letter { font-family: "Cormorant Garamond", serif; font-size: 3.4em; font-weight: 600; color: #B55B29; float: left; line-height: .82; padding: 6px 12px 0 0; }
.jw-article-body .pull-quote {
    padding-left: 24px; border-left: 2px solid #B55B29;
    font-family: "Cormorant Garamond", Georgia, serif; font-weight: 600;
    font-size: 1.6rem; line-height: 1.4;
}
.jw-article-body .pull-quote cite { display: block; margin-top: 10px; font-family: "Libre Caslon Text", serif; font-style: normal; font-size: .72rem; letter-spacing: .2em; text-transform: uppercase; color: #96471D; }
.jw-article-body .takeaway { padding: 20px; background: rgba(63,78,58,.06); border: 1px solid rgba(63,78,58,.22); border-radius: 3px; }
.jw-article-body .takeaway .tk-label { display: flex; align-items: center; gap: 8px; font-size: .72rem; letter-spacing: .22em; text-transform: uppercase; color: #3F4E3A; font-weight: 700; margin-bottom: 8px; }
.jw-article-body .takeaway svg { width: 15px; height: 15px; }
.jw-article-body .takeaway p { margin: 0; font-size: 1rem; }
.jw-article-body ul { display: grid; gap: 14px; padding-left: 2px; list-style: none; }
.jw-article-body ul li { position: relative; padding-left: 24px; color: rgba(29,42,68,.74); line-height: 1.75; }
.jw-article-body ul li strong { color: #1D2A44; }
.jw-article-body ul li::before { content: ""; position: absolute; left: 2px; top: .68em; width: 6px; height: 6px; border-radius: 50%; background: #B55B29; }
.jw-article-body figure { margin: 0; background: #FFFDF8; padding: 10px; border: 1px solid rgba(29,42,68,.16); }
.jw-article-body figure img { width: 100%; display: block; }
.jw-article-body figcaption { font-family: "Edu SA Hand", cursive; text-align: center; padding-top: 10px; font-size: .95rem; color: rgba(29,42,68,.74); }
.jw-article-body .article-table { width: 100%; border-collapse: collapse; font-size: .95rem; }
.jw-article-body .article-table th, .jw-article-body .article-table td { padding: 10px 12px; border-bottom: 1px solid rgba(29,42,68,.16); text-align: left; }
.jw-article-body .article-table th { font-family: "Cormorant Garamond", serif; font-weight: 700; font-size: .78rem; letter-spacing: .12em; text-transform: uppercase; color: #96471D; }
.jw-article-body .table-wrap { overflow-x: auto; }
.jw-article-body .inline-cta {
    padding: 26px; background: #FFFDF8; border: 1px solid rgba(181,91,41,.35);
    display: grid; grid-template-columns: 84px minmax(0,1fr); gap: 22px; align-items: center;
}
.jw-article-body .inline-cta img { width: 100%; display: block; border: 1px solid rgba(29,42,68,.16); }
.jw-article-body .inline-cta h3 { font-size: 1.3rem; margin-bottom: 6px; }
.jw-article-body .inline-cta p { font-size: .95rem; color: rgba(29,42,68,.74); margin-bottom: 14px; }
.jw-article-body .inline-cta .btn-primary {
    background: #B55B29; border: 0; color: #FFF6EC; border-radius: 2px;
    font-family: "Cormorant Garamond", serif; font-weight: 700; letter-spacing: .14em;
    text-transform: uppercase; font-size: .82rem; padding: 11px 20px;
}
.jw-article-body .article-rule { border: 0; border-top: 1px solid rgba(29,42,68,.16); }
.jw-preview-note { text-align: center; color: #8a9099; font-size: .85rem; padding: 40px 0; }
</style>
