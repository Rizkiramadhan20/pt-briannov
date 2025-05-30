// Home section animations
const homeAnimations = () => {
  gsap.from(".home-title", {
    y: 100,
    opacity: 0,
    duration: 1,
    ease: "power4.out",
  });

  gsap.from(".home-description", {
    y: 50,
    opacity: 0,
    duration: 1,
    delay: 0.3,
    ease: "power4.out",
  });

  gsap.from(".home-framework li", {
    y: 30,
    opacity: 0,
    duration: 0.8,
    stagger: 0.1,
    delay: 0.5,
    ease: "power3.out",
  });

  gsap.to(".home-cta", {
    y: 0,
    scale: 1,
    opacity: 1,
    duration: 0.8,
    delay: 0.8,
    ease: "elastic.out(1, 0.5)",
  });

  gsap.from(".social-icons a", {
    y: 20,
    opacity: 0,
    duration: 0.6,
    stagger: 0.1,
    delay: 1,
    ease: "power2.out",
  });

  gsap.from(".partner-logo", {
    scale: 0.8,
    opacity: 0,
    duration: 0.8,
    stagger: 0.1,
    delay: 1.2,
    ease: "power2.out",
  });

  // Weekly Growth animation
  gsap.from(".home-growth", {
    scale: 0.5,
    opacity: 0,
    duration: 1,
    delay: 0.5,
    ease: "back.out(1.7)",
  });

  // Client Trusted animation
  gsap.from(".home-trusted", {
    scale: 0.5,
    opacity: 0,
    duration: 1,
    delay: 0.5,
    ease: "back.out(1.7)",
  });
};

// Works section animations
const worksAnimations = () => {
  gsap.from(".work-image", {
    x: -100,
    opacity: 0,
    duration: 1,
    scrollTrigger: {
      trigger: ".work-image",
      start: "top 80%",
      end: "top 20%",
      toggleActions: "play none none reverse",
    },
  });

  gsap.from(".work-text", {
    y: 30,
    opacity: 0,
    duration: 0.8,
    delay: 0.2,
    scrollTrigger: {
      trigger: ".work-content",
      start: "top 80%",
      end: "top 20%",
      toggleActions: "play none none reverse",
    },
  });

  gsap.from(".work-title", {
    y: 30,
    opacity: 0,
    duration: 0.8,
    delay: 0.4,
    scrollTrigger: {
      trigger: ".work-content",
      start: "top 80%",
      end: "top 20%",
      toggleActions: "play none none reverse",
    },
  });

  gsap.from(".work-description", {
    y: 30,
    opacity: 0,
    duration: 0.8,
    delay: 0.6,
    scrollTrigger: {
      trigger: ".work-content",
      start: "top 80%",
      end: "top 20%",
      toggleActions: "play none none reverse",
    },
  });

  gsap.from(".work-cta", {
    y: 30,
    opacity: 0,
    duration: 0.8,
    delay: 0.8,
    scrollTrigger: {
      trigger: ".work-content",
      start: "top 80%",
      end: "top 20%",
      toggleActions: "play none none reverse",
    },
  });
};

// About section animations
const aboutAnimations = () => {
  gsap.from(".about-image", {
    x: -100,
    opacity: 0,
    duration: 1,
    scrollTrigger: {
      trigger: ".about-image",
      start: "top 80%",
      end: "top 20%",
      toggleActions: "play none none reverse",
    },
  });

  gsap.from(".about-content", {
    x: 100,
    opacity: 0,
    duration: 1,
    scrollTrigger: {
      trigger: ".about-content",
      start: "top 80%",
      end: "top 20%",
      toggleActions: "play none none reverse",
    },
  });

  gsap.from(".about-metric", {
    y: 50,
    opacity: 0,
    duration: 0.8,
    stagger: 0.2,
    scrollTrigger: {
      trigger: ".about-metrics",
      start: "top 80%",
      end: "top 20%",
      toggleActions: "play none none reverse",
    },
  });
};

// Timeline section animations
const timelineAnimations = () => {
  gsap.from(".timeline-item", {
    y: 100,
    opacity: 0,
    duration: 1,
    stagger: 0.3,
    scrollTrigger: {
      trigger: ".timeline-item",
      start: "top 80%",
      end: "top 20%",
      toggleActions: "play none none reverse",
    },
  });
};

// Projects section animations
const projectsAnimations = () => {
  gsap.from(".project-card", {
    scale: 0.9,
    opacity: 0,
    duration: 1,
    stagger: 0.2,
    scrollTrigger: {
      trigger: ".project-card",
      start: "top 80%",
      end: "top 20%",
      toggleActions: "play none none reverse",
    },
  });
};

