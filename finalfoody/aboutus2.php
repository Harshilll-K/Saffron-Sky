<?php 
session_start();
include("connect.php");

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['fullname'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Saffron Sky</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #ffffff;
    }

    /* Navbar Styling */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      z-index: 1000;
      padding: 0 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      height: 140px;
    }

    .navbar.scrolled {
      background: rgba(255, 255, 255, 1);
      padding: 8px 20px;
    }

    /* Adjust main content to prevent overlap with fixed navbar */
    main {
      padding-top: 100px;
    }

    .nav-links {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
      width: 100%;
      max-width: 1400px;
      margin: 0 auto;
      height: 100%;
    }

    .nav-group {
      display: flex;
      align-items: center;
      gap: 2rem;
      height: 100%;
      min-width: 320px;
    }

    .nav-center {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
      margin: 0;
      height: 140px;
      min-width: 400px;
    }

    .logo-container {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
      padding: 10px;
    }

    .logo-image {
      height: 80px;
      width: auto;
      object-fit: contain;
      max-width: none;
      transform: scale(1.3);
    }

    .logo-text {
      font-size: 1.2rem;
      color: #FF7F50;
      font-weight: 600;
      text-transform: lowercase;
      letter-spacing: 1px;
    }

    .nav-links a {
      text-decoration: none;
      color: #333;
      font-weight: 600;
      padding: 8px 15px;
      transition: color 0.3s;
    }

    .nav-links a:hover {
      color: #ff4444;
    }

    .cart-button {
      background-color: #2ecc71;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 8px 16px;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
      width: 100%;
      margin-top: 15px;
    }

    .auth-btn {
      background-color: white;
      border: 2px solid #ff4444;
      color: #333;
      border-radius: 8px;
      padding: 8px 16px;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    .auth-btn:hover {
      background-color: #ff4444;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Dropdown Menu Styles */
    .menu-dropdown {
      position: relative;
      display: inline-block;
    }

    .menu-dropdown > a {
      display: inline-block;
      padding: 8px 15px;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: white;
      min-width: 250px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      border-radius: 8px;
      z-index: 1001;
      top: 100%;
      left: 0;
      padding: 8px 0;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .dropdown-content:before {
      content: '';
      position: absolute;
      top: -10px;
      left: 0;
      width: 100%;
      height: 10px;
      background: transparent;
    }

    .menu-dropdown:hover .dropdown-content {
      display: block;
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .dropdown-content a {
      color: #333;
      padding: 12px 20px;
      text-decoration: none;
      display: block;
      transition: all 0.3s ease;
      font-weight: 500;
    }

    .dropdown-content a:hover {
      background-color: #f8f9fa;
      color: #ff4444;
      padding-left: 25px;
    }

    /* Submenu Styles */
    .dropdown-submenu {
      position: relative;
    }

    .dropdown-subcontent {
      display: none;
      position: absolute;
      left: 100%;
      top: 0;
      background-color: white;
      min-width: 200px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      border-radius: 8px;
      z-index: 1002;
      padding: 8px 0;
    }

    .dropdown-submenu:hover .dropdown-subcontent {
      display: block;
    }

    .dropdown-subcontent a {
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      transition: all 0.3s ease;
    }

    .dropdown-subcontent a:hover {
      background-color: #f8f9fa;
      color: orange;
      padding-left: 24px;
    }

    .about-section {
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transform: translateY(50px);
      opacity: 0;
      transition: transform 0.6s ease, opacity 0.6s ease;
    }

    .about-section.visible {
      transform: translateY(0);
      opacity: 1;
    }
  </style>
</head>

<body>
  <!-- Navigation Bar -->
  <header class="navbar">
    <div class="nav-links">
      <div class="nav-group">
        <a href="./homepage.php">Home</a>
        <a href="./aboutus2.php">About Us</a>
        <div class="menu-dropdown">
          <a href="./menu_2.php">Menu ▾</a>
          <div class="dropdown-content">
            <a href="./starter2.php">Starters</a>
            <a href="./vegmaincourse2.php">Veg Main Course</a>
            <a href="./nonvegmaincourse2.php">Non-Veg Main Course</a>
            <a href="./ColdDrinks2.php">Cold Drinks</a>
            <a href="./Deserts2.php">Desserts</a>
            <a href="./MilkShakes2.php">Milkshakes and Icecream</a>
          </div>
        </div>
      </div>

      <div class="nav-center">
        <div class="logo-container">
          <img src="images/LogoFi.jpg" alt="Saffron Sky Logo" class="logo-image">
        </div>
      </div>

      <div class="nav-group">
        <a href="./blogs2.php">Blogs</a>
        <?php if ($isLoggedIn): ?>
          <a href="./logout.php" class="auth-btn">Logout</a>
          <span class="text-gray-700">Welcome, <?php echo htmlspecialchars($userName); ?></span>
        <?php else: ?>
          <a href="./login_page.php" class="auth-btn">Log In</a>
          <a href="./signuppage.php" class="auth-btn">Sign Up</a>
        <?php endif; ?>
        <a href="./cart_page2.php" class="hover:text-orange-500 text-xl flex items-center relative">
          🛒
          <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"></span>
        </a>
      </div>
    </div>
  </header>

  <main class="container mx-auto p-6 flex flex-col items-center" style="padding-top: 180px;">
    <!-- Centered About Image -->
    <div class="about-image flex justify-center">
      <img src="./about us.jpg" alt="About Us" class="w-80 h-80 object-cover rounded-lg shadow-md">
    </div>

    <!-- About Section -->
    <section class="about-section max-w-2xl text-center mt-6" id="about">
      <h2 class="text-2xl font-bold">About Saffron Sky</h2>
      <p class="text-lg text-justify mt-4">
        At Saffron Sky, we are passionate about delivering the finest quality food, straight to your doorstep.
        Our journey began with a simple vision—to bring restaurant-quality meals into the comfort of your home.
      </p>
      <p class="text-lg text-justify mt-4">
        We believe that good food brings people together, and our mission is to make every meal an unforgettable
        experience.
      </p>
      <h3 class="text-xl font-bold mt-6">Why Choose Saffron Sky?</h3>
      <ul class="list-none mt-4">
        <li class="bg-blue-100 p-3 rounded-lg mt-2">✔ Freshness Guaranteed – Our ingredients are handpicked daily to
          ensure the highest quality.</li>
        <li class="bg-blue-100 p-3 rounded-lg mt-2">✔ Convenience at Its Best – Enjoy gourmet meals without leaving
          your home.</li>
        <li class="bg-blue-100 p-3 rounded-lg mt-2">✔ Passion for Excellence – Our team is dedicated to delivering
          exceptional food and service.</li>
        <li class="bg-blue-100 p-3 rounded-lg mt-2">✔ Affordable Luxury – Restaurant-quality dining at prices that fit
          your budget.</li>
      </ul>
    </section>
  </main>

  <footer class="bg-gray-800 text-white py-12">
    <div class="max-w-6xl mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <h3 class="text-xl font-bold mb-4">About Saffron Sky</h3>
          <p class="text-gray-300">Delivering delicious food with love and care since 2024.</p>
        </div>
        <div>
          <h3 class="text-xl font-bold mb-4">Quick Links</h3>
          <ul class="space-y-2">
            <li><a href="./homepage.php" class="text-gray-300 hover:text-orange-500">Home</a></li>
            <li><a href="./menu.html" class="text-gray-300 hover:text-orange-500">Menu</a></li>
            <li><a href="./aboutus.html" class="text-gray-300 hover:text-orange-500">About Us</a></li>
            <li><a href="./blogs_page.html" class="text-gray-300 hover:text-orange-500">Blogs</a></li>
          </ul>
        </div>
        <div>
          <h3 class="text-xl font-bold mb-4">Contact Us</h3>
          <ul class="space-y-2 text-gray-300">
            <li>+91 1234567890</li>
            <li>info@saffronsky.com</li>
            <li>123 Food Street, City</li>
          </ul>
        </div>
        <div>
          <h3 class="text-xl font-bold mb-4">Follow Us</h3>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-300 hover:text-orange-500">Facebook</a>
            <a href="#" class="text-gray-300 hover:text-orange-500">Twitter</a>
            <a href="#" class="text-gray-300 hover:text-orange-500">Instagram</a>
          </div>
        </div>
      </div>
      <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
        <p>&copy; 2024 Saffron Sky. All rights reserved.</p>
      </div>
    </div>
  </footer>
  
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      setTimeout(() => {
        document.getElementById("about").classList.add("visible");
      }, 200);
    });
  </script>
</body>

</html>