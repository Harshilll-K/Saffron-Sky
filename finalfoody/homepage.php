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
  <title>Saffron Sky</title>
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
      /* Add invisible padding area */
      margin-top: 10px;
    }

    /* Add invisible padding area before the dropdown */
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

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(
        rgba(0, 0, 0, 0.2),
        rgba(0, 0, 0, 0.3) 50%,
        rgba(0, 0, 0, 0.4)
      );
      z-index: 1;
    }

    .hero-text {
      max-width: 900px;
      text-align: center;
      position: relative;
      z-index: 2;
      color: white;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
      padding: 2rem;
    }

    .hero-text h1 {
      font-size: 4rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      letter-spacing: 1px;
      line-height: 1.2;
    }

    .hero-text p {
      font-size: 1.4rem;
      margin-bottom: 2.5rem;
      font-weight: 500;
      line-height: 1.6;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    .hero-buttons {
      display: flex;
      gap: 20px;
      justify-content: center;
      margin-top: 2rem;
    }

    .hero-button {
      padding: 15px 35px;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 30px;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s ease;
      background: #ff4444;
      color: white;
      border: 2px solid #ff4444;
    }

    .hero-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .hero-button.outline {
      background: transparent;
      border: 2px solid white;
    }

    .hero-button.outline:hover {
      background: white;
      color: #ff4444;
    }

    /* Menu Section */
    .menu {
      background: #26337A;
      padding: 80px 0;
      color: white;
    }

    .menu h2 {
      color: white;
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 60px;
      text-align: center;
    }

    .special-menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .special-menu-item {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .special-menu-item:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .special-menu-image {
      width: 100%;
      height: 200px;
      overflow: hidden;
    }

    .special-menu-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .special-menu-item:hover .special-menu-image img {
      transform: scale(1.1);
    }

    .special-menu-content {
      padding: 20px;
    }

    .special-menu-tag {
      background: #ff4444;
      color: white;
      padding: 5px 15px;
      border-radius: 20px;
      display: inline-block;
      margin-bottom: 10px;
      font-size: 0.9rem;
    }

    .special-menu-title {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 10px;
      color: #333;
    }

    .special-menu-desc {
      color: #666;
      font-size: 0.9rem;
      margin: 10px 0;
    }

    .special-menu-price {
      display: flex;
      align-items: center;
      gap: 10px;
      justify-content: center;
      margin-top: 15px;
    }

    .special-menu-original-price {
      text-decoration: line-through;
      color: #666;
      font-size: 1rem;
    }

    .special-menu-discounted-price {
      font-size: 1.5rem;
      font-weight: bold;
      color: #ff4444;
    }

    /* Blog Section */
    .blog-section {
      padding: 80px 0;
      background-color: #f8f9fa;
    }

    .blog-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      max-width: 1200px;
      margin: 40px auto 0;
      padding: 0 20px;
    }

    .blog-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .blog-card:hover {
      transform: translateY(-10px);
    }

    .blog-image {
      width: 100%;
      height: 200px;
      overflow: hidden;
    }

    .blog-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .blog-content {
      padding: 20px;
    }

    .blog-title {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 10px;
      color: #333;
    }

    .blog-excerpt {
      color: #666;
      margin-bottom: 15px;
      line-height: 1.6;
    }

    .blog-meta {
      display: flex;
      justify-content: space-between;
      color: #999;
      font-size: 0.9rem;
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

    .cart-button:hover {
      background-color: #27ae60;
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

    /* Add Chatbot Styling */
    .chatbot-button {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #ff4444;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s;
        z-index: 1000;
        border: none;
        font-size: 24px;
    }

    .chatbot-button:hover {
        transform: scale(1.1);
    }

    .chatbot-container {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 350px;
        height: 500px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        display: none;
        flex-direction: column;
        z-index: 1000;
        overflow: hidden;
    }

    .chatbot-header {
        background: #ff4444;
        color: white;
        padding: 15px 20px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close-chat {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }

    .chat-messages {
        flex-grow: 1;
        padding: 20px;
        overflow-y: auto;
    }

    .chat-input-container {
        padding: 15px;
        border-top: 1px solid #eee;
        display: flex;
        gap: 10px;
    }

    .chat-input {
        flex-grow: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 20px;
        outline: none;
    }

    .chat-input:focus {
        border-color: #ff4444;
    }

    .send-button {
        background: #ff4444;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .send-button:hover {
        background: #ff2222;
    }

    .message {
        margin-bottom: 15px;
        max-width: 80%;
    }

    .bot-message {
        background: #f0f0f0;
        padding: 12px;
        border-radius: 12px 12px 12px 0;
        margin-right: auto;
        color: #333;
    }

    .user-message {
        background: #ff4444;
        color: white;
        padding: 12px;
        border-radius: 12px 12px 0 12px;
        margin-left: auto;
    }

    .suggestion-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .suggestion-chip {
        background: #fff;
        border: 1px solid #ff4444;
        color: #ff4444;
        padding: 6px 12px;
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.9rem;
    }

    .suggestion-chip:hover {
        background: #ff4444;
        color: white;
    }

    .logo-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 5px;
      background-color: transparent;
    }

    .logo-image {
      height: 80px;
      width: auto;
      object-fit: contain;
      max-width: none;
      transform: scale(1.3);
    }

    .logo-text {
      font-size: 1.5rem;
      color: #FF7F50;
      font-weight: 600;
      text-transform: lowercase;
      letter-spacing: 1px;
      margin-top: 5px;
    }

    /* Meal Box Styling */
    .meal-box {
      background: #2a2a2a;
      border-radius: 20px;
      overflow: hidden;
      width: 100%;
      max-width: 1000px;
      margin: 0 auto;
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
      display: flex;
      position: relative;
      height: 400px;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .meal-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.3);
    }

    .meal-image {
      width: 50%;
      padding: 20px;
      display: flex;
      align-items: center;
    }

    .meal-image img {
      width: 100%;
      height: 100%;
      border-radius: 15px;
      object-fit: cover;
    }

    .meal-content {
      width: 50%;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: linear-gradient(135deg, #2a2a2a 60%, #ff4444 100%);
      color: white;
    }

    .meal-type {
      background: #ff4444;
      color: white;
      padding: 5px 15px;
      border-radius: 20px;
      display: inline-block;
      margin-bottom: 15px;
      font-weight: 600;
    }

    .meal-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 15px;
      color: white;
    }

    .meal-price {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 15px;
    }

    .original-price {
      font-size: 1.2rem;
      color: #888;
      text-decoration: line-through;
    }

    .discounted-price {
      font-size: 2rem;
      font-weight: 700;
      color: #ff4444;
    }

    .meal-description {
      color: #fff;
      font-size: 1.1rem;
      line-height: 1.6;
      margin-bottom: 20px;
    }

    .slider {
      display: flex;
      transition: transform 0.5s ease-in-out;
      width: 100%;
    }

    .slide {
      min-width: 100%;
      padding: 20px;
    }

    /* Navigation dots */
    .slider-dots {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
    }

    .dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .dot.active {
      background: #ff4444;
    }

    /* User Dropdown Styles */
    .user-dropdown {
      position: relative;
      display: inline-block;
    }

    .user-dropdown-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      padding: 8px 16px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .user-dropdown-btn:hover {
      background-color: #f8f9fa;
    }

    .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background-color: #ff4444;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: white;
      min-width: 200px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      border-radius: 8px;
      z-index: 1001;
      margin-top: 8px;
    }

    .dropdown-content.show {
      display: block;
    }

    .dropdown-content a {
      color: #333;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      transition: all 0.3s ease;
    }

    .dropdown-content a:hover {
      background-color: #f8f9fa;
      color: #ff4444;
    }

    .dropdown-content a i {
      margin-right: 8px;
      width: 20px;
    }

    @media (max-width: 768px) {
      .dropdown-content {
        position: fixed;
        top: 70px;
        left: 0;
        right: 0;
        margin: 0;
        border-radius: 0;
      }
    }
  </style>
</head>

<body>

// session_start();
<?php
// session_start();
include("connect.php");

if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    
    // Fix: Correct table reference & debug query failure
    $query = mysqli_query($conn, "SELECT users.* FROM users WHERE users.email='$email'");

    if (!$query) {
        die("Query Failed: " . mysqli_error($conn)); // Debugging
    }

    while ($row = mysqli_fetch_assoc($query)) {
        echo  "";
    }
}
?>
</body>

