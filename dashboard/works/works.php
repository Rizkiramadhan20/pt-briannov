<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../../../index.php");
    exit;
}
$user = $_SESSION['user'];

// Include database configuration
require_once '../../config/db.php';

// Fetch all partners
$result = $db->query("SELECT * FROM works ORDER BY created_at DESC");
$works = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $works[] = $row;
    }
}

// Include sidebar dan header
include '../sidebar.php';
include '../header.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Works - Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {}
        }
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</head>

<body class="bg-gray-50">
    <section class="ml-0 sm:ml-64 pt-16 sm:pt-20 px-4 sm:px-8 min-h-screen transition-all duration-200">
        <div class="p-6 rounded-xl bg-white shadow-lg transition-shadow duration-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="space-y-2">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Works</h2>
                    <p class="text-gray-600 text-sm sm:text-base">Manage your works entries</p>
                </div>

                <?php if (empty($works)): ?>
                <button data-modal-target="createWorksModal" data-modal-toggle="createWorksModal"
                    class="inline-flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none transition-colors duration-200">
                    <i class='bx bx-plus text-xl'></i>
                    Add Work Entry
                </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Works List -->
        <div class="mt-6">
            <?php if (empty($works)): ?>
            <div class="flex flex-col items-center justify-center py-12 px-4">
                <svg class="w-32 h-32 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Works Entries Found</h3>
                <p class="text-gray-500 text-center mb-4">Start by adding your first work entry.</p>
                <button data-modal-target="createWorksModal" data-modal-toggle="createWorksModal"
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none transition-colors duration-200">
                    Add Your First Work Entry
                </button>
            </div>
            <?php else: ?>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg md:overflow-visible">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Image</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Title</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Text</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Description</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Created At</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($works as $work): ?>
                        <tr class="border-b border-gray-200 bg-white hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <div class="w-20 h-20">
                                    <img src="../<?php echo htmlspecialchars($work['image']); ?>" alt="Work"
                                        class="w-full h-full object-contain rounded-lg bg-gray-100 p-2">
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <?php echo htmlspecialchars($work['title']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <?php echo htmlspecialchars($work['text']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <?php echo htmlspecialchars($work['description']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <?php echo date('d M Y H:i', strtotime($work['created_at'])); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <div class="flex items-center gap-2">
                                    <button type="button"
                                        class="edit-work text-blue-600 hover:text-blue-500 transition-colors duration-200"
                                        data-id="<?php echo $work['id']; ?>"
                                        data-title="<?php echo htmlspecialchars($work['title']); ?>"
                                        data-description="<?php echo htmlspecialchars($work['description']); ?>"
                                        data-text="<?php echo htmlspecialchars($work['text']); ?>"
                                        data-modal-target="editWorksModal" data-modal-toggle="editWorksModal">
                                        <i class='bx bx-edit text-xl'></i>
                                    </button>
                                    <button type="button"
                                        class="delete-work text-red-600 hover:text-red-500 transition-colors duration-200"
                                        data-id="<?php echo $work['id']; ?>" data-modal-target="deleteWorksModal"
                                        data-modal-toggle="deleteWorksModal">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- Create Modal -->
        <div id="createWorksModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Add Work Entry
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="createWorksModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form id="createWorksForm" class="p-6" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                            <input type="text" id="title" name="title"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="3"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-700">Text</label>
                            <textarea id="text" name="text" rows="3"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="image" class="block mb-2 text-sm font-medium text-gray-700">Image</label>
                            <div id="uploadContainer" class="flex items-center justify-center w-full">
                                <label for="image"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-50">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L7.5 8.5M10 6l2.5 2.5" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                                                upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                    </div>
                                    <input type="file" id="image" name="image" accept="image/*" class="hidden" required
                                        onchange="previewImage(this)" />
                                </label>
                            </div>
                            <!-- Image Preview Container -->
                            <div id="imagePreview" class="mt-4 hidden">
                                <div class="flex justify-between items-start mb-2">
                                    <p class="text-sm text-gray-600">Preview:</p>
                                    <button type="button" onclick="removePreview()"
                                        class="text-red-600 hover:text-red-500">
                                        <i class='bx bx-x text-xl'></i>
                                    </button>
                                </div>
                                <div class="w-full max-w-xs">
                                    <img id="preview" src="#" alt="Preview"
                                        class="w-full h-auto rounded-lg bg-gray-100 p-2 hidden">
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end space-x-2">
                            <button type="button" data-modal-hide="createWorksModal"
                                class="text-gray-700 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cancel</button>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editWorksModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Edit Work Entry
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="editWorksModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form id="editWorksForm" class="p-6">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-4">
                            <label for="edit_title" class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                            <input type="text" id="edit_title" name="title"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="edit_description"
                                class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                            <textarea id="edit_description" name="description" rows="3"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="edit_text" class="block mb-2 text-sm font-medium text-gray-700">Text</label>
                            <textarea id="edit_text" name="text" rows="3"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="edit_image" class="block mb-2 text-sm font-medium text-gray-700">Image</label>
                            <div id="editUploadContainer" class="flex items-center justify-center w-full">
                                <label for="edit_image"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-50">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L7.5 8.5M10 6l2.5 2.5" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                                                upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                    </div>
                                    <input type="file" id="edit_image" name="image" accept="image/*" class="hidden"
                                        onchange="previewEditImage(this)" />
                                </label>
                            </div>
                            <!-- Image Preview Container -->
                            <div id="editImagePreview" class="mt-4 hidden">
                                <div class="flex justify-between items-start mb-2">
                                    <p class="text-sm text-gray-600">Preview:</p>
                                    <button type="button" onclick="removeEditPreview()"
                                        class="text-red-600 hover:text-red-500">
                                        <i class='bx bx-x text-xl'></i>
                                    </button>
                                </div>
                                <div class="w-full max-w-xs">
                                    <img id="edit_preview" src="#" alt="Preview"
                                        class="w-full h-auto rounded-lg bg-gray-100 p-2 hidden">
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end space-x-2">
                            <button type="button" data-modal-hide="editWorksModal"
                                class="text-gray-700 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cancel</button>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div id="deleteWorksModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Delete Work Entry
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="deleteWorksModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Are you sure you want to delete this work entry? This action
                            cannot be undone.</p>
                        <div class="flex items-center justify-end space-x-2">
                            <button type="button" data-modal-hide="deleteWorksModal"
                                class="text-gray-700 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cancel</button>
                            <button type="button" id="confirmDelete"
                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                <span class="delete-text">Delete</span>
                                <span class="delete-loading hidden">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow" role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <i class='bx bx-check text-xl'></i>
            </div>
            <div class="ml-3 text-sm font-normal" id="toast-message"></div>
            <button type="button"
                class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8"
                onclick="hideToast()">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>
    </div>

    <script src="js/works.js"></script>
</body>

</html>