document.addEventListener("DOMContentLoaded", function () {
  // Get all navigation links
  const navLinks = document.querySelectorAll('a[href^="#"]');
  const homeLink = document.querySelector('a[href="/"]');

  // Function to close mobile menu
  function closeMobileMenu() {
    const mobileMenu = document.querySelector("[x-data]");
    if (mobileMenu && mobileMenu.__x) {
      mobileMenu.__x.$data.mobileMenuOpen = false;
    }
  }

  // Function to update active state
  function updateActiveState() {
    const scrollPosition = window.scrollY;

    // Get all sections
    const sections = document.querySelectorAll("section[id]");
    let isInSection = false;

    sections.forEach((section) => {
      const sectionTop = section.offsetTop - 100; // Offset for header height
      const sectionHeight = section.offsetHeight;
      const sectionId = section.getAttribute("id");

      if (
        scrollPosition >= sectionTop &&
        scrollPosition < sectionTop + sectionHeight
      ) {
        isInSection = true;
        // Remove active class from all links
        navLinks.forEach((link) => {
          link.classList.remove("text-blue-600", "after:w-full");
          link.classList.add("text-gray-600");
        });

        // Add active class to current section's link
        const activeLink = document.querySelector(`a[href="#${sectionId}"]`);
        if (activeLink) {
          activeLink.classList.remove("text-gray-600");
          activeLink.classList.add("text-blue-600", "after:w-full");
        }
      }
    });

    // Handle home link active state
    if (homeLink) {
      if (!isInSection && scrollPosition < 100) {
        // Remove active class from all links
        navLinks.forEach((link) => {
          link.classList.remove("text-blue-600", "after:w-full");
          link.classList.add("text-gray-600");
        });

        // Add active class to home link
        homeLink.classList.remove("text-gray-600");
        homeLink.classList.add("text-blue-600", "after:w-full");
      } else if (isInSection) {
        // Ensure home link is not active when in a section
        homeLink.classList.remove("text-blue-600", "after:w-full");
        homeLink.classList.add("text-gray-600");
      }
    }
  }

  // Add smooth scrolling to all links
  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      // Close mobile menu if it's open
      closeMobileMenu();

      const targetId = this.getAttribute("href");
      if (targetId === "/") {
        window.scrollTo({
          top: 0,
          behavior: "smooth",
        });
        return;
      }

      const targetSection = document.querySelector(targetId);
      if (targetSection) {
        const headerOffset = 80; // Adjust this value based on your header height
        const elementPosition = targetSection.getBoundingClientRect().top;
        const offsetPosition =
          elementPosition + window.pageYOffset - headerOffset;

        window.scrollTo({
          top: offsetPosition,
          behavior: "smooth",
        });
      }
    });
  });

  // Also handle home link click
  if (homeLink) {
    homeLink.addEventListener("click", function (e) {
      e.preventDefault();
      closeMobileMenu();
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  }

  // Update active state on scroll
  window.addEventListener("scroll", updateActiveState);

  // Initial check for active state
  updateActiveState();
});
