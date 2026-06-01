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
    <title>Restaurant Menu - Cold Drinks</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            background-color: #3498db;
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
            background-color: #2980b9;
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

        /* Navbar Styling */
        .navbar {
            background: white;
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-left, .nav-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-center {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 10px;
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
            font-weight: 500;
            color: #333;
            transition: color 0.3s ease;
        }

        .nav-link.active {
            color: #FF4444;
        }

        .nav-link:hover {
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

        /* Footer Styling */
        footer {
            background-color: #1f2937;
            color: white;
            padding: 3rem 0;
        }

        footer a {
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #ff4444;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 4rem;
            max-width: 72rem;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .footer-section h3 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .footer-section p, .footer-section li {
            color: #d1d5db;
        }

        .footer-section ul {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .footer-bottom {
            border-top: 1px solid #374151;
            margin-top: 4rem;
            padding-top: 2rem;
            text-align: center;
            color: #9ca3af;
        }
    </style>
</head>

<body>

    <body class="bg-gray-100">

        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-left">
                    <a href="homepage.php" class="nav-link active">Home</a>
                    <a href="aboutus2.php" class="nav-link">About Us</a>
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
                
                <div class="nav-center">
                    <div class="logo-container">
                        <img src="./images/LogoFi.jpg" alt="Saffron Sky Logo" class="logo-image">
                    </div>
                </div>
                
                <div class="nav-right">
                    <a href="blogs2.php" class="nav-link">Blogs</a>
                    <div class="user-profile">
                        <div class="profile-circle"><?php echo $isLoggedIn ? substr($userName, 0, 1) : ''; ?></div>
                        <span><?php echo $isLoggedIn ? htmlspecialchars($userName) : ''; ?></span>
                    </div>
                    <a href="cart_page2.php" class="cart-icon">
                        🛒
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"></span>
                    </a>
                </div>
            </div>
        </nav>

        <main class="container" style="margin-top: 160px;">

            <!-- Cold Drinks Section -->
            <section class="menu-category">
                <h3 class="category-title">Cold Drinks 🥤</h3>
                <div class="menu-grid">
                    <!-- Coca-Cola -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Coca-Cola.webp" alt="Coca-Cola">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Coca-Cola</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Classic Cola</p>
                            <button class="cart-button" onclick="addToCart('Coca-Cola', 40, './cold drink/Coca-Cola.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Pepsi -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Pepsi.webp" alt="Pepsi">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Pepsi</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Refreshing Cola</p>
                            <button class="cart-button" onclick="addToCart('Pepsi', 40, './cold drink/Pepsi.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Thums Up -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/thumbs up.jpeg" alt="Thums Up">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Thums Up</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Strong Cola</p>
                            <button class="cart-button" onclick="addToCart('Thums Up', 40, './cold drink/thumbs up.jpeg')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Sprite -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Sprite.webp" alt="Sprite">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Sprite</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Lemon-Lime Flavored Soda</p>
                            <button class="cart-button" onclick="addToCart('Sprite', 40, './cold drink/Sprite.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- 7UP -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/7UP.webp" alt="7UP">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">7UP</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Crisp Lemon-Lime Drink</p>
                            <button class="cart-button" onclick="addToCart('7UP', 40, './cold drink/7UP.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Mountain Dew -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Mountain Dew.webp" alt="Mountain Dew">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Mountain Dew</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Citrus Blast</p>
                            <button class="cart-button" onclick="addToCart('Mountain Dew', 40, './cold drink/Mountain Dew.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Limca -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Limca.webp" alt="Limca">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Limca</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Lemon Refreshment</p>
                            <button class="cart-button" onclick="addToCart('Limca', 40, './cold drink/Limca.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Fanta -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Fanta.webp" alt="Fanta">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Fanta</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Orange Flavored Soda</p>
                            <button class="cart-button" onclick="addToCart('Fanta', 40, './cold drink/Fanta.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Maaza -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Maaza.webp" alt="Maaza">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Maaza</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Mango Drink</p>
                            <button class="cart-button" onclick="addToCart('Maaza', 40, './cold drink/Maaza.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Slice -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Slice.webp" alt="Slice">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Slice</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Thick Mango Juice</p>
                            <button class="cart-button" onclick="addToCart('Slice', 40, './cold drink/Slice.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Appy Fizz -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Appy Fizz.webp" alt="Appy Fizz">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Appy Fizz</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Apple Flavored Sparkling Drink</p>
                            <button class="cart-button" onclick="addToCart('Appy Fizz', 40, './cold drink/Appy Fizz.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Minute Maid -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Minute Maid.webp" alt="Minute Maid">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Minute Maid</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Pulpy Orange Juice</p>
                            <button class="cart-button" onclick="addToCart('Minute Maid', 40, './cold drink/Minute Maid.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Sting -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/sting.jpeg" alt="Sting">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Sting</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Energy Drink (Berry Flavor)</p>
                            <button class="cart-button" onclick="addToCart('Sting', 40, './cold drink/sting.jpeg')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Red Bull -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Red Bull.webp" alt="Red Bull">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Red Bull</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Energy Drink</p>
                            <button class="cart-button" onclick="addToCart('Red Bull', 40, './cold drink/Red Bull.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Bisleri Limonata -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./cold drink/Bisleri Limonata.webp" alt="Bisleri Limonata">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Bisleri Limonata</h4>
                            <p class="item-price">₹40</p>
                            <p class="item-description">Lemon-Mint Drink</p>
                            <button class="cart-button" onclick="addToCart('Bisleri Limonata', 40, './cold drink/Bisleri Limonata.webp')">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-gray-800 text-white py-12">
            <div class="max-w-6xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-16">
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
                <div class="border-t border-gray-700 mt-16 pt-8 text-center text-gray-400">
                    <p>&copy; 2024 Saffron Sky. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <script>
            // Cart functionality
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            function addToCart(name, price, image) {
                // Check if item already exists in cart
                const existingItemIndex = cart.findIndex(item => item.name === name);
                
                if (existingItemIndex !== -1) {
                    // If item exists, increment quantity
                    cart[existingItemIndex].quantity = (cart[existingItemIndex].quantity || 1) + 1;
                } else {
                    // If item doesn't exist, add it
                    cart.push({
                        name: name,
                        price: price,
                        image: image,
                        quantity: 1
                    });
                }

                // Save to localStorage
                localStorage.setItem('cart', JSON.stringify(cart));
                
                // Show notification
                showNotification(`${name} added to cart!`);
                
                // Update cart count
                updateCartCount();
            }

            function showNotification(message) {
                const notification = document.createElement('div');
                notification.className = 'notification';
                notification.textContent = message;
                document.body.appendChild(notification);
                
                // Remove notification after 2 seconds
                setTimeout(() => {
                    notification.remove();
                }, 2000);
            }

            function updateCartCount() {
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
                    cartCount.textContent = totalItems;
                    cartCount.style.display = totalItems > 0 ? 'block' : 'none';
                }
            }

            // Initialize cart count
            document.addEventListener('DOMContentLoaded', () => {
                // Add cart count element if it doesn't exist
                if (!document.getElementById('cart-count')) {
                    const cartCount = document.createElement('div');
                    cartCount.id = 'cart-count';
                    document.body.appendChild(cartCount);
                }
                updateCartCount();
            });

            // Add styles for notification and cart count
            const styles = `
                .notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background-color: #2ecc71;
                    color: white;
                    padding: 12px 24px;
                    border-radius: 4px;
                    z-index: 1000;
                    animation: slideIn 0.3s ease-out;
                }

                #cart-count {
                    position: fixed;
                    top: 10px;
                    right: 10px;
                    background-color: #ff4444;
                    color: white;
                    width: 24px;
                    height: 24px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 14px;
                    font-weight: bold;
                    z-index: 1000;
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

                .cart-button {
                    background-color: #2ecc71;
                    color: white;
                    border: none;
                    padding: 8px 16px;
                    border-radius: 4px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                }

                .cart-button:hover {
                    background-color: #27ae60;
                    transform: translateY(-2px);
                }
            `;

            const styleSheet = document.createElement('style');
            styleSheet.textContent = styles;
            document.head.appendChild(styleSheet);

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        </script>

</html>