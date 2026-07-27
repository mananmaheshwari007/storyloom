/* ============================================================
   STORYLOOM — loom hero (scroll-morph intro)
   Cards burst outward from the centre into a ring around the
   headline, then idle-rotate very slowly (a quiet, premium touch)
   until the user scrolls — at which point real page scroll (sticky
   stage) takes over and morphs the ring into a large bottom arc,
   continuing seamlessly from wherever the idle rotation left off.
   No wheel hijacking, no mouse parallax.
   Loading the page mid-scroll (refresh) skips the intro and
   renders the correct state instantly.
   ============================================================ */
(function () {
  "use strict";

  var hero = document.querySelector(".loom-hero");
  if (!hero) return;
  var stage = hero.querySelector(".loom-stage");
  var cardsWrap = hero.querySelector(".loom-cards");
  var copy = hero.querySelector(".loom-copy");
  var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  var IMAGES = [];
  for (var n = 1; n <= 16; n++) {
    IMAGES.push("assets/img/cards/c" + String(n).padStart(2, "0") + ".webp");
  }
  var small = window.innerWidth < 640;
  var TOTAL = small ? 12 : 16;

  /* ---------- Build cards ---------- */
  var cards = [];
  for (var i = 0; i < TOTAL; i++) {
    var el = document.createElement("div");
    el.className = "loom-card";
    el.innerHTML =
      '<a href="library.html" tabindex="-1" aria-hidden="true">' +
      '<span class="face front"><img src="' + IMAGES[i % IMAGES.length] + '" alt="" loading="eager" decoding="async"></span>' +
      '<span class="face back"><img src="assets/img/logo-emblem-light.png" alt=""></span>' +
      "</a>";
    cardsWrap.appendChild(el);
    cards.push(el);
  }

  var size = { w: stage.clientWidth, h: stage.clientHeight };
  var onResize = function () {
    size.w = stage.clientWidth;
    size.h = stage.clientHeight;
  };
  window.addEventListener("resize", onResize);

  var lerp = function (a, b, t) { return a * (1 - t) + b * t; };
  var clamp = function (v, lo, hi) { return Math.min(Math.max(v, lo), hi); };

  var setCard = function (el, x, y, r, s, o) {
    el.style.transform =
      "translate(-50%,-50%) translate3d(" + x + "px," + y + "px,0) rotate(" + r + "deg) scale(" + s + ")";
    el.style.opacity = o;
  };

  /* ---------- Geometry ---------- */
  /* The ring is a true circle. Mobile sits a touch higher (bigger
     lift) and — since running off the narrow edges is fine there —
     uses a much larger radius (2x the old, carefully-fitted value)
     so the ring reads as full and rich rather than a tight cluster.
     Desktop is unchanged. */
  var lift = function () { return size.w < 640 ? size.h * 0.06 : size.h * 0.03; };
  var idleAngle = 0; // slow "premium" rotation; frozen the instant scroll engages
  var circlePos = function (i) {
    var mobileFitR = clamp(Math.min(size.h * 0.34, size.w * 0.47), 120, 520);
    var r = size.w < 640
      ? clamp(mobileFitR * 2, 150, 900)
      : clamp(size.h * 0.42, 150, 520);
    var ang = (i / TOTAL) * 360 + idleAngle;
    var rad = (ang * Math.PI) / 180;
    return {
      x: Math.cos(rad) * r,
      y: Math.sin(rad) * r - lift(),
      r: ang + 90,
      s: 1
    };
  };
  var arcPos = function (i, shuffle) {
    var mobile = size.w < 768;
    var baseRadius = Math.min(size.w, size.h * 1.5);
    var arcRadius = baseRadius * (mobile ? 1.4 : 1.1);
    var apexY = size.h * (mobile ? 0.16 : 0.28);
    var centerY = apexY + arcRadius;
    var spread = mobile ? 100 : 130;
    var start = -90 - spread / 2;
    var step = spread / (TOTAL - 1);
    /* 0.4: sweeps the fan just far enough that the last cards reach the
       apex at full scroll without the whole arc leaving the viewport */
    var bounded = -shuffle * spread * 0.4;
    var ang = start + i * step + bounded;
    var rad = (ang * Math.PI) / 180;
    return {
      x: Math.cos(rad) * arcRadius,
      y: Math.sin(rad) * arcRadius + centerY,
      r: ang + 90,
      s: mobile ? 1.6 : 1.8
    };
  };

  var progress = function () {
    var rect = hero.getBoundingClientRect();
    var vh = window.innerHeight;
    var travel = rect.height - vh;
    return travel > 0 ? clamp(-rect.top / travel, 0, 1) : 1;
  };
  var morphOf = function (p) { return clamp(p / 0.4, 0, 1); };
  var shuffleOf = function (p) { return clamp((p - 0.4) / 0.6, 0, 1); };

  var renderMorph = function (m, sh) {
    for (var i = 0; i < TOTAL; i++) {
      var c = circlePos(i);
      var a = arcPos(i, sh);
      setCard(cards[i], lerp(c.x, a.x, m), lerp(c.y, a.y, m), lerp(c.r, a.r, m), lerp(1, a.s, m), 1);
    }
    var mobile = size.w < 768;
    copy.style.transform = "translateY(" + (-m * size.h * (mobile ? 0.24 : 0.22)) + "px)";
    stage.classList.toggle("arc-ready", m > 0.72);
  };

  /* ---------- Static mode (reduced motion): final arc, no theatre ---------- */
  if (reduceMotion) {
    hero.classList.add("static");
    stage.classList.add("arc-ready");
    var place = function () {
      onResize();
      for (var i = 0; i < TOTAL; i++) {
        var p = arcPos(i, 0.28);
        setCard(cards[i], p.x, p.y, p.r, 1, 1);
      }
    };
    requestAnimationFrame(place);
    window.addEventListener("resize", place);
    return;
  }

  /* ---------- State ---------- */
  var scrollEngaged = false;
  var revealDone = false;
  var morph = 0, shuffle = 0;
  var t1 = null, t2 = null;

  /* ---------- Idle rotation — the "premium" resting state ----------
     Once the reveal lands the ring in formation, it turns on its
     own, very slowly (one full turn every 5 minutes), until the user
     scrolls. idleAngle is baked directly into circlePos, so the
     scroll-driven morph below continues from whatever angle the ring
     had reached — no jump, no reset to zero.
     Driven by setInterval rather than requestAnimationFrame: at this
     speed 16fps is visually indistinguishable from 60fps, and unlike
     rAF it keeps ticking in contexts where rAF is paused/throttled
     (backgrounded tabs, some embedded/preview frames). */
  var DEG_PER_MS = 360 / (300 * 1000);
  var idleTimerId = null;
  var idleLastTs = null;
  var renderIdleCircle = function () {
    for (var i = 0; i < TOTAL; i++) {
      var c = circlePos(i);
      setCard(cards[i], c.x, c.y, c.r, c.s, 1);
    }
  };
  var idleTick = function () {
    var now = Date.now();
    if (idleLastTs !== null) idleAngle += (now - idleLastTs) * DEG_PER_MS;
    idleLastTs = now;
    renderIdleCircle();
  };
  var startIdle = function () {
    if (idleTimerId || scrollEngaged || !revealDone) return;
    idleLastTs = Date.now();
    idleTimerId = window.setInterval(idleTick, 60);
  };
  var stopIdle = function () {
    if (idleTimerId) { window.clearInterval(idleTimerId); idleTimerId = null; }
  };

  var engage = function () {
    if (scrollEngaged) return;
    scrollEngaged = true;
    clearTimeout(t1); clearTimeout(t2);
    stopIdle(); // freezes idleAngle exactly where it is — the morph picks up from here
    cards.forEach(function (el) { el.classList.remove("intro-anim"); });
  };

  /* ---------- Reveal: cards burst outward from the centre ---------- */
  var setCenterPhase = function () {
    for (var i = 0; i < TOTAL; i++) {
      setCard(cards[i], 0, -lift(), (Math.random() - 0.5) * 50, 0.3, 0);
    }
  };
  var setCirclePhase = function () {
    for (var i = 0; i < TOTAL; i++) {
      var c = circlePos(i);
      setCard(cards[i], c.x, c.y, c.r, c.s, 1);
    }
  };

  /* ---------- Init: fresh load runs the reveal; a mid-page refresh
     (restored scroll) skips straight to the correct scroll state ---------- */
  var p0 = progress();
  if (p0 > 0.02) {
    scrollEngaged = true;
    revealDone = true;
    morph = morphOf(p0);
    shuffle = shuffleOf(p0);
    renderMorph(morph, shuffle);
  } else {
    cards.forEach(function (el) { el.classList.add("intro-anim"); });
    setCenterPhase();
    t1 = setTimeout(function () {
      if (scrollEngaged) return;
      setCirclePhase();
      t2 = setTimeout(function () {
        if (scrollEngaged) return;
        cards.forEach(function (el) { el.classList.remove("intro-anim"); });
        revealDone = true;
        startIdle();
      }, 1250); // matches the .intro-anim transform transition (1.15s) + a small buffer
    }, 260);
  }

  /* ---------- Scroll-driven morph loop ---------- */
  var running = false;
  var frame = function () {
    var p = progress();
    var morphT = morphOf(p);
    var shuffleT = shuffleOf(p);

    if (!scrollEngaged && morphT > 0.02) {
      engage();
      /* jump straight to the live values so there is no catch-up lurch */
      morph = morphT;
      shuffle = shuffleT;
    }

    if (scrollEngaged) {
      morph += (morphT - morph) * 0.16;
      shuffle += (shuffleT - shuffle) * 0.16;
      if (Math.abs(morphT - morph) < 0.001) morph = morphT;
      if (Math.abs(shuffleT - shuffle) < 0.001) shuffle = shuffleT;
      renderMorph(morph, shuffle);
    }
    if (running) requestAnimationFrame(frame);
  };

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        if (!running) { running = true; requestAnimationFrame(frame); }
        startIdle();
      } else {
        running = false;
        stopIdle();
      }
    });
  });
  io.observe(hero);
})();
