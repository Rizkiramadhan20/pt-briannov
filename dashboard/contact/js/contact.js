// Toast elements
const toast = document.getElementById("toast");
const toastMessage = document.getElementById("toast-message");
const toastIcon = document.getElementById("toast-icon");

// Function to show toast
function showToast(message, type = "success") {
  // Set message
  toastMessage.textContent = message;

  // Set icon and color based on type
  if (type === "success") {
    toastIcon.className =
      "inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200";
    toastIcon.innerHTML = '<i class="bx bx-check text-xl"></i>';
  } else if (type === "error") {
    toastIcon.className =
      "inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200";
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
  toast.classList.remove("block");
  toast.classList.add("hidden");
}

// Function to close modal
function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;

  // Try using Flowbite if available
  if (window.flowbite && window.flowbite.Modal) {
    const modalInstance = window.flowbite.Modal.getInstance(modal);
    if (modalInstance) {
      modalInstance.hide();
    }
  }

  // Fallback: Hide modal manually
  modal.classList.add("hidden");
  modal.setAttribute("aria-hidden", "true");
  modal.removeAttribute("aria-modal");
  modal.removeAttribute("role");
  modal.classList.remove("show");

  // Remove ALL modal backdrops
  document
    .querySelectorAll(
      ".modal-backdrop, .fixed.inset-0.bg-gray-900.bg-opacity-50"
    )
    .forEach((el) => el.remove());
}

// View Message
document.querySelectorAll(".view-message").forEach((button) => {
  button.addEventListener("click", function () {
    const name = this.getAttribute("data-name");
    const email = this.getAttribute("data-email");
    const subject = this.getAttribute("data-subject");
    const message = this.getAttribute("data-message");

    document.getElementById("view-name").textContent = name;
    document.getElementById("view-email").textContent = email;
    document.getElementById("view-subject").textContent = subject;
    document.getElementById("view-message").textContent = message;
  });
});

// Delete Message
let messageIdToDelete = null;

document.querySelectorAll(".delete-message").forEach((button) => {
  button.addEventListener("click", function () {
    messageIdToDelete = this.getAttribute("data-id");
  });
});

document.getElementById("confirmDelete").addEventListener("click", function () {
  if (!messageIdToDelete) return;

  const button = this;
  const deleteText = button.querySelector(".delete-text");
  const deleteLoading = button.querySelector(".delete-loading");

  // Show loading state
  deleteText.classList.add("hidden");
  deleteLoading.classList.remove("hidden");
  button.disabled = true;

  // Send delete request
  fetch("delete_contact.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "id=" + messageIdToDelete,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      // Close modal first
      closeModal("deleteMessageModal");

      if (data.success) {
        // Remove the row from the table
        const row = document
          .querySelector(`[data-id="${messageIdToDelete}"]`)
          .closest("tr");
        if (row) {
          row.remove();
        }

        // Show success message
        showToast(data.message || "Message deleted successfully", "success");

        // Check if table is empty
        const tbody = document.querySelector("tbody");
        if (tbody && tbody.children.length === 0) {
          location.reload(); // Reload to show empty state
        }
      } else {
        showToast(data.message || "Failed to delete message", "error");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      // Close modal even if there's an error
      closeModal("deleteMessageModal");
      showToast("An error occurred while deleting the message", "error");
    })
    .finally(() => {
      // Reset button state
      deleteText.classList.remove("hidden");
      deleteLoading.classList.add("hidden");
      button.disabled = false;
      messageIdToDelete = null;
    });
});
