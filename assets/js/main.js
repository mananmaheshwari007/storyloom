/* ============================================================
   STORYLOOM — shared interactions
   All animation is transform/opacity only and respects
   prefers-reduced-motion.
   ============================================================ */
(function () {
  "use strict";

  var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* ---------- Sticky header ---------- */
  var header = document.querySelector(".site-header");
  if (header) {
    var onScrollHeader = function () {
      header.classList.toggle("is-scrolled", window.scrollY > 24);
    };
    window.addEventListener("scroll", onScrollHeader, { passive: true });
    onScrollHeader();
  }

  /* ---------- Mobile menu ---------- */
  var toggle = document.querySelector(".nav-toggle");
  var menu = document.querySelector(".mobile-menu");
  if (toggle && menu) {
    var links = menu.querySelectorAll("a.menu-link");
    links.forEach(function (a, i) {
      a.style.transitionDelay = 0.06 + i * 0.05 + "s";
    });
    var setMenu = function (open) {
      toggle.setAttribute("aria-expanded", String(open));
      menu.classList.toggle("is-open", open);
      document.body.style.overflow = open ? "hidden" : "";
    };
    toggle.addEventListener("click", function () {
      setMenu(toggle.getAttribute("aria-expanded") !== "true");
    });
    menu.addEventListener("click", function (e) {
      if (e.target.closest("a")) setMenu(false);
    });
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && menu.classList.contains("is-open")) setMenu(false);
    });
  }

  /* ---------- Hero entrance ---------- */
  var hero = document.querySelector(".hero");
  if (hero) {
    var heroReady = function () { hero.classList.add("is-ready"); };
    requestAnimationFrame(function () {
      requestAnimationFrame(heroReady);
    });
    window.setTimeout(heroReady, 800); // fallback when rAF is throttled (hidden/background tab)
  }

  /* ---------- Scroll reveals ---------- */
  var revealables = document.querySelectorAll("[data-reveal], .thread-divider");
  if ("IntersectionObserver" in window && revealables.length) {
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            io.unobserve(entry.target);
          }
        });
      },
      { rootMargin: "0px 0px -8% 0px", threshold: 0.08 }
    );
    revealables.forEach(function (el) { io.observe(el); });
  } else {
    revealables.forEach(function (el) { el.classList.add("is-visible"); });
  }

  /* ---------- Gentle parallax on hero art ---------- */
  var plate = document.querySelector(".hero-plate-wrap");
  if (plate && !reduceMotion) {
    var ticking = false;
    var parallax = function () {
      var y = Math.min(window.scrollY, 900);
      plate.style.transform = "translateY(" + y * -0.045 + "px)";
      ticking = false;
    };
    window.addEventListener("scroll", function () {
      if (!ticking) { requestAnimationFrame(parallax); ticking = true; }
    }, { passive: true });
  }

  /* ---------- Testimonial rotator ---------- */
  var stage = document.querySelector(".testimonial-stage");
  if (stage) {
    var items = stage.querySelectorAll(".testimonial");
    var dots = document.querySelectorAll(".testimonial-dots button");
    var idx = 0;
    var timer = null;
    var show = function (n) {
      idx = (n + items.length) % items.length;
      items.forEach(function (el, i) { el.classList.toggle("is-active", i === idx); });
      dots.forEach(function (d, i) { d.setAttribute("aria-current", String(i === idx)); });
    };
    var play = function () {
      if (reduceMotion) return;
      timer = window.setInterval(function () { show(idx + 1); }, 6000);
    };
    var stop = function () { if (timer) { clearInterval(timer); timer = null; } };
    dots.forEach(function (d, i) {
      d.addEventListener("click", function () { stop(); show(i); play(); });
    });
    stage.addEventListener("mouseenter", stop);
    stage.addEventListener("mouseleave", function () { stop(); play(); });
    show(0);
    play();
  }

  /* ---------- FAQ accordion ---------- */
  document.querySelectorAll(".faq-item").forEach(function (item) {
    var btn = item.querySelector(".faq-q");
    var panel = item.querySelector(".faq-a");
    if (!btn || !panel) return;
    btn.setAttribute("aria-expanded", "false");
    btn.addEventListener("click", function () {
      var open = item.classList.toggle("is-open");
      btn.setAttribute("aria-expanded", String(open));
    });
  });

  /* ---------- Book reader (centre-fold page turn) ----------
     The book = two static halves + a turning leaf hinged at the
     spine. Index -1 is the closed front cover (sitting on the
     right of the spine); index pages.length is the back cover
     (closed on the left). Every spread is split across the fold. */
  var modal = document.querySelector(".reader-modal");
  if (modal) {
    var bookEl = modal.querySelector(".reader-book");
    var halfL = modal.querySelector(".half-left");
    var halfR = modal.querySelector(".half-right");
    var leaf = modal.querySelector(".leaf");
    var leafF = modal.querySelector(".leaf-front");
    var leafB = modal.querySelector(".leaf-back");
    var titleEl = modal.querySelector(".reader-title");
    var captionEl = modal.querySelector(".reader-caption");
    var indEl = modal.querySelector(".page-ind");
    var prevBtn = modal.querySelector(".reader-arrow.prev");
    var nextBtn = modal.querySelector(".reader-arrow.next");
    var closeBtn = modal.querySelector(".reader-close");
    var current = { pages: [], title: "", sub: "", i: -1 };
    var lastFocus = null;
    var animating = false;

    var esc = function (s) {
      return String(s).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
    };
    var faceHTML = function (kind) {
      if (kind === "cover") {
        return '<span class="bookface"><img src="assets/img/logo-emblem-light.png" alt="">' +
          '<span class="bf-title">' + esc(current.title) + "</span>" +
          '<span class="bf-sub">' + esc(current.sub || "A Storyloom original") + "</span></span>";
      }
      return '<span class="bookface"><img src="assets/img/logo-emblem-light.png" alt="">' +
        '<span class="bf-sub">Woven by Storyloom</span></span>';
    };
    /* what occupies one side of the fold at position i */
    var sideView = function (i, side) {
      if (i === -1) return side === "right" ? "cover" : null;
      if (i === current.pages.length) return side === "left" ? "back" : null;
      return current.pages[i] || null;
    };
    var setFace = function (el, view, side) {
      el.innerHTML = "";
      el.classList.remove("empty");
      if (!view) { el.classList.add("empty"); return; }
      if (view === "cover" || view === "back") {
        var src = view === "cover" ? current.coverSrc : current.backSrc;
        if (src) {
          var cimg = document.createElement("img");
          cimg.className = "art-cover";
          cimg.src = src;
          cimg.alt = view === "cover" ? "Front cover of " + current.title : "Back cover";
          el.appendChild(cimg);
        } else {
          el.innerHTML = faceHTML(view);
        }
        return;
      }
      var img = document.createElement("img");
      img.className = "art" + (side === "right" ? " side-right" : "");
      img.src = view.src;
      img.alt = view.alt || "";
      el.appendChild(img);
    };
    var renderSteady = function () {
      setFace(halfL, sideView(current.i, "left"), "left");
      setFace(halfR, sideView(current.i, "right"), "right");
      leaf.className = "leaf";
      leaf.style.display = "none";
      leaf.style.transitionDuration = "";
      var n = current.pages.length;
      indEl.textContent = current.i === -1 ? "Cover" : current.i === n ? "The end" : (current.i + 1) + " / " + n;
      captionEl.textContent =
        current.i >= 0 && current.i < n ? (current.pages[current.i].caption || "") :
        current.i === -1 ? "Turn the page to begin" : "";
      prevBtn.disabled = current.i === -1;
      nextBtn.disabled = current.i === n;
      bookEl.classList.toggle("closed-right", current.i === -1);
      bookEl.classList.toggle("closed-left", current.i === n);
    };
    /* rAF + a short setTimeout fallback — some environments (background
       tabs, this app's non-compositing preview pane) throttle or skip
       rAF entirely, which would otherwise stall a burst of queued turns
       partway through. Mirrors the same guard used for .hero above. */
    var nextFrame = function (cb) {
      var done = false;
      var run = function () { if (done) return; done = true; cb(); };
      requestAnimationFrame(function () { requestAnimationFrame(run); });
      window.setTimeout(run, 40);
    };
    var queued = [];
    var turn = function (dir, fast) {
      if (animating) {
        if (queued.length < 4) queued.push(dir);
        return;
      }
      var from = current.i;
      var to = from + dir;
      if (to < -1 || to > current.pages.length) { queued.length = 0; return; }
      if (reduceMotion) { current.i = to; renderSteady(); return; }
      animating = true;
      /* queued turns play quicker so a burst of clicks reads as
         riffling through pages, not one slow turn per click */
      leaf.style.transitionDuration = (fast || queued.length) ? "0.4s" : "";
      if (dir > 0) {
        setFace(halfL, sideView(from, "left"), "left");
        setFace(halfR, sideView(to, "right"), "right");
        setFace(leafF, sideView(from, "right"), "right");
        setFace(leafB, sideView(to, "left"), "left");
        leaf.className = "leaf on-right";
      } else {
        setFace(halfR, sideView(from, "right"), "right");
        setFace(halfL, sideView(to, "left"), "left");
        setFace(leafF, sideView(from, "left"), "left");
        setFace(leafB, sideView(to, "right"), "right");
        leaf.className = "leaf on-left";
      }
      leaf.style.display = "";
      bookEl.classList.remove("closed-right", "closed-left");
      var finish = function () {
        leaf.removeEventListener("transitionend", finish);
        if (!animating) return;
        animating = false;
        current.i = to;
        renderSteady();
        if (queued.length) {
          var next = queued.shift();
          turn(next, true);
        }
      };
      leaf.addEventListener("transitionend", finish);
      window.setTimeout(finish, (fast || queued.length) ? 520 : 780);
      nextFrame(function () { leaf.classList.add("turn"); });
    };

    var openReader = function (srcEl) {
      try {
        current.pages = JSON.parse(srcEl.getAttribute("data-book-pages"));
      } catch (e) { return; }
      current.title = srcEl.getAttribute("data-book-title") || "Storyloom";
      current.sub = srcEl.getAttribute("data-book-sub") || "";
      current.coverSrc = srcEl.getAttribute("data-book-cover") || "";
      current.backSrc = srcEl.getAttribute("data-book-back") || "";
      current.i = -1;
      titleEl.textContent = current.title;
      current.pages.forEach(function (p) { var im = new Image(); im.src = p.src; });
      [current.coverSrc, current.backSrc].forEach(function (s) {
        if (s) { var im = new Image(); im.src = s; }
      });
      lastFocus = document.activeElement;
      modal.classList.add("is-open");
      document.body.style.overflow = "hidden";
      renderSteady();
      closeBtn.focus();
    };
    var closeReader = function () {
      modal.classList.remove("is-open");
      document.body.style.overflow = "";
      animating = false;
      queued.length = 0;
      if (lastFocus) lastFocus.focus();
    };

    document.querySelectorAll("[data-book-pages]").forEach(function (el) {
      el.addEventListener("click", function () { openReader(el); });
    });
    // Display cards (and anything else) can proxy to a reader button
    document.querySelectorAll("[data-open-book]").forEach(function (el) {
      el.addEventListener("click", function () {
        var target = document.querySelector(el.getAttribute("data-open-book"));
        if (target) openReader(target);
      });
    });
    prevBtn.addEventListener("click", function () { turn(-1); });
    nextBtn.addEventListener("click", function () { turn(1); });
    closeBtn.addEventListener("click", closeReader);
    modal.addEventListener("click", function (e) { if (e.target === modal) closeReader(); });
    document.addEventListener("keydown", function (e) {
      if (!modal.classList.contains("is-open")) return;
      if (e.key === "Escape") closeReader();
      if (e.key === "ArrowRight") nextBtn.click();
      if (e.key === "ArrowLeft") prevBtn.click();
    });
  }

  /* ---------- Begin form → WhatsApp / mail handoff ---------- */
  var beginForm = document.querySelector("#begin-form");
  if (beginForm) {
    beginForm.addEventListener("submit", function (e) {
      e.preventDefault();
      var f = new FormData(beginForm);
      var lines = [
        "Hello Storyloom — I'd like to begin a story.",
        "",
        "My name: " + (f.get("name") || "—"),
        "The story is for: " + (f.get("for") || "—"),
        "Occasion: " + (f.get("occasion") || "—"),
        "When I need it: " + (f.get("timeline") || "Flexible"),
        "",
        "A little about them: " + (f.get("story") || "—")
      ];
      var msg = encodeURIComponent(lines.join("\n"));
      var channel = beginForm.querySelector("input[name='channel']:checked");
      if (channel && channel.value === "email") {
        window.location.href =
          "mailto:hello@storyloom.in?subject=" +
          encodeURIComponent("Begin My Story — " + (f.get("name") || "")) +
          "&body=" + msg;
      } else {
        window.open("https://wa.me/919999999999?text=" + msg, "_blank", "noopener");
      }
      var note = document.querySelector("#begin-success");
      if (note) { note.hidden = false; note.focus(); }
    });
  }

  /* ---------- Scroll progress bar ---------- */
  var progressBar = document.createElement("div");
  progressBar.className = "scroll-progress";
  progressBar.setAttribute("aria-hidden", "true");
  document.body.appendChild(progressBar);
  var progressTick = false;
  var updateProgress = function () {
    var max = document.documentElement.scrollHeight - window.innerHeight;
    progressBar.style.transform = "scaleX(" + (max > 0 ? Math.min(window.scrollY / max, 1) : 0) + ")";
    progressTick = false;
  };
  window.addEventListener("scroll", function () {
    if (!progressTick) { progressTick = true; requestAnimationFrame(updateProgress); }
  }, { passive: true });
  window.addEventListener("resize", updateProgress);
  updateProgress();

  /* ---------- Footer year ---------- */
  document.querySelectorAll("[data-year]").forEach(function (el) {
    el.textContent = String(new Date().getFullYear());
  });
})();
