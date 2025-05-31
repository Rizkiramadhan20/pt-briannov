// Initialize ScrollReveal only if not already initialized
if (typeof window.sr === "undefined") {
  window.sr = ScrollReveal({
    origin: "bottom",
    distance: "60px",
    duration: 1000,
    delay: 200,
    easing: "cubic-bezier(0.5, 0, 0, 1)",
    reset: false,
  });
}

// Initialize animations state
window.isAnimationsInitialized = window.isAnimationsInitialized || false;

// Home section animations
function initHomeAnimations() {
  if (window.isAnimationsInitialized) return;

  const elements = {
    title: document.querySelector(".home-title"),
    description: document.querySelector(".home-description"),
    framework: document.querySelectorAll(".home-framework li"),
    cta: document.querySelector(".home-cta"),
    socialIcons: document.querySelectorAll(".social-icons a"),
    partnerLogos: document.querySelectorAll(".partner-logo"),
    growth: document.querySelector(".home-growth"),
    trusted: document.querySelector(".home-trusted"),
  };

  if (elements.title)
    window.sr.reveal(elements.title, { delay: 0, distance: "100px" });
  if (elements.description)
    window.sr.reveal(elements.description, { delay: 200, distance: "50px" });
  if (elements.framework.length)
    window.sr.reveal(elements.framework, {
      delay: 400,
      interval: 100,
      distance: "30px",
    });
  if (elements.cta)
    window.sr.reveal(elements.cta, { delay: 600, distance: "30px" });
  if (elements.socialIcons.length)
    window.sr.reveal(elements.socialIcons, {
      delay: 800,
      interval: 100,
      distance: "20px",
    });
  if (elements.partnerLogos.length)
    window.sr.reveal(elements.partnerLogos, {
      delay: 1000,
      interval: 100,
      distance: "30px",
    });
  if (elements.growth)
    window.sr.reveal(elements.growth, {
      delay: 500,
      scale: 0.5,
      origin: "left",
    });
  if (elements.trusted)
    window.sr.reveal(elements.trusted, {
      delay: 500,
      scale: 0.5,
      origin: "right",
    });
}

// Works section animations
function initWorksAnimations() {
  if (window.isAnimationsInitialized) return;

  const elements = {
    image: document.querySelector(".work-image"),
    text: document.querySelector(".work-text"),
    title: document.querySelector(".work-title"),
    description: document.querySelector(".work-description"),
    cta: document.querySelector(".work-cta"),
  };

  if (elements.image)
    window.sr.reveal(elements.image, { delay: 0, scale: 0.8, origin: "left" });
  if (elements.text)
    window.sr.reveal(elements.text, { delay: 200, distance: "30px" });
  if (elements.title)
    window.sr.reveal(elements.title, { delay: 400, distance: "30px" });
  if (elements.description)
    window.sr.reveal(elements.description, { delay: 600, distance: "30px" });
  if (elements.cta)
    window.sr.reveal(elements.cta, { delay: 800, distance: "30px" });
}

// About section animations
function initAboutAnimations() {
  if (window.isAnimationsInitialized) return;

  const elements = {
    image: document.querySelector(".about-image"),
    content: document.querySelector(".about-content"),
    metrics: document.querySelectorAll(".about-metric"),
  };

  if (elements.image)
    window.sr.reveal(elements.image, { delay: 0, scale: 0.8, origin: "left" });
  if (elements.content)
    window.sr.reveal(elements.content, {
      delay: 200,
      scale: 0.8,
      origin: "right",
    });
  if (elements.metrics.length)
    window.sr.reveal(elements.metrics, {
      delay: 400,
      interval: 200,
      scale: 0.8,
    });
}

// Timeline section animations
function initTimelineAnimations() {
  if (window.isAnimationsInitialized) return;

  const elements = document.querySelectorAll(".timeline-item");
  if (elements.length)
    window.sr.reveal(elements, { delay: 0, interval: 300, scale: 0.8 });
}

// Projects section animations
function initProjectsAnimations() {
  if (window.isAnimationsInitialized) return;

  const elements = document.querySelectorAll(".project-card");
  if (elements.length)
    window.sr.reveal(elements, { delay: 0, interval: 200, scale: 0.8 });
}

// Testimonials section animations
function initTestimonialsAnimations() {
  if (window.isAnimationsInitialized) return;

  const elements = {
    subtitle: document.querySelector(".testimonials-subtitle"),
    title: document.querySelector(".testimonials-title"),
    description: document.querySelector(".testimonials-description"),
  };

  if (elements.subtitle)
    window.sr.reveal(elements.subtitle, { delay: 0, scale: 0.8 });
  if (elements.title)
    window.sr.reveal(elements.title, { delay: 200, scale: 0.8 });
  if (elements.description)
    window.sr.reveal(elements.description, { delay: 400, scale: 0.8 });
}

// Contact section animations
function initContactAnimations() {
  if (window.isAnimationsInitialized) return;

  const elements = {
    info: document.querySelector(".contact-info"),
    form: document.querySelector(".contact-form"),
  };

  if (elements.info)
    window.sr.reveal(elements.info, { delay: 0, scale: 0.8, origin: "left" });
  if (elements.form)
    window.sr.reveal(elements.form, {
      delay: 200,
      scale: 0.8,
      origin: "right",
    });
}

// Inspirations section animations
function initInspirationsAnimations() {
  if (window.isAnimationsInitialized) return;

  const elements = {
    subtitle: document.querySelector(".inspiration-subtitle"),
    title: document.querySelector(".inspiration-title"),
    description: document.querySelector(".inspiration-description"),
    desktopCards: document.querySelectorAll(
      ".hidden.md\\:block .inspiration-card"
    ),
  };

  if (elements.subtitle)
    window.sr.reveal(elements.subtitle, { delay: 0, scale: 0.8 });
  if (elements.title)
    window.sr.reveal(elements.title, { delay: 200, scale: 0.8 });
  if (elements.description)
    window.sr.reveal(elements.description, { delay: 400, scale: 0.8 });
  if (elements.desktopCards.length)
    window.sr.reveal(elements.desktopCards, {
      delay: 600,
      interval: 100,
      scale: 0.8,
    });
}

// Initialize all animations
function initAnimations() {
  if (window.isAnimationsInitialized) return;

  try {
    // Run all animations
    initHomeAnimations();
    initWorksAnimations();
    initAboutAnimations();
    initTimelineAnimations();
    initProjectsAnimations();
    initTestimonialsAnimations();
    initContactAnimations();
    initInspirationsAnimations();

    window.isAnimationsInitialized = true;
  } catch (error) {
    console.error("Error initializing animations:", error);
  }
}

// Initialize when DOM is loaded
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initAnimations);
} else {
  initAnimations();
}

// Refresh ScrollTrigger on window resize
window.addEventListener("resize", () => {
  ScrollTrigger.refresh();
});
