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
    <title>Menu Categories - Saffron Sky</title>
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

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 20px;
            height: 100vh;
            background: url('./images/hbg2.webp') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            gap: 20px;
        }

        .hero-text {
            max-width: 900px;
            text-align: center;
            position: relative;
            z-index: 1;
            color: black;
        }

        /* Menu Section */
        .menu-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            width: 180px;
        }

        .menu-item img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .menu-item:hover img {
            transform: scale(1.1);
        }

        /* Blog and Auth Button Alignment */
        .nav-buttons {
            display: flex;
            align-items: center;
            gap: 15px;
        }
    </style>





    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        .header {
            background-color: #fff;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            margin-bottom: 40px;
            padding-top: 160px;
            color: #333;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .menu-box {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            aspect-ratio: 1 / 1;
        }

        .menu-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .menu-box a {
            color: inherit;
            text-decoration: none;
            display: block;
            height: 100%;
        }

        .menu-image {
            height: 100%;
            overflow: hidden;
        }

        .menu-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .menu-box:hover .menu-image img {
            transform: scale(1.05);
        }

        .menu-title {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .special-tag {
            position: absolute;
            top: 0;
            left: 0;
            background-color: #e74c3c;
            color: white;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: bold;
            z-index: 1;
        }

        .footer {
            text-align: center;
            padding: 30px 0;
            margin-top: 60px;
            background-color: #333;
            color: #fff;
        }

        .auth-btn {
            background-color: rgba(255, 255, 255, 0.8);
            border: 2px solid red;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: bold;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .auth-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 28px;
            }
        }

        .menu-categories {
            padding-bottom: 120px;
        }
    </style>
</head>

<body class="bg-gray-100">
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
                    <img src="./images/LogoFi.jpg" alt="Saffron Sky Logo" class="logo-image">
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

    <main>
        <section class="menu-categories">
            <div class="container">
                <h2 class="section-title">Our Menu</h2>

                <div class="menu-grid">
                    <!-- Row 1 -->
                    <!-- Menu Item 1 -->
                    <div class="menu-box">
                        <a href="starter2.php">
                            <div class="menu-image">
                                <!-- Replace with your image path -->
                                <img src="./images/home menu/starter.webp" alt="Together Combos">
                            </div>
                            <div class="menu-title">Starters</div>
                            <div class="special-tag">Starters at just ₹299 only</div>
                        </a>
                    </div>

                    <!-- Menu Item 2 -->
                    <div class="menu-box">
                        <a href="vegmaincourse2.php">
                            <div class="menu-image">
                                <!-- Replace with your image path -->
                                <img src="./images/home menu/veg main course.jpg" alt="Comfort Meals">
                            </div>
                            <div class="menu-title">Veg Main Course</div>
                        </a>
                    </div>

                    <!-- Menu Item 3 -->
                    <div class="menu-box">
                        <a href="nonvegmaincourse2.php">
                            <div class="menu-image">
                                <!-- Replace with your image path -->
                                <img src="./images/home menu/non veg main course.avif" alt="All-In-1 Meals">
                            </div>
                            <div class="menu-title">Non-Veg Main Course</div>
                        </a>
                    </div>

                    <!-- Row 2 -->
                    <!-- Menu Item 4 -->
                    <div class="menu-box">
                        <a href="ColdDrinks2.php">
                            <div class="menu-image">
                                <!-- Replace with your image path -->
                                <img src="./images/home menu/cold drinks.jpg" alt="Mini Meals">
                            </div>
                            <div class="menu-title">Cold Drinks</div>
                        </a>
                    </div>

                    <!-- Menu Item 5 -->
                    <div class="menu-box">
                        <a href="Deserts2.php">
                            <div class="menu-image">
                                <!-- Replace with your image path -->
                                <img src="./images/home menu/dessert.jpg" alt="Desi Box">
                            </div>
                            <div class="menu-title">Deserts</div>
                        </a>
                    </div>

                    <!-- Menu Item 6 -->
                    <div class="menu-box">
                        <a href="MilkShakes2.php">
                            <div class="menu-image">
                                <!-- Replace with your image path -->
                                <img src="./images/home menu/milkshake and ice cream.webp" alt="Dum Biryani">
                            </div>
                            <div class="menu-title">MilkShakes and Ice-Cream</div>
                        </a>
                    </div>
                </div>
            </div>
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
                <li><a href="./menu_2.php" class="text-gray-300 hover:text-orange-500">Menu</a></li>
                <li><a href="./aboutus2.php" class="text-gray-300 hover:text-orange-500">About Us</a></li>
                <li><a href="./blogs2.php" class="text-gray-300 hover:text-orange-500">Blogs</a></li>
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
</body>
</html>