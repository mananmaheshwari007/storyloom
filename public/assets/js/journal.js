/* ---------- Journal TOC ScrollSpy & Category Filter ---------- */
document.addEventListener("DOMContentLoaded", function () {
  // 1. Auto-generate & ScrollSpy TOC links for article page
  var articleBody = document.querySelector(".article-body");
  var tocNav = document.querySelector(".toc");

  if (articleBody && tocNav) {
    var tocUl = tocNav.querySelector("ul");
    // h3 too: a listicle keeps its numbered points at h3, and querying only h2
    // left the rail showing two entries for an article with ten of them.
    var headings = articleBody.querySelectorAll("h2, h3");

    if (headings.length === 0) {
      tocNav.style.display = "none";
    } else if (tocUl) {
      tocUl.innerHTML = "";
      var tocLinks = [];

      headings.forEach(function (h2, index) {
        if (!h2.id) {
          h2.id = "section-" + (index + 1);
        }
        var li = document.createElement("li");
        var a = document.createElement("a");
        a.href = "#" + h2.id;
        a.textContent = h2.textContent.replace(/[*_~]/g, "").trim();

        // Smooth scroll on click
        a.addEventListener("click", function (e) {
          e.preventDefault();
          var target = document.getElementById(h2.id);
          if (target) {
            var headerOffset = 100;
            var elementPosition = target.getBoundingClientRect().top;
            var offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
              top: offsetPosition,
              behavior: "smooth"
            });
          }
        });

        if (h2.tagName === "H3") li.className = "toc-sub";
        li.appendChild(a);
        tocUl.appendChild(li);
        tocLinks.push({ heading: h2, link: a });
      });

      // Activate first link by default
      if (tocLinks.length > 0) {
        tocLinks[0].link.classList.add("active");
      }

      // ScrollSpy using IntersectionObserver
      if ("IntersectionObserver" in window) {
        var observerOptions = {
          root: null,
          rootMargin: "-15% 0px -60% 0px",
          threshold: 0
        };

        var observer = new IntersectionObserver(function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              var activeId = entry.target.id;
              tocLinks.forEach(function (item) {
                if (item.heading.id === activeId) {
                  item.link.classList.add("active");
                } else {
                  item.link.classList.remove("active");
                }
              });
            }
          });
        }, observerOptions);

        headings.forEach(function (h2) {
          observer.observe(h2);
        });
      }
    }
  }

  // 2. Category Pill Filter for index page
  var row = document.querySelector(".filter-row");
  if (!row) return;

  var pills = row.querySelectorAll(".filter-pill");
  // The promoted "start here" article is filterable too — leaving it pinned in
  // place while the grid filtered around it made the count read as a lie.
  var cards = Array.prototype.slice.call(
    document.querySelectorAll(".featured-post[data-cat], #post-grid .post-card")
  );
  if (!cards.length) return;

  var countEl = document.getElementById("filter-count");
  var noResults = document.getElementById("no-results");

  var filterCategory = function (cat) {
    var visibleCount = 0;
    cards.forEach(function (card) {
      var itemCat = card.getAttribute("data-cat");
      if (cat === "all" || itemCat === cat) {
        card.style.display = "";
        visibleCount++;
      } else {
        card.style.display = "none";
      }
    });

    pills.forEach(function (btn) {
      var active = btn.getAttribute("data-filter") === cat;
      btn.setAttribute("aria-pressed", String(active));
    });

    if (countEl) {
      if (cat === "all") {
        countEl.textContent = "";
      } else {
        countEl.textContent = visibleCount + " article" + (visibleCount === 1 ? "" : "s") + " in this topic";
      }
    }

    if (noResults) {
      noResults.hidden = visibleCount > 0;
    }
  };

  pills.forEach(function (btn) {
    btn.addEventListener("click", function () {
      var cat = btn.getAttribute("data-filter");
      filterCategory(cat);
    });
  });
});
