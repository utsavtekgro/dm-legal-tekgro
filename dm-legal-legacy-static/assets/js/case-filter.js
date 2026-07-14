/**
 * Case studies filter (issue + practice area selects, search, view more).
 * Replaces the useState-driven filtering in CaseStudiesSection.tsx.
 */
(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    var grid = document.querySelector("[data-case-grid]");
    if (!grid) return;

    var cards = Array.prototype.slice.call(grid.querySelectorAll("[data-case-card]"));
    var issueSelect = document.querySelector("[data-case-issue]");
    var practiceSelect = document.querySelector("[data-case-practice]");
    var searchInput = document.querySelector("[data-case-search]");
    var moreBtn = document.querySelector("[data-case-more]");
    var emptyMessage = document.querySelector("[data-case-empty]");

    var visibleCount = 3;
    var PAGE_SIZE = 3;

    function matches(card) {
      var issue = card.getAttribute("data-issue");
      var practice = card.getAttribute("data-practice");
      var keywords = card.getAttribute("data-keywords") || "";
      var query = searchInput ? searchInput.value.trim().toLowerCase() : "";

      var issueOk = !issueSelect || issueSelect.value === "All" || issue === issueSelect.value;
      var practiceOk = !practiceSelect || practiceSelect.value === "All" || practice === practiceSelect.value;
      var searchOk = !query || keywords.indexOf(query) !== -1;
      return issueOk && practiceOk && searchOk;
    }

    function render() {
      var matched = cards.filter(matches);
      cards.forEach(function (card) { card.classList.add("hidden"); });
      matched.slice(0, visibleCount).forEach(function (card) { card.classList.remove("hidden"); });

      if (moreBtn) moreBtn.classList.toggle("hidden", visibleCount >= matched.length);
      if (emptyMessage) emptyMessage.classList.toggle("hidden", matched.length > 0);
    }

    [issueSelect, practiceSelect].forEach(function (el) {
      if (el) el.addEventListener("change", function () { visibleCount = PAGE_SIZE; render(); });
    });
    if (searchInput) searchInput.addEventListener("input", function () { visibleCount = PAGE_SIZE; render(); });
    if (moreBtn) moreBtn.addEventListener("click", function () { visibleCount += PAGE_SIZE; render(); });

    render();
  });
})();
