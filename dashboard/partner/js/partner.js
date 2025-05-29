// Toast Notification
function showToast(message, isSuccess = true) {
  let toast = document.getElementById("toast");
  let toastMessage = document.getElementById("toast-message");
  if (!toast) {
    toast = document.createElement("div");
    toast.id = "toast";
    toast.className = "fixed top-4 right-4 z-50";
    toast.innerHTML = `
      <div class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 ${
          isSuccess
            ? "text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200"
            : "text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200"
        }">
          <i class='bx ${isSuccess ? "bx-check" : "bx-x"} text-xl'></i>
        </div>
        <div class="ml-3 text-sm font-normal" id="toast-message"></div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.parentElement.parentElement.remove();">
          <i class='bx bx-x text-xl'></i>
        </button>
      </div>
    `;
    document.body.appendChild(toast);
    toastMessage = document.getElementById("toast-message");
  }
  toastMessage.textContent = message;
  toast.classList.remove("hidden");
  setTimeout(() => {
    if (toast) toast.classList.add("hidden");
  }, 3000);
}

// Image Preview Functions
function previewImage(input) {
  const preview = document.getElementById("preview");
  const previewContainer = document.getElementById("imagePreview");
  const uploadContainer = document.getElementById("uploadContainer");

  if (input.files && input.files[0]) {
    const reader = new FileReader();

    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.classList.remove("hidden");
      previewContainer.classList.remove("hidden");
      uploadContainer.classList.add("hidden");
    };

    reader.readAsDataURL(input.files[0]);
  } else {
    removePreview();
  }
}

function removePreview() {
  const preview = document.getElementById("preview");
  const previewContainer = document.getElementById("imagePreview");
  const uploadContainer = document.getElementById("uploadContainer");
  const fileInput = document.getElementById("image");

  preview.src = "#";
  preview.classList.add("hidden");
  previewContainer.classList.add("hidden");
  uploadContainer.classList.remove("hidden");
  fileInput.value = ""; // Reset file input
}

document
  .getElementById("createPartnerForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData(this);

    // Send data to server
    fetch("utils/create_partner.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
          throw new TypeError("Oops, we haven't got JSON!");
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          showToast("Partner image uploaded successfully!", true);
          setTimeout(() => window.location.reload(), 1000);
        } else {
          showToast("Error uploading image: " + data.message, false);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        showToast("An error occurred while uploading image", false);
      });
  });

// Delete functionality
let currentDeleteId = null;

document.querySelectorAll(".delete-partner").forEach((button) => {
  button.addEventListener("click", function () {
    currentDeleteId = this.dataset.id;
  });
});

document.getElementById("confirmDelete").addEventListener("click", function () {
  if (!currentDeleteId) return;

  const deleteText = this.querySelector(".delete-text");
  const deleteLoading = this.querySelector(".delete-loading");
  const modal = document.getElementById("deletePartnerModal");

  // Show loading state
  deleteText.classList.add("hidden");
  deleteLoading.classList.remove("hidden");
  this.disabled = true;

  fetch("utils/delete_partner.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id: currentDeleteId }),
  })
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      const contentType = response.headers.get("content-type");
      if (!contentType || !contentType.includes("application/json")) {
        throw new TypeError("Oops, we haven't got JSON!");
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        // Hide modal
        const modalInstance = new Modal(modal);
        modalInstance.hide();

        // Remove the deleted image
        const image = document
          .querySelector(`[data-id="${currentDeleteId}"]`)
          .closest(".group");
        if (image) {
          image.remove();
        }

        showToast("Partner image deleted successfully!", true);

        // If no images left, reload to show empty state
        if (document.querySelectorAll(".group").length === 0) {
          setTimeout(() => window.location.reload(), 1000);
        }
      } else {
        showToast("Error deleting image: " + data.message, false);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      showToast("An error occurred while deleting image", false);
    })
    .finally(() => {
      // Reset loading state
      deleteText.classList.remove("hidden");
      deleteLoading.classList.add("hidden");
      this.disabled = false;
      currentDeleteId = null;
    });
});
