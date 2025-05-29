document
  .getElementById("createContentForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData(this);
    const label = formData.get("labels").trim();

    // Get frameworks from the list
    const frameworks = Array.from(
      document.querySelectorAll(".framework-tag")
    ).map((tag) => tag.textContent);

    // Create data object
    const data = {
      title: formData.get("title"),
      text: formData.get("text"),
      description: formData.get("description"),
      framework: frameworks,
      labels: label,
      href: formData.get("href"),
    };

    // Send data to server
    fetch("utils/create_content.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Content created successfully!");
          window.location.reload();
        } else {
          alert("Error creating content: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while creating content");
      });
  });

// Framework management
const frameworkContainer = document.getElementById("frameworkContainer");
const frameworkList = document.getElementById("frameworkList");
const addFrameworkBtn = document.querySelector(".add-framework");
const frameworkInput = document.querySelector(".framework-input");

function addFramework() {
  const input = frameworkInput.value.trim();
  if (!input) return;

  const frameworks = document.querySelectorAll(".framework-tag");
  if (frameworks.length >= 6) {
    alert("Maximum 6 frameworks allowed");
    return;
  }

  const tag = document.createElement("span");
  tag.className =
    "framework-tag bg-blue-700 text-white px-3 py-1 rounded-full text-sm flex items-center gap-2";
  tag.innerHTML = `
        ${input}
        <button type="button" class="remove-framework text-white hover:text-gray-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;

  frameworkList.appendChild(tag);
  frameworkInput.value = "";

  // Add remove functionality
  tag.querySelector(".remove-framework").addEventListener("click", () => {
    tag.remove();
  });
}

addFrameworkBtn.addEventListener("click", addFramework);
frameworkInput.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    e.preventDefault();
    addFramework();
  }
});

// Edit functionality
document.querySelectorAll(".edit-content").forEach((button) => {
  button.addEventListener("click", function () {
    const id = this.dataset.id;
    const row = this.closest("tr");

    // Get content data from table row
    const title = row.querySelector("td:nth-child(1)").textContent.trim();
    const text = row.querySelector("td:nth-child(2)").textContent.trim();
    const description = row.querySelector("td:nth-child(3)").textContent.trim();
    const labels = row.querySelector("td:nth-child(5)").textContent.trim();
    const href = row.querySelector("td:nth-child(6) a").getAttribute("href");
    const frameworks = Array.from(
      row.querySelectorAll("td:nth-child(4) .bg-blue-600\\/20")
    ).map((tag) => tag.textContent.trim());

    // Fill edit form
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_title").value = title;
    document.getElementById("edit_text").value = text;
    document.getElementById("edit_description").value = description;
    document.getElementById("edit_labels").value = labels;
    document.getElementById("edit_href").value = href;

    // Clear and fill frameworks
    const frameworkList = document.getElementById("editFrameworkList");
    frameworkList.innerHTML = "";
    frameworks.forEach((framework) => {
      const tag = document.createElement("span");
      tag.className =
        "framework-tag bg-blue-700 text-white px-3 py-1 rounded-full text-sm flex items-center gap-2";
      tag.innerHTML = `
                ${framework}
                <button type="button" class="remove-framework text-white hover:text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
      frameworkList.appendChild(tag);

      // Add remove functionality
      tag.querySelector(".remove-framework").addEventListener("click", () => {
        tag.remove();
      });
    });
  });
});

// Edit form submission
document
  .getElementById("editContentForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData(this);
    const label = formData.get("labels").trim();

    // Get frameworks from the list
    const frameworks = Array.from(
      document.querySelectorAll("#editFrameworkList .framework-tag")
    ).map((tag) => tag.textContent.trim());

    // Create data object
    const data = {
      id: formData.get("id"),
      title: formData.get("title"),
      text: formData.get("text"),
      description: formData.get("description"),
      framework: frameworks,
      labels: label,
      href: formData.get("href"),
    };

    // Send data to server
    fetch("utils/edit_content.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Content updated successfully!");
          window.location.reload();
        } else {
          alert("Error updating content: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while updating content");
      });
  });

// Delete functionality
let currentDeleteId = null;

document.querySelectorAll(".delete-content").forEach((button) => {
  button.addEventListener("click", function () {
    currentDeleteId = this.dataset.id;
  });
});

document.getElementById("confirmDelete").addEventListener("click", function () {
  if (!currentDeleteId) return;

  const deleteText = this.querySelector(".delete-text");
  const deleteLoading = this.querySelector(".delete-loading");
  const modal = document.getElementById("deleteContentModal");

  // Show loading state
  deleteText.classList.add("hidden");
  deleteLoading.classList.remove("hidden");
  this.disabled = true;

  fetch("utils/delete_content.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id: currentDeleteId }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Hide modal
        const modalInstance = new Modal(modal);
        modalInstance.hide();

        // Remove the deleted card
        const card = document.querySelector(
          `[data-content-id="${currentDeleteId}"]`
        );
        if (card) {
          card.remove();
        }
      } else {
        alert("Error deleting content: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("An error occurred while deleting content");
    })
    .finally(() => {
      // Reset loading state
      deleteText.classList.remove("hidden");
      deleteLoading.classList.add("hidden");
      this.disabled = false;
      currentDeleteId = null;
    });
});

// Edit framework management
const editFrameworkInput = document.querySelector(".edit-framework-input");
const editAddFrameworkBtn = document.querySelector(".edit-add-framework");

function addEditFramework() {
  const input = editFrameworkInput.value.trim();
  if (!input) return;

  const frameworks = document.querySelectorAll(
    "#editFrameworkList .framework-tag"
  );
  if (frameworks.length >= 6) {
    alert("Maximum 6 frameworks allowed");
    return;
  }

  const tag = document.createElement("span");
  tag.className =
    "framework-tag bg-blue-700 text-white px-3 py-1 rounded-full text-sm flex items-center gap-2";
  tag.innerHTML = `
        ${input}
        <button type="button" class="remove-framework text-white hover:text-gray-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;

  document.getElementById("editFrameworkList").appendChild(tag);
  editFrameworkInput.value = "";

  // Add remove functionality
  tag.querySelector(".remove-framework").addEventListener("click", () => {
    tag.remove();
  });
}

editAddFrameworkBtn.addEventListener("click", addEditFramework);
editFrameworkInput.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    e.preventDefault();
    addEditFramework();
  }
});
