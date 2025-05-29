<?php
// Sidebar Dashboard
?>
<!-- Mobile sidebar backdrop -->
<div id="sidebar-mobile-backdrop" class="fixed inset-0 z-30 hidden bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300"></div>

<!-- Sidebar -->
<aside id="sidebar-mobile" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform duration-300 ease-in-out -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-[#181A20] border-r border-gray-700">
        <!-- Logo and Close Button -->
        <div class="flex items-center justify-between mb-8 px-2">
            <div class="flex items-center gap-2">
                <img src="/assets/login.jpg" alt="Logo" class="w-10 h-10 rounded-full object-cover" />
                <span class="text-xl font-bold tracking-wide text-white">Stakemint</span>
            </div>
            <button type="button" class="inline-flex items-center p-2 text-sm text-gray-400 rounded-lg sm:hidden hover:bg-[#23263A] focus:outline-none focus:ring-2 focus:ring-gray-600" data-drawer-hide="sidebar-mobile" aria-controls="sidebar-mobile">
                <span class="material-icons">close</span>
            </button>
        </div>

        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <span class="material-icons text-gray-400">search</span>
                </div>
                <input type="text" class="bg-[#23263A] border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search...">
            </div>
        </div>

        <!-- Navigation -->
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/compon/dashboard/dashboard.php" class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'bg-[#23263A]' : '' ?>">
                    <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">dashboard</span>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/compon/dashboard/home/home.php" class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'home.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">home</span>
                    <span class="ml-3">Home</span>
                </a>
            </li>

            <li>
                <a href="/compon/dashboard/partner/partner.php" class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'partner.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">home</span>
                    <span class="ml-3">Partner</span>
                </a>
            </li>
            
            <li>
                <a href="/compon/dashboard/about/about.php" class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'about.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">info</span>
                    <span class="ml-3">About</span>
                </a>
            </li>
            <li>
                <a href="/compon/dashboard/count/count.php" class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'count.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">numbers</span>
                    <span class="ml-3">Count</span>
                </a>
            </li>
            <li>
                <a href="/compon/dashboard/services/services.php" class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'services.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">miscellaneous_services</span>
                    <span class="ml-3">Services</span>
                </a>
            </li>
            <li>
                <a href="/compon/dashboard/customers/customers.php" class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'customers.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">people</span>
                    <span class="ml-3">Customers</span>
                </a>
            </li>
          
            <li>
                <button type="button" class="flex items-center w-full p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200" aria-controls="dropdown-staking" data-collapse-toggle="dropdown-staking">
                    <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">bar_chart</span>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Accounts</span>
                    <span class="material-icons text-gray-400 group-hover:text-white transition-transform duration-200">expand_more</span>
                </button>
                <ul id="dropdown-staking" class="hidden py-2 space-y-2 transition-all duration-200">
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-white transition duration-200 rounded-lg pl-11 group hover:bg-[#23263A]">
                            <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">admin_panel_settings</span>
                            <span class="ml-3">Admins</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-white transition duration-200 rounded-lg pl-11 group hover:bg-[#23263A]">
                            <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">group</span>
                            <span class="ml-3">Users</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <button type="button" class="flex items-center w-full p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200" aria-controls="dropdown-settings" data-collapse-toggle="dropdown-settings">
                    <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">settings</span>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Settings</span>
                    <span class="material-icons text-gray-400 group-hover:text-white transition-transform duration-200">expand_more</span>
                </button>
                <ul id="dropdown-settings" class="hidden py-2 space-y-2 transition-all duration-200">
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-white transition duration-200 rounded-lg pl-11 group hover:bg-[#23263A]">
                            <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">person</span>
                            <span class="ml-3">Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-white transition duration-200 rounded-lg pl-11 group hover:bg-[#23263A]">
                            <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">security</span>
                            <span class="ml-3">Security</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-white transition duration-200 rounded-lg pl-11 group hover:bg-[#23263A]">
                            <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">notifications</span>
                            <span class="ml-3">Notifications</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Bottom Section -->
        <div class="pt-4 mt-4 space-y-2 border-t border-gray-700">
            <a href="#" class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200">
                <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">help_outline</span>
                <span class="ml-3">Help Center</span>
            </a>
            <a href="../logout.php" class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200">
                <span class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">logout</span>
                <span class="ml-3">Logout</span>
            </a>
        </div>
    </div>
</aside>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 