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

  // Hide modal manually
  modal.classList.add("hidden");
  modal.setAttribute("aria-hidden", "true");
  modal.removeAttribute("aria-modal");
  modal.removeAttribute("role");
  modal.classList.remove("show");

  // Remove ALL modal backdrops and overlays
  document
    .querySelectorAll(
      ".modal-backdrop, .fixed.inset-0.bg-gray-900.bg-opacity-50, [data-modal-backdrop]"
    )
    .forEach((el) => el.remove());

  // Remove overflow-hidden from body
  document.body.classList.remove("overflow-hidden");
}

// View Message
document.addEventListener("DOMContentLoaded", function () {
  // View Message Modal
  const viewButtons = document.querySelectorAll(".view-message");
  viewButtons.forEach((button) => {
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

  // Reply Message Modal
  const replyButtons = document.querySelectorAll(".reply-message");
  replyButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const contactId = this.getAttribute("data-id");
      const email = this.getAttribute("data-email");
      const subject = document
        .querySelector(`[data-id="${contactId}"]`)
        .closest("tr")
        .querySelector("td:nth-child(3)").textContent;

      // Open Gmail compose URL
      const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(
        email
      )}&su=${encodeURIComponent("Re: " + subject)}`;
      window.open(gmailUrl, "_blank");
    });
  });

  // Reply Form Submit
  const replyForm = document.getElementById("replyForm");
  if (replyForm) {
    replyForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const submitButton = this.querySelector('button[type="submit"]');
      const replyText = submitButton.querySelector(".reply-text");
      const replyLoading = submitButton.querySelector(".reply-loading");

      // Show loading state
      replyText.classList.add("hidden");
      replyLoading.classList.remove("hidden");
      submitButton.disabled = true;

      try {
        const formData = new FormData(this);
        const response = await fetch("utils/process_reply.php", {
          method: "POST",
          body: formData,
        });

        const result = await response.json();

        if (result.success) {
          showToast("Reply sent successfully!", "success");
          // Close modal
          const modal = document.getElementById("replyMessageModal");
          const modalInstance = flowbite.Modal.getInstance(modal);
          modalInstance.hide();
          // Reset form
          this.reset();
        } else {
          showToast(result.message || "Failed to send reply", "error");
        }
      } catch (error) {
        showToast("An error occurred while sending the reply", "error");
      } finally {
        // Reset button state
        replyText.classList.remove("hidden");
        replyLoading.classList.add("hidden");
        submitButton.disabled = false;
      }
    });
  }

  // Delete Message
  const deleteButtons = document.querySelectorAll(".delete-message");
  deleteButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const contactId = this.getAttribute("data-id");
      const confirmDeleteBtn = document.getElementById("confirmDelete");

      confirmDeleteBtn.onclick = async function () {
        const deleteText = this.querySelector(".delete-text");
        const deleteLoading = this.querySelector(".delete-loading");

        // Show loading state
        deleteText.classList.add("hidden");
        deleteLoading.classList.remove("hidden");
        this.disabled = true;

        try {
          const response = await fetch("utils/delete_contact.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: contactId }),
          });

          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }

          const result = await response.json();

          if (result.success) {
            showToast("Message deleted successfully!", "success");
            // Remove the row from the table
            const row = document
              .querySelector(`[data-id="${contactId}"]`)
              .closest("tr");
            row.remove();

            // Close modal using Flowbite and force cleanup
            const modal = document.getElementById("deleteMessageModal");
            if (window.flowbite && window.flowbite.Modal) {
              const modalInstance = window.flowbite.Modal.getInstance(modal);
              if (modalInstance) {
                // Attempt to hide using Flowbite's API
                modalInstance.hide();

                // Add a small delay before forceful cleanup
                setTimeout(() => {
                  // Force remove backdrop and reset body state
                  const backdrop = document.querySelector(
                    "[data-modal-backdrop]"
                  );
                  if (backdrop) {
                    backdrop.remove();
                  }
                  document.body.classList.remove("overflow-hidden");

                  // Ensure modal element is also truly hidden
                  modal.classList.add("hidden");
                  modal.setAttribute("aria-hidden", "true");
                  modal.removeAttribute("aria-modal");
                  modal.removeAttribute("role");
                  modal.classList.remove("show");
                }, 250); // Increased delay slightly
              } else {
                // Fallback if Flowbite instance not found
                modal.classList.add("hidden");
                modal.setAttribute("aria-hidden", "true");
                const backdrop = document.querySelector(
                  "[data-modal-backdrop]"
                );
                if (backdrop) backdrop.remove();
                document.body.classList.remove("overflow-hidden");
              }
            } else {
              // Fallback if Flowbite library is not available
              const modal = document.getElementById("deleteMessageModal");
              const backdrop = document.querySelector("[data-modal-backdrop]");

              modal.classList.add("hidden");
              modal.setAttribute("aria-hidden", "true");
              if (backdrop) backdrop.remove();
              document.body.classList.remove("overflow-hidden");
            }
          } else {
            showToast(result.message || "Failed to delete message", "error");
          }
        } catch (error) {
          console.error("Delete error:", error);
          showToast("An error occurred while deleting the message", "error");
        } finally {
          // Reset button state
          deleteText.classList.remove("hidden");
          deleteLoading.classList.add("hidden");
          this.disabled = false;
        }
      };
    });
  });
});
