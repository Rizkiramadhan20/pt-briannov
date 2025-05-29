<?php
// Header Dashboard
if (!isset($user)) {
    session_start();
    $user = $_SESSION['user'] ?? null;
}
?>
<header class="fixed top-0 right-0 left-0 sm:left-64 z-30">
    <nav class="bg-[#23263A] border-b border-gray-700 px-4 py-2.5">
        <div class="flex flex-wrap justify-between items-center">
            <div class="flex justify-start items-center">
                <button data-drawer-target="sidebar-mobile" data-drawer-toggle="sidebar-mobile" aria-controls="sidebar-mobile" type="button" class="inline-flex items-center p-2 text-sm text-gray-400 rounded-lg sm:hidden hover:bg-[#1E2028] focus:outline-none focus:ring-2 focus:ring-gray-600">
                    <span class="material-icons">menu</span>
                </button>
                <span class="self-center text-xl font-semibold whitespace-nowrap text-white ml-4">Dashboard</span>
            </div>
            <div class="flex items-center lg:order-2 gap-2">
                <!-- Notifications -->
                <button type="button" data-dropdown-toggle="notification-dropdown" class="p-2 text-gray-400 rounded-lg hover:text-white hover:bg-[#1E2028] focus:outline-none focus:ring-2 focus:ring-gray-600 relative">
                    <span class="material-icons">notifications</span>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">2</span>
                </button>
                <!-- Dropdown menu -->
                <div class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-[#23263A] rounded-lg divide-y divide-gray-700 shadow-lg" id="notification-dropdown">
                    <div class="block py-2 px-4 text-base font-medium text-center text-gray-400 bg-[#1E2028]">
                        Notifications
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        <a href="#" class="flex py-3 px-4 border-b border-gray-700 hover:bg-[#1E2028] transition-colors duration-200">
                            <div class="flex-shrink-0">
                                <span class="material-icons text-blue-500">account_balance_wallet</span>
                            </div>
                            <div class="pl-3 w-full">
                                <div class="text-gray-400 text-sm mb-1.5">New staking reward received</div>
                                <div class="text-xs text-gray-400">2 minutes ago</div>
                            </div>
                        </a>
                        <a href="#" class="flex py-3 px-4 border-b border-gray-700 hover:bg-[#1E2028] transition-colors duration-200">
                            <div class="flex-shrink-0">
                                <span class="material-icons text-green-500">trending_up</span>
                            </div>
                            <div class="pl-3 w-full">
                                <div class="text-gray-400 text-sm mb-1.5">ETH price increased by 5%</div>
                                <div class="text-xs text-gray-400">1 hour ago</div>
                            </div>
                        </a>
                    </div>
                    <a href="#" class="block py-2 text-sm font-medium text-center text-gray-400 hover:bg-[#1E2028] transition-colors duration-200">
                        <div class="inline-flex items-center">
                            View all
                        </div>
                    </a>
                </div>

                <!-- Profile -->
                <button type="button" class="flex text-sm bg-[#1E2028] rounded-lg md:mr-0 focus:ring-4 focus:ring-gray-600 hover:bg-[#2A2D3A] transition-colors duration-200" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <div class="flex items-center gap-2 px-4 py-2">
                        <span class="material-icons text-gray-400">account_circle</span>
                        <span class="text-white font-medium hidden sm:inline"><?= htmlspecialchars($user['fullname'] ?? 'Admin') ?></span>
                    </div>
                </button>
                <!-- Dropdown menu -->
                <div class="hidden z-50 my-4 text-base list-none bg-[#23263A] rounded-lg divide-y divide-gray-700 shadow-lg" id="user-dropdown">
                    <div class="py-3 px-4">
                        <span class="block text-sm text-white"><?= htmlspecialchars($user['fullname'] ?? 'Admin') ?></span>
                        <span class="block text-sm text-gray-400 truncate"><?= htmlspecialchars($user['email'] ?? 'admin@example.com') ?></span>
                    </div>
                    <ul class="py-1" aria-labelledby="user-menu-button">
                        <li>
                            <a href="#" class="flex items-center py-2 px-4 text-sm text-gray-400 hover:bg-[#1E2028] transition-colors duration-200">
                                <span class="material-icons text-sm mr-2">person</span>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-2 px-4 text-sm text-gray-400 hover:bg-[#1E2028] transition-colors duration-200">
                                <span class="material-icons text-sm mr-2">settings</span>
                                Settings
                            </a>
                        </li>
                        <li>
                            <a href="/logout.php" class="flex items-center py-2 px-4 text-sm text-gray-400 hover:bg-[#1E2028] transition-colors duration-200">
                                <span class="material-icons text-sm mr-2">logout</span>
                                Sign out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 