/**
 * Blog listing category filter, search and "Show more/less" pagination.
 * Operates on server-rendered cards (data-category, data-keywords),
 * replacing the React useState-driven BlogSection.tsx behaviour.
 */
(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    var grid = document.querySelector("[data-blog-grid]");
    if (!grid) return;

    var cards = Array.prototype.slice.call(grid.querySelectorAll("[data-blog-card]"));
    var categoryButtons = document.querySelectorAll("[data-blog-category]");
    var searchInput = document.querySelector("[data-blog-search]");
    var showMoreBtn = document.querySelector("[data-blog-more]");
    var showLessBtn = document.querySelector("[data-blog-less]");
    var emptyMessage = document.querySelector("[data-blog-empty]");

    var activeCategory = "All Information";
    var query = "";
    var visibleCount = 6;
    var PAGE_SIZE = 6;

    function matches(card) {
      var category = card.getAttribute("data-category");
      var keywords = card.getAttribute("data-keywords") || "";
      var categoryOk = activeCategory === "All Information" || category === activeCategory;
      var searchOk = !query || keywords.indexOf(query.toLowerCase()) !== -1;
      return categoryOk && searchOk;
    }

    function render() {
      var matched = cards.filter(matches);
      matched.forEach(function (card, i) { card.classList.toggle("hidden", i >= visibleCount); });
      cards.filter(function (c) { return matched.indexOf(c) === -1; }).forEach(function (c) {
        c.classList.add("hidden");
      });

      if (showMoreBtn) showMoreBtn.classList.toggle("hidden", visibleCount >= matched.length);
      if (showLessBtn) showLessBtn.classList.toggle("hidden", visibleCount <= PAGE_SIZE);
      if (emptyMessage) emptyMessage.classList.toggle("hidden", matched.length > 0);
    }

    categoryButtons.forEach(function (btn) {
      btn.addEventListener("click", function () {
        categoryButtons.forEach(function (b) { b.classList.remove("is-active"); });
        btn.classList.add("is-active");
        activeCategory = btn.getAttribute("data-blog-category");
        visibleCount = PAGE_SIZE;
        render();
      });
    });

    if (searchInput) {
      searchInput.addEventListener("input", function () {
        query = searchInput.value.trim();
        visibleCount = PAGE_SIZE;
        render();
      });
    }

    if (showMoreBtn) showMoreBtn.addEventListener("click", function () { visibleCount += PAGE_SIZE; render(); });
    if (showLessBtn) showLessBtn.addEventListener("click", function () { visibleCount = PAGE_SIZE; render(); });

    render();
  });
})();
