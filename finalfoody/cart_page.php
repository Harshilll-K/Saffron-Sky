<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Saffron Sky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
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

        /* Dropdown Menu Styling */
        .menu-dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 200px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px 0;
            z-index: 1000;
        }

        .menu-dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            display: block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #f8f9fa;
            color: #ff4444;
        }

        /* Main Content Spacing */
        .cart-container {
            max-width: 1200px;
            margin: 180px auto 40px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }

        .cart-items {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
            gap: 20px;
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-name {
            font-weight: bold;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 4px;
        }

        .item-price {
            color: #666;
            font-size: 0.9rem;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .quantity-btn {
            background: #f8f9fa;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .quantity-btn:hover {
            background: #e9ecef;
        }

        .delete-btn {
            color: #dc3545;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            transition: color 0.2s;
        }

        .delete-btn:hover {
            color: #c82333;
        }

        /* Order Summary Styling */
        .order-summary {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            height: fit-content;
        }

        .summary-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            color: #666;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            font-weight: bold;
            color: #333;
            font-size: 1.2rem;
        }

        .checkout-btn {
            background-color: #ff4444;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 16px;
            width: 100%;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .checkout-btn:hover {
            background-color: #ff2222;
        }

        .empty-cart {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .empty-cart h2 {
            font-size: 1.5rem;
            margin-bottom: 16px;
            color: #333;
        }

        .continue-shopping {
            display: inline-block;
            background-color: #ff4444;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .continue-shopping:hover {
            background-color: #ff2222;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .cart-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
        }

        .clear-cart {
            background: none;
            border: none;
            color: #ff4444;
            cursor: pointer;
            font-weight: 500;
            transition: color 0.2s;
        }

        .clear-cart:hover {
            color: #ff2222;
        }

        /* Footer Styling */
        footer {
            background-color: #1a1a1a;
            color: white;
            padding: 60px 0 20px;
            margin-top: 60px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #fff;
        }

        .footer-section p, .footer-section a {
            color: #a0aec0;
            line-height: 1.6;
            margin-bottom: 0.5rem;
        }

        .footer-section a:hover {
            color: #ff4444;
        }

        .footer-bottom {
            border-top: 1px solid #2d3748;
            padding-top: 20px;
            text-align: center;
            color: #a0aec0;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <header class="navbar">
        <div class="nav-links">
            <div class="nav-group">
                <a href="./homepage.php">Home</a>
                <a href="./aboutus.php">About Us</a>
                <div class="menu-dropdown">
                    <a href="./menu.html">Menu</a>
                    <div class="dropdown-content">
                        <a href="./starters.html">Starters</a>
                        <a href="./vegmaincourse.html">Veg Main Course</a>
                        <a href="./nonvegmaincourse.html">Non-Veg Main Course</a>
                        <a href="./ColdDrinks.html">Cold Drinks</a>
                        <a href="./Deserts.html">Desserts</a>
                        <a href="./MilkShakes.html">Milkshakes and Icecream</a>
          </div>
                </div>
            </div>

            <div class="nav-center">
                <div class="logo-container">
                    <img src="./images/LogoFi.jpg" alt="Saffron Sky Logo" class="logo-image">
                </div>
            </div>

            <div class="nav-group">
                <a href="./blogs_page.html">Blogs</a>
                <a href="./login_page.php" class="auth-btn">Log In</a>
                <a href="./signuppage.php" class="auth-btn">Sign Up</a>
                <a href="./cart_page.php" class="hover:text-orange-500 text-xl flex items-center relative">
                    🛒
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" style="display: none;"></span>
                </a>
            </div>
        </div>
    </header>

    <div class="cart-container">
        <div class="cart-items">
            <div class="cart-header">
                <h1 class="cart-title">Your Cart</h1>
                <button class="clear-cart" onclick="clearCart()">Clear Cart</button>
            </div>
            <div id="cart-items-container">
                <!-- Cart items will be dynamically inserted here -->
            </div>
        </div>

        <div class="order-summary">
            <h2 class="summary-title">Order Summary</h2>
            <div class="summary-item">
                <span>Subtotal</span>
                <span id="subtotal">₹0.00</span>
            </div>
            <div class="summary-item">
                <span>Delivery Fee</span>
                <span id="delivery-fee">₹0.00</span>
            </div>
            <div class="summary-item">
                <span>Tax</span>
                <span id="tax">₹0.00</span>
            </div>
            <div class="summary-total">
                <span>Total</span>
                <span id="total">₹0.00</span>
            </div>
            <button class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
        </div>
    </div>

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
        function loadCart() {
            const cartContainer = document.getElementById('cart-items-container');
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            if (cart.length === 0) {
                cartContainer.innerHTML = `
                    <div class="empty-cart">
                        <h2>Your cart is empty</h2>
                        <p>Add items from our menu to start your order</p>
                        <a href="./menu.html" class="continue-shopping">Continue Shopping</a>
                    </div>
                `;
                updateOrderSummary(0, 0, 0);
                return;
            }

            cartContainer.innerHTML = cart.map((item, index) => `
                <div class="cart-item">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="item-details">
                        <div class="item-name">${item.name}</div>
                        <div class="item-price">₹${item.price}</div>
                    </div>
                    <div class="quantity-controls">
                        <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                        <span>${item.quantity}</span>
                        <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                    </div>
                    <button class="delete-btn" onclick="removeItem(${index})">🗑️</button>
                </div>
            `).join('');

            updateOrderSummary();
        }

        function updateQuantity(index, change) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart[index].quantity = Math.max(1, cart[index].quantity + change);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function removeItem(index) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function clearCart() {
            localStorage.setItem('cart', JSON.stringify([]));
            loadCart();
        }

        function updateOrderSummary() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const deliveryFee = cart.length > 0 ? 50 : 0;
            const tax = subtotal * 0.05; // 5% tax

            document.getElementById('subtotal').textContent = `₹${subtotal.toFixed(2)}`;
            document.getElementById('delivery-fee').textContent = `₹${deliveryFee.toFixed(2)}`;
            document.getElementById('tax').textContent = `₹${tax.toFixed(2)}`;
            document.getElementById('total').textContent = `₹${(subtotal + deliveryFee + tax).toFixed(2)}`;
        }

        function checkout() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                showNotification('Your cart is empty!', 'error');
                return;
            }
            window.location.href = 'checkout_page.php';
        }

        // Load cart when page loads
        document.addEventListener('DOMContentLoaded', loadCart);

        // Add cart count functionality
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
