/**
 * DM Legal Services — shared front-end behaviour.
 * Vanilla ES6+ replacement for: React state/hooks, AOS, Swiper/react-slick,
 * framer-motion modal transitions, and the React search components.
 * Every block below guards on the presence of its target element(s), so a
 * single file can be safely included on every page.
 */
(function () {
  "use strict";

  /* ----------------------------------------------------------------
   * Scroll-reveal (AOS replacement)
   * ------------------------------------------------------------- */
  function initScrollReveal() {
    var targets = document.querySelectorAll("[data-aos]");
    if (!targets.length) return;

    if (!("IntersectionObserver" in window)) {
      targets.forEach(function (el) { el.classList.add("is-visible"); });
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            var el = entry.target;
            var delay = parseInt(el.getAttribute("data-aos-delay") || "0", 10);
            setTimeout(function () { el.classList.add("is-visible"); }, delay);
            observer.unobserve(el);
          }
        });
      },
      { threshold: 0.15 }
    );

    targets.forEach(function (el) {
      el.style.opacity = "0";
      el.style.transform = "translateY(16px)";
      el.style.transition = "opacity 0.6s ease, transform 0.6s ease";
      observer.observe(el);
    });

    document.documentElement.appendChild(
      document.createElement("style")
    ).textContent = "[data-aos].is-visible{opacity:1 !important;transform:none !important;}";
  }

  /* ----------------------------------------------------------------
   * Header: scroll-direction hide + mobile menu + search overlay
   * ------------------------------------------------------------- */
  function initHeader() {
  const header = document.querySelector('.site-header'),
        menuBtn = document.querySelector('[data-menu-open]'),
        closeBtn = document.querySelector('[data-menu-close]'),
        mobilePanel = document.querySelector('[data-mobile-panel]'),
        searchBtn = document.querySelector('[data-search-toggle]'),
        searchOverlay = document.querySelector('[data-search-overlay]'),
        searchClose = document.querySelector('[data-search-close]');

  let lastY = window.scrollY;

  window.addEventListener('scroll', () => {
    header?.classList.toggle('is-hidden', window.scrollY > lastY + 10);
    if (window.scrollY < lastY - 10) header?.classList.remove('is-hidden');
    lastY = window.scrollY;
  });

  const lockScroll = () => {
    document.body.style.overflow =
      mobilePanel?.classList.contains('is-open') ||
      searchOverlay?.classList.contains('is-open')
        ? 'hidden'
        : '';
  };

  const toggleMenu = (open) => {
    mobilePanel?.classList.toggle('is-open', open);
    if (menuBtn) menuBtn.style.display = open ? 'none' : 'block';
    if (closeBtn) closeBtn.style.display = open ? 'block' : 'none';
    lockScroll();
  };

  const toggleSearch = (open) => {
    searchOverlay?.classList.toggle('is-open', open);
    lockScroll();
  };

  closeBtn && (closeBtn.style.display = 'none');

  menuBtn?.addEventListener('click', () => toggleMenu(true));
  closeBtn?.addEventListener('click', () => toggleMenu(false));
  searchBtn?.addEventListener('click', () => toggleSearch(true));
  searchClose?.addEventListener('click', () => toggleSearch(false));

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      toggleMenu(false);
      toggleSearch(false);
    }
  });
}

