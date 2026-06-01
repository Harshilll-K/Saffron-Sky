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
    <title>Saffron Sky - Menu Items</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
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

        .nav-center img {
            height: 80px;
            width: auto;
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

        .veg {
            background-color: #2ecc71;
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
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
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

        .cart-button.added {
            background-color: #2ecc71;
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

<body class="bg-gray-100">

    <div id="notification" class="notification">Item added to cart!</div>

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
                <?php if ($isLoggedIn): ?>
                    <div class="user-profile">
                        <div class="profile-circle"><?php echo substr($userName, 0, 1); ?></div>
                        <span><?php echo htmlspecialchars($userName); ?></span>
                    </div>
                <?php else: ?>
                    <a href="./login_page.php" class="nav-link">Log In</a>
                    <a href="./signuppage.php" class="nav-link">Sign Up</a>
                <?php endif; ?>
                <a href="./cart_page2.php" class="cart-icon">
                    🛒
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"></span>
                </a>
            </div>
        </div>
    </nav>

    <body>



        <main class="container">


            <section class="menu-category">
                <h3 class="category-title">Vegetarian Starters</h3>
                <div class="menu-grid">
                    <!-- Veg Item 1 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Paneer Tikka.jpeg">
                            <div class="food-type veg">V</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Paneer Tikka</h4>
                            <p class="item-price">₹260</p>
                            <p class="item-description">Cottage cheese cubes marinated with yogurt and spices, grilled
                                to perfection in a tandoor.</p>
                            <button class="cart-button" onclick="addToCart('Paneer Tikka', 260, './starter/Paneer Tikka.jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Veg Item 2 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Hara Bhara Kebab.jpeg">
                            <div class="food-type veg">V</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Hara Bhara Kebab</h4>
                            <p class="item-price">₹230</p>
                            <p class="item-description">Spinach and green pea patties flavored with aromatic spices and
                                herbs.</p>
                            <button class="cart-button" onclick="addToCart('Hara Bhara Kebab', 230, './starter/Hara Bhara Kebab.jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Veg Item 3 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Crispy Corn.jpeg">
                            <div class="food-type veg">V</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Crispy Corn</h4>
                            <p class="item-price">₹200</p>
                            <p class="item-description">Sweet corn kernels tossed with mild spices and deep-fried until
                                golden and crispy.</p>
                            <button class="cart-button" onclick="addToCart('Crispy Corn', 200, './starter/Crispy Corn.jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Veg Item 4 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Tandoori Mushroom.webp">
                            <div class="food-type veg">V</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Tandoori Mushroom</h4>
                            <p class="item-price">₹250</p>
                            <p class="item-description">Fresh mushrooms marinated in yogurt and spices, cooked in a
                                tandoor.</p>
                            <button class="cart-button" onclick="addToCart('Tandoori Mushroom', 250, './starter/Tandoori Mushroom.webp')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Veg Item 5 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Dahi Ke Kebab.webp">
                            <div class="food-type veg">V</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Dahi Ke Kebab</h4>
                            <p class="item-price">₹240</p>
                            <p class="item-description">Soft kebabs made from hung curd, flavored with mint and mild
                                spices.</p>
                            <button class="cart-button" onclick="addToCart('Dahi Ke Kebab', 240, './starter/Dahi Ke Kebab.webp')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Veg Item 6 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Spring Rolls.jpeg">
                            <div class="food-type veg">V</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Spring Rolls</h4>
                            <p class="item-price">₹210</p>
                            <p class="item-description">Crispy rolls filled with julienned vegetables and spices.</p>
                            <button class="cart-button" onclick="addToCart('Spring Rolls', 210, './starter/Spring Rolls.jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Veg Item 7 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Veg Seekh Kebab.webp">
                            <div class="food-type veg">V</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Veg Seekh Kebab</h4>
                            <p class="item-price">₹220</p>
                            <p class="item-description">Minced vegetable kebabs cooked on skewers in a tandoor.</p>
                            <button class="cart-button" onclick="addToCart('Veg Seekh Kebab', 220, './starter/Veg Seekh Kebab.webp')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Veg Item 8 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Stuffed Tandoori Aloo.jpeg">
                            <div class="food-type veg">V</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Stuffed Tandoori Aloo</h4>
                            <p class="item-price">₹230</p>
                            <p class="item-description">Potatoes stuffed with paneer, spices, and herbs, cooked in a
                                tandoor.</p>
                            <button class="cart-button" onclick="addToCart('Stuffed Tandoori Aloo', 230, './starter/Stuffed Tandoori Aloo.jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Veg Item 9 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Chilli Paneer (Dry).jpeg">
                            <div class="food-type veg">V</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Chilli Paneer (Dry)</h4>
                            <p class="item-price">₹270</p>
                            <p class="item-description">Crispy paneer cubes tossed with bell peppers, onions, and spicy
                                sauce.</p>
                            <button class="cart-button" onclick="addToCart('Chilli Paneer (Dry)', 270, './starter/Chilli Paneer (Dry).jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Veg Item 10 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Honey Chilli Potato.webp">
                            <div class="food-type veg">V</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Honey Chilli Potato</h4>
                            <p class="item-price">₹190</p>
                            <p class="item-description">Crispy potato fingers tossed in a sweet and spicy honey chilli
                                sauce.</p>
                            <button class="cart-button" onclick="addToCart('Honey Chilli Potato', 190, './starter/Honey Chilli Potato.webp')">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="menu-category">
                <h3 class="category-title">Non-Vegetarian Starters</h3>
                <div class="menu-grid">
                    <!-- Non-Veg Item 1 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Chicken Tikka.webp">
                            <div class="food-type non-veg">N</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Chicken Tikka</h4>
                            <p class="item-price">₹300</p>
                            <p class="item-description">Boneless chicken pieces marinated in spices and yogurt, grilled
                                in a tandoor.</p>
                            <button class="cart-button" onclick="addToCart('Chicken Tikka', 300, './starter/Chicken Tikka.webp')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Non-Veg Item 2 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Tandoori Chicken.jpeg">
                            <div class="food-type non-veg">N</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Tandoori Chicken</h4>
                            <p class="item-price">₹320</p>
                            <p class="item-description">Chicken marinated in yogurt and spices, cooked to perfection in
                                a clay oven.</p>
                            <button class="cart-button" onclick="addToCart('Tandoori Chicken', 320, './starter/Tandoori Chicken.jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Non-Veg Item 3 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Mutton Seekh Kebab.jpeg">
                            <div class="food-type non-veg">N</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Mutton Seekh Kebab</h4>
                            <p class="item-price">₹350</p>
                            <p class="item-description">Minced mutton mixed with spices and herbs, cooked on skewers in
                                a tandoor.</p>
                            <button class="cart-button" onclick="addToCart('Mutton Seekh Kebab', 350, './starter/Mutton Seekh Kebab.jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Non-Veg Item 4 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Chicken Malai Tikka.webp">
                            <div class="food-type non-veg">N</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Chicken Malai Tikka</h4>
                            <p class="item-price">₹310</p>
                            <p class="item-description">Succulent pieces of chicken marinated in cream, cheese, and mild
                                spices.</p>
                            <button class="cart-button" onclick="addToCart('Chicken Malai Tikka', 310, './starter/Chicken Malai Tikka.webp')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Non-Veg Item 5 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Fish Amritsari.webp">
                            <div class="food-type non-veg">N</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Fish Amritsari</h4>
                            <p class="item-price">₹330</p>
                            <p class="item-description">Fish fillets coated in a spiced gram flour batter and
                                deep-fried.</p>
                            <button class="cart-button" onclick="addToCart('Fish Amritsari', 330, './starter/Fish Amritsari.webp')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Non-Veg Item 6 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Prawn Koliwada.jpeg">
                            <div class="food-type non-veg">N</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Prawn Koliwada</h4>
                            <p class="item-price">₹370</p>
                            <p class="item-description">Spicy deep-fried prawns coated in a special Koliwada masala.</p>
                            <button class="cart-button" onclick="addToCart('Prawn Koliwada', 370, './starter/Prawn Koliwada.jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Non-Veg Item 7 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Chicken 65.jpeg">
                            <div class="food-type non-veg">N</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Chicken 65</h4>
                            <p class="item-price">₹290</p>
                            <p class="item-description">Spicy deep-fried chicken chunks flavored with curry leaves and
                                spices.</p>
                            <button class="cart-button" onclick="addToCart('Chicken 65', 290, './starter/Chicken 65.jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Non-Veg Item 8 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Crispy Chicken.jpeg">
                            <div class="food-type non-veg">N</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Crispy Chicken</h4>
                            <p class="item-price">₹280</p>
                            <p class="item-description">Boneless chicken pieces deep-fried until golden and crispy.</p>

                            <button class="cart-button" onclick="addToCart('Crispy Chicken', 280, './starter/Crispy Chicken.jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Non-Veg Item 9 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Mutton Galouti Kebab.jpeg">
                            <div class="food-type non-veg">N</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Mutton Galouti Kebab</h4>
                            <p class="item-price">₹400</p>
                            <p class="item-description">Melt-in-your-mouth kebabs made from finely minced mutton and
                                aromatic spices.</p>
                            <button class="cart-button" onclick="addToCart('Mutton Galouti Kebab', 400, './starter/Mutton Galouti Kebab.jpeg')">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Non-Veg Item 10 -->
                    <div class="menu-item">
                        <div class="item-image">
                            <img src="./starter/Lemon Garlic Prawns.jpeg">
                            <div class="food-type non-veg">N</div>
                        </div>
                        <div class="item-info">
                            <h4 class="item-title">Lemon Garlic Prawns</h4>
                            <p class="item-price">₹390</p>
                            <p class="item-description">Succulent prawns cooked with lemon, garlic, and herbs.</p>
                            <button class="cart-button" onclick="addToCart('Lemon Garlic Prawns', 390, './starter/Lemon Garlic Prawns.jpeg')">
                                Add to Cart
                            </button>
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
                            <li><a href="./aboutus.php" class="text-gray-300 hover:text-orange-500">About Us</a></li>
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

        <script>
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