<body class="bg-gray-100">

  <!-- Navigation Bar -->
  <nav class="navbar">
    <div class="nav-links">
      <div class="nav-group">
        <a href="./homepage.php">Home</a>
        <a href="./aboutus2.php">About Us</a>
        <div class="menu-dropdown">
          <a href="./menu_2.php">Menu</a>
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
          <div class="user-dropdown">
            <div class="user-dropdown-btn" onclick="toggleDropdown()">
              <div class="user-avatar">
                <?php echo strtoupper(substr($userName, 0, 1)); ?>
              </div>
              <span><?php echo htmlspecialchars($userName); ?></span>
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="dropdown-content" id="userDropdown">
              <a href="./past_orders.php">
                <i class="fas fa-history"></i>
                Past Orders
              </a>
              <a href="./logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
          </div>
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
  </nav>

  <script>
    function toggleDropdown() {
      const dropdown = document.getElementById('userDropdown');
      dropdown.classList.toggle('show');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
      const dropdown = document.getElementById('userDropdown');
      const dropdownBtn = document.querySelector('.user-dropdown-btn');
      
      if (!dropdownBtn.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.remove('show');
      }
    });
  </script>

  <main>
    <!-- Meal Box Slider Section -->
    <section class="meal-box-slider">
      <style>
        .meal-box-slider {
          padding-top: 100px;
          background: url('images/BGFFF.jpg') no-repeat center center;
          background-size: cover;
          overflow: hidden;
          position: relative;
        }
        
        .slider-container {
          max-width: 1400px;
          margin: 0 auto;
          padding: 40px 20px;
          display: flex;
          gap: 30px;
          justify-content: center;
          align-items: center;
          position: relative;
          background: rgba(255, 255, 255, 0.9);
          border-radius: 15px;
          margin: 20px auto;
        }

        .slider {
          display: flex;
          transition: transform 0.5s ease-in-out;
          width: 100%;
        }

        .slide {
          min-width: 100%;
          padding: 20px;
        }
        
        .meal-box {
          background: #2a2a2a;
          border-radius: 20px;
          overflow: hidden;
          width: 100%;
          max-width: 1000px;
          margin: 0 auto;
          box-shadow: 0 10px 20px rgba(0,0,0,0.2);
          display: flex;
          position: relative;
          height: 400px;
          cursor: pointer;
          transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .meal-box:hover {
          transform: translateY(-5px);
          box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        }

        .meal-image {
          width: 50%;
          padding: 20px;
          display: flex;
          align-items: center;
        }

        .meal-image img {
          width: 100%;
          height: 100%;
          border-radius: 15px;
          object-fit: cover;
        }
        
        .meal-content {
          width: 50%;
          padding: 40px;
          display: flex;
          flex-direction: column;
          justify-content: center;
          background: linear-gradient(135deg, #2a2a2a 60%, #ff4444 100%);
          color: white;
        }
        
        .meal-type {
          background: #ff4444;
          color: white;
          padding: 5px 15px;
          border-radius: 20px;
          display: inline-block;
          margin-bottom: 15px;
          font-weight: 600;
        }
        
        .meal-title {
          font-size: 2.5rem;
          font-weight: 700;
          margin-bottom: 15px;
          color: white;
        }
        
        .meal-price {
          display: flex;
          align-items: center;
          gap: 10px;
          margin-bottom: 15px;
        }
        
        .original-price {
          font-size: 1.2rem;
          color: #888;
          text-decoration: line-through;
        }
        
        .discounted-price {
          font-size: 2rem;
          font-weight: 700;
          color: #ff4444;
        }
        
        .membership-badge {
          background: #000;
          color: white;
          padding: 8px 16px;
          border-radius: 8px;
          display: inline-flex;
          align-items: center;
          gap: 8px;
          font-size: 14px;
          margin-top: 10px;
        }

        .slider-nav {
          position: absolute;
          top: 50%;
          transform: translateY(-50%);
          background: #2a2a2a;
          width: 40px;
          height: 40px;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          cursor: pointer;
          border: none;
          color: #fff;
          font-size: 20px;
          z-index: 10;
          box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .prev {
          left: 20px;
        }

        .next {
          right: 20px;
        }

        .search-container {
          max-width: 600px;
          margin: 30px auto;
          padding: 0 20px;
        }

        .search-box {
          display: flex;
          gap: 10px;
        }

        .search-input {
          flex: 1;
          padding: 15px;
          border: 2px solid #444;
          border-radius: 8px;
          font-size: 1rem;
          background-color: #2a2a2a;
          color: #fff;
          transition: border-color 0.3s;
        }

        .search-input::placeholder {
          color: #888;
        }

        .search-input:focus {
          border-color: #ff4444;
          outline: none;
          background-color: #333;
        }

        .search-button {
          background: #ff4444;
          color: white;
          border: none;
          padding: 0 30px;
          border-radius: 8px;
          font-weight: 600;
          cursor: pointer;
          transition: background-color 0.3s;
        }

        .search-button:hover {
          background: #ff2222;
        }
      </style>

      <div class="slider-container">
        <button class="slider-nav prev" onclick="prevSlide()">❮</button>
        <button class="slider-nav next" onclick="nextSlide()">❯</button>
        
        <div class="slider">
          <!-- First Meal Box -->
          <div class="slide">
            <a href="./nonvegmaincourse.html#butter-chicken" class="meal-box">
              <div class="meal-image">
                <img src="nonv/butter chicken.webp" alt="Butter Chicken">
              </div>
              <div class="meal-content">
                <span class="meal-type">Non Veg</span>
                <h2 class="meal-title">Butter Chicken</h2>
                <div class="meal-price">
                  <span class="original-price">₹350</span>
                  <span class="discounted-price">₹299</span>
                </div>
                <p class="meal-description">Tender chicken pieces in rich, creamy tomato gravy</p>
              </div>
            </a>
          </div>

          <!-- Second Meal Box -->
          <div class="slide">
            <a href="./vegmaincourse.html#paneer-tikka" class="meal-box">
              <div class="meal-image">
                <img src="veg main course/Paneer Butter Masala.webp" alt="Paneer Butter Masala">
              </div>
              <div class="meal-content">
                <span class="meal-type">Veg</span>
                <h2 class="meal-title">Paneer Butter Masala</h2>
                <div class="meal-price">
                  <span class="original-price">₹250</span>
                  <span class="discounted-price">₹249</span>
                </div>
                <p class="meal-description">Cottage cheese cubes in rich tomato and butter gravy</p>
              </div>
            </a>
          </div>

          <!-- Third Meal Box -->
          <div class="slide">
            <a href="./nonvegmaincourse.html#chicken-biryani" class="meal-box">
              <div class="meal-image">
                <img src="./nonv/chicken tikka.webp" alt="Chicken Biryani">
              </div>
              <div class="meal-content">
                <span class="meal-type">Non Veg</span>
                <h2 class="meal-title">Chicken Tikka Masala</h2>
                <div class="meal-price">
                  <span class="original-price">₹420</span>
                  <span class="discounted-price">₹330</span>
                </div>
                <p class="meal-description">Fragrant rice cooked with tender chicken and aromatic spices</p>
              </div>
            </a>
          </div>

          <!-- Fourth Meal Box -->
          <div class="slide">
            <a href="./vegmaincourse.html#dal-makhani" class="meal-box">
              <div class="meal-image">
                <img src="veg main course/Shahi Paneer.webp" alt="Dal Makhani">
              </div>
              <div class="meal-content">
                <span class="meal-type">Veg</span>
                <h2 class="meal-title">Shahi Paneer</h2>
                <div class="meal-price">
                  <span class="original-price">₹280</span>
                  <span class="discounted-price">₹269</span>
                </div>
                <p class="meal-description">Paneer in a creamy sauce with nuts and aromatic spices</p>
              </div>
            </a>
          </div>

          <!-- Fifth Meal Box -->
          <div class="slide">
            <a href="./vegmaincourse.html#kadhai-paneer" class="meal-box">
              <div class="meal-image">
                <img src="veg main course/Kadhai Paneer.webp" alt="Kaju Masala">
              </div>
              <div class="meal-content">
                <span class="meal-type">Veg</span>
                <h2 class="meal-title">Kadhai Paneer</h2>
                <div class="meal-price">
                  <span class="original-price">₹290</span>
                  <span class="discounted-price">₹249</span>
                </div>
                <p class="meal-description">Paneer with bell peppers in spicy kadhai masala</p>
              </div>
            </a>
          </div>

          <!-- Sixth Meal Box -->
          <div class="slide">
            <a href="./Deserts.html#gulab-jamun" class="meal-box">
              <div class="meal-image">
                <img src="desert images/gulab jamun.webp" alt="Gulab Jamun">
              </div>
              <div class="meal-content">
                <span class="meal-type">Dessert</span>
                <h2 class="meal-title">Gulab Jamun</h2>
                <div class="meal-price">
                  <span class="original-price">₹150</span>
                  <span class="discounted-price">₹129</span>
                </div>
                <p class="meal-description">Soft milk dumplings soaked in aromatic sugar syrup</p>
              </div>
            </a>
          </div>
        </div>
      </div>

      <!-- Navigation dots -->
      <div class="slider-dots">
        <span class="dot active" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
        <span class="dot" onclick="currentSlide(5)"></span>
        <span class="dot" onclick="currentSlide(6)"></span>
      </div>

      <div class="search-container">
        <div class="search-box">
          <input type="search" class="search-input" placeholder="Search for food...">
          <button onclick="searchFood()" class="search-button">Find Food</button>
        </div>
      </div>
    </section>

    <!-- Text Animation Section -->
    <section class="text-animation-section">
      <style>
        .text-animation-section {
          padding: 60px 20px;
          background: #fff;
          overflow: hidden;
          position: relative;
          min-height: 300px;
          margin: 40px 0;
        }
        .text-container {
          max-width: 1400px;
          margin: 0 auto;
          position: relative;
          height: 300px;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
        }
        .text-row {
          display: flex;
          justify-content: center;
          gap: 30px;
          position: relative;
        }
        .animated-text {
          opacity: 0;
          transform: scale(0.95);
          animation: textFadeIn 6s infinite;
          white-space: nowrap;
          font-family: 'Poppins', sans-serif;
          padding: 10px;
        }
        .text-red {
          color: #e31837;
        }
        .text-gray {
          color: #666666;
        }
        .text-large {
          font-size: 3.5rem;
          font-weight: 700;
          letter-spacing: -1px;
        }
        .text-medium {
          font-size: 3rem;
          font-weight: 600;
        }
        .kannada {
          font-family: 'Noto Sans Kannada', sans-serif;
          font-weight: 700;
        }
        .devanagari {
          font-family: 'Noto Sans Devanagari', sans-serif;
          font-weight: 700;
        }

        @keyframes textFadeIn {
          0% {
            opacity: 0;
            transform: scale(0.95) translateY(10px);
          }
          10%, 90% {
            opacity: 1;
            transform: scale(1) translateY(0);
          }
          100% {
            opacity: 0;
            transform: scale(1.05) translateY(-10px);
          }
        }

        /* Animation delays for each row */
        .row-1 .animated-text:nth-child(1) { animation-delay: 0s; }
        .row-1 .animated-text:nth-child(2) { animation-delay: 0.5s; }
        .row-1 .animated-text:nth-child(3) { animation-delay: 1s; }
        .row-1 .animated-text:nth-child(4) { animation-delay: 1.5s; }

        .row-2 .animated-text:nth-child(1) { animation-delay: 2s; }
        .row-2 .animated-text:nth-child:nth-child(2) { animation-delay: 2.5s; }
        .row-2 .animated-text:nth-child(3) { animation-delay: 3s; }
        .row-2 .animated-text:nth-child(4) { animation-delay: 3.5s; }

        .row-3 .animated-text:nth-child(1) { animation-delay: 4s; }
        .row-3 .animated-text:nth-child(2) { animation-delay: 4.5s; }
        .row-3 .animated-text:nth-child(3) { animation-delay: 5s; }
        .row-3 .animated-text:nth-child(4) { animation-delay: 5.5s; }

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Noto+Sans+Devanagari:wght@400;700&family=Noto+Sans+Kannada:wght@400;700&display=swap');
      </style>

      <div class="text-container">
        <div class="text-row row-1">
          <div class="animated-text text-large text-red">Irresistible</div>
          <div class="animated-text text-large kannada text-gray">ರುಚಿಯಾದ</div>
          <div class="animated-text text-large text-gray">Lababdar</div>
          <div class="animated-text text-large text-red">Heavenly</div>
        </div>
        
        <div class="text-row row-2">
          <div class="animated-text text-medium text-gray">All-in-1-Meal</div>
          <div class="animated-text text-large devanagari text-gray">स्वादिष्ट</div>
          <div class="animated-text text-large text-red">Chicken Tikka</div>
          <div class="animated-text text-medium text-gray">Dal Makhni</div>
        </div>
        
        <div class="text-row row-3">
          <div class="animated-text text-large text-gray">Superfast</div>
          <div class="animated-text text-large text-gray">Authentic</div>
          <div class="animated-text text-medium text-gray">Paneer</div>
          <div class="animated-text text-large text-red">Delicious</div>
        </div>
      </div>
    </section>

    <!-- Box8 Animation Section -->
    <section class="box8-animation py-8">
      <style>
        .box8-animation {
          background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
          padding: 40px 0;
          margin: 20px 0;
        }
        .box8-container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 0 20px;
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
          gap: 20px;
        }
        .box8-item {
          background: white;
          border-radius: 12px;
          padding: 20px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease, box-shadow 0.3s ease;
          text-align: center;
          position: relative;
          overflow: hidden;
        }
        .box8-item:hover {
          transform: translateY(-10px);
          box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .box8-item::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
          transform: translateX(-100%);
          transition: transform 0.6s ease;
        }
        .box8-item:hover::before {
          transform: translateX(100%);
        }
        .box8-icon {
          font-size: 40px;
          color: #fb6107;
          margin-bottom: 15px;
        }
        .box8-title {
          font-size: 20px;
          font-weight: bold;
          margin-bottom: 10px;
          color: #2d3748;
        }
        .box8-description {
          color: #718096;
          font-size: 14px;
          line-height: 1.5;
        }
      </style>
      <div class="box8-container">
        <div class="box8-item">
          <div class="box8-icon">🍔</div>
          <h3 class="box8-title">Fresh Ingredients</h3>
          <p class="box8-description">We use only the freshest ingredients to prepare your favorite dishes</p>
        </div>
        <div class="box8-item">
          <div class="box8-icon">🚚</div>
          <h3 class="box8-title">Fast Delivery</h3>
          <p class="box8-description">Get your food delivered hot and fresh within 30 minutes</p>
        </div>
        <div class="box8-item">
          <div class="box8-icon">⭐</div>
          <h3 class="box8-title">Quality Service</h3>
          <p class="box8-description">Experience the best service with our dedicated team</p>
        </div>
        <div class="box8-item">
          <div class="box8-icon">💳</div>
          <h3 class="box8-title">Easy Payment</h3>
          <p class="box8-description">Multiple payment options for your convenience</p>
        </div>
      </div>
    </section>

    <!-- Popular Menu -->
    <section class="menu text-center py-12">
      <style>
        .menu {
          background: #faf9f6;
          padding: 60px 0;
        }

        .menu h2 {
          color: #333;
          font-size: 2.5rem;
          font-weight: 700;
          margin-bottom: 40px;
        }

        .special-menu-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
          gap: 30px;
          max-width: 1200px;
          margin: 0 auto;
          padding: 0 20px;
        }

        .special-menu-item {
          background: white;
          border-radius: 15px;
          overflow: hidden;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease;
        }

        .special-menu-item:hover {
          transform: translateY(-10px);
          box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .special-menu-image {
          width: 100%;
          height: 200px;
          overflow: hidden;
        }

        .special-menu-image img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.3s ease;
        }

        .special-menu-item:hover .special-menu-image img {
          transform: scale(1.1);
        }

        .special-menu-content {
          padding: 20px;
        }

        .special-menu-tag {
          background: #ff4444;
          color: white;
          padding: 5px 15px;
          border-radius: 20px;
          display: inline-block;
          margin-bottom: 10px;
          font-size: 0.9rem;
        }

        .special-menu-title {
          font-size: 1.5rem;
          font-weight: bold;
          margin-bottom: 10px;
          color: #333;
        }

        .special-menu-desc {
          color: #666;
          font-size: 0.9rem;
          margin: 10px 0;
        }

        .special-menu-price {
          display: flex;
          align-items: center;
          gap: 10px;
          justify-content: center;
          margin-top: 15px;
        }

        .special-menu-original-price {
          text-decoration: line-through;
          color: #666;
          font-size: 1rem;
        }

        .special-menu-discounted-price {
          font-size: 1.5rem;
          font-weight: bold;
          color: #ff4444;
        }
      </style>

      <h2>Today's Special</h2>
      <div class="special-menu-grid">
        <div class="special-menu-item">
          <div class="special-menu-image">
            <img src="nonv/butter chicken.webp" alt="Butter Chicken">
        </div>
          <div class="special-menu-content">
            <span class="special-menu-tag">Chef's Special</span>
            <h3 class="special-menu-title">Butter Chicken</h3>
            <p class="special-menu-desc">Tender chicken pieces in rich, creamy tomato gravy</p>
            <div class="special-menu-price">
              <span class="special-menu-original-price">₹350</span>
              <span class="special-menu-discounted-price">₹299</span>
            </div>
            <button class="cart-button" onclick="addToCart('Butter Chicken', 299, 'nonv/butter chicken.webp')">Add to Cart</button>
          </div>
        </div>

        <div class="special-menu-item">
          <div class="special-menu-image">
            <img src="images/Paneer Tikka Masala.jpg" alt="Paneer Tikka">
          </div>
          <div class="special-menu-content">
            <span class="special-menu-tag">Bestseller</span>
            <h3 class="special-menu-title">Paneer Tikka</h3>
            <p class="special-menu-desc">Grilled cottage cheese with spicy marinade</p>
            <div class="special-menu-price">
              <span class="special-menu-original-price">₹280</span>
              <span class="special-menu-discounted-price">₹249</span>
            </div>
            <button class="cart-button" onclick="addToCart('Paneer Tikka', 249, 'images/Paneer Tikka Masala.jpg')">Add to Cart</button>
          </div>
        </div>

        <div class="special-menu-item">
          <div class="special-menu-image">
            <img src="images/chicken-biryani-recipe.jpg" alt="Chicken Biryani">
          </div>
          <div class="special-menu-content">
            <span class="special-menu-tag">Most Popular</span>
            <h3 class="special-menu-title">Chicken Biryani</h3>
            <p class="special-menu-desc">Fragrant rice cooked with tender chicken and aromatic spices</p>
            <div class="special-menu-price">
              <span class="special-menu-original-price">₹320</span>
              <span class="special-menu-discounted-price">₹279</span>
            </div>
            <button class="cart-button" onclick="addToCart('Chicken Biryani', 279, 'images/chicken-biryani-recipe.jpg')">Add to Cart</button>
          </div>
        </div>

        <div class="special-menu-item">
          <div class="special-menu-image">
            <img src="veg main course/Dal Makhani.webp" alt="Dal Makhani">
          </div>
          <div class="special-menu-content">
            <span class="special-menu-tag">Veg Special</span>
            <h3 class="special-menu-title">Dal Makhani</h3>
            <p class="special-menu-desc">Creamy black lentils cooked overnight with butter and spices</p>
            <div class="special-menu-price">
              <span class="special-menu-original-price">₹250</span>
              <span class="special-menu-discounted-price">₹199</span>
            </div>
            <button class="cart-button" onclick="addToCart('Dal Makhani', 199, 'veg main course/Dal Makhani.webp')">Add to Cart</button>
          </div>
        </div>

        <div class="special-menu-item">
          <div class="special-menu-image">
            <img src="images/Kaju Masala.jpeg" alt="Malai Kofta">
          </div>
          <div class="special-menu-content">
            <span class="special-menu-tag">Veg Deluxe</span>
            <h3 class="special-menu-title">Kaju Masala</h3>
            <p class="special-menu-desc">Soft cottage cheese dumplings in rich creamy gravy</p>
            <div class="special-menu-price">
              <span class="special-menu-original-price">₹290</span>
              <span class="special-menu-discounted-price">₹249</span>
            </div>
            <button class="cart-button" onclick="addToCart('Kaju Masala', 249, 'images/Kaju Masala.jpeg')">Add to Cart</button>
          </div>
        </div>

        <div class="special-menu-item">
          <div class="special-menu-image">
            <img src="desert images/gulab jamun.webp" alt="Gulab Jamun">
          </div>
          <div class="special-menu-content">
            <span class="special-menu-tag">Sweet Special</span>
            <h3 class="special-menu-title">Gulab Jamun</h3>
            <p class="special-menu-desc">Soft milk dumplings soaked in aromatic sugar syrup</p>
            <div class="special-menu-price">
              <span class="special-menu-original-price">₹150</span>
              <span class="special-menu-discounted-price">₹129</span>
            </div>
            <button class="cart-button" onclick="addToCart('Gulab Jamun', 129, 'desert images/gulab jamun.webp')">Add to Cart</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us text-center py-12 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl font-bold mb-8">Why Choose Saffron Sky?</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div
            class="p-6 bg-white rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:transform hover:scale-105">
            <div class="flex justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                stroke="#fb6107" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" x2="12" y1="2" y2="22"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">No Commission Fees</h3>
            <p class="text-gray-600">Keep more of your profits with our commission-free platform</p>
          </div>

          <div
            class="p-6 bg-white rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:transform hover:scale-105">
            <div class="flex justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                stroke="#fb6107" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M3 5V19A9 3 0 0 0 21 19V5"></path>
                <path d="M3 12A9 3 0 0 0 21 12"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Own Your Data</h3>
            <p class="text-gray-600">Full control and ownership of your customer data</p>
          </div>

          <div
            class="p-6 bg-white rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:transform hover:scale-105">
            <div class="flex justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                stroke="#fb6107" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                <path d="m9 11 3 3L22 4"></path>
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Easy Setup</h3>
            <p class="text-gray-600">Get started in minutes with our intuitive platform</p>
          </div>

          <div
            class="p-6 bg-white rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:transform hover:scale-105">
            <div class="flex justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                stroke="#fb6107" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                  d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                </path>
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Boost Engagement</h3>
            <p class="text-gray-600">Engage customers with targeted marketing tools</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Customer Reviews -->
    <section class="testimonials_customers_section">
      <style>
        .testimonials_customers_section {
          padding: 50px 0;
          background-color: #f9f9f9;
          overflow: hidden;
        }

        .testimonials_customers_section h2 {
          text-align: center;
          margin-bottom: 40px;
          font-weight: 600;
          color: #333;
        }

        .testimonials_customers_box {
          background-color: white;
          border-radius: 8px;
          padding: 30px;
          box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
          height: 100%;
          position: relative;
          transition: transform 0.3s ease, box-shadow 0.3s ease;
          overflow: hidden;
        }

        .testimonials_customers_box:hover {
          transform: translateY(-10px);
          box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        /* Glittering effect */
        .testimonials_customers_box:before {
          content: '';
          position: absolute;
          top: -50%;
          left: -50%;
          width: 200%;
          height: 200%;
          background: linear-gradient(45deg,
              rgba(255, 255, 255, 0) 0%,
              rgba(255, 255, 255, 0.1) 25%,
              rgba(255, 255, 255, 0.6) 50%,
              rgba(255, 255, 255, 0.1) 75%,
              rgba(255, 255, 255, 0) 100%);
          transform: rotate(45deg);
          opacity: 0;
          transition: opacity 0.5s;
          pointer-events: none;
        }

        .testimonials_customers_box:hover:before {
          opacity: 1;
          animation: glitter 1.5s ease-in-out infinite;
        }

        @keyframes glitter {
          0% {
            transform: rotate(45deg) translateX(-100%) translateY(-100%);
          }

          100% {
            transform: rotate(45deg) translateX(100%) translateY(100%);
          }
        }

        .profile-icon {
          width: 70px;
          height: 70px;
          background-color: #FF8C00;
          /* Orange */
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          margin: 0 auto 20px;
          color: white;
          font-size: 28px;
          font-weight: bold;
        }

        .testimonials_customers_box p {
          font-style: italic;
          color: #555;
          line-height: 1.6;
          margin-bottom: 20px;
          text-align: center;
        }

        .testimonials_customers_box h3 {
          font-weight: 600;
          margin-bottom: 5px;
          color: #333;
        }

        .testimonials_customers_box span {
          color: #777;
          font-size: 14px;
        }

        .customer-info {
          margin-top: 20px;
          text-align: center;
        }

        .row-2-cols {
          display: flex;
          flex-wrap: wrap;
          justify-content: center;
          max-width: 1200px;
          margin: 0 auto;
        }

        .col-half {
          flex: 0 0 45%;
          max-width: 45%;
          padding: 0 15px;
          margin-bottom: 30px;
        }

        @media (max-width: 768px) {
          .col-half {
            flex: 0 0 90%;
            max-width: 90%;
          }
        }

        .container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 0 15px;
        }
      </style>
      <div class="container">
        <div class="row mx-0">
          <div class="text-2xl">
            <h2>What Our Customers Say</h2>
          </div>
        </div>
        <div class="row-2-cols">
          <div class="col-half">
            <div class="testimonials_customers_box">
              <div class="profile-icon">AS</div>
              <p>""This app is a game-changer! The user interface is smooth, and the real-time tracking is super accurate. 
                My orders always arrive on time, and I love the variety of restaurants available. Plus, the customer service is responsive and helpful. 
                Highly recommend!
                ""</p>
              <div class="customer-info">
                <h3>Abhishek Sakure</h3>
              </div>
            </div>
          </div>
          <div class="col-half">
            <div class="testimonials_customers_box">
              <div class="profile-icon">NK</div>
              <p>Ordered a cheeseburger with fries, and it was absolutely delicious! The food arrived hot, fresh, and well-packaged. The burger was juicy, and the fries were crispy—just like they would be at the restaurant. Definitely ordering again</p>
              <div class="customer-info">
                <h3>Naman Kadam</h3>
              </div>
            </div>
          </div>
          <div class="col-half">
            <div class="testimonials_customers_box">
              <div class="profile-icon">AA</div>
              <p>"The app is easy to use, but sometimes delivery times can be unpredictable. While most orders arrive on time, a few have been delayed without proper updates. Customer support could be more responsive, but overall, it gets the job done."</p>
              <div class="customer-info">
                <h3>Ayush Agarwal</h3>
              </div>
            </div>
          </div>
          <div class="col-half">
            <div class="testimonials_customers_box">
              <div class="profile-icon">VC</div>
              <p>""The pizza I ordered was decent, but it arrived lukewarm. The taste was good, but I expected better packaging to keep it hot. Would consider ordering again, but only if they improve delivery speed."""</p>
              <div class="customer-info">
                <h3>Visharad Chandankar</h3>
              </div>
            </div>
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

  <script>
    // Navbar Scroll Effect
    window.addEventListener("scroll", function () {
      const navbar = document.querySelector(".navbar");
      if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
      } else {
        navbar.classList.remove("scrolled");
      }
    });

    function searchFood() {
        const searchInput = document.querySelector('input[type="search"]');
        const searchTerm = searchInput.value.trim().toLowerCase();

        // Define search terms and their corresponding pages
        const searchMap = {
            // Starters
            "samosa": "./starters.html#samosa",
            "spring roll": "./starters.html#spring-roll",
            "paneer tikka": "./starters.html#paneer-tikka",
            "chicken tikka": "./starters.html#chicken-tikka",
            "veg pakora": "./starters.html#veg-pakora",
            "chicken pakora": "./starters.html#chicken-pakora",
            "paneer pakora": "./starters.html#paneer-pakora",
            "aloo tikki": "./starters.html#aloo-tikki",
            "veg cutlet": "./starters.html#veg-cutlet",
            "chicken cutlet": "./starters.html#chicken-cutlet",

            // Vegetarian Main Course
            "paneer butter masala": "./vegmaincourse.html#paneer-butter-masala",
            "dal makhani": "./vegmaincourse.html#dal-makhani",
            "malai kofta": "./vegmaincourse.html#malai-kofta",
            "palak paneer": "./vegmaincourse.html#palak-paneer",
            "mushroom masala": "./vegmaincourse.html#mushroom-masala",
            "veg biryani": "./vegmaincourse.html#veg-biryani",
            "paneer biryani": "./vegmaincourse.html#paneer-biryani",
            "mushroom biryani": "./vegmaincourse.html#mushroom-biryani",
            "veg pulao": "./vegmaincourse.html#veg-pulao",
            "paneer pulao": "./vegmaincourse.html#paneer-pulao",

            // Non-Vegetarian Main Course
            "butter chicken": "./nonvegmaincourse.html#butter-chicken",
            "chicken biryani": "./nonvegmaincourse.html#chicken-biryani",
            "mutton biryani": "./nonvegmaincourse.html#mutton-biryani",
            "chicken curry": "./nonvegmaincourse.html#chicken-curry",
            "mutton curry": "./nonvegmaincourse.html#mutton-curry",
            "fish curry": "./nonvegmaincourse.html#fish-curry",
            "prawn curry": "./nonvegmaincourse.html#prawn-curry",
            "chicken tikka masala": "./nonvegmaincourse.html#chicken-tikka-masala",
            "mutton rogan josh": "./nonvegmaincourse.html#mutton-rogan-josh",
            "fish fry": "./nonvegmaincourse.html#fish-fry",

            // Cold Drinks
            "coca cola": "./ColdDrinks.html#coca-cola",
            "pepsi": "./ColdDrinks.html#pepsi",
            "sprite": "./ColdDrinks.html#sprite",
            "fanta": "./ColdDrinks.html#fanta",
            "thums up": "./ColdDrinks.html#thums-up",
            "7up": "./ColdDrinks.html#7up",
            "limca": "./ColdDrinks.html#limca",
            "maaza": "./ColdDrinks.html#maaza",
            "slice": "./ColdDrinks.html#slice",
            "appy fizz": "./ColdDrinks.html#appy-fizz",

            // Desserts
            "gulab jamun": "./Deserts.html#gulab-jamun",
            "rasmalai": "./Deserts.html#rasmalai",
            "kheer": "./Deserts.html#kheer",
            "moong dal halwa": "./Deserts.html#moong-dal-halwa",
            "besan ladoo": "./Deserts.html#besan-ladoo",
            "kaju katli": "./Deserts.html#kaju-katli",
            "barfi": "./Deserts.html#barfi",
            "malpua": "./Deserts.html#malpua",
            "phirni": "./Deserts.html#phirni",
            "shahi tukda": "./Deserts.html#shahi-tukda",

            // Category-based redirects
            "starter": "./starters.html",
            "starters": "./starters.html",
            "veg main course": "./vegmaincourse.html",
            "vegetarian": "./vegmaincourse.html",
            "non veg main course": "./nonvegmaincourse.html",
            "non vegetarian": "./nonvegmaincourse.html",
            "cold drink": "./ColdDrinks.html",
            "cold drinks": "./ColdDrinks.html",
            "dessert": "./Deserts.html",
            "desserts": "./Deserts.html",
            "milkshake": "./MilkShakes.html",
            "milkshakes": "./MilkShakes.html",
            "ice cream": "./ice_cream.html"
        };

        // Check for exact matches first
        for (const [key, value] of Object.entries(searchMap)) {
            if (searchTerm === key.toLowerCase()) {
                window.location.href = value;
                return;
            }
        }

        // Check for partial matches
        for (const [key, value] of Object.entries(searchMap)) {
            if (searchTerm.includes(key.toLowerCase())) {
                window.location.href = value;
                return;
            }
        }

        // If no match found, show alert
        alert("No matching results found! Please try searching for specific items or categories.");
    }

    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const slider = document.querySelector('.slider');

    function showSlide(index) {
      if (index >= slides.length) {
        currentSlide = 0;
      } else if (index < 0) {
        currentSlide = slides.length - 1;
      } else {
        currentSlide = index;
      }

      slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    function nextSlide() {
      showSlide(currentSlide + 1);
    }

    function prevSlide() {
      showSlide(currentSlide - 1);
    }

    // Auto slide every 5 seconds
    setInterval(nextSlide, 5000);

    // Add event listeners for navigation dots
    document.querySelectorAll('.dot').forEach((dot, index) => {
      dot.addEventListener('click', (e) => {
        e.preventDefault();
        showSlide(index);
      });
    });

    // Prevent slider navigation from interfering with link clicks
    document.querySelectorAll('.meal-box').forEach(box => {
      box.addEventListener('click', (e) => {
        // If clicking on the navigation buttons, prevent default
        if (e.target.classList.contains('slider-nav')) {
          e.preventDefault();
        }
      });
    });

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
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());

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

    // Add Chatbot JavaScript
    let chatOpen = false;
    const foodCategories = {
        'vegetarian': [
            { name: 'Paneer Butter Masala', price: 299, description: 'Creamy tomato gravy with soft paneer cubes' },
            { name: 'Dal Makhani', price: 249, description: 'Slow-cooked black lentils with butter and cream' },
            { name: 'Malai Kofta', price: 279, description: 'Cottage cheese dumplings in rich gravy' },
            { name: 'Palak Paneer', price: 259, description: 'Fresh spinach with paneer in mild spices' }
        ],
        'non-vegetarian': [
            { name: 'Butter Chicken', price: 349, description: 'Tender chicken in creamy tomato gravy' },
            { name: 'Chicken Biryani', price: 329, description: 'Fragrant rice with spiced chicken' },
            { name: 'Mutton Curry', price: 399, description: 'Tender mutton in rich gravy' },
            { name: 'Fish Curry', price: 379, description: 'Fresh fish in coconut-based gravy' }
        ],
        'starters': [
            { name: 'Paneer Tikka', price: 199, description: 'Grilled cottage cheese with spices' },
            { name: 'Chicken Tikka', price: 249, description: 'Grilled chicken with special marinade' },
            { name: 'Veg Pakora', price: 149, description: 'Crispy fried vegetable fritters' },
            { name: 'Spring Roll', price: 179, description: 'Crispy rolls with vegetable filling' }
        ],
        'desserts': [
            { name: 'Gulab Jamun', price: 129, description: 'Soft milk dumplings in sugar syrup' },
            { name: 'Rasmalai', price: 149, description: 'Soft cheese patties in sweetened milk' },
            { name: 'Kheer', price: 139, description: 'Rice pudding with nuts and saffron' },
            { name: 'Gajar Ka Halwa', price: 159, description: 'Carrot pudding with nuts' }
        ],
        'drinks': [
            { name: 'Cold Coffee', price: 99, description: 'Iced coffee with cream' },
            { name: 'Mango Lassi', price: 89, description: 'Sweet yogurt drink with mango' },
            { name: 'Fresh Lime Soda', price: 69, description: 'Sparkling lime drink' },
            { name: 'Masala Chai', price: 59, description: 'Spiced Indian tea' }
        ]
    };

    // Add user preferences tracking
    let userPreferences = {
        dietaryPreference: null,
        favoriteCategories: [],
        lastOrder: null
    };

    // Enhanced chatbot functions
    function toggleChat() {
        const chatbot = document.getElementById('chatbot');
        chatOpen = !chatOpen;
        chatbot.style.display = chatOpen ? 'flex' : 'none';
        
        if (chatOpen && document.getElementById('chat-messages').children.length === 0) {
            addBotMessage("Hello! 👋 I'm your food recommendation assistant. How can I help you today?");
            showSuggestions(['Browse Menu', 'Track Order', 'Get Recommendations', 'View Special Offers']);
        }
    }

    function addMessage(message, isUser = false) {
        const messagesDiv = document.getElementById('chat-messages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user-message' : 'bot-message'}`;
        messageDiv.textContent = message;
        messagesDiv.appendChild(messageDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function addBotMessage(message) {
        addMessage(message, false);
    }

    function showSuggestions(suggestions) {
        const messagesDiv = document.getElementById('chat-messages');
        const suggestionsDiv = document.createElement('div');
        suggestionsDiv.className = 'suggestion-chips';
        
        suggestions.forEach(suggestion => {
            const chip = document.createElement('button');
            chip.className = 'suggestion-chip';
            chip.textContent = suggestion;
            chip.onclick = () => handleSuggestionClick(suggestion);
            suggestionsDiv.appendChild(chip);
        });
        
        messagesDiv.appendChild(suggestionsDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function handleSuggestionClick(suggestion) {
        addMessage(suggestion, true);
        processUserInput(suggestion);
    }

    function sendMessage() {
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        
        if (message) {
            addMessage(message, true);
            processUserInput(message);
            input.value = '';
        }
    }

    function handleKeyPress(event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    }

    function processUserInput(input) {
        input = input.toLowerCase();
        
        if (input.includes('browse') || input.includes('menu')) {
            addBotMessage("What type of food would you like to explore?");
            showSuggestions(['Vegetarian', 'Non-Vegetarian', 'Starters', 'Desserts', 'Drinks']);
        }
        else if (input.includes('track') || input.includes('order')) {
            addBotMessage("Please enter your order ID to track your order.");
            showSuggestions(['Cancel', 'Back to Menu']);
        }
        else if (input.includes('recommend') || input.includes('suggestion')) {
            if (userPreferences.dietaryPreference) {
                addBotMessage(`Based on your preference for ${userPreferences.dietaryPreference}, here are some recommendations:`);
                const recommendations = foodCategories[userPreferences.dietaryPreference.toLowerCase()];
                recommendations.forEach(item => {
                    addBotMessage(`${item.name} - ₹${item.price}\n${item.description}`);
                });
                showSuggestions(['Add to Cart', 'View More', 'Back to Menu']);
            } else {
                addBotMessage("What type of food do you prefer?");
                showSuggestions(['Vegetarian', 'Non-Vegetarian', 'Both']);
            }
        }
        else if (input.includes('special') || input.includes('offer')) {
            addBotMessage("Here are today's special offers:");
            addBotMessage("1. Buy 2 Starters, Get 1 Free\n2. 20% off on all Main Course items\n3. Free dessert with orders above ₹500");
            showSuggestions(['View Menu', 'Place Order', 'Back to Main']);
        }
        else if (input.includes('vegetarian') || input.includes('veg')) {
            userPreferences.dietaryPreference = 'vegetarian';
            addBotMessage("Great choice! Here are our vegetarian specialties:");
            const recommendations = foodCategories.vegetarian;
            recommendations.forEach(item => {
                addBotMessage(`${item.name} - ₹${item.price}\n${item.description}`);
            });
            showSuggestions(['Add to Cart', 'View More', 'Back to Menu']);
        }
        else if (input.includes('non-vegetarian') || input.includes('non veg')) {
            userPreferences.dietaryPreference = 'non-vegetarian';
            addBotMessage("Perfect! Here are our non-vegetarian specialties:");
            const recommendations = foodCategories['non-vegetarian'];
            recommendations.forEach(item => {
                addBotMessage(`${item.name} - ₹${item.price}\n${item.description}`);
            });
            showSuggestions(['Add to Cart', 'View More', 'Back to Menu']);
        }
        else if (input.includes('add to cart')) {
            addBotMessage("Which item would you like to add to your cart?");
            const currentCategory = userPreferences.dietaryPreference.toLowerCase();
            const items = foodCategories[currentCategory];
            const itemNames = items.map(item => item.name);
            showSuggestions(itemNames);
        }
        else if (input.includes('back') || input.includes('main')) {
            addBotMessage("How can I help you today?");
            showSuggestions(['Browse Menu', 'Track Order', 'Get Recommendations', 'View Special Offers']);
        }
        else {
            addBotMessage("I can help you with menu browsing, order tracking, and recommendations. What would you like to do?");
            showSuggestions(['Browse Menu', 'Track Order', 'Get Recommendations', 'View Special Offers']);
        }
    }
  </script>

  <!-- Add Chatbot HTML -->
  <button class="chatbot-button" onclick="toggleChat()">💬</button>

  <div class="chatbot-container" id="chatbot">
    <div class="chatbot-header">
        <span>Food Recommendation Bot</span>
        <button class="close-chat" onclick="toggleChat()">×</button>
    </div>
    <div class="chat-messages" id="chat-messages">
        <!-- Messages will be added here -->
    </div>
    <div class="chat-input-container">
        <input type="text" class="chat-input" id="chat-input" placeholder="Ask me what to eat..." onkeypress="handleKeyPress(event)">
        <button class="send-button" onclick="sendMessage()">Send</button>
    </div>
  </div>

</body>

</html>