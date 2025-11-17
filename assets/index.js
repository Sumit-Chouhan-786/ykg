// =========================
// Mobile navbar toggle
// =========================
document.addEventListener("DOMContentLoaded", function () {
  var toggler = document.querySelector(".navbar-toggler");
  var nav = document.getElementById("mainNav");

  if (toggler && nav) {
    toggler.addEventListener("click", function () {
      nav.classList.toggle("show");
    });
  }

  // =========================
  // Tabs (Services)
  // =========================
  var tabButtons = document.querySelectorAll(".tab-btn");
  var tabContents = document.querySelectorAll(".tab-content");

  if (tabButtons.length && tabContents.length) {
    tabButtons.forEach(function (btn) {
      btn.addEventListener("click", function () {
        var target = btn.getAttribute("data-tab");

        // button state
        tabButtons.forEach(function (b) {
          b.classList.remove("active");
        });
        btn.classList.add("active");

        // content state
        tabContents.forEach(function (c) {
          if (c.id === target + "-content") {
            c.classList.add("active");
          } else {
            c.classList.remove("active");
          }
        });
      });
    });
  }

  // =========================
  // GA4 event: phone click
  // =========================
  document.addEventListener("click", function (e) {
    var link = e.target.closest('a[href^="tel:"]');
    if (!link || typeof gtag === "undefined") return;

    try {
      gtag("event", "phone_click", {
        event_category: "engagement",
        event_label: link.getAttribute("href"),
        value: 1
      });
    } catch (err) {
      // fail silently
    }
  });

  // =========================
  // GA4 event: contact form submit
  // =========================
  var form = document.getElementById("contact-form");
  if (form && typeof gtag !== "undefined") {
    form.addEventListener("submit", function () {
      try {
        gtag("event", "contact_form_submit", {
          event_category: "lead",
          event_label: window.location.pathname,
          value: 1
        });
      } catch (err) {
        // ignore
      }
    });
  }
});