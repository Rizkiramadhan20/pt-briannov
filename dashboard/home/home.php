<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../../../index.php");
    exit;
}
$user = $_SESSION['user'];

// Include database configuration
require_once '../../config/db.php';

// Fetch all content
$result = $db->query("SELECT * FROM home ORDER BY created_at DESC");
$contents = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['framework'] = json_decode($row['framework'], true);
        $contents[] = $row;
    }
}

// Include sidebar dan header
include '../sidebar.php';
include '../header.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home - Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/assets/logo.png">
    <!-- Preload critical resources -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" as="style">
    <link rel="preload" href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css" as="style">

    <!-- Load styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>

    <!-- Load Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js" defer></script>
</head>

<body class="bg-gray-50">
    <section class="ml-0 sm:ml-64 pt-16 sm:pt-20 px-4 sm:px-8 min-h-screen transition-all duration-200">
        <div class="p-6 rounded-xl bg-white shadow-lg transition-shadow duration-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="space-y-2">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Home Content</h2>
                    <p class="text-gray-600 text-sm sm:text-base">Manage and organize your home page content efficiently
                    </p>
                </div>

                <?php if (empty($contents)): ?>
                <button data-modal-target="createContentModal" data-modal-toggle="createContentModal"
                    class="inline-flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none transition-colors duration-200">
                    <i class='bx bx-plus text-xl'></i>
                    Create Content
                </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Content List -->
        <div class="mt-6">
            <?php if (empty($contents)): ?>
            <div class="flex flex-col items-center justify-center py-12 px-4">
                <svg class="w-32 h-32 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Content Found</h3>
                <p class="text-gray-500 text-center mb-4">Start by creating your first content to display here.</p>
                <button data-modal-target="createContentModal" data-modal-toggle="createContentModal"
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none transition-colors duration-200">
                    Create Your First Content
                </button>
            </div>
            <?php else: ?>
            <div class="relative shadow-md sm:rounded-lg overflow-x-auto md:overflow-visible">
                <table class="min-w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap md:whitespace-normal">Title</th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap md:whitespace-normal">Text</th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap md:whitespace-normal">Description</th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap md:whitespace-normal">Frameworks</th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap md:whitespace-normal">Label</th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap md:whitespace-normal">Link</th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap md:whitespace-normal">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contents as $content): ?>
                        <tr class="border-b border-gray-200 bg-white hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap md:whitespace-normal">
                                <?php echo htmlspecialchars($content['title']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <?php echo htmlspecialchars($content['text']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <?php echo htmlspecialchars($content['description']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <div class="flex flex-wrap gap-1">
                                    <?php foreach ($content['framework'] as $framework): ?>
                                    <span
                                        class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium border border-blue-200">
                                        <?php echo htmlspecialchars($framework); ?>
                                    </span>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs">
                                    <?php echo htmlspecialchars($content['labels']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <a href="<?php echo htmlspecialchars($content['href']); ?>" target="_blank"
                                    class="text-blue-600 hover:text-blue-500 transition-colors duration-200 flex items-center gap-1">
                                    <span>Visit</span>
                                    <i class='bx bx-link-external'></i>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <div class="flex gap-2">
                                    <button type="button"
                                        class="edit-content text-blue-600 hover:text-blue-500 transition-colors duration-200"
                                        data-id="<?php echo $content['id']; ?>" data-modal-target="editContentModal"
                                        data-modal-toggle="editContentModal">
                                        <i class='bx bx-edit text-xl'></i>
                                    </button>
                                    <button type="button"
                                        class="delete-content text-red-600 hover:text-red-500 transition-colors duration-200"
                                        data-id="<?php echo $content['id']; ?>" data-modal-target="deleteContentModal"
                                        data-modal-toggle="deleteContentModal">
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

        <!-- Modal -->
        <div id="createContentModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Create New Content
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="createContentModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form id="createContentForm" class="p-6">
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                            <input type="text" id="title" name="title"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-700">Text</label>
                            <input type="text" id="text" name="text"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required></textarea>
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Frameworks (Max 6)</label>
                            <div id="frameworkContainer" class="space-y-2">
                                <div class="flex gap-2">
                                    <input type="text"
                                        class="framework-input bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Enter framework">
                                    <button type="button"
                                        class="add-framework text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div id="frameworkList" class="mt-2 flex flex-wrap gap-2"></div>
                        </div>
                        <div class="mb-6">
                            <label for="labels" class="block mb-2 text-sm font-medium text-gray-700">Label</label>
                            <input type="text" id="labels" name="labels"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Enter label" required>
                        </div>
                        <div class="mb-6">
                            <label for="href" class="block mb-2 text-sm font-medium text-gray-700">URL</label>
                            <input type="url" id="href" name="href"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div class="flex items-center justify-end space-x-2">
                            <button type="button" data-modal-hide="createContentModal"
                                class="text-gray-700 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cancel</button>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editContentModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Edit Content
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="editContentModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form id="editContentForm" class="p-6">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-6">
                            <label for="edit_title" class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                            <input type="text" id="edit_title" name="title"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="edit_text" class="block mb-2 text-sm font-medium text-gray-700">Text</label>
                            <input type="text" id="edit_text" name="text"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div class="mb-6">
                            <label for="edit_description"
                                class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                            <textarea id="edit_description" name="description" rows="4"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required></textarea>
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Frameworks (Max 6)</label>
                            <div id="editFrameworkContainer" class="space-y-2">
                                <div class="flex gap-2">
                                    <input type="text"
                                        class="edit-framework-input bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Enter framework">
                                    <button type="button"
                                        class="edit-add-framework text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div id="editFrameworkList" class="mt-2 flex flex-wrap gap-2"></div>
                        </div>
                        <div class="mb-6">
                            <label for="edit_labels" class="block mb-2 text-sm font-medium text-gray-700">Label</label>
                            <input type="text" id="edit_labels" name="labels"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Enter label" required>
                        </div>
                        <div class="mb-6">
                            <label for="edit_href" class="block mb-2 text-sm font-medium text-gray-700">URL</label>
                            <input type="url" id="edit_href" name="href"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div class="flex items-center justify-end space-x-2">
                            <button type="button" data-modal-hide="editContentModal"
                                class="text-gray-700 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cancel</button>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div id="deleteContentModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Delete Content
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="deleteContentModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Are you sure you want to delete this content? This action cannot
                            be undone.</p>
                        <div class="flex items-center justify-end space-x-2">
                            <button type="button" data-modal-hide="deleteContentModal"
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

    <script src="js/home.js"></script>
</body>

</html>