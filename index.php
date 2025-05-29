<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Kreasi Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {}
        }
      }
    </script>
  </head>
  <body>
    <?php include 'components/header/header.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <div class="split-container">
        <div class="welcome-section">
          <h1>Welcome to Our Website</h1>
          <?php if (isset($_SESSION['user'])): ?>
              <p>Hello, <?= htmlspecialchars($_SESSION['user']['fullname']) ?>!</p>
              <a href="logout.php" class="btn">Logout</a>
          <?php else: ?>
              <p>Please login to continue</p>
              <a href="login.php" class="btn">Login</a>
              <a href="register.php" class="btn">Register</a>
          <?php endif; ?>
        </div>
      </div>
    </main>

    <!-- Fixed Footer -->
    <footer class="fixed-footer">
      <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
          <div>&copy; 2024 Your Website. All rights reserved.</div>
          <div class="space-x-4">
            <a href="#" class="hover:text-blue-600">Privacy Policy</a>
            <a href="#" class="hover:text-blue-600">Terms of Service</a>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html> 