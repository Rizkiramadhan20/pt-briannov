// Validasi
function validateRegister() {
  const password = document.querySelector('input[name="password"]').value;
  if (password.length < 6) {
    alert("Password minimal 6 karakter");
    return false;
  }
  return true;
}

// Sidebar functionality
document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar-mobile");
  const backdrop = document.getElementById("sidebar-mobile-backdrop");
  const toggleButtons = document.querySelectorAll(
    '[data-drawer-toggle="sidebar-mobile"]'
  );
  const hideButtons = document.querySelectorAll(
    '[data-drawer-hide="sidebar-mobile"]'
  );
  const dropdownButtons = document.querySelectorAll("[data-collapse-toggle]");
  const navLinks = document.querySelectorAll('a[href^="/"]');

  // Add page transition effect
  function addPageTransition() {
    document.body.style.opacity = "0";
    setTimeout(() => {
      document.body.style.opacity = "1";
    }, 100);
  }

  // Add transition to all navigation links
  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      if (!this.getAttribute("href").startsWith("#")) {
        e.preventDefault();
        document.body.style.opacity = "0";
        setTimeout(() => {
          window.location.href = this.getAttribute("href");
        }, 200);
      }
    });
  });

  // Toggle sidebar
  function toggleSidebar() {
    sidebar.classList.toggle("-translate-x-full");
    backdrop.classList.toggle("hidden");
    document.body.classList.toggle("overflow-hidden");
  }

  // Hide sidebar
  function hideSidebar() {
    if (!sidebar.classList.contains("-translate-x-full")) {
      sidebar.classList.add("-translate-x-full");
      backdrop.classList.add("hidden");
      document.body.classList.remove("overflow-hidden");
    }
  }

  // Add click event listeners
  toggleButtons.forEach((button) =>
    button.addEventListener("click", toggleSidebar)
  );

  hideButtons.forEach((button) =>
    button.addEventListener("click", hideSidebar)
  );

  // Handle dropdown animations
  dropdownButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const targetId = this.getAttribute("aria-controls");
      const target = document.getElementById(targetId);
      const arrow = this.querySelector(".material-icons:last-child");

      // Toggle dropdown with smooth animation
      target.style.maxHeight = target.classList.contains("hidden")
        ? target.scrollHeight + "px"
        : "0";
      target.classList.toggle("hidden");

      // Rotate arrow with smooth animation
      if (target.classList.contains("hidden")) {
        arrow.style.transform = "rotate(0deg)";
      } else {
        arrow.style.transform = "rotate(180deg)";
      }
    });
  });

  // Handle window resize
  window.addEventListener("resize", function () {
    if (window.innerWidth >= 640) {
      // sm breakpoint
      sidebar.classList.remove("-translate-x-full");
      backdrop.classList.add("hidden");
      document.body.classList.remove("overflow-hidden");
    } else {
      // Mobile view
      sidebar.classList.add("-translate-x-full");
      backdrop.classList.add("hidden");
      document.body.classList.remove("overflow-hidden");
    }
  });

  // Initialize page transition
  addPageTransition();
});
