<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
$user = $_SESSION['user'];
// Include sidebar dan header
include 'sidebar.php';
include 'header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
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
            <h1 class="text-xl sm:text-2xl font-bold text-white mb-2">Selamat datang Admin, <?= htmlspecialchars($user['fullname']) ?>!</h1>
            <p class="text-sm sm:text-base text-[#A3A6B1]">Ini adalah halaman khusus untuk admin.</p>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 sm:mb-8">
            <div class="bg-[#23263A] rounded-lg shadow p-4 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-8 w-8 rounded-lg bg-blue-600 text-white">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-400">Total Users</h2>
                        <p class="text-xl sm:text-2xl font-semibold text-white">2,450</p>
                    </div>
                </div>
            </div>
            <div class="bg-[#23263A] rounded-lg shadow p-4 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-8 w-8 rounded-lg bg-green-600 text-white">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-400">Active Staking</h2>
                        <p class="text-xl sm:text-2xl font-semibold text-white">1,250</p>
                    </div>
                </div>
            </div>
            <div class="bg-[#23263A] rounded-lg shadow p-4 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-8 w-8 rounded-lg bg-yellow-600 text-white">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-400">Total Volume</h2>
                        <p class="text-xl sm:text-2xl font-semibold text-white">$45,250</p>
                    </div>
                </div>
            </div>
            <div class="bg-[#23263A] rounded-lg shadow p-4 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-8 w-8 rounded-lg bg-purple-600 text-white">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-400">Rewards</h2>
                        <p class="text-xl sm:text-2xl font-semibold text-white">$12,500</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Crypto Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-[#23263A] rounded-xl p-4 sm:p-6 shadow hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-white">show_chart</span>
                        <h3 class="text-white font-medium">Ethereum (ETH)</h3>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">+2.85%</span>
                </div>
                <div class="text-2xl sm:text-3xl font-bold text-white mb-2">13.62%</div>
                <div class="text-green-400 text-sm">$2,450.00</div>
            </div>
            <div class="bg-[#23263A] rounded-xl p-4 sm:p-6 shadow hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-white">show_chart</span>
                        <h3 class="text-white font-medium">BNB Chain</h3>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">+5.87%</span>
                </div>
                <div class="text-2xl sm:text-3xl font-bold text-white mb-2">12.72%</div>
                <div class="text-green-400 text-sm">$1,850.00</div>
            </div>
            <div class="bg-[#23263A] rounded-xl p-4 sm:p-6 shadow hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-white">show_chart</span>
                        <h3 class="text-white font-medium">Polygon (Matic)</h3>
                    </div>
                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">-0.98%</span>
                </div>
                <div class="text-2xl sm:text-3xl font-bold text-white mb-2">6.29%</div>
                <div class="text-red-400 text-sm">$950.00</div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-[#23263A] rounded-xl shadow p-4 sm:p-6 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg sm:text-xl font-bold text-white">Recent Activity</h2>
                <button class="text-sm text-blue-500 hover:text-blue-400">View All</button>
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs text-gray-400 uppercase bg-[#1E2028]">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-3">User</th>
                            <th scope="col" class="px-4 sm:px-6 py-3">Action</th>
                            <th scope="col" class="px-4 sm:px-6 py-3">Amount</th>
                            <th scope="col" class="px-4 sm:px-6 py-3">Status</th>
                            <th scope="col" class="px-4 sm:px-6 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-700 hover:bg-[#1E2028] transition-colors duration-200">
                            <td class="px-4 sm:px-6 py-4">John Doe</td>
                            <td class="px-4 sm:px-6 py-4">Staking ETH</td>
                            <td class="px-4 sm:px-6 py-4">2.5 ETH</td>
                            <td class="px-4 sm:px-6 py-4"><span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Completed</span></td>
                            <td class="px-4 sm:px-6 py-4">2024-02-20</td>
                        </tr>
                        <tr class="border-b border-gray-700 hover:bg-[#1E2028] transition-colors duration-200">
                            <td class="px-4 sm:px-6 py-4">Jane Smith</td>
                            <td class="px-4 sm:px-6 py-4">Unstaking BNB</td>
                            <td class="px-4 sm:px-6 py-4">15 BNB</td>
                            <td class="px-4 sm:px-6 py-4"><span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Pending</span></td>
                            <td class="px-4 sm:px-6 py-4">2024-02-19</td>
                        </tr>
                        <tr class="border-b border-gray-700 hover:bg-[#1E2028] transition-colors duration-200">
                            <td class="px-4 sm:px-6 py-4">Mike Johnson</td>
                            <td class="px-4 sm:px-6 py-4">Staking MATIC</td>
                            <td class="px-4 sm:px-6 py-4">5000 MATIC</td>
                            <td class="px-4 sm:px-6 py-4"><span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Completed</span></td>
                            <td class="px-4 sm:px-6 py-4">2024-02-18</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html> 