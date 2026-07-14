/**
 * Sub-topic tabs + accordion for practice-area-inner.php.
 * Replaces the useState/useRef driven InnerDropdownSection.tsx.
 */
(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    var wrap = document.querySelector("[data-inner-dropdown]");
    if (!wrap) return;

    var tabs = wrap.querySelectorAll("[data-dropdown-tab]");
    var items = wrap.querySelectorAll("[data-dropdown-item]");

    function openItem(id) {
      items.forEach(function (item) {
        item.classList.toggle("is-open", item.getAttribute("data-dropdown-item") === id);
      });
      tabs.forEach(function (tab) {
        tab.classList.toggle("is-active", tab.getAttribute("data-dropdown-tab") === id);
      });
    }

    function scrollToItem(id) {
      var el = wrap.querySelector('[data-dropdown-item="' + id + '"]');
      if (!el) return;
      var top = el.getBoundingClientRect().top + window.scrollY - 100;
      window.scrollTo({ top: top, behavior: "smooth" });
    }

    tabs.forEach(function (tab) {
      tab.addEventListener("click", function () {
        var id = tab.getAttribute("data-dropdown-tab");
        openItem(id);
        setTimeout(function () { scrollToItem(id); }, 300);
      });
    });

    items.forEach(function (item) {
      var id = item.getAttribute("data-dropdown-item");
      var head = item.querySelector("[data-dropdown-head]");
      head.addEventListener("click", function () {
        var willOpen = !item.classList.contains("is-open");
        item.classList.toggle("is-open", willOpen);
        tabs.forEach(function (tab) {
          tab.classList.toggle("is-active", tab.getAttribute("data-dropdown-tab") === id && willOpen);
        });
        if (willOpen) setTimeout(function () { scrollToItem(id); }, 300);
      });
    });
  });
})();
