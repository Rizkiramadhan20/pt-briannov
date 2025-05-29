<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Fixed Header -->
<header class="fixed-header py-4 w-full" x-data="{ mobileMenuOpen: false }">
  <nav class="container mx-auto px-4 flex justify-between items-center">
    <a href="/index.php" class="text-xl font-bold">Kreasi Digital</a>
    
    <!-- Desktop Navigation -->
    <ul class="hidden md:flex item-center gap-4">
      <li>
        <a href="/" class="hover:text-blue-600">Home</a>
      </li>
      <li>
        <a href="#about" class="hover:text-blue-600">About Us</a>
      </li>
      <li>
        <a href="#" class="hover:text-blue-600">Services</a>
      </li>
      <li>
        <a href="#" class="hover:text-blue-600">Portofolio</a>
      </li>
      <li>
        <a href="#" class="hover:text-blue-600">Pricing</a>
      </li>
    </ul>

    <!-- Mobile Navigation -->
    <div class="md:hidden">
      <!-- Mobile Menu Overlay -->
      <div 
        x-show="mobileMenuOpen" 
        class="fixed inset-0 bg-black bg-opacity-50 z-40"
        @click="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
      ></div>

      <!-- Mobile Menu Panel -->
      <div 
        x-show="mobileMenuOpen"
        class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg z-50 transform transition-transform duration-300"
        :class="mobileMenuOpen ? 'translate-x-0' : 'translate-x-full'"
        @click.away="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
      >
        <div class="p-4">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Menu</h2>
            <button @click="mobileMenuOpen = false" class="text-gray-500 hover:text-gray-700">
              <span class="material-icons">close</span>
            </button>
          </div>
          <ul class="space-y-2">
            <li>
              <a href="/" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">Home</a>
            </li>
            <li>
              <a href="#about" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">About</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">Service</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">Portofolio</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">Pricing</a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Desktop Button -->
    <div class="hidden md:block">
      <a
        href="/compon/login.php"
        class="border border-gray-400 text-gray-600 px-4 py-2 rounded-full hover:bg-gray-100"
        >Let's Talk</a
      >
    </div>

    <!-- Mobile Menu and Button -->
    <div class="flex items-center gap-2 md:hidden">
      <a
        href="/login.php"
        class="border border-gray-400 text-gray-600 px-3 py-1 rounded-full hover:bg-gray-100"
        >Login</a
      >
      
      <!-- Mobile menu button -->
      <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-700">
        <span class="material-icons">menu</span>
      </button>
    </div>
  </nav>
</header>

<link
  href="https://fonts.googleapis.com/icon?family=Material+Icons"
  rel="stylesheet"
/>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
