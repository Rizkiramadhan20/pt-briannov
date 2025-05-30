<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../../../index.php");
    exit;
}
$user = $_SESSION['user'];

// Include database configuration
require_once '../../config/db.php';

// Mark all as read
$db->query("UPDATE contacts SET is_read = 1 WHERE is_read = 0");

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Get total contacts count
$total_result = $db->query("SELECT COUNT(*) as total FROM contacts");
$total_contacts = $total_result ? (int)$total_result->fetch_assoc()['total'] : 0;
$total_pages = ceil($total_contacts / $limit);

// Fetch contacts for current page
$result = $db->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
$contacts = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }
}

// Include sidebar dan header
include '../sidebar.php';
include '../header.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Contact Messages - Admin Dashboard</title>
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
    <script>
    // Initialize Flowbite
    document.addEventListener('DOMContentLoaded', function() {
        window.flowbite = window.flowbite || {};
    });
    </script>
</head>

<body class="bg-gray-50">
    <section class="ml-0 sm:ml-64 pt-16 sm:pt-20 px-4 sm:px-8 min-h-screen transition-all duration-200">
        <div class="p-6 rounded-xl bg-white shadow-lg transition-shadow duration-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="space-y-2">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Contact Messages</h2>
                    <p class="text-gray-600 text-sm sm:text-base">View and manage contact form submissions</p>
                </div>
            </div>
        </div>

        <!-- Contact Messages List -->
        <div class="mt-6">
            <?php if (empty($contacts)): ?>
            <div class="flex flex-col items-center justify-center py-12 px-4">
                <svg class="w-32 h-32 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Messages Found</h3>
                <p class="text-gray-500 text-center">No contact form submissions yet.</p>
            </div>
            <?php else: ?>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg md:overflow-visible">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Name</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Email</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Subject</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Message</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Date</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap md:whitespace-normal">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <?php echo htmlspecialchars($contact['name']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <?php echo htmlspecialchars($contact['email']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <?php echo htmlspecialchars($contact['subject']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <?php echo htmlspecialchars($contact['message']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <?php echo date('d M Y H:i', strtotime($contact['created_at'])); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap md:whitespace-normal">
                                <div class="flex items-center gap-2">
                                    <button type="button"
                                        class="view-message text-blue-600 hover:text-blue-700 transition-colors duration-200"
                                        data-id="<?php echo $contact['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($contact['name']); ?>"
                                        data-email="<?php echo htmlspecialchars($contact['email']); ?>"
                                        data-subject="<?php echo htmlspecialchars($contact['subject']); ?>"
                                        data-message="<?php echo htmlspecialchars($contact['message']); ?>"
                                        data-modal-target="viewMessageModal" data-modal-toggle="viewMessageModal">
                                        <i class='bx bx-show text-xl'></i>
                                    </button>
                                    <button type="button"
                                        class="reply-message text-green-600 hover:text-green-700 transition-colors duration-200"
                                        data-id="<?php echo $contact['id']; ?>"
                                        data-email="<?php echo htmlspecialchars($contact['email']); ?>">
                                        <i class='bx bx-reply text-xl'></i>
                                    </button>
                                    <button type="button"
                                        class="delete-message text-red-600 hover:text-red-700 transition-colors duration-200"
                                        data-id="<?php echo $contact['id']; ?>" data-modal-target="deleteMessageModal"
                                        data-modal-toggle="deleteMessageModal">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="flex justify-center mt-6">
                <nav class="inline-flex -space-x-px text-sm">
                    <!-- Prev -->
                    <a href="?page=<?php echo max(1, $page-1); ?>"
                        class="px-3 py-2 ml-0 leading-tight text-gray-600 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 <?php if($page==1) echo 'opacity-50 pointer-events-none'; ?>">&laquo;
                        Prev</a>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>"
                        class="px-3 py-2 leading-tight border border-gray-300 <?php echo $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                    <!-- Next -->
                    <a href="?page=<?php echo min($total_pages, $page+1); ?>"
                        class="px-3 py-2 leading-tight text-gray-600 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 <?php if($page==$total_pages) echo 'opacity-50 pointer-events-none'; ?>">Next
                        &raquo;</a>
                </nav>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- View Message Modal -->
        <div id="viewMessageModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Message Details
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="viewMessageModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Name</label>
                                <p class="mt-1 text-gray-900" id="view-name"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Email</label>
                                <p class="mt-1 text-gray-900" id="view-email"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Subject</label>
                                <p class="mt-1 text-gray-900" id="view-subject"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Message</label>
                                <p class="mt-1 text-gray-900 whitespace-pre-wrap" id="view-message"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Message Modal -->
        <div id="deleteMessageModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Delete Message
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="deleteMessageModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Are you sure you want to delete this message? This action cannot
                            be
                            undone.</p>
                        <div class="flex items-center justify-end space-x-2">
                            <button type="button" data-modal-hide="deleteMessageModal"
                                class="text-gray-600 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cancel</button>
                            <button type="button" id="confirmDelete"
                                class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
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
            <div id="toast-icon"
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

    <script src="js/contact.js"></script>
</body>

</html>