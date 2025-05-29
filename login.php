<?php
session_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header("Location: dashboard/dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {}
        }
      }
    </script>
  </head>
  <body class="bg-gray-100 min-h-screen">
    <section class="flex min-h-screen">
      <!-- Left: Login Form -->
      <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="w-full max-w-md space-y-8">
          <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
            <p class="mt-2 text-gray-600">Sign in to continue to your account</p>
          </div>
          
          <?php if (isset($_GET['error'])): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <?php echo htmlspecialchars($_GET['error']); ?>
          </div>
          <?php endif; ?>

          <?php if (isset($_GET['success'])): ?>
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <?php echo htmlspecialchars($_GET['success']); ?>
          </div>
          <?php endif; ?>

          <form action="process.php" method="POST" class="mt-8 space-y-6">
            <div class="space-y-4">
              <input type="email" name="email" placeholder="Email" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
              <input type="password" name="password" placeholder="Password" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
            </div>
            <button type="submit" name="login" 
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
              Sign In
            </button>
          </form>
          
          <div class="text-center mt-4">
            <p class="text-gray-600">
              Don't have an account? 
              <a href="register.php" class="font-medium text-blue-600 hover:text-blue-500">
                Sign up
              </a>
            </p>
          </div>
        </div>
      </div>

      <!-- Right: Image/Info -->
      <div class="hidden lg:block lg:w-1/2 relative">
        <img src="assets/login.jpg" alt="Art" class="absolute inset-0 w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
          <div class="text-center text-white p-8">
            <h2 class="text-3xl font-bold mb-4">Welcome to our community</h2>
            <p class="text-lg">Sign in to access your account and start sharing your photos</p>
          </div>
        </div>
      </div>
    </section>
  </body>
</html> 