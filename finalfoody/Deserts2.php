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
    <title>Restaurant Menu - Desserts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Navbar styles */
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

        .nav-center img {
            height: 80px;
            width: auto;
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

        body {
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            padding-top: 140px;
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

        /* Dropdown styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 10px 0;
            z-index: 1000;
            top: 100%;
            left: 0;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 20px;
            text-decoration: none;
            display: block;
            text-align: left;
            transition: background-color 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #f8f8f8;
            color: #ff4444;
        }

        .logo-image {
            height: 80px;
            width: auto;
            object-fit: contain;
            max-width: none;
            transform: scale(1.3);
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

        .dropdown-content:before {
            content: '';
            position: absolute;
            top: -10px;
            left: 0;
            width: 100%;
            height: 10px;
            background: transparent;
        }
    </style>
</head>

<body>
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

    <body class="bg-gray-100">


        <main class="container">

            <!-- Indian Sweets Section -->
            <section class="menu-category">
                <h3 class="category-title">Indian Sweets</h3>
                <div class="menu-grid">
                    <!-- Gulab Jamun -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/gulab jamun.webp" alt="Gulab Jamun">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Gulab Jamun</h4>
                            <p class="item-price">₹80 (2 pcs)</p>
                            <p class="item-description">Soft milk solids balls soaked in rose-flavored sugar syrup</p>
                            <button class="cart-button" onclick="addToCart('Gulab Jamun', 80, './desert images/gulab jamun.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Rasgulla -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/rasgulla.webp" alt="Rasgulla">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Rasgulla</h4>
                            <p class="item-price">₹90 (2 pcs)</p>
                            <p class="item-description">Spongy cottage cheese balls in light sugar syrup</p>
                            <button class="cart-button" onclick="addToCart('Rasgulla', 90, './desert images/rasgulla.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Rasmalai -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/rasmalai.webp" alt="Rasmalai">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Rasmalai</h4>
                            <p class="item-price">₹120 (2 pcs)</p>
                            <p class="item-description">Flattened cheese patties soaked in creamy saffron milk</p>
                            <button class="cart-button" onclick="addToCart('Rasmalai', 120, './desert images/rasmalai.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Jalebi -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/jalebi.webp" alt="Jalebi">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Jalebi</h4>
                            <p class="item-price">₹100 (200g)</p>
                            <p class="item-description">Crispy, pretzel-shaped sweet soaked in saffron syrup</p>
                            <button class="cart-button" onclick="addToCart('Jalebi', 100, './desert images/jalebi.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Gajar ka Halwa -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/gajar ka halwa.webp" alt="Gajar ka Halwa">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Gajar ka Halwa</h4>
                            <p class="item-price">₹150 (per plate)</p>
                            <p class="item-description">Sweet carrot pudding with nuts and cardamom</p>
                            <button class="cart-button" onclick="addToCart('Gajar Halwa', 150, './desert images/gajar ka halwa.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Moong Dal Halwa -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/Moong Dal Halwa.webp" alt="Moong Dal Halwa">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Moong Dal Halwa</h4>
                            <p class="item-price">₹160 (per plate)</p>
                            <p class="item-description">Rich and hearty pudding made from yellow lentils</p>
                            <button class="cart-button" onclick="addToCart('Moong Dal Halwa', 160, './desert images/Moong Dal Halwa.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Besan Ladoo -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/besan ke ladoo.webp" alt="Besan Ladoo">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Besan Ladoo</h4>
                            <p class="item-price">₹120 (2 pcs)</p>
                            <p class="item-description">Sweet gram flour balls with cardamom and nuts</p>
                            <button class="cart-button" onclick="addToCart('Besan Ladoo', 120, './desert images/besan ke ladoo.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Kaju Katli -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/kaju katli.webp" alt="Kaju Katli">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Kaju Katli</h4>
                            <p class="item-price">₹250 (250g)</p>
                            <p class="item-description">Diamond-shaped cashew fudge with silver foil</p>
                            <button class="cart-button" onclick="addToCart('Kaju Katli', 250, './desert images/kaju katli.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Barfi -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/Barfi (CoconutPistaKesar).webp" alt="Barfi">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Barfi (Coconut/Pista/Kesar)</h4>
                            <p class="item-price">₹200 (250g)</p>
                            <p class="item-description">Dense milk fudge in various flavors</p>
                            <button class="cart-button" onclick="addToCart('Barfi', 200, './desert images/Barfi (CoconutPistaKesar).webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Malpua -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/Malpua.webp" alt="Malpua">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Malpua</h4>
                            <p class="item-price">₹140 (2 pcs)</p>
                            <p class="item-description">Sweet pancakes dipped in sugar syrup</p>
                            <button class="cart-button" onclick="addToCart('Malpua', 140, './desert images/Malpua.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Phirni -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/phirni.jpg" alt="Phirni">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Phirni</h4>
                            <p class="item-price">₹130 (per bowl)</p>
                            <p class="item-description">Creamy rice pudding with cardamom and nuts</p>
                            <button class="cart-button" onclick="addToCart('Phirni', 130, './desert images/phirni.jpg')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Shahi Tukda -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/Shahi Tukda.webp" alt="Shahi Tukda">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Shahi Tukda</h4>
                            <p class="item-price">₹160 (per plate)</p>
                            <p class="item-description">Royal bread pudding with creamy topping and nuts</p>
                            <button class="cart-button" onclick="addToCart('Shahi Tukda', 160, './desert images/Shahi Tukda.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Modak -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/Modak.webp" alt="Modak">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Modak</h4>
                            <p class="item-price">₹180 (5 pcs)</p>
                            <p class="item-description">Steamed dumplings with coconut and jaggery filling</p>
                            <button class="cart-button" onclick="addToCart('Modak', 180, './desert images/Modak.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Sandesh -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/Sandesh.webp" alt="Sandesh">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Sandesh</h4>
                            <p class="item-price">₹150 (2 pcs)</p>
                            <p class="item-description">Bengali cottage cheese dessert with cardamom</p>
                            <button class="cart-button" onclick="addToCart('Sandesh', 150, './desert images/Sandesh.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Mysore Pak -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/Mysore Pak.webp" alt="Mysore Pak">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Mysore Pak</h4>
                            <p class="item-price">₹200 (250g)</p>
                            <p class="item-description">Rich South Indian sweet made with ghee and gram flour</p>
                            <button class="cart-button" onclick="addToCart('Mysore Pak', 200, './desert images/Mysore Pak.webp')">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Pastries Section -->
            <section class="menu-category">
                <h3 class="category-title">Pastries 🍰</h3>
                <div class="menu-grid">
                    <!-- Black Forest Pastry -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/Chocolate Truffle Pastry.webp" alt="Black Forest Pastry">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Black Forest Pastry</h4>
                            <p class="item-price">₹80 (per piece)</p>
                            <p class="item-description">Chocolate sponge with cherries and whipped cream</p>
                            <button class="cart-button" onclick="addToCart('Black Forest Pastry', 80, './desert images/Chocolate Truffle Pastry.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Chocolate Truffle Pastry -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/Chocolate Truffle Pastry.webp" alt="Chocolate Truffle Pastry">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Chocolate Truffle Pastry</h4>
                            <p class="item-price">₹90 (per piece)</p>
                            <p class="item-description">Rich chocolate cake with ganache frosting</p>
                            <button class="cart-button" onclick="addToCart('Chocolate Truffle Pastry', 90, './desert images/Chocolate Truffle Pastry.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Red Velvet Pastry -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/Red Velvet Pastry.webp" alt="Red Velvet Pastry">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Red Velvet Pastry</h4>
                            <p class="item-price">₹100 (per piece)</p>
                            <p class="item-description">Red cocoa cake with cream cheese frosting</p>
                            <button class="cart-button" onclick="addToCart('Red Velvet Pastry', 100, './desert images/Red Velvet Pastry.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Butterscotch Pastry -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/Butterscotch Pastry.webp" alt="Butterscotch Pastry">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Butterscotch Pastry</h4>
                            <p class="item-price">₹85 (per piece)</p>
                            <p class="item-description">Vanilla cake with caramel frosting and butterscotch chips
                            </p>
                            <button class="cart-button" onclick="addToCart('Butterscotch Pastry', 85, './desert images/Butterscotch Pastry.webp')">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Pineapple Pastry -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./desert images/pineapple pastery.webp" alt="Pineapple Pastry">
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Pineapple Pastry</h4>
                            <p class="item-price">₹75 (per piece)</p>
                            <p class="item-description">Light vanilla cake with pineapple chunks and cream</p>
                            <button class="cart-button" onclick="addToCart('Pineapple Pastry', 75, './desert images/pineapple pastery.webp')">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="container">
                <p>&copy; 2025 Restaurant Name. All Rights Reserved.</p>
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