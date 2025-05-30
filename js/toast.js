// Toast elements
const toast = document.getElementById("toast");
const toastMessage = document.getElementById("toast-message");
const toastIcon = document.getElementById("toast-icon");

// Function to show toast
function showToast(message, type = "success") {
  if (!toast || !toastMessage || !toastIcon) {
    console.error("Toast elements not found");
    return;
  }

  // Set message
  toastMessage.textContent = message;

  // Set icon and color based on type
  if (type === "success") {
    toastIcon.className =
      "inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-600 bg-green-50 rounded-lg";
    toastIcon.innerHTML = '<i class="bx bx-check text-xl"></i>';
  } else if (type === "error") {
    toastIcon.className =
      "inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-600 bg-red-50 rounded-lg";
    toastIcon.innerHTML = '<i class="bx bx-x text-xl"></i>';
  }

  // Show toast
  toast.classList.remove("hidden");
  toast.classList.add("block");

  // Auto hide after 3 seconds
  setTimeout(() => {
    hideToast();
  }, 3000);
}

// Function to hide toast
function hideToast() {
  if (!toast) return;

  toast.classList.remove("block");
  toast.classList.add("hidden");
}

// Export functions for use in other scripts
window.showToast = showToast;
window.hideToast = hideToast;
