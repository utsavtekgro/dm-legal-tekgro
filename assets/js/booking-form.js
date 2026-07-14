/**
 * Multi-step "Book a Lawyer" form: date picker calendar, step navigation,
 * progress indicator and summary recap. Replaces StepForm.tsx / StepOne.tsx /
 * StepTwo.tsx / StepThree.tsx (framer-motion + react-day-picker + react-hook-form).
 */
(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector("[data-booking-form]");
    if (!form) return;

    var panels = form.querySelectorAll("[data-step-panel]");
    var dots = form.querySelectorAll("[data-step-dot]");
    var nextBtns = form.querySelectorAll("[data-step-next]");
    var prevBtns = form.querySelectorAll("[data-step-prev]");
    var currentStep = 1;

    function showStep(step) {
      currentStep = step;
      panels.forEach(function (panel) {
        panel.classList.toggle("is-active", parseInt(panel.getAttribute("data-step-panel"), 10) === step);
      });
      dots.forEach(function (dot) {
        dot.classList.toggle("is-active", parseInt(dot.getAttribute("data-step-dot"), 10) <= step);
      });
      if (step === 3) updateSummary();
    }

    function validatePanel(step) {
      var panel = form.querySelector('[data-step-panel="' + step + '"]');
      var fields = panel.querySelectorAll("input[required], select[required], textarea[required]");
      var valid = true;
      fields.forEach(function (field) {
        if (!field.checkValidity()) { field.reportValidity(); valid = false; }
      });
      if (step === 1 && !dateInput.value) {
        alert("Please select a date.");
        valid = false;
      }
      return valid;
    }

    nextBtns.forEach(function (btn) {
      btn.addEventListener("click", function () {
        if (validatePanel(currentStep)) showStep(currentStep + 1);
      });
    });
    prevBtns.forEach(function (btn) {
      btn.addEventListener("click", function () { showStep(currentStep - 1); });
    });

    /* ---------------- Calendar (StepOne.tsx) ---------------- */
    var calendarEl = form.querySelector("[data-calendar]");
    var dateInput = form.querySelector('input[name="date"]');
    var summaryDate = form.querySelector("[data-summary-date]");
    var monthLabel = calendarEl.querySelector("[data-calendar-month]");
    var grid = calendarEl.querySelector("[data-calendar-grid]");
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    var viewDate = new Date(today.getFullYear(), today.getMonth(), 1);
    var selectedDate = new Date(today);

    function pad(n) { return n < 10 ? "0" + n : "" + n; }
    function isoDate(d) { return d.getFullYear() + "-" + pad(d.getMonth() + 1) + "-" + pad(d.getDate()); }

    function renderCalendar() {
      var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      monthLabel.textContent = monthNames[viewDate.getMonth()] + " " + viewDate.getFullYear();

      grid.innerHTML = "";
      ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"].forEach(function (d) {
        var span = document.createElement("span");
        span.textContent = d;
        grid.appendChild(span);
      });

      var firstDay = new Date(viewDate.getFullYear(), viewDate.getMonth(), 1).getDay();
      var daysInMonth = new Date(viewDate.getFullYear(), viewDate.getMonth() + 1, 0).getDate();

      for (var i = 0; i < firstDay; i++) {
        grid.appendChild(document.createElement("span"));
      }

      for (var day = 1; day <= daysInMonth; day++) {
        var cellDate = new Date(viewDate.getFullYear(), viewDate.getMonth(), day);
        var btn = document.createElement("button");
        btn.type = "button";
        btn.className = "calendar__day";
        btn.textContent = day;

        if (cellDate < today) {
          btn.disabled = true;
        } else {
          btn.addEventListener("click", function (clickedDate) {
            return function () {
              selectedDate = clickedDate;
              dateInput.value = isoDate(selectedDate);
              renderCalendar();
            };
          }(cellDate));
        }

        if (cellDate.getTime() === today.getTime()) btn.classList.add("is-today");
        if (cellDate.getTime() === selectedDate.getTime()) btn.classList.add("is-selected");

        grid.appendChild(btn);
      }
    }

    var prevMonthBtn = calendarEl.querySelector("[data-calendar-prev]");
    var nextMonthBtn = calendarEl.querySelector("[data-calendar-next]");
    if (prevMonthBtn) prevMonthBtn.addEventListener("click", function () {
      viewDate.setMonth(viewDate.getMonth() - 1);
      renderCalendar();
    });
    if (nextMonthBtn) nextMonthBtn.addEventListener("click", function () {
      viewDate.setMonth(viewDate.getMonth() + 1);
      renderCalendar();
    });

    dateInput.value = isoDate(selectedDate);
    renderCalendar();

    /* ---------------- Step 3 summary ---------------- */
    function updateSummary() {
      if (summaryDate) summaryDate.textContent = dateInput.value || "Not selected";
    }

    showStep(1);
  });
})();
