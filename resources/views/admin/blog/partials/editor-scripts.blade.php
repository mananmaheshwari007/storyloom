<script>
/* ============================================================
   Storyloom Journal writer
   State is a plain array of blocks. Structural changes (add,
   delete, move, duplicate) re-render the list; typing updates
   state in place so the caret is never lost.
   ============================================================ */
(function () {
    "use strict";

    var blocksField  = document.getElementById("blocksField");
    var promoField   = document.getElementById("promoField");
    var listEl       = document.getElementById("jwBlocks");
    if (!blocksField || !listEl) return;

    var DEFAULT_PROMO = JSON.parse(document.getElementById("jwDefaultPromo").textContent);

    var state = [];
    try { state = JSON.parse(blocksField.value) || []; } catch (e) { state = []; }
    if (!Array.isArray(state)) state = [];

    var promo = {};
    try { promo = JSON.parse(promoField.value) || {}; } catch (e) { promo = {}; }

    var LABELS = {
        paragraph: "Paragraph", heading: "Heading", image: "Image",
        quote: "Pull quote", takeaway: "Takeaway", list: "List",
        table: "Table", promo: "Promotional book", divider: "Divider"
    };

    var ICONS = {
        paragraph: "text-paragraph", heading: "type-h2", image: "image",
        quote: "quote", takeaway: "lightbulb", list: "list-ul",
        table: "table", promo: "bag-check", divider: "hr"
    };

    function blank(type) {
        switch (type) {
            case "heading":   return { type: "heading", level: "h2", text: "" };
            case "paragraph": return { type: "paragraph", text: "", lead: state.length === 0 };
            case "image":     return { type: "image", src: "", alt: "", caption: "" };
            case "quote":     return { type: "quote", text: "", cite: "" };
            case "takeaway":  return { type: "takeaway", label: "The takeaway", text: "" };
            case "list":      return { type: "list", items: [{ lead: "", text: "" }] };
            case "table":     return { type: "table", head: ["", ""], rows: [["", ""], ["", ""]], caption: "" };
            case "promo":     return { type: "promo", promo: Object.assign({}, DEFAULT_PROMO) };
            default:          return { type: "divider" };
        }
    }

    var esc = function (s) {
        return String(s == null ? "" : s)
            .replace(/&/g, "&amp;").replace(/</g, "&lt;")
            .replace(/>/g, "&gt;").replace(/"/g, "&quot;");
    };

    /* ---------- persist ---------- */
    function sync() {
        blocksField.value = JSON.stringify(state);

        var panelHeading = document.getElementById("promoHeading");
        var panelBody    = document.getElementById("promoBody");
        var panelCover   = document.getElementById("promoCover");
        var panelCtaText = document.getElementById("promoCtaText");
        var panelCtaUrl  = document.getElementById("promoCtaUrl");

        if (panelHeading) promo.heading  = panelHeading.value;
        if (panelBody)    promo.body     = panelBody.value;
        if (panelCover)   promo.cover    = panelCover.value;
        if (panelCtaText) promo.cta_text = panelCtaText.value;
        if (panelCtaUrl)  promo.cta_url  = panelCtaUrl.value;

        // If an inline promo block exists in state, sync its values
        var inlinePromo = null;
        for (var i = 0; i < state.length; i++) {
            if (state[i].type === "promo") {
                state[i].promo = Object.assign({}, promo, state[i].promo || {});
                inlinePromo = state[i].promo;
                break;
            }
        }

        var activePromo = inlinePromo || promo || DEFAULT_PROMO;
        if (promoField) promoField.value = JSON.stringify(activePromo);

        document.getElementById("jwStats").textContent =
            state.length + (state.length === 1 ? " block" : " blocks");
        document.getElementById("jwEmpty").hidden = state.length > 0;
        if (typeof paintToc === "function") paintToc();
        if (typeof paintWords === "function") paintWords();
    }

    /* ---------- field builders ---------- */
    function rich(value, placeholder, onInput, isLarge, isSmall) {
        var wrap = document.createElement("div");

        var bar = document.createElement("div");
        bar.className = "jw-rt-bar";
        [["B", "bold", "Bold"], ["I", "italic", "Italic"], ["🔗", "link", "Add link"]]
            .forEach(function (spec) {
                var b = document.createElement("button");
                b.type = "button";
                b.className = "jw-rt-btn";
                b.title = spec[2];
                b.innerHTML = spec[1] === "bold" ? "<strong>B</strong>"
                            : spec[1] === "italic" ? "<em>I</em>"
                            : '<i class="bi bi-link-45deg"></i>';
                b.addEventListener("mousedown", function (e) { e.preventDefault(); });
                b.addEventListener("click", function () {
                    ed.focus();
                    if (spec[1] === "link") {
                        var url = window.prompt("Link URL (e.g. begin.html or https://…)");
                        if (url) document.execCommand("createLink", false, url);
                    } else {
                        document.execCommand(spec[1], false, null);
                    }
                    onInput(ed.innerHTML);
                });
                bar.appendChild(b);
            });

        var ed = document.createElement("div");
        ed.className = "jw-rich" + (isLarge ? " jw-rich-lg" : "") + (isSmall ? " jw-rich-sm" : "");
        ed.contentEditable = "true";
        ed.setAttribute("data-empty", placeholder || "");
        ed.innerHTML = value || "";
        ed.addEventListener("input", function () { onInput(ed.innerHTML); });
        // paste as plain text so outside formatting never leaks in
        ed.addEventListener("paste", function (e) {
            e.preventDefault();
            var txt = (e.clipboardData || window.clipboardData).getData("text/plain");
            document.execCommand("insertText", false, txt);
        });

        wrap.appendChild(bar);
        wrap.appendChild(ed);
        return wrap;
    }

    function input(value, placeholder, onInput) {
        var el = document.createElement("input");
        el.type = "text";
        el.className = "jw-input";
        el.value = value || "";
        el.placeholder = placeholder || "";
        el.addEventListener("input", function () { onInput(el.value); });
        return el;
    }

    /* text input with an Upload button beside it */
    function inputUpload(value, placeholder, onInput) {
        var wrap = document.createElement("div");
        wrap.className = "d-flex gap-2";
        var el = input(value, placeholder, onInput);
        var up = document.createElement("button");
        up.type = "button";
        up.className = "btn btn-outline-secondary jw-mini text-nowrap";
        up.innerHTML = '<i class="bi bi-upload"></i> Upload';
        up.addEventListener("click", function () {
            window.jwUpload(function (url) { el.value = url; onInput(url); });
        });
        wrap.appendChild(el);
        wrap.appendChild(up);
        return wrap;
    }

    function labelled(text, node, hint) {
        var w = document.createElement("div");
        var l = document.createElement("label");
        l.className = "jw-label";
        l.textContent = text;
        w.appendChild(l);
        w.appendChild(node);
        if (hint) {
            var h = document.createElement("p");
            h.className = "jw-hint";
            h.textContent = hint;
            w.appendChild(h);
        }
        return w;
    }

    /* ---------- block body per type ---------- */
    function buildBody(block, index) {
        var body = document.createElement("div");
        body.className = "jw-block-body";

        if (block.type === "paragraph") {
            body.appendChild(rich(block.text, "Write your paragraph…", function (v) { block.text = v; sync(); }, true));
            var lw = document.createElement("div");
            lw.className = "form-check mt-2";
            lw.innerHTML =
                '<input class="form-check-input" type="checkbox" id="lead' + index + '"' + (block.lead ? " checked" : "") + '>' +
                '<label class="form-check-label small text-muted" for="lead' + index + '">Opening paragraph (adds the large decorative first letter)</label>';
            lw.querySelector("input").addEventListener("change", function (e) {
                block.lead = e.target.checked;
                if (block.lead) {
                    state.forEach(function (b) { if (b !== block && b.type === "paragraph") b.lead = false; });
                    render();
                }
                sync();
            });
            body.appendChild(lw);

        } else if (block.type === "heading") {
            var row = document.createElement("div");
            row.className = "jw-row two";
            var sel = document.createElement("select");
            sel.className = "jw-input";
            sel.innerHTML = '<option value="h2">Section heading (H2)</option><option value="h3">Sub heading (H3)</option>';
            sel.value = block.level || "h2";
            sel.addEventListener("change", function () { block.level = sel.value; sync(); });
            row.appendChild(labelled("Level", sel, "H2 headings appear in the article's contents list."));
            row.appendChild(labelled("Heading text", rich(block.text, "e.g. What actually passes", function (v) { block.text = v; sync(); })));
            body.appendChild(row);

        } else if (block.type === "image") {
            body.appendChild(labelled("Image path or URL",
                inputUpload(block.src, "assets/img/spread-bench-dusk.webp", function (v) { block.src = v; sync(); }),
                "Use a path from the site's assets folder, or upload one in Media and paste the path here."));
            var r2 = document.createElement("div");
            r2.className = "jw-row two mt-2";
            r2.appendChild(labelled("Alt text (for accessibility)", input(block.alt, "Describe the illustration", function (v) { block.alt = v; sync(); })));
            r2.appendChild(labelled("Caption (optional)", rich(block.caption, "shown under the image", function (v) { block.caption = v; sync(); })));
            body.appendChild(r2);

        } else if (block.type === "quote") {
            body.appendChild(labelled("Quote", rich(block.text, "The line you want to stand out…", function (v) { block.text = v; sync(); }, true)));
            body.appendChild(labelled("Attribution (optional)", rich(block.cite, "e.g. Storyloom · Studio note", function (v) { block.cite = v; sync(); })));

        } else if (block.type === "takeaway") {
            body.appendChild(labelled("Label", rich(block.label, "The takeaway", function (v) { block.label = v; sync(); })));
            body.appendChild(labelled("Text", rich(block.text, "The point you want remembered…", function (v) { block.text = v; sync(); }, true)));

        } else if (block.type === "list") {
            var optsRow = document.createElement("div");
            optsRow.className = "jw-row two mb-3 align-items-center";

            var styleSel = document.createElement("select");
            styleSel.className = "jw-input";
            styleSel.innerHTML =
                '<option value="bulleted">Bulleted (•)</option>' +
                '<option value="numbered">Numbered (1, 2, 3…)</option>';
            styleSel.value = block.list_style || "bulleted";
            styleSel.addEventListener("change", function () {
                block.list_style = styleSel.value;
                render();
            });
            optsRow.appendChild(labelled("List Style", styleSel));

            var nw = document.createElement("div");
            nw.className = "form-check mt-3";
            nw.innerHTML =
                '<input class="form-check-input" type="checkbox" id="newline' + index + '"' + (block.newline ? " checked" : "") + '>' +
                '<label class="form-check-label small text-muted" for="newline' + index + '">Start paragraph copy on the next line</label>';
            nw.querySelector("input").addEventListener("change", function (e) {
                block.newline = e.target.checked;
                sync();
            });
            optsRow.appendChild(nw);

            body.appendChild(optsRow);

            var host = document.createElement("div");
            var isNumbered = (block.list_style === "numbered");
            (block.items || []).forEach(function (item, i) {
                var wrap = document.createElement("div");
                wrap.className = "jw-item";

                var marker = document.createElement("div");
                marker.className = "jw-item-bullet" + (isNumbered ? "" : " is-bullet");
                marker.innerHTML = isNumbered ? (i + 1) : "&bull;";
                wrap.appendChild(marker);

                var fields = document.createElement("div");
                fields.className = "jw-item-fields";
                fields.appendChild(labelled("Title / Lead-in (optional)", rich(item.lead, "Lead-in or question title", function (v) { item.lead = v; sync(); }, false, true)));
                fields.appendChild(labelled("Paragraph Copy", rich(item.text, "The rest of this point", function (v) { item.text = v; sync(); })));
                wrap.appendChild(fields);
                var del = document.createElement("button");
                del.type = "button";
                del.className = "jw-tool jw-del";
                del.innerHTML = '<i class="bi bi-x-lg"></i>';
                del.title = "Remove this point";
                del.addEventListener("click", function () {
                    block.items.splice(i, 1);
                    if (!block.items.length) block.items.push({ lead: "", text: "" });
                    render();
                });
                wrap.appendChild(del);
                host.appendChild(wrap);
            });
            body.appendChild(host);
            var addI = document.createElement("button");
            addI.type = "button";
            addI.className = "btn btn-outline-secondary jw-mini";
            addI.innerHTML = '<i class="bi bi-plus-lg"></i> Add point';
            addI.addEventListener("click", function () { block.items.push({ lead: "", text: "" }); render(); });
            body.appendChild(addI);

        } else if (block.type === "table") {
            var grid = document.createElement("div");
            grid.className = "jw-table-grid";
            var tbl = document.createElement("table");

            var thead = document.createElement("tr");
            (block.head || []).forEach(function (cell, c) {
                var td = document.createElement("td");
                var inp = rich(cell, "Column " + (c + 1), function (v) { block.head[c] = v; sync(); });
                td.appendChild(inp);
                thead.appendChild(td);
            });
            tbl.appendChild(thead);

            (block.rows || []).forEach(function (row, r) {
                var tr = document.createElement("tr");
                row.forEach(function (cell, c) {
                    var td = document.createElement("td");
                    td.appendChild(rich(cell, "", function (v) { block.rows[r][c] = v; sync(); }));
                    tr.appendChild(td);
                });
                var tdDel = document.createElement("td");
                var del = document.createElement("button");
                del.type = "button";
                del.className = "jw-tool jw-del";
                del.innerHTML = '<i class="bi bi-x-lg"></i>';
                del.title = "Remove row";
                del.addEventListener("click", function () {
                    block.rows.splice(r, 1);
                    if (!block.rows.length) block.rows.push(block.head.map(function () { return ""; }));
                    render();
                });
                tdDel.appendChild(del);
                tr.appendChild(tdDel);
                tbl.appendChild(tr);
            });

            grid.appendChild(tbl);
            body.appendChild(grid);

            var ctrls = document.createElement("div");
            ctrls.className = "d-flex gap-2 mt-2 flex-wrap";
            var addRow = document.createElement("button");
            addRow.type = "button";
            addRow.className = "btn btn-outline-secondary jw-mini";
            addRow.innerHTML = '<i class="bi bi-plus-lg"></i> Add row';
            addRow.addEventListener("click", function () {
                block.rows.push(block.head.map(function () { return ""; }));
                render();
            });
            var addCol = document.createElement("button");
            addCol.type = "button";
            addCol.className = "btn btn-outline-secondary jw-mini";
            addCol.innerHTML = '<i class="bi bi-plus-lg"></i> Add column';
            addCol.addEventListener("click", function () {
                block.head.push("");
                block.rows.forEach(function (r) { r.push(""); });
                render();
            });
            var delCol = document.createElement("button");
            delCol.type = "button";
            delCol.className = "btn btn-outline-secondary jw-mini";
            delCol.innerHTML = '<i class="bi bi-dash-lg"></i> Remove column';
            delCol.addEventListener("click", function () {
                if (block.head.length <= 1) return;
                block.head.pop();
                block.rows.forEach(function (r) { r.pop(); });
                render();
            });
            ctrls.appendChild(addRow); ctrls.appendChild(addCol); ctrls.appendChild(delCol);
            body.appendChild(ctrls);
            body.appendChild(labelled("Caption (optional)",
                rich(block.caption, "shown under the table", function (v) { block.caption = v; sync(); })));

        } else if (block.type === "promo") {
            block.promo = block.promo || Object.assign({}, DEFAULT_PROMO);
            var p = block.promo;
            var note = document.createElement("p");
            note.className = "jw-hint mb-2";
            note.textContent = "This is the book we promote inside this article. It starts as the house default — select a library book or change any field below.";
            body.appendChild(note);

            var booksList = window.libraryBooksData || [];
            if (booksList.length) {
                var bkSel = document.createElement("select");
                bkSel.className = "jw-input mb-2";
                bkSel.innerHTML = '<option value="">— Pick a library book to promote —</option>' +
                    booksList.map(function (lb) {
                        var isSelected = (p.cta_url === "library?book=" + lb.id);
                        return '<option value="' + lb.id + '" data-cover="' + esc(lb.cover_image) + '"' + (isSelected ? " selected" : "") + '>' +
                            'Book #' + lb.id + ': ' + esc(lb.title) + '</option>';
                    }).join("");
                bkSel.addEventListener("change", function () {
                    var opt = bkSel.options[bkSel.selectedIndex];
                    if (opt && opt.value) {
                        p.cover = opt.getAttribute("data-cover") || p.cover;
                        p.cta_url = "library?book=" + opt.value;
                        render();
                    }
                });
                body.appendChild(labelled("Pick Library Book to Promote", bkSel));
            }

            body.appendChild(labelled("Heading", rich(p.heading, "Promo heading", function (v) { p.heading = v; sync(); })));
            body.appendChild(labelled("Body text", rich(p.body, "Why this book fits this article…", function (v) { p.body = v; sync(); }, true)));
            var pr = document.createElement("div");
            pr.className = "jw-row two mt-2";
            pr.appendChild(labelled("Book cover image", inputUpload(p.cover, "assets/img/book1/cover.webp", function (v) { p.cover = v; sync(); })));
            pr.appendChild(labelled("Button link", input(p.cta_url, "library?book=1", function (v) { p.cta_url = v; sync(); })));
            body.appendChild(pr);
            body.appendChild(labelled("Button text", rich(p.cta_text, "Read a real book", function (v) { p.cta_text = v; sync(); })));

            var reset = document.createElement("button");
            reset.type = "button";
            reset.className = "btn btn-outline-secondary jw-mini mt-2";
            reset.innerHTML = '<i class="bi bi-arrow-counterclockwise"></i> Reset to default book';
            reset.addEventListener("click", function () {
                block.promo = Object.assign({}, DEFAULT_PROMO);
                render();
            });
            body.appendChild(reset);

        } else {
            var d = document.createElement("p");
            d.className = "text-muted small mb-0";
            d.textContent = "A thin horizontal rule to separate two parts of the article.";
            body.appendChild(d);
        }

        return body;
    }

    /* ---------- in-between block inserter ---------- */
    function createInserter(targetIndex) {
        var div = document.createElement("div");
        div.className = "jw-inserter";

        var btn = document.createElement("button");
        btn.type = "button";
        btn.className = "jw-inserter-btn";
        btn.innerHTML = '<i class="bi bi-plus-lg"></i> Insert block here';

        var menu = document.createElement("div");
        menu.className = "jw-inserter-menu";
        menu.hidden = true;

        var types = ["paragraph", "heading", "image", "quote", "takeaway", "list", "table", "promo", "divider"];
        types.forEach(function (t) {
            var itemBtn = document.createElement("button");
            itemBtn.type = "button";
            itemBtn.className = "jw-inserter-item";
            var icon = ICONS[t] ? "bi bi-" + ICONS[t] : "bi bi-plus-square";
            itemBtn.innerHTML = '<i class="' + icon + '"></i> ' + esc(LABELS[t] || t);
            itemBtn.addEventListener("click", function (e) {
                e.stopPropagation();
                state.splice(targetIndex, 0, blank(t));
                render();
                var cards = listEl.querySelectorAll(".jw-block");
                if (cards[targetIndex]) {
                    cards[targetIndex].scrollIntoView({ behavior: "smooth", block: "center" });
                }
            });
            menu.appendChild(itemBtn);
        });

        var closeBtn = document.createElement("button");
        closeBtn.type = "button";
        closeBtn.className = "jw-inserter-close";
        closeBtn.title = "Close menu";
        closeBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
        closeBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            menu.hidden = true;
            div.classList.remove("is-open");
        });
        menu.appendChild(closeBtn);

        btn.addEventListener("click", function (e) {
            e.stopPropagation();
            var isOpening = menu.hidden;
            listEl.querySelectorAll(".jw-inserter-menu").forEach(function (m) { m.hidden = true; });
            listEl.querySelectorAll(".jw-inserter").forEach(function (i) { i.classList.remove("is-open"); });
            if (isOpening) {
                menu.hidden = false;
                div.classList.add("is-open");
            }
        });

        div.appendChild(btn);
        div.appendChild(menu);
        return div;
    }

    /* ---------- render the block list ---------- */
    function render() {
        listEl.innerHTML = "";

        if (state.length > 0) {
            listEl.appendChild(createInserter(0));
        }

        state.forEach(function (block, index) {
            var card = document.createElement("div");
            card.className = "jw-block jw-block-" + block.type + (block.type === "promo" ? " is-promo" : "");

            var head = document.createElement("div");
            head.className = "jw-block-head";
            var iconName = ICONS[block.type] || "square";
            head.innerHTML = '<span class="jw-block-kind"><i class="bi bi-' + iconName + '"></i> ' + esc(LABELS[block.type] || block.type) + "</span>";

            var tools = document.createElement("div");
            tools.className = "jw-block-tools";

            function tool(icon, title, fn, disabled) {
                var b = document.createElement("button");
                b.type = "button";
                b.className = "jw-tool" + (title === "Delete block" ? " jw-del" : "");
                b.innerHTML = '<i class="bi bi-' + icon + '"></i>';
                b.title = title;
                b.disabled = !!disabled;
                b.addEventListener("click", fn);
                return b;
            }

            tools.appendChild(tool("plus-lg", "Insert block below", function () {
                state.splice(index + 1, 0, blank("paragraph"));
                render();
                var cards = listEl.querySelectorAll(".jw-block");
                if (cards[index + 1]) cards[index + 1].scrollIntoView({ behavior: "smooth", block: "center" });
            }));

            tools.appendChild(tool("arrow-up", "Move up", function () {
                var t = state[index - 1]; state[index - 1] = state[index]; state[index] = t; render();
            }, index === 0));

            tools.appendChild(tool("arrow-down", "Move down", function () {
                var t = state[index + 1]; state[index + 1] = state[index]; state[index] = t; render();
            }, index === state.length - 1));

            tools.appendChild(tool("files", "Duplicate", function () {
                state.splice(index + 1, 0, JSON.parse(JSON.stringify(block)));
                render();
            }));

            tools.appendChild(tool("trash", "Delete block", function () {
                if (!window.confirm("Remove this " + (LABELS[block.type] || "block").toLowerCase() + "?")) return;
                state.splice(index, 1);
                render();
            }));

            head.appendChild(tools);
            card.appendChild(head);
            card.appendChild(buildBody(block, index));
            listEl.appendChild(card);
            listEl.appendChild(createInserter(index + 1));
        });

        sync();
        paintToc();
        paintWords();
    }

    /* ---------- add buttons ---------- */
    document.querySelectorAll("[data-add]").forEach(function (btn) {
        btn.addEventListener("click", function () {
            state.push(blank(btn.getAttribute("data-add")));
            render();
            var cards = listEl.querySelectorAll(".jw-block");
            if (cards.length) cards[cards.length - 1].scrollIntoView({ behavior: "smooth", block: "center" });
        });
    });

    /* ---------- preview (mirrors the server-side renderer) ---------- */

    function resolveUrl(url) {
        if (!url) return "";
        url = url.trim();
        if (url.startsWith("http://") || url.startsWith("https://") || url.startsWith("data:") || url.startsWith("//")) {
            return url;
        }
        var baseUrl = "{{ asset('/') }}";
        if (url.startsWith("/")) url = url.substring(1);
        return baseUrl + url;
    }

    /* Same treatment JournalRenderer::linksOpenInNewTab() applies on save, so
       the preview shows links behaving as they will once published. */
    function linksNewTab(html) {
        if (!html || html.indexOf("<a ") === -1) return html;
        return html.replace(/<a\b([^>]*)>/gi, function (whole, attrs) {
            if (!/\btarget\s*=/i.test(attrs)) attrs += ' target="_blank"';
            if (!/\brel\s*=/i.test(attrs)) attrs += ' rel="noopener"';
            return "<a" + attrs + ">";
        });
    }

    function previewHTML() {
        return state.map(function (b) {
            if (b.type === "heading")
                return "<" + (b.level || "h2") + ">" + (b.text || "") + "</" + (b.level || "h2") + ">";
            if (b.type === "paragraph")
                return '<p' + (b.lead ? ' class="lead-in"' : "") + ">" + (b.text || "") + "</p>";
            if (b.type === "image") {
                var resolvedSrc = resolveUrl(b.src);
                if (!resolvedSrc) return "";
                return '<figure class="article-figure plate"><img src="' + esc(resolvedSrc) + '" alt="' + esc(b.alt) + '">' +
                    (b.caption ? "<figcaption>" + b.caption + "</figcaption>" : "") + "</figure>";
            }
            if (b.type === "quote")
                return '<blockquote class="pull-quote">' + (b.text || "") +
                    (b.cite ? "<cite>" + b.cite + "</cite>" : "") + "</blockquote>";
            if (b.type === "takeaway")
                return '<div class="takeaway"><p class="tk-label">' +
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12.5l5 5L20 6.5"/></svg> ' +
                    (b.label || "The takeaway") + "</p><p>" + (b.text || "") + "</p></div>";
            if (b.type === "list") {
                var isNewline  = !!b.newline;
                var isNumbered = (b.list_style === "numbered");
                var tag = isNumbered ? "ol" : "ul";
                return "<" + tag + ' class="article-list' + (isNumbered ? " is-numbered" : "") + '">' + (b.items || []).map(function (i) {
                    var leadStr = (i.lead || "").trim();
                    var textStr = (i.text || "").trim();
                    if (!leadStr && !textStr) return "";
                    if (leadStr) {
                        var leadMarkup = (leadStr.toLowerCase().startsWith("<strong") || leadStr.toLowerCase().startsWith("<b")) ? leadStr : "<strong>" + leadStr + "</strong>";
                        return "<li>" + leadMarkup + (isNewline ? "<br>" : " ") + textStr + "</li>";
                    }
                    return "<li>" + textStr + "</li>";
                }).join("") + "</" + tag + ">";
            }
            if (b.type === "table") {
                var head = (b.head || []).some(function (c) { return (c || "").trim(); })
                    ? "<thead><tr>" + b.head.map(function (c) { return "<th>" + (c || "") + "</th>"; }).join("") + "</tr></thead>" : "";
                var rows = (b.rows || []).map(function (r) {
                    if (!r.some(function (c) { return (c || "").trim(); })) return "";
                    return "<tr>" + r.map(function (c) { return "<td>" + (c || "") + "</td>"; }).join("") + "</tr>";
                }).join("");
                return '<div class="table-wrap"><table class="article-table">' + head + "<tbody>" + rows + "</tbody></table></div>" +
                    (b.caption ? '<p class="table-caption">' + (b.caption || "") + "</p>" : "");
            }
            if (b.type === "promo") {
                var promoEn = document.getElementById("promoEnabled");
                if (promoEn && !promoEn.checked) return "";

                var p = b.promo || DEFAULT_PROMO;
                var coverPath = p.cover;
                var ctaPath   = p.cta_url || "library?book=1";

                // Auto-match library book cover if link points to library?book=X
                if (ctaPath && window.libraryBooksData) {
                    var m = ctaPath.match(/book[=_](\d+)/i);
                    if (m) {
                        var targetId = parseInt(m[1], 10);
                        var foundBk = window.libraryBooksData.find(function (lb) { return lb.id === targetId; });
                        if (foundBk && foundBk.cover_image) {
                            coverPath = foundBk.cover_image;
                        }
                    }
                }

                var resolvedCover = resolveUrl(coverPath || "assets/img/book1/cover.webp");
                var resolvedCta   = resolveUrl(ctaPath);
                var ctaBtnText    = (p.cta_text || "").trim() || "Read a real book";
                return '<aside class="inline-cta"><a class="ic-cover" href="' + esc(resolvedCta) + '" style="display:block;"><img src="' + esc(resolvedCover) + '" alt=""></a>' +
                    "<div><h3>" + (p.heading || "") + "</h3><p>" + (p.body || "") + "</p>" +
                    '<a class="btn btn-primary" href="' + esc(resolvedCta) + '">' + ctaBtnText + ' <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg></a></div></aside>';
            }
            if (b.type === "divider") return '<hr class="article-rule">';
            return "";
        }).map(linksNewTab).join("\n");
    }

    var tabWrite = document.getElementById("jwTabWrite");
    var tabPrev  = document.getElementById("jwTabPreview");
    tabWrite.addEventListener("click", function () {
        document.getElementById("jwWrite").hidden = false;
        document.getElementById("jwPreview").hidden = true;
        tabWrite.classList.add("active"); tabPrev.classList.remove("active");
    });
    /* Build a complete document for the preview iframe, using the live
       stylesheet and the same wrappers blog/show.blade.php puts around an
       article. Anything the real page inherits from .article-layout or
       .article-body is therefore inherited here too. */
    function previewDocument(width) {
        var css   = {!! json_encode(asset('assets/css/main.css') . '?v=' . (@filemtime(public_path('assets/css/main.css')) ?: '1')) !!};
        var fonts = "https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap";
        var title = (document.getElementById("titleRich") || {}).innerHTML || "";
        var body  = state.length
            ? previewHTML()
            : '<p style="text-align:center;color:#8a9099;padding:40px 0;">Nothing to preview yet — add a block first.</p>';

        var promoEn = document.getElementById("promoEnabled");
        var showPromo = promoEn ? promoEn.checked : true;
        var hasInlinePromo = state.some(function (b) { return b.type === "promo"; });

        if (showPromo && !hasInlinePromo) {
            var p = promo || DEFAULT_PROMO;
            var coverPath = p.cover;
            var ctaPath   = p.cta_url || "library?book=1";
            if (ctaPath && window.libraryBooksData) {
                var m = ctaPath.match(/book[=_](\d+)/i);
                if (m) {
                    var targetId = parseInt(m[1], 10);
                    var foundBk = window.libraryBooksData.find(function (lb) { return lb.id === targetId; });
                    if (foundBk && foundBk.cover_image) coverPath = foundBk.cover_image;
                }
            }
            var resolvedCover = resolveUrl(coverPath || "assets/img/book1/cover.webp");
            var resolvedCta   = resolveUrl(ctaPath);
            var ctaBtnText    = (p.cta_text || "").trim() || "Read a real book";
            body += '\n<aside class="inline-cta"><a class="ic-cover" href="' + esc(resolvedCta) + '" style="display:block;"><img src="' + esc(resolvedCover) + '" alt=""></a>' +
                '<div><h3>' + (p.heading || "") + '</h3><p>' + (p.body || "") + '</p>' +
                '<a class="btn btn-primary" href="' + esc(resolvedCta) + '">' + ctaBtnText + ' <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 12h17m0 0-6-6m6 6-6 6"/></svg></a></div></aside>';
        }

        return '<!doctype html><html lang="en"><head><meta charset="utf-8">' +
            '<meta name="viewport" content="width=device-width, initial-scale=1">' +
            '<link rel="stylesheet" href="' + fonts + '">' +
            '<link rel="stylesheet" href="' + css + '">' +
            '<style>' +
              'body{margin:0;background:var(--parchment,#F8F4EC);}' +
              /* The reveal animation is driven by an observer that does not run
                 in here, so content would sit invisible at opacity 0. */
              '[data-reveal]{opacity:1 !important;transform:none !important;}' +
              '.jw-frame-wrap{padding:' + (width === "mobile" ? "18px 16px 40px" : "34px 40px 60px") + ';}' +
            '</style></head><body><div class="jw-frame-wrap">' +
            (title ? '<h1 class="jw-frame-title">' + title + '</h1>' : '') +
            '<div class="article-body">' + body + '</div>' +
            '</div></body></html>';
    }

    var previewWidth = "desktop";

    function paintPreview() {
        var frame = document.getElementById("jwPreviewFrame");
        if (!frame) return;
        var doc = frame.contentDocument || frame.contentWindow.document;
        doc.open();
        doc.write(previewDocument(previewWidth));
        doc.close();
    }

    document.querySelectorAll(".jw-width-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            previewWidth = btn.getAttribute("data-width");
            document.querySelectorAll(".jw-width-btn").forEach(function (b) { b.classList.remove("active"); });
            btn.classList.add("active");
            document.getElementById("jwPreviewStage")
                .classList.toggle("is-mobile", previewWidth === "mobile");
            paintPreview();
        });
    });

    tabPrev.addEventListener("click", function () {
        paintPreview();
        document.getElementById("jwWrite").hidden = true;
        document.getElementById("jwPreview").hidden = false;
        tabPrev.classList.add("active"); tabWrite.classList.remove("active");
    });

    /* ---------- first run: a sensible Storyloom skeleton ---------- */
    if (!state.length) {
        state = [
            { type: "paragraph", text: "", lead: true },
            { type: "heading", level: "h2", text: "" },
            { type: "paragraph", text: "" },
            { type: "promo", promo: Object.assign({}, DEFAULT_PROMO) }
        ];
    }


    /* ---------- image upload (shared by every cover / image field) ---------- */
    var uploader = document.getElementById("jwUploader");
    var uploadTarget = null;

    window.jwUpload = function (setter) {
        uploadTarget = setter;
        uploader.value = "";
        uploader.click();
    };

    if (uploader) {
        uploader.addEventListener("change", function () {
            var file = uploader.files && uploader.files[0];
            if (!file || !uploadTarget) return;
            var fd = new FormData();
            fd.append("file", file);
            var token = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').content
                : (document.querySelector('input[name="_token"]') || {}).value;
            fd.append("_token", token);

            fetch("{{ route('admin.blog.upload') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token
                },
                body: fd
            })
                .then(function (r) { return r.json(); })
                .then(function (d) {
                    if (d && d.url) { uploadTarget(d.url); }
                    else { window.alert("Upload failed."); }
                })
                .catch(function () { window.alert("Upload failed."); });
        });
    }

    /* delegated upload buttons for plain inputs (sidebar cover etc.) */
    document.querySelectorAll("[data-upload-for]").forEach(function (btn) {
        btn.addEventListener("click", function () {
            var input = document.getElementById(btn.getAttribute("data-upload-for"));
            window.jwUpload(function (url) {
                input.value = url;
                input.dispatchEvent(new Event("input", { bubbles: true }));
            });
        });
    });

    /* ---------- sidebar book card ---------- */
    var sidebarField = document.getElementById("sidebarField");
    if (sidebarField) {
        var DEFAULT_SIDEBAR = JSON.parse(document.getElementById("jwDefaultSidebar").textContent);
        var sb = {};
        try { sb = JSON.parse(sidebarField.value) || {}; } catch (e) { sb = {}; }
        sb = Object.assign({}, DEFAULT_SIDEBAR, sb);

        var map = {
            sbLabel: "label", sbHeading: "heading", sbBody: "body",
            sbCover: "cover", sbCtaUrl: "cta_url", sbCtaText: "cta_text"
        };

        function paintCover() {
            var img = document.getElementById("sbCoverPreview");
            if (!img) return;
            var v = sb.cover || "";
            img.src = v ? resolveUrl(v) : "";
            img.style.visibility = v ? "visible" : "hidden";
        }

        function paintSidebar() {
            Object.keys(map).forEach(function (id) {
                var el = document.getElementById(id);
                if (el) el.value = sb[map[id]] || "";
            });
            paintCover();
            var en = document.getElementById("sbEnabled");
            if (en) en.checked = sb.enabled !== false;
            sidebarField.value = JSON.stringify(sb);
        }

        Object.keys(map).forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            el.addEventListener("input", function () {
                sb[map[id]] = el.value;
                sidebarField.value = JSON.stringify(sb);
                if (id === "sbCover") paintCover();
            });
        });

        var sbEn = document.getElementById("sbEnabled");
        if (sbEn) sbEn.addEventListener("change", function () {
            sb.enabled = sbEn.checked;
            sidebarField.value = JSON.stringify(sb);
        });

        /* Library book picker, matching the one on the Article Body Promo panel.
           It fills the cover and the link and leaves the wording alone, so a
           book can be swapped without losing copy that has been tuned. */
        var sbPick = document.getElementById("sbBookSelect");
        if (sbPick) {
            // Reflect the book the card already points at, if any.
            var current = String(sb.cta_url || "").match(/book[=_](\d+)/i);
            if (current) sbPick.value = current[1];

            sbPick.addEventListener("change", function () {
                var opt = sbPick.options[sbPick.selectedIndex];
                if (!opt || !opt.value) return;

                sb.cover = opt.getAttribute("data-cover") || sb.cover;
                sb.cta_url = "library?book=" + opt.value;

                paintSidebar();
            });
        }

        var sbReset = document.getElementById("sbReset");
        if (sbReset) sbReset.addEventListener("click", function () {
            sb = Object.assign({}, DEFAULT_SIDEBAR);
            if (sbPick) sbPick.value = "";
            paintSidebar();
        });

        paintSidebar();
    }

    /* ---------- article body promo panel listeners ---------- */
    (function () {
        var pHeading = document.getElementById("promoHeading");
        var pBody    = document.getElementById("promoBody");
        var pCover   = document.getElementById("promoCover");
        var pCtaText = document.getElementById("promoCtaText");
        var pCtaUrl  = document.getElementById("promoCtaUrl");
        var pSelect  = document.getElementById("promoBookSelect");

        function updatePromoPanel() {
            if (pHeading) promo.heading  = pHeading.value;
            if (pBody)    promo.body     = pBody.value;
            if (pCover)   promo.cover    = pCover.value;
            if (pCtaText) promo.cta_text = pCtaText.value;
            if (pCtaUrl)  promo.cta_url  = pCtaUrl.value;

            var prevImg = document.getElementById("promoCoverPreview");
            if (prevImg && pCover) {
                prevImg.src = resolveUrl(pCover.value);
            }

            sync();
        }

        [pHeading, pBody, pCover, pCtaText, pCtaUrl].forEach(function (el) {
            if (el) {
                el.addEventListener("input", updatePromoPanel);
                el.addEventListener("change", updatePromoPanel);
            }
        });

        if (pSelect) {
            pSelect.addEventListener("change", function () {
                var opt = pSelect.options[pSelect.selectedIndex];
                if (opt && opt.value) {
                    var cover = opt.getAttribute("data-cover") || "";
                    if (pCover) pCover.value = cover;
                    if (pCtaUrl) pCtaUrl.value = "library?book=" + opt.value;
                    updatePromoPanel();
                }
            });
        }

        var promoEn = document.getElementById("promoEnabled");
        if (promoEn) {
            promoEn.addEventListener("change", function () {
                sync();
                if (typeof paintPreview === "function") paintPreview();
            });
        }
    })();

    /* ---------- full-article preview ---------- */
    var fullBtn = document.getElementById("jwFullPreview");
    if (fullBtn) {
        fullBtn.addEventListener("click", function () {
            sync();
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "{{ route('admin.blog.preview') }}";
            form.target = "_blank";

            function hidden(name, value) {
                var i = document.createElement("input");
                i.type = "hidden"; i.name = name; i.value = value == null ? "" : value;
                form.appendChild(i);
            }

            var tokenEl = document.querySelector('input[name="_token"]');
            hidden("_token", tokenEl ? tokenEl.value : "");
            hidden("blocks", blocksField.value);
            hidden("promo", promoField.value);
            hidden("sidebar_promo", sidebarField ? sidebarField.value : "");

            var get = function (id) { var e = document.getElementById(id); return e ? e.value : ""; };
            hidden("title", get("title"));
            hidden("title_html", get("titleHtmlField"));
            hidden("short_description", get("short_description"));
            hidden("dek", get("dek"));
            hidden("category", get("category"));
            hidden("read_time", get("read_time"));
            hidden("toc_label", get("toc_label"));
            hidden("featured_image", get("featured_image"));
            var tEn = document.getElementById("tocEnabled");
            if (tEn && tEn.checked) hidden("show_toc", "1");

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        });
    }

    /* ---------- headline <em> accent ---------- */
    var titleRich = document.getElementById("titleRich");
    var titleHtmlField = document.getElementById("titleHtmlField");
    var titlePlain = document.getElementById("title");
    var syncTitle = function () {};

    if (titleRich && titleHtmlField && titlePlain) {
        syncTitle = function () {
            titleHtmlField.value = titleRich.innerHTML;
            titlePlain.value = titleRich.textContent.trim();
        };
        titleRich.addEventListener("input", syncTitle);
        titleRich.addEventListener("blur", syncTitle);

        titleRich.addEventListener("paste", function (e) {
            e.preventDefault();
            var txt = (e.clipboardData || window.clipboardData).getData("text/plain");
            document.execCommand("insertText", false, txt);
        });

        var accentToEm = function () {
            var last = null;
            var nodes = titleRich.querySelectorAll("i, span[style*='italic']");

            Array.prototype.forEach.call(nodes, function (node) {
                var em = document.createElement("em");
                em.innerHTML = node.innerHTML;
                node.parentNode.replaceChild(em, node);
                last = em;
            });

            return last;
        };

        var emBtn = document.getElementById("titleEmBtn");
        if (emBtn) {
            emBtn.addEventListener("mousedown", function (e) { e.preventDefault(); });
            emBtn.addEventListener("click", function () {
                titleRich.focus();
                document.execCommand("italic", false, null);

                var replaced = accentToEm();
                if (replaced) {
                    var range = document.createRange();
                    range.selectNodeContents(replaced);
                    var sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(range);
                }

                syncTitle();
            });
        }
        syncTitle();
    }

    /* ---------- form submit sync ---------- */
    var mainBlogForm = document.querySelector("form[action*='admin/blog']");
    if (mainBlogForm) {
        mainBlogForm.addEventListener("submit", function () {
            if (typeof syncTitle === "function") syncTitle();
            if (typeof sync === "function") sync();
        });
    }


    /* ---------- contents list (the reader's "jump around" rail) ---------- */
    var tocPreview = document.getElementById("tocPreview");
    var tocEnabled = document.getElementById("tocEnabled");

    function stripTocText(raw) {
        if (!raw) return "";
        var tmp = document.createElement("div");
        tmp.innerHTML = String(raw).replace(/&nbsp;/gi, " ");
        return (tmp.textContent || tmp.innerText || "").replace(/\s+/g, " ").trim();
    }

    function slugify(s) {
        return String(s).toLowerCase().replace(/<[^>]*>/g, "")
            .replace(/[^\w\s-]/g, "").trim().replace(/\s+/g, "-");
    }

    function paintToc() {
        if (!tocPreview) return;
        var heads = state.filter(function (b) {
            return b.type === "heading" && stripTocText(b.text) !== "";
        });
        tocPreview.innerHTML = "";
        if (!heads.length) {
            var li = document.createElement("li");
            li.className = "jw-toc-empty";
            li.textContent = "Add an H2 heading and it will show up here.";
            tocPreview.appendChild(li);
            return;
        }
        heads.forEach(function (h) {
            var li = document.createElement("li");
            var txt = stripTocText(h.text);
            li.textContent = txt;
            li.title = "#" + slugify(txt);
            tocPreview.appendChild(li);
        });
    }

    function paintDim() {
        var panel = tocPreview ? tocPreview.closest(".jw-panel") : null;
        if (panel) panel.style.opacity = (tocEnabled && !tocEnabled.checked) ? ".55" : "";
    }
    if (tocEnabled) tocEnabled.addEventListener("change", paintDim);

    /* word count for the toolbar */
    function paintWords() {
        var el = document.getElementById("jwWords");
        if (!el) return;
        var text = state.map(function (b) {
            var bag = [b.text || "", b.caption || "", b.cite || ""];
            (b.items || []).forEach(function (i) { bag.push((i.lead || "") + " " + (i.text || "")); });
            (b.rows || []).forEach(function (r) { bag.push(r.join(" ")); });
            return bag.join(" ");
        }).join(" ").replace(/<[^>]*>/g, " ");
        var n = text.split(/\s+/).filter(Boolean).length;
        el.textContent = n + (n === 1 ? " word" : " words");
    }

    /* Cover Image Live Preview listener */
    var coverFileInput = document.getElementById("featured_image_file");
    if (coverFileInput) {
        coverFileInput.addEventListener("change", function (e) {
            var file = e.target.files && e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function (evt) {
                    var base64 = evt.target.result;
                    var hiddenInput = document.getElementById("featured_image");
                    if (hiddenInput) hiddenInput.value = base64;
                    var img = document.getElementById("cover_preview_img");
                    var container = document.getElementById("cover_preview_container");
                    if (img) img.src = base64;
                    if (container) container.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });
    }

    paintDim();
    render();
})();
</script>
