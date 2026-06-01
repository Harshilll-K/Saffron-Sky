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
    <title>Restaurant Menu - Veg Main Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            margin-bottom: 40px;
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
            margin-bottom: 20px;
            color: #333;
        }

        .section-subtitle {
            text-align: center;
            font-size: 18px;
            margin-bottom: 40px;
            color: #666;
        }

        .menu-category {
            margin-bottom: 60px;
        }

        .category-title {
            font-size: 30px;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
            color: #333;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }

        .auth-btn {
            background-color: rgba(255, 255, 255, 0.8);
            border: 2px solid orange;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: bold;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .auth-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .menu-item {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .menu-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .item-image {
            height: 200px;
            background-color: #eee;
            position: relative;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-info {
            padding: 20px;
        }

        .item-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .item-price {
            font-size: 18px;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 10px;
        }

        .item-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
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
        }

        .cart-button:hover {
            background-color: #27ae60;
        }

        .footer {
            text-align: center;
            padding: 30px 0;
            margin-top: 60px;
            background-color: #333;
            color: #fff;
        }

        @media (max-width: 992px) {
            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        #cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            display: none;
        }

        /* Navbar Styling */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: white;
            z-index: 1000;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nav-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .nav-group {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-center {
            display: flex;
            align-items: center;
            justify-content: center;
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

        .nav-link {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #FF4444;
        }

        .nav-link.active {
            color: #FF4444;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .profile-circle {
            width: 40px;
            height: 40px;
            background: #FF4444;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .cart-icon {
            font-size: 1.5rem;
            color: #333;
            text-decoration: none;
            position: relative;
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
    </style>
</head>

<body>

    <body class="bg-gray-100">

        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="nav-links">
                <!-- Left Links -->
                <div class="nav-group">
                    <a href="./homepage.php" class="nav-link active">Home</a>
                    <a href="./aboutus2.php" class="nav-link">About Us</a>
                    <div class="menu-dropdown">
                        <a href="./menu_2.php" class="nav-link">Menu</a>
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

                <!-- Centered Logo -->
                <div class="nav-center">
                    <div class="logo-container">
                        <img src="./images/LogoFi.jpg" alt="Saffron Sky Logo" class="logo-image">
                    </div>
                </div>

                <!-- Right Links -->
                <div class="nav-group">
                    <a href="./blogs2.php" class="nav-link">Blogs</a>
                    <div class="user-profile">
                        <div class="profile-circle"><?php echo $isLoggedIn ? substr($userName, 0, 1) : ''; ?></div>
                        <span><?php echo $isLoggedIn ? htmlspecialchars($userName) : ''; ?></span>
                    </div>
                    <a href="./cart_page2.php" class="cart-icon">
                        🛒
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"></span>
                    </a>
                </div>
            </div>
        </nav>

        <body>
            <header class="header">

            </header>

            <main class="container" style="margin-top: 160px;">

                <!-- Veg Main Course Section -->
                <section class="menu-category">
                    <h3 class="category-title">Vegetarian Specialties</h3>
                    <div class="menu-grid">
                        <!-- Paneer Butter Masala -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Paneer Butter Masala.webp" alt="Paneer Butter Masala">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Paneer Butter Masala</h4>
                                <p class="item-price">₹250</p>
                                <p class="item-description">Cottage cheese cubes in rich tomato and butter gravy</p>
                                <button class="cart-button" onclick="addToCart('Paneer Butter Masala', 250, './veg main course/Paneer Butter Masala.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Shahi Paneer -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Shahi Paneer.webp" alt="Shahi Paneer">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Shahi Paneer</h4>
                                <p class="item-price">₹260</p>
                                <p class="item-description">Paneer in a creamy sauce with nuts and aromatic spices</p>
                                <button class="cart-button" onclick="addToCart('Shahi Paneer', 260, './veg main course/Shahi Paneer.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Kadhai Paneer -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Kadhai Paneer.webp" alt="Kadhai Paneer">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Kadhai Paneer</h4>
                                <p class="item-price">₹250</p>
                                <p class="item-description">Paneer with bell peppers in spicy kadhai masala</p>
                                <button class="cart-button" onclick="addToCart('Kadhai Paneer', 250, './veg main course/Kadhai Paneer.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Mutter Paneer -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Mutter Paneer.webp" alt="Mutter Paneer">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Mutter Paneer</h4>
                                <p class="item-price">₹230</p>
                                <p class="item-description">Paneer and green peas in a tomato-based gravy</p>
                                <button class="cart-button" onclick="addToCart('Mutter Paneer', 230, './veg main course/Mutter Paneer.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Palak Paneer -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Palak Paneer.webp" alt="Palak Paneer">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Palak Paneer</h4>
                                <p class="item-price">₹240</p>
                                <p class="item-description">Paneer cubes in a creamy spinach gravy</p>
                                <button class="cart-button" onclick="addToCart('Palak Paneer', 240, './veg main course/Palak Paneer.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Dal Makhani -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Dal Makhani.webp" alt="Dal Makhani">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Dal Makhani</h4>
                                <p class="item-price">₹220</p>
                                <p class="item-description">Black lentils slow-cooked with butter and cream</p>
                                <button class="cart-button" onclick="addToCart('Dal Makhani', 220, './veg main course/Dal Makhani.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Dal Tadka -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Dal Tadka.webp" alt="Dal Tadka">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Dal Tadka</h4>
                                <p class="item-price">₹190</p>
                                <p class="item-description">Yellow lentils tempered with cumin and garlic</p>
                                <button class="cart-button" onclick="addToCart('Dal Tadka', 190, './veg main course/Dal Tadka.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Chole Masala -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Chole Masala.webp" alt="Chole Masala">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Chole Masala</h4>
                                <p class="item-price">₹200</p>
                                <p class="item-description">Spicy chickpeas curry with onions and tomatoes</p>
                                <button class="cart-button" onclick="addToCart('Chole Masala', 200, './veg main course/Chole Masala.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Rajma Masala -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Rajma Masala.webp" alt="Rajma Masala">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Rajma Masala</h4>
                                <p class="item-price">₹210</p>
                                <p class="item-description">Kidney beans in a thick tomato-onion gravy</p>
                                <button class="cart-button" onclick="addToCart('Rajma Masala', 210, './veg main course/Rajma Masala.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Mix Veg Curry -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Mix Veg Curry.webp" alt="Mix Veg Curry">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Mix Veg Curry</h4>
                                <p class="item-price">₹200</p>
                                <p class="item-description">Assorted vegetables in a savory curry sauce</p>
                                <button class="cart-button" onclick="addToCart('Mix Veg Curry', 200, './veg main course/Mix Veg Curry.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Aloo Gobhi -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Aloo Gobhi.webp" alt="Aloo Gobhi">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Aloo Gobhi</h4>
                                <p class="item-price">₹180</p>
                                <p class="item-description">Potato and cauliflower stir-fried with spices</p>
                                <button class="cart-button" onclick="addToCart('Aloo Gobhi', 180, './veg main course/Aloo Gobhi.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Baingan Bharta -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Baingan Bharta.webp" alt="Baingan Bharta">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Baingan Bharta</h4>
                                <p class="item-price">₹200</p>
                                <p class="item-description">Smoky mashed eggplant cooked with spices</p>
                                <button class="cart-button" onclick="addToCart('Baingan Bharta', 200, './veg main course/Baingan Bharta.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Dum Aloo -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Dum Aloo.webp" alt="Dum Aloo">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Dum Aloo</h4>
                                <p class="item-price">₹210</p>
                                <p class="item-description">Baby potatoes in a rich, spicy gravy</p>
                                <button class="cart-button" onclick="addToCart('Dum Aloo', 210, './veg main course/Dum Aloo.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Bhindi Masala -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Bhindi Masala.webp" alt="Bhindi Masala">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Bhindi Masala</h4>
                                <p class="item-price">₹190</p>
                                <p class="item-description">Okra stir-fried with onions and spices</p>
                                <button class="cart-button" onclick="addToCart('Bhindi Masala', 190, './veg main course/Bhindi Masala.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Jeera Aloo -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Jeera Aloo.webp" alt="Jeera Aloo">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Jeera Aloo</h4>
                                <p class="item-price">₹160</p>
                                <p class="item-description">Potatoes tossed with cumin seeds and spices</p>
                                <button class="cart-button" onclick="addToCart('Jeera Aloo', 160, './veg main course/Jeera Aloo.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Veg Kofta Curry -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Veg Kofta Curry.webp" alt="Veg Kofta Curry">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Veg Kofta Curry</h4>
                                <p class="item-price">₹240</p>
                                <p class="item-description">Vegetable dumplings in a creamy tomato gravy</p>
                                <button class="cart-button" onclick="addToCart('Veg Kofta Curry', 240, './veg main course/Veg Kofta Curry.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Navratan Korma -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Navratan Korma.webp" alt="Navratan Korma">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Navratan Korma</h4>
                                <p class="item-price">₹260</p>
                                <p class="item-description">Nine-gem mixed vegetables in rich creamy sauce</p>
                                <button class="cart-button" onclick="addToCart('Navratan Korma', 260, './veg main course/Navratan Korma.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Methi Malai Matar -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Methi Malai Matar.webp" alt="Methi Malai Matar">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Methi Malai Matar</h4>
                                <p class="item-price">₹250</p>
                                <p class="item-description">Green peas and fenugreek leaves in creamy sauce</p>
                                <button class="cart-button" onclick="addToCart('Methi Malai Matar', 250, './veg main course/Methi Malai Matar.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Veg Biryani -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Veg Biryani.webp" alt="Veg Biryani">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Veg Biryani</h4>
                                <p class="item-price">₹220</p>
                                <p class="item-description">Aromatic rice cooked with vegetables and spices</p>
                                <button class="cart-button" onclick="addToCart('Veg Biryani', 220, './veg main course/Veg Biryani.webp')">Add to Cart</button>
                            </div>
                        </div>

                        <!-- Khichdi -->
                        <div class="menu-item">
                            <div class="item-image">
                                <img src="./veg main course/Khichdi.webp" alt="Khichdi">
                            </div>
                            <div class="item-info">
                                <h4 class="item-title">Khichdi (With Ghee & Papad)</h4>
                                <p class="item-price">₹180</p>
                                <p class="item-description">Comforting rice and lentil dish served with ghee and papad
                                </p>
                                <button class="cart-button" onclick="addToCart('Khichdi', 180, './veg main course/Khichdi.webp')">Add to Cart</button>
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
                                <li>info@ghrkitchen.com</li>
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

        <script>
            // Cart functionality
            function addToCart(name, price, image) {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const existingItem = cart.find(item => item.name === name);
                
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        name: name,
                        price: price,
                        image: image,
                        quantity: 1
                    });
                }
                
                localStorage.setItem('cart', JSON.stringify(cart));
                showNotification(`${name} added to cart!`);
                updateCartCount();
            }

            function showNotification(message) {
                const notification = document.createElement('div');
                notification.className = 'notification';
                notification.textContent = message;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }

            function updateCartCount() {
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = totalItems;
                    cartCount.style.display = totalItems > 0 ? 'block' : 'none';
                }
            }

            // Initialize cart count on page load
            document.addEventListener('DOMContentLoaded', updateCartCount);
        </script>
    </body>

</html>