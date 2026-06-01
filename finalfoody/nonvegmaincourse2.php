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
    <title>Restaurant Menu - Non-Veg Main Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Reset and base styles */
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
            border-bottom: 2px solid #e74c3c;
            color: #333;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }

        .menu-item {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
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

        .food-type {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
            color: white;
        }

        .non-veg {
            background-color: #e74c3c;
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
            color: #e74c3c;
            margin-bottom: 10px;
        }

        .item-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .footer {
            text-align: center;
            padding: 30px 0;
            margin-top: 60px;
            background-color: #333;
            color: #fff;
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

        <main class="container" style="margin-top: 150px;">

            <!-- Non-Veg Main Course Section -->
            <section class="menu-category">
                <h3 class="category-title">Non-Vegetarian Main Courses 🍗</h3>
                <div class="menu-grid">
                    <!-- Butter Chicken -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/butter chicken.webp" alt="Butter Chicken">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Butter Chicken</h4>
                            <p class="item-price">₹320</p>
                            <p class="item-description">Tender chicken pieces cooked in a rich, creamy tomato sauce with
                                aromatic spices.</p>
                            <button class="cart-button" onclick="addToCart('Butter Chicken', 320, './nonv/butter chicken.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Chicken Tikka Masala -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/chicken tikka.webp" alt="Chicken Tikka Masala">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Chicken Tikka Masala</h4>
                            <p class="item-price">₹330</p>
                            <p class="item-description">Grilled chicken tikka cooked in a spiced tomato-based sauce with
                                bell peppers and onions.</p>
                            <button class="cart-button" onclick="addToCart('Chicken Tikka Masala', 330, './nonv/chicken tikka.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Kadhai Chicken -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/kadhai chicken.webp" alt="Kadhai Chicken">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Kadhai Chicken</h4>
                            <p class="item-price">₹310</p>
                            <p class="item-description">Spicy chicken curry cooked with bell peppers, onions, and
                                traditional kadhai spices.</p>
                            <button class="cart-button" onclick="addToCart('Kadhai Chicken', 310, './nonv/kadhai chicken.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Chicken Curry (Dhaba Style) -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/chicken curry(Dhaba style).webp" alt="Chicken Curry (Dhaba Style)">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Chicken Curry (Dhaba Style)</h4>
                            <p class="item-price">₹300</p>
                            <p class="item-description">Authentic roadside-style chicken curry with rustic flavors and
                                aromatic spices.</p>
                            <button class="cart-button" onclick="addToCart('Chicken Curry (Dhaba Style)', 300, './nonv/chicken curry(Dhaba style).webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Chicken Korma -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/chicken korma.webp" alt="Chicken Korma">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Chicken Korma</h4>
                            <p class="item-price">₹340</p>
                            <p class="item-description">Chicken simmered in a mild, creamy sauce with cashews, almonds,
                                and aromatic spices.</p>
                            <button class="cart-button" onclick="addToCart('Chicken Korma', 340, './nonv/chicken korma.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Egg Curry -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/egg curry.webp" alt="Egg Curry">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Egg Curry</h4>
                            <p class="item-price">₹220</p>
                            <p class="item-description">Boiled eggs simmered in a flavorful onion-tomato gravy with
                                traditional Indian spices.</p>
                            <button class="cart-button" onclick="addToCart('Egg Curry', 220, './nonv/egg curry.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Mutton Rogan Josh -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/mutton rogan josh.webp" alt="Mutton Rogan Josh">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Mutton Rogan Josh</h4>
                            <p class="item-price">₹420</p>
                            <p class="item-description">Tender mutton pieces slow-cooked in a rich Kashmiri spice blend
                                with yogurt and aromatics.</p>
                            <button class="cart-button" onclick="addToCart('Mutton Rogan Josh', 420, './nonv/mutton rogan josh.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Mutton Keema Masala -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/mutton keema.webp" alt="Mutton Keema Masala">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Mutton Keema Masala</h4>
                            <p class="item-price">₹400</p>
                            <p class="item-description">Minced mutton cooked with peas, onions, tomatoes, and a blend of
                                aromatic spices.</p>
                            <button class="cart-button" onclick="addToCart('Mutton Keema Masala', 400, './nonv/mutton keema.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Fish Curry (Bengali Style) -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/fish curry (Bengali style).webp" alt="Fish Curry (Bengali Style)">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Fish Curry (Bengali Style)</h4>
                            <p class="item-price">₹350</p>
                            <p class="item-description">Fresh fish cooked in a traditional Bengali mustard sauce with
                                green chilies.</p>
                            <button class="cart-button" onclick="addToCart('Fish Curry (Bengali Style)', 350, './nonv/fish curry (Bengali style).webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Prawn Masala Curry -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/prawn masala curry.webp" alt="Prawn Masala Curry">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Prawn Masala Curry</h4>
                            <p class="item-price">₹370</p>
                            <p class="item-description">Succulent prawns cooked in a tangy tomato-based sauce with
                                coconut and spices.</p>
                            <button class="cart-button" onclick="addToCart('Prawn Masala Curry', 370, './nonv/prawn masala curry.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Chicken Chettinad -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/chicken chettinad.webp" alt="Chicken Chettinad">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Chicken Chettinad</h4>
                            <p class="item-price">₹360</p>
                            <p class="item-description">Fiery South Indian chicken curry with black peppercorns, star
                                anise, and curry leaves.</p>
                            <button class="cart-button" onclick="addToCart('Chicken Chettinad', 360, './nonv/chicken chettinad.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Andhra Spicy Chicken Curry -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/chicken curry(Dhaba style).webp" alt="Andhra Spicy Chicken Curry">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Andhra Spicy Chicken Curry</h4>
                            <p class="item-price">₹340</p>
                            <p class="item-description">Hot and spicy chicken curry from Andhra Pradesh with red chilies
                                and tamarind.</p>
                            <button class="cart-button" onclick="addToCart('Andhra Spicy Chicken Curry', 340, './nonv/chicken curry(Dhaba style).webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Goan Fish Curry -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/Goan Fish Curry.webp" alt="Goan Fish Curry">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Goan Fish Curry</h4>
                            <p class="item-price">₹380</p>
                            <p class="item-description">Coastal fish curry with coconut milk, kokum, and traditional
                                Goan spices.</p>
                            <button class="cart-button" onclick="addToCart('Goan Fish Curry', 380, './nonv/Goan Fish Curry.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Mutton Handi -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/Mutton handi.webp" alt="Mutton Handi">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Mutton Handi</h4>
                            <p class="item-price">₹430</p>
                            <p class="item-description">Slow-cooked mutton in a clay pot with onions, tomatoes, and a
                                blend of spices.</p>
                            <button class="cart-button" onclick="addToCart('Mutton Handi', 430, './nonv/Mutton handi.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Hyderabadi Chicken Dum Ka -->
                    <div class="menu-item">
                        <div class="item-image">
                            <div class="food-type non-veg">N</div>
                            <img src="./nonv/Hydrabadi Chicken dum ka.webp" alt="Hyderabadi Chicken Dum Ka">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Hyderabadi Chicken Dum Ka</h4>
                            <p class="item-price">₹350</p>
                            <p class="item-description">Aromatic chicken curry slow-cooked.</p>
                            <button class="cart-button" onclick="addToCart('Hyderabadi Chicken Dum Ka', 350, './nonv/Hydrabadi Chicken dum ka.webp')">Add to Cart</button>
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
</html>

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

    // Add scroll effect to navbar
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>