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

// Metric management for Create form
const metricsContainer = document.getElementById("metricsContainer");
const metricsList = document.getElementById("metricsList");
const addMetricBtn = document.querySelector("#createAboutModal .add-metric");
const metricCountInput = document.querySelector(
  "#createAboutModal .metric-count-input"
);
const metricTitleInput = document.querySelector(
  "#createAboutModal .metric-title-input"
);

function addMetric() {
  const count = metricCountInput.value.trim();
  const title = metricTitleInput.value.trim();

  if (!count || !title) {
    showToast("Please enter both count and title for the metric", false);
    return;
  }

  const metrics = document.querySelectorAll("#metricsList .metric-item");
  if (metrics.length >= 2) {
    showToast("Maximum 2 metrics allowed", false);
    return;
  }

  const metricItem = document.createElement("span");
  metricItem.className =
    "metric-item bg-blue-700 text-white px-3 py-1 rounded-full text-sm flex items-center gap-2";
  metricItem.innerHTML = `
        <div class="flex flex-col items-center">
            <span class="text-lg font-bold text-white metric-count">${count}</span>
            <span class="text-xs text-gray-300 metric-title">${title}</span>
        </div>
        <button type="button" class="remove-metric text-white hover:text-gray-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;

  metricsList.appendChild(metricItem);
  metricCountInput.value = "";
  metricTitleInput.value = "";

  // Add remove functionality
  metricItem.querySelector(".remove-metric").addEventListener("click", () => {
    metricItem.remove();
  });
}

if (addMetricBtn) {
  addMetricBtn.addEventListener("click", addMetric);
}

if (metricCountInput) {
  metricCountInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      addMetric();
    }
  });
}

if (metricTitleInput) {
  metricTitleInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      addMetric();
    }
  });
}

document
  .getElementById("createAboutForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData();
    formData.append("title", document.getElementById("title").value);
    formData.append("text", document.getElementById("text").value);
    formData.append("image", document.getElementById("image").files[0]);

    // Get metrics from the list
    const metrics = Array.from(
      document.querySelectorAll("#metricsList .metric-item")
    ).map((item) => {
      const count = item.querySelector(".metric-count").textContent.trim();
      const title = item.querySelector(".metric-title").textContent.trim();
      return { count: count, title: title };
    });

    // Add metrics to form data as JSON string
    formData.append("metrics", JSON.stringify(metrics));

    // Send data to server
    fetch("utils/create_about.php", {
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
          showToast("About content uploaded successfully!", true);
          setTimeout(() => window.location.reload(), 1000);
        } else {
          showToast("Error uploading content: " + data.message, false);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        showToast("An error occurred while uploading content", false);
      });
  });

// Edit functionality
document.querySelectorAll(".edit-about").forEach((button) => {
  button.addEventListener("click", function () {
    const id = this.dataset.id;
    const row = this.closest("tr");

    // Get content data from table row
    const title = row.querySelector("td:nth-child(2)").textContent.trim();
    const text = row.querySelector("td:nth-child(3)").textContent.trim();
    const metricsCell = row.querySelector("td:nth-child(4)");
    const metrics = Array.from(
      metricsCell.querySelectorAll(".flex.flex-col .text-lg")
    ).map((countElement) => {
      const metricItemDiv = countElement.closest(".flex.flex-col");
      const count = countElement.textContent.trim();
      const titleElement = metricItemDiv.querySelector(".text-sm");
      const title = titleElement ? titleElement.textContent.trim() : "";
      return { count: parseInt(count), title: title };
    });
    const image = row.querySelector("td:nth-child(1) img").getAttribute("src");

    // Fill edit form
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_title").value = title;
    document.getElementById("edit_text").value = text;

    // Clear and fill metrics
    const editMetricsList = document.getElementById("editMetricsList");
    editMetricsList.innerHTML = "";
    metrics.forEach((metric) => {
      const metricItem = document.createElement("span");
      metricItem.className =
        "metric-item bg-blue-700 text-white px-3 py-1 rounded-full text-sm flex items-center gap-2";
      metricItem.innerHTML = `
              <div class="flex flex-col items-center">
                  <span class="text-lg font-bold text-white metric-count">${metric.count}</span>
                  <span class="text-xs text-gray-300 metric-title">${metric.title}</span>
              </div>
              <button type="button" class="remove-metric text-white hover:text-gray-300">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
              </button>
          `;
      editMetricsList.appendChild(metricItem);

      // Add remove functionality
      metricItem
        .querySelector(".remove-metric")
        .addEventListener("click", () => {
          metricItem.remove();
        });
    });

    // Handle image preview for edit form
    const editPreview = document.getElementById("edit_preview");
    const editImagePreviewContainer =
      document.getElementById("editImagePreview");
    const editUploadContainer = document.getElementById("editUploadContainer");

    if (image && image !== "#") {
      editPreview.src = image;
      editPreview.classList.remove("hidden");
      editImagePreviewContainer.classList.remove("hidden");
      editUploadContainer.classList.add("hidden");
    } else {
      removeEditPreview();
    }
  });
});

// Metric management for Edit form
const editMetricsList = document.getElementById("editMetricsList");
const editAddMetricBtn = document.querySelector(
  "#editAboutModal .edit-add-metric"
);
const editMetricCountInput = document.querySelector(
  "#editAboutModal .edit-metric-count-input"
);
const editMetricTitleInput = document.querySelector(
  "#editAboutModal .edit-metric-title-input"
);

function addEditMetric() {
  const count = editMetricCountInput.value.trim();
  const title = editMetricTitleInput.value.trim();

  if (!count || !title) {
    showToast("Please enter both count and title for the metric", false);
    return;
  }

  const metrics = document.querySelectorAll("#editMetricsList .metric-item");
  if (metrics.length >= 2) {
    showToast("Maximum 2 metrics allowed", false);
    return;
  }

  const metricItem = document.createElement("span");
  metricItem.className =
    "metric-item bg-blue-700 text-white px-3 py-1 rounded-full text-sm flex items-center gap-2";
  metricItem.innerHTML = `
          <div class="flex flex-col items-center">
              <span class="text-lg font-bold text-white metric-count">${count}</span>
              <span class="text-xs text-gray-300 metric-title">${title}</span>
          </div>
          <button type="button" class="remove-metric text-white hover:text-gray-300">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
          </button>
      `;

  editMetricsList.appendChild(metricItem);
  editMetricCountInput.value = "";
  editMetricTitleInput.value = "";

  // Add remove functionality
  metricItem.querySelector(".remove-metric").addEventListener("click", () => {
    metricItem.remove();
  });
}

if (editAddMetricBtn) {
  editAddMetricBtn.addEventListener("click", addEditMetric);
}

if (editMetricCountInput) {
  editMetricCountInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      addEditMetric();
    }
  });
}

if (editMetricTitleInput) {
  editMetricTitleInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      addEditMetric();
    }
  });
}

// Handle image preview for edit form
function previewEditImage(input) {
  const preview = document.getElementById("edit_preview");
  const previewContainer = document.getElementById("editImagePreview");
  const uploadContainer = document.getElementById("editUploadContainer");

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
    removeEditPreview();
  }
}

function removeEditPreview() {
  const preview = document.getElementById("edit_preview");
  const previewContainer = document.getElementById("editImagePreview");
  const uploadContainer = document.getElementById("editUploadContainer");
  const fileInput = document.getElementById("edit_image");

  preview.src = "#";
  preview.classList.add("hidden");
  previewContainer.classList.add("hidden");
  uploadContainer.classList.remove("hidden");
  fileInput.value = ""; // Reset file input
}

document
  .getElementById("editAboutForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData();
    formData.append("id", document.getElementById("edit_id").value);
    formData.append("title", document.getElementById("edit_title").value);
    formData.append("text", document.getElementById("edit_text").value);

    // Get metrics from the list
    const metrics = Array.from(
      document.querySelectorAll("#editMetricsList .metric-item")
    ).map((item) => {
      const count = item.querySelector(".metric-count").textContent.trim();
      const title = item.querySelector(".metric-title").textContent.trim();
      return { count: parseInt(count), title: title };
    });

    // Add metrics to form data as JSON string
    formData.append("metrics", JSON.stringify(metrics || []));

    // Only append image if a new one is selected
    const imageInput = document.getElementById("edit_image");
    if (imageInput.files && imageInput.files[0]) {
      formData.append("image", imageInput.files[0]);
    }

    // Send data to server
    fetch("utils/edit_about.php", {
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
          showToast("About content updated successfully!", true);
          setTimeout(() => window.location.reload(), 1000);
        } else {
          showToast("Error updating content: " + data.message, false);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        showToast("An error occurred while updating content", false);
      });
  });

// Delete functionality
let currentDeleteId = null;

document.querySelectorAll(".delete-about").forEach((button) => {
  button.addEventListener("click", function () {
    currentDeleteId = this.dataset.id;
  });
});

document.getElementById("confirmDelete").addEventListener("click", function () {
  if (!currentDeleteId) return;

  const deleteText = this.querySelector(".delete-text");
  const deleteLoading = this.querySelector(".delete-loading");
  const modal = document.getElementById("deleteAboutModal");

  // Show loading state
  deleteText.classList.add("hidden");
  deleteLoading.classList.remove("hidden");
  this.disabled = true;

  fetch("utils/delete_about.php", {
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

        // Remove the deleted row
        const row = document
          .querySelector(`button[data-id="${currentDeleteId}"]`)
          .closest("tr");
        if (row) {
          row.remove();
        }

        showToast("About content deleted successfully!", true);

        // If no content left, reload to show empty state (optional)
        // if (document.querySelectorAll(".group").length === 0) {
        //   setTimeout(() => window.location.reload(), 1000);
        // }
      } else {
        showToast("Error deleting content: " + data.message, false);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      showToast("An error occurred while deleting content", false);
    })
    .finally(() => {
      // Reset loading state
      deleteText.classList.remove("hidden");
      deleteLoading.classList.add("hidden");
      this.disabled = false;
      currentDeleteId = null;
    });
});

// Explicitly initialize Flowbite modals after the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function () {
  const createAboutModalEl = document.getElementById("createAboutModal");
  const editAboutModalEl = document.getElementById("editAboutModal");
  const deleteAboutModalEl = document.getElementById("deleteAboutModal");

  if (createAboutModalEl) new Modal(createAboutModalEl);
  if (editAboutModalEl) new Modal(editAboutModalEl);
  if (deleteAboutModalEl) new Modal(deleteAboutModalEl);
});
