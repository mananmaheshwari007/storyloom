/* ============================================================
   STORYLOOM — journal (blog) interactions
   · Client-side topic filtering on the index
   · Newsletter capture (no backend — hands off to mail)
   · Reading progress + active-heading table of contents
     on article pages
   ============================================================ */
(function () {
  "use strict";

  var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* ---------- Topic filtering ---------- */
  var pills = document.querySelectorAll(".filter-pill");
  var grid = document.getElementById("post-grid");
  if (pills.length && grid) {
    var cards = grid.querySelectorAll(".post-card");
    var countEl = document.getElementById("filter-count");
    var emptyEl = document.getElementById("no-results");

    var apply = function (filter) {
      var shown = 0;
      cards.forEach(function (card) {
        var match = filter === "all" || card.getAttribute("data-cat") === filter;
        card.hidden = !match;
        if (match) {
          shown++;
          /* re-run the entrance so filtered-in cards animate rather than pop */
          if (!reduceMotion) {
            card.classList.remove("is-visible");
            card.style.setProperty("--stagger", String(shown % 3));
            void card.offsetWidth; // force reflow so the transition restarts
            card.classList.add("is-visible");
          }
        }
      });
      if (countEl) {
        countEl.textContent =
          shown + (shown === 1 ? " story" : " stories") +
          (filter === "all" ? "" : " in this topic");
      }
      if (emptyEl) emptyEl.hidden = shown !== 0;
    };

    pills.forEach(function (pill) {
      pill.addEventListener("click", function () {
        pills.forEach(function (p) { p.setAttribute("aria-pressed", String(p === pill)); });
        apply(pill.getAttribute("data-filter"));
      });
    });

    apply("all");
  }

  /* ---------- Newsletter capture ---------- */
  var newsForm = document.getElementById("news-form");
  if (newsForm) {
    newsForm.addEventListener("submit", function (e) {
      e.preventDefault();
      var input = newsForm.querySelector("input[type='email']");
      var value = (input.value || "").trim();
      if (!value || value.indexOf("@") < 1 || value.indexOf(".") < 0) {
        input.focus();
        input.setAttribute("aria-invalid", "true");
        return;
      }
      input.removeAttribute("aria-invalid");
      /* No backend yet — hand the subscriber off by mail so nothing is lost.
         Swap this for a real list endpoint when one exists. */
      window.location.href =
        "mailto:hello@storyloom.in" +
        "?subject=" + encodeURIComponent("Subscribe me to The Loom Letter") +
        "&body=" + encodeURIComponent("Please add this address to The Loom Letter: " + value);
      var ok = document.getElementById("news-success");
      if (ok) ok.hidden = false;
      newsForm.reset();
    });
  }

  /* ---------- Article: active heading in the table of contents ---------- */
  var toc = document.querySelector(".toc");
  if (toc && "IntersectionObserver" in window) {
    var links = toc.querySelectorAll("a[href^='#']");
    var map = {};
    var targets = [];
    links.forEach(function (a) {
      var id = a.getAttribute("href").slice(1);
      var section = document.getElementById(id);
      if (section) { map[id] = a; targets.push(section); }
    });
    if (targets.length) {
      var spy = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          var a = map[entry.target.id];
          if (!a) return;
          if (entry.isIntersecting) {
            links.forEach(function (l) { l.style.color = ""; l.style.fontWeight = ""; });
            a.style.color = "var(--terra-deep)";
            a.style.fontWeight = "700";
          }
        });
      }, { rootMargin: "-15% 0px -70% 0px", threshold: 0 });
      targets.forEach(function (t) { spy.observe(t); });
    }
  }

  /* ---------- Article: share buttons ---------- */
  document.querySelectorAll("[data-share]").forEach(function (btn) {
    btn.addEventListener("click", function (e) {
      var kind = btn.getAttribute("data-share");
      var url = window.location.href;
      var title = document.title;
      if (kind === "copy") {
        e.preventDefault();
        if (navigator.clipboard) {
          navigator.clipboard.writeText(url).then(function () {
            var prev = btn.getAttribute("aria-label");
            btn.setAttribute("aria-label", "Link copied");
            btn.classList.add("copied");
            window.setTimeout(function () {
              btn.setAttribute("aria-label", prev);
              btn.classList.remove("copied");
            }, 2000);
          });
        }
        return;
      }
      if (kind === "native") {
        if (navigator.share) {
          e.preventDefault();
          navigator.share({ title: title, url: url }).catch(function () {});
        }
      }
    });
  });
})();
