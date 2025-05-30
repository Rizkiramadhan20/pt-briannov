<?php
// Sidebar Dashboard
?>
<!-- Mobile sidebar backdrop -->
<div id="sidebar-mobile-backdrop"
    class="fixed inset-0 z-30 hidden bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300"></div>

<!-- Sidebar -->
<aside id="sidebar-mobile"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform duration-300 ease-in-out -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-[#181A20] border-r border-gray-700">
        <!-- Logo and Close Button -->
        <div class="flex items-center justify-between mb-8 px-2">
            <div class="flex items-center gap-2">
                <img src="/assets/login.jpg" alt="Logo" class="w-10 h-10 rounded-full object-cover" />
                <span class="text-xl font-bold tracking-wide text-white">Stakemint</span>
            </div>
            <button type="button"
                class="inline-flex items-center p-2 text-sm text-gray-400 rounded-lg sm:hidden hover:bg-[#23263A] focus:outline-none focus:ring-2 focus:ring-gray-600"
                data-drawer-hide="sidebar-mobile" aria-controls="sidebar-mobile">
                <span class="material-icons">close</span>
            </button>
        </div>

        <!-- Navigation -->
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/dashboard/dashboard.php"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'bg-[#23263A]' : '' ?>">
                    <span
                        class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">dashboard</span>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/dashboard/home/home.php"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'home.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span
                        class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">house</span>
                    <span class="ml-3">Home</span>
                </a>
            </li>

            <li>
                <a href="/dashboard/partner/partner.php"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'partner.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span
                        class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">handshake</span>
                    <span class="ml-3">Partner</span>
                </a>
            </li>

            <li>
                <a href="/dashboard/timeline/timeline.php"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'timeline.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span
                        class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">schedule</span>
                    <span class="ml-3">Timeline</span>
                </a>
            </li>
            <li>
                <a href="/dashboard/works/works.php"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'works.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span
                        class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">work</span>
                    <span class="ml-3">Works</span>
                </a>
            </li>
            <li>
                <a href="/dashboard/projects/projects.php"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'projects.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span
                        class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">folder</span>
                    <span class="ml-3">Projects</span>
                </a>
            </li>
            <li>
                <a href="/dashboard/inspiration/inspiration.php"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'inspiration.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span
                        class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">lightbulb</span>
                    <span class="ml-3">Inspiration</span>
                </a>
            </li>

            <li>
                <a href="/dashboard/testimonials/testimonials.php"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200 <?= strpos($_SERVER['PHP_SELF'], 'testimonials.php') !== false ? 'bg-[#23263A]' : '' ?>">
                    <span
                        class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">format_quote</span>
                    <span class="ml-3">Testimonials</span>
                </a>
            </li>

            <!-- Bottom Section -->
            <div class="pt-4 mt-4 space-y-2 border-t border-gray-700">
                <a href="/dashboard/contact/contact.php"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200">
                    <span
                        class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">help_outline</span>
                    <span class="ml-3">Contact</span>
                </a>
                <a href="/logout.php"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-[#23263A] group transition-all duration-200">
                    <span
                        class="material-icons text-gray-400 group-hover:text-white transition-colors duration-200">logout</span>
                    <span class="ml-3">Logout</span>
                </a>
            </div>
        </ul>
    </div>
</aside>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">