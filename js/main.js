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

  // Toggle sidebar
  function toggleSidebar() {
    sidebar.classList.toggle("-translate-x-full");
    document.body.classList.toggle("overflow-hidden");
  }

  // Hide sidebar
  function hideSidebar() {
    if (!sidebar.classList.contains("-translate-x-full")) {
      sidebar.classList.add("-translate-x-full");
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

      // Toggle dropdown
      target.classList.toggle("hidden");

      // Rotate arrow
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
});