document.addEventListener('DOMContentLoaded', initHeader);
  /* ----------------------------------------------------------------
   * Mobile bottom nav: hide on scroll down
   * ------------------------------------------------------------- */
  function initMobileBottomNav() {
    var nav = document.querySelector(".mobile-bottom-nav");
    if (!nav) return;
    var lastY = window.scrollY;
    window.addEventListener("scroll", function () {
      var y = window.scrollY;
      nav.classList.toggle("is-hidden", y > lastY && y > 50);
      lastY = y;
    });
  }

  /* ----------------------------------------------------------------
   * Blog search (shared by header top-bar search + mobile search overlay)
   * ------------------------------------------------------------- */
  function getBlogData() {
    var node = document.getElementById("blogs-data");
    if (!node) return [];
    try { return JSON.parse(node.textContent); } catch (err) { return []; }
  }

  function filterBlogs(blogs, query) {
    var q = query.trim().toLowerCase();
    if (!q) return [];
    return blogs.filter(function (b) {
      return (
        b.title.toLowerCase().indexOf(q) !== -1 ||
        b.category.toLowerCase().indexOf(q) !== -1 ||
        b.excerpt.toLowerCase().indexOf(q) !== -1 ||
        (b.tags || []).some(function (t) { return t.toLowerCase().indexOf(q) !== -1; })
      );
    });
  }

  function renderBlogResults(container, results, emptyMessage) {
    container.innerHTML = "";
    if (!results.length) {
      var p = document.createElement("p");
      p.className = "search-empty";
      p.textContent = emptyMessage;
      container.appendChild(p);
      return;
    }
    results.forEach(function (blog) {
      var a = document.createElement("a");
      a.href = "blog-detail.php?slug=" + encodeURIComponent(blog.slug);
      a.className = "search-result";
      a.innerHTML =
        '<img src="' + blog.image + '" alt="" loading="lazy">' +
        '<div><h4>' + blog.title + "</h4>" +
        "<p>" + blog.excerpt.slice(0, 110) + "...</p>" +
        "<span>" + blog.author.date + " &middot; " + blog.category + "</span></div>";
      container.appendChild(a);
    });
  }

  function initSearch() {
    var blogs = getBlogData();
    if (!blogs.length) return;

    document.querySelectorAll("[data-search-form]").forEach(function (form) {
      var input = form.querySelector("input");
      var resultsBox = form.parentElement.querySelector("[data-search-results]");
      if (!input || !resultsBox) return;

      function runSearch() {
        var results = filterBlogs(blogs, input.value);
        renderBlogResults(resultsBox, results, "No results found.");
        resultsBox.classList.toggle("is-open", input.value.trim().length > 0);
      }

      form.addEventListener("submit", function (e) { e.preventDefault(); runSearch(); });
      input.addEventListener("input", function () {
        if (form.hasAttribute("data-live")) runSearch();
      });

      document.addEventListener("click", function (e) {
        if (!form.parentElement.contains(e.target)) {
          resultsBox.classList.remove("is-open");
        }
      });
    });
  }

  /* ----------------------------------------------------------------
   * Under-development modal
   * ------------------------------------------------------------- */
  function initModal() {
    var overlay = document.querySelector("[data-dev-modal]");
    if (!overlay) return;
    setTimeout(function () { overlay.hidden = false; }, 100);
    var closeBtn = overlay.querySelector("[data-modal-close]");
    if (closeBtn) closeBtn.addEventListener("click", function () { overlay.hidden = true; });
    overlay.addEventListener("click", function (e) {
      if (e.target === overlay) overlay.hidden = true;
    });
  }

  /* ----------------------------------------------------------------
   * FAQ accordion (single-open) + generic accordion blocks
   * ------------------------------------------------------------- */
  function initAccordions() {
    document.querySelectorAll("[data-faq-list]").forEach(function (list) {
      var items = list.querySelectorAll(".faq-item");
      items.forEach(function (item, idx) {
        if (idx === 0) item.classList.add("is-open");
        item.querySelector(".faq-item__head").addEventListener("click", function () {
          var wasOpen = item.classList.contains("is-open");
          items.forEach(function (i) { i.classList.remove("is-open"); });
          if (!wasOpen) item.classList.add("is-open");
        });
      });
    });

    document.querySelectorAll(".accordion-item__head").forEach(function (head) {
      head.addEventListener("click", function () {
        head.closest(".accordion-item").classList.toggle("is-open");
      });
    });
  }

  /* ----------------------------------------------------------------
   * Tabs (FAQ categories, fee categories, etc.)
   * ------------------------------------------------------------- */
  function initTabs() {
    document.querySelectorAll("[data-tabs]").forEach(function (tabGroup) {
      var buttons = tabGroup.querySelectorAll("[data-tab-btn]");
      var panels = document.querySelectorAll(
        '[data-tab-panel][data-tabs-target="' + tabGroup.getAttribute("data-tabs") + '"]'
      );
      buttons.forEach(function (btn) {
        btn.addEventListener("click", function () {
          buttons.forEach(function (b) { b.classList.remove("is-active"); });
          btn.classList.add("is-active");
          var target = btn.getAttribute("data-tab-btn");
          panels.forEach(function (panel) {
            panel.classList.toggle("hidden", panel.getAttribute("data-tab-panel") !== target);
          });
        });
      });
    });
  }

  /* ----------------------------------------------------------------
   * Generic carousel (Swiper/react-slick replacement)
   * Markup: .carousel > .carousel__track > children, optional
   * [data-autoplay="4000"] and dot/arrow nav rendered into [data-dots]/[data-arrows]
   * ------------------------------------------------------------- */
  function initCarousels() {
    document.querySelectorAll(".carousel").forEach(function (carousel) {
      var track = carousel.querySelector(".carousel__track");
      if (!track) return;
      var slides = Array.prototype.slice.call(track.children);
      if (slides.length < 2) return;

      var dotsWrap = carousel.querySelector(".carousel__dots");
      if (dotsWrap) {
        dotsWrap.innerHTML = "";
        slides.forEach(function (_, i) {
          var dot = document.createElement("button");
          dot.type = "button";
          dot.setAttribute("aria-label", "Go to slide " + (i + 1));
          if (i === 0) dot.classList.add("is-active");
          dot.addEventListener("click", function () { scrollToSlide(i); });
          dotsWrap.appendChild(dot);
        });
      }

      function scrollToSlide(i) {
        var slide = slides[i];
        track.scrollTo({ left: slide.offsetLeft - track.offsetLeft, behavior: "smooth" });
      }

      var prevBtn = carousel.querySelector(".carousel__arrow--prev");
      var nextBtn = carousel.querySelector(".carousel__arrow--next");
      var current = 0;
      function go(delta) {
        current = (current + delta + slides.length) % slides.length;
        scrollToSlide(current);
      }
      if (prevBtn) prevBtn.addEventListener("click", function () { go(-1); });
      if (nextBtn) nextBtn.addEventListener("click", function () { go(1); });

      var ticking = false;
      track.addEventListener("scroll", function () {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(function () {
          var trackCenter = track.scrollLeft + track.clientWidth / 2;
          var closest = 0;
          var closestDist = Infinity;
          slides.forEach(function (slide, i) {
            var dist = Math.abs(slide.offsetLeft + slide.clientWidth / 2 - trackCenter);
            if (dist < closestDist) { closestDist = dist; closest = i; }
          });
          current = closest;
          if (dotsWrap) {
            Array.prototype.forEach.call(dotsWrap.children, function (dot, i) {
              dot.classList.toggle("is-active", i === closest);
            });
          }
          ticking = false;
        });
      });

      var autoplay = parseInt(carousel.getAttribute("data-autoplay") || "0", 10);
      if (autoplay > 0) {
        var timer = setInterval(function () { go(1); }, autoplay);
        carousel.addEventListener("mouseenter", function () { clearInterval(timer); });
        carousel.addEventListener("mouseleave", function () {
          timer = setInterval(function () { go(1); }, autoplay);
        });
      }
    });
  }

  /* ----------------------------------------------------------------
   * Generic AJAX form submission with CSRF + inline success/error
   * Markup: <form data-ajax-form action="api/xxx.php">
   * ------------------------------------------------------------- */
  function initAjaxForms() {
    document.querySelectorAll("[data-ajax-form]").forEach(function (form) {
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        var submitBtn = form.querySelector('button[type="submit"]');
        var messageBox = form.querySelector("[data-form-message]");
        var honeypot = form.querySelector('input[name="website"]');

        if (honeypot && honeypot.value) return; // bot trap, silently drop

        if (!form.checkValidity()) {
          form.reportValidity();
          return;
        }

        if (submitBtn) { submitBtn.disabled = true; submitBtn.dataset.originalText = submitBtn.textContent; submitBtn.textContent = "Sending..."; }

        fetch(form.getAttribute("action"), {
          method: "POST",
          body: new FormData(form),
          headers: { "X-Requested-With": "XMLHttpRequest" },
        })
          .then(function (res) { return res.json(); })
          .then(function (data) {
            if (messageBox) {
              messageBox.textContent = data.message;
              messageBox.className = data.success ? "form-success" : "form-fail";
              messageBox.hidden = false;
            }
            if (data.success) form.reset();
          })
          .catch(function () {
            if (messageBox) {
              messageBox.textContent = "Something went wrong. Please try again or call us directly.";
              messageBox.className = "form-fail";
              messageBox.hidden = false;
            }
          })
          .finally(function () {
            if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = submitBtn.dataset.originalText; }
          });
      });
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    initScrollReveal();
    initHeader();
    initMobileBottomNav();
    initSearch();
    initModal();
    initAccordions();
    initTabs();
    initCarousels();
    initAjaxForms();
  });
})();