// Testimonials section animations
const testimonialsAnimations = () => {
  // Heading animations
  gsap.from(".testimonials-subtitle", {
    y: 30,
    opacity: 0,
    duration: 0.8,
    scrollTrigger: {
      trigger: ".testimonials-subtitle",
      start: "top 70%",
      end: "top 30%",
      toggleActions: "play none none none",
      once: true,
      immediateRender: false,
    },
  });

  gsap.from(".testimonials-title", {
    y: 30,
    opacity: 0,
    duration: 0.8,
    delay: 0.2,
    scrollTrigger: {
      trigger: ".testimonials-title",
      start: "top 70%",
      end: "top 30%",
      toggleActions: "play none none none",
      once: true,
      immediateRender: false,
    },
  });

  gsap.from(".testimonials-description", {
    y: 30,
    opacity: 0,
    duration: 0.8,
    delay: 0.4,
    scrollTrigger: {
      trigger: ".testimonials-description",
      start: "top 70%",
      end: "top 30%",
      toggleActions: "play none none none",
      once: true,
      immediateRender: false,
    },
  });
};

// Contact section animations
const contactAnimations = () => {
  gsap.from(".contact-info", {
    x: -100,
    opacity: 0,
    duration: 1,
    scrollTrigger: {
      trigger: ".contact-info",
      start: "top 70%",
      end: "top 30%",
      toggleActions: "play none none none",
      once: true,
      immediateRender: false,
    },
  });

  gsap.from(".contact-form", {
    x: 100,
    opacity: 0,
    duration: 1,
    scrollTrigger: {
      trigger: ".contact-form",
      start: "top 70%",
      end: "top 30%",
      toggleActions: "play none none none",
      once: true,
      immediateRender: false,
    },
  });
};

// Inspirations section animations
const inspirationsAnimations = () => {
  // Header animations
  gsap.from(".inspiration-subtitle", {
    y: 30,
    opacity: 0,
    duration: 0.8,
    scrollTrigger: {
      trigger: ".inspiration-subtitle",
      start: "top 70%",
      end: "top 30%",
      toggleActions: "play none none none",
      once: true,
      immediateRender: false,
    },
  });

  gsap.from(".inspiration-title", {
    y: 30,
    opacity: 0,
    duration: 0.8,
    delay: 0.2,
    scrollTrigger: {
      trigger: ".inspiration-title",
      start: "top 70%",
      end: "top 30%",
      toggleActions: "play none none none",
      once: true,
      immediateRender: false,
    },
  });

  gsap.from(".inspiration-description", {
    y: 30,
    opacity: 0,
    duration: 0.8,
    delay: 0.4,
    scrollTrigger: {
      trigger: ".inspiration-description",
      start: "top 70%",
      end: "top 30%",
      toggleActions: "play none none none",
      once: true,
      immediateRender: false,
    },
  });

  // Mobile cards animations
  gsap.from(".md\\:hidden .inspiration-card", {
    scale: 0.8,
    opacity: 0,
    duration: 0.8,
    stagger: 0.1,
    scrollTrigger: {
      trigger: ".md\\:hidden .inspiration-card",
      start: "top 70%",
      end: "top 30%",
      toggleActions: "play none none none",
      once: true,
      immediateRender: false,
    },
  });

  // Desktop cards animations - First Row
  gsap.from(".hidden.md\\:block .absolute.top-\\[250px\\] .inspiration-card", {
    scale: 0.8,
    opacity: 0,
    duration: 0.8,
    stagger: 0.1,
    scrollTrigger: {
      trigger: ".hidden.md\\:block .absolute.top-\\[250px\\]",
      start: "top 70%",
      end: "top 30%",
      toggleActions: "play none none none",
      once: true,
      immediateRender: false,
    },
  });

  // Desktop cards animations - Second Row
  gsap.from(".hidden.md\\:block .absolute.top-\\[550px\\] .inspiration-card", {
    scale: 0.8,
    opacity: 0,
    duration: 0.8,
    stagger: 0.1,
    scrollTrigger: {
      trigger: ".hidden.md\\:block .absolute.top-\\[550px\\]",
      start: "top 70%",
      end: "top 30%",
      toggleActions: "play none none none",
      once: true,
      immediateRender: false,
    },
  });
};

// Initialize all animations
const initAnimations = () => {
  // Register ScrollTrigger plugin
  gsap.registerPlugin(ScrollTrigger);

  // Clear any existing ScrollTrigger instances
  ScrollTrigger.getAll().forEach((st) => st.kill());

  // Initialize animations
  homeAnimations();
  worksAnimations();
  aboutAnimations();
  timelineAnimations();
  projectsAnimations();
  testimonialsAnimations();
  contactAnimations();
  inspirationsAnimations();
};

// Run animations when DOM is loaded
document.addEventListener("DOMContentLoaded", initAnimations);

// Refresh animations when page is fully loaded
window.addEventListener("load", () => {
  ScrollTrigger.refresh();
});
