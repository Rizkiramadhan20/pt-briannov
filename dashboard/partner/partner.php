<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}
$user = $_SESSION['user'];
// Include sidebar dan header
include '../sidebar.php';
include '../header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Partner - Admin Dashboard</title>
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
<body class="bg-[#181A20]">
    <main class="ml-0 sm:ml-64 pt-16 sm:pt-20 px-4 sm:px-8 min-h-screen transition-all duration-200">
        <div class="mb-6 sm:mb-8">
            <h1 class="text-xl sm:text-2xl font-bold text-white mb-2">Home Page</h1>
            <p class="text-sm sm:text-base text-[#A3A6B1]">Welcome to the home page.</p>
        </div>

        <!-- Your home page content here -->
        <div class="bg-[#23263A] rounded-xl shadow p-4 sm:p-6 hover:shadow-lg transition-shadow duration-200">
            <h2 class="text-lg sm:text-xl font-bold text-white mb-4">Home Content</h2>
            <p class="text-gray-400">This is your home page content.</p>
        </div>
    </main>
</body>
</html>