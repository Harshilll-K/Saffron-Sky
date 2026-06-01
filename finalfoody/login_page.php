<?php
session_start();
$conn = mysqli_connect("localhost", "root", "root", "login17");

if (!$conn) {
    http_response_code(500);
    echo "Database connection failed: " . mysqli_connect_error();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Use prepared statement to prevent SQL injection
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if (!$stmt) {
        http_response_code(500);
        echo "Prepare failed: " . mysqli_error($conn);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Verify the hashed password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['fullname'] = $row['fullname'];
            
            http_response_code(200);
            header("Location: homepage2.php");
            exit();
        } else {
            http_response_code(401);
            echo "Invalid password!";
            exit();
        }
    } else {
        http_response_code(404);
        echo "Email not found in database!";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Safron Sky Login</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      align-items: center;
      justify-content: center;
    }
    /* Navbar Styling */
    .navbar {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      background: transparent;
      z-index: 1000;
      padding: 10px 20px;
    }
    .nav-links {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      width: 100%;
    }
    .nav-links > div {
      display: flex;
      align-items: center;
      gap: 20px;
    }
    .nav-links a {
      text-decoration: none;
      color: rgb(0, 0, 0);
      font-weight: bold;
      padding: 8px 15px;
      transition: color 0.3s;
    }
    .nav-links a:hover {
      color: orange;
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
      background-color: #ff4444;
      color: white;
      transform: translateY(-2px);
    }

    .card {
      background: white;
      padding: 2.5rem;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 420px;
      text-align: center;
      transform: translateY(0);
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card h2 {
      font-size: 28px;
      margin-bottom: 12px;
      color: #2d3748;
    }
    .card p {
      font-size: 15px;
      color: #718096;
      margin-bottom: 24px;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 16px;
      text-align: left;
    }
    .input-group {
      position: relative;
    }
    label {
      font-size: 14px;
      font-weight: 600;
      color: #4a5568;
      margin-bottom: 6px;
      display: block;
    }
    input {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 15px;
      transition: all 0.3s ease;
    }
    input:focus {
      border-color: #4299e1;
      box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
      outline: none;
    }
    .error-message {
      color: #e53e3e;
      font-size: 12px;
      margin-top: 4px;
      display: none;
    }
    .input-error {
      border-color: #e53e3e !important;
    }
    .btn {
      width: 100%;
      background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      border-radius: 8px;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .btn:hover {
      background: linear-gradient(135deg, #3182ce 0%, #2b6cb0 100%);
      transform: translateY(-2px);
    }
    .btn:active {
      transform: translateY(0);
    }
    .footer {
      margin-top: 24px;
      font-size: 14px;
      color: #718096;
    }
    a {
      text-decoration: none;
      color: #4299e1;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    a:hover {
      color: #3182ce;
    }
    .toast {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 16px 24px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      display: flex;
      align-items: center;
      gap: 12px;
      transform: translateX(120%);
      transition: transform 0.3s ease;
      z-index: 1000;
    }
    .toast.show {
      transform: translateX(0);
    }
    .toast.success {
      border-left: 4px solid #48bb78;
    }
    .toast.error {
      border-left: 4px solid #e53e3e;
    }
    .toast i {
      font-size: 20px;
    }
    .toast.success i {
      color: #48bb78;
    }
    .toast.error i {
      color: #e53e3e;
    }
    .loading {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      display: none;
    }
    .loading i {
      font-size: 24px;
      color: #4299e1;
      animation: spin 1s linear infinite;
    }
    @keyframes spin {
      100% { transform: rotate(360deg); }
    }

    /* Dropdown Menu Styles */
    .menu-dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: white;
      min-width: 200px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      border-radius: 8px;
      z-index: 1001;
      top: 100%;
      left: 0;
      padding: 8px 0;
    }

    .menu-dropdown:hover .dropdown-content {
      display: block;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      transition: all 0.3s ease;
    }

    .dropdown-content a:hover {
      background-color: #f8f9fa;
      color: orange;
      padding-left: 24px;
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
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <header class="navbar bg-white bg-opacity-50">
    <div class="nav-links">
      <div class="flex space-x-6 font-lg">
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

      <div class="flex flex-col items-center justify-center flex-grow">
        <img src="./images/LogoFi.jpg" alt="Saffron Sky Logo" class="h-20 mx-auto">
      </div>

      <div class="flex space-x-6 text-lg font-semibold items-center">
        <a href="./blogs_page.html">Blogs</a>
        <a href="./login_page.php" class="auth-btn">Log In</a>
        <a href="./signuppage.php" class="auth-btn">Sign Up</a>
        <a href="./cart_page.php" class="hover:text-orange-500 text-xl flex items-center relative">
          🛒
          <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"></span>
        </a>
      </div>
    </div>
  </header>

  <div class="card">
    <h2>Welcome to Saffron Sky</h2>
    <p>Login to order food from your favorite restaurants</p>
    <form action="login_page.php" method="POST" id="loginForm">
      <div class="input-group">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" placeholder="your@email.com" required>
        <div class="error-message" id="emailError">Please enter a valid email address ending with .com or .net or .in or .org or .co.in or yahoo.in</div>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
      </div>
      <button type="submit" class="btn" name="signUp">
        <span>Login</span>
        <div class="loading">
          <i class="fas fa-spinner"></i>
        </div>
      </button>
    </form>
    <p class="footer">Don't have an account? <a href="signuppage.php">Sign Up</a></p>
  </div>

  <div class="toast" id="toast">
    <i class="fas"></i>
    <span class="message"></span>
  </div>

  <script>
    const form = document.getElementById('loginForm');
    const toast = document.getElementById('toast');
    const loading = document.querySelector('.loading');
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');

    function showToast(message, type) {
      const icon = toast.querySelector('i');
      const messageSpan = toast.querySelector('.message');
      
      toast.className = `toast ${type}`;
      icon.className = `fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}`;
      messageSpan.textContent = message;
      
      toast.classList.add('show');
      setTimeout(() => {
        toast.classList.remove('show');
      }, 3000);
    }

    function validateEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.(com|net|in|org|co\.in)$|^[^\s@]+@yahoo\.in$/;
      if (!emailRegex.test(email)) {
        emailInput.classList.add('input-error');
        emailError.style.display = 'block';
        emailError.textContent = 'Please enter a valid email address ending with .com or .net or .in or .org or .co.in or yahoo.in';
        return false;
      } else {
        emailInput.classList.remove('input-error');
        emailError.style.display = 'none';
        return true;
      }
    }

    // Real-time email validation
    emailInput.addEventListener('input', function() {
      validateEmail(this.value);
    });

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      const email = emailInput.value.trim();
      const password = document.getElementById('password').value;

      // Validate email
      if (!validateEmail(email)) {
        emailInput.focus();
        return;
      }

      loading.style.display = 'flex';
      
      try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
          method: 'POST',
          body: formData
        });
        
        if (response.ok) {
          showToast('Login successful! Redirecting...', 'success');
          setTimeout(() => {
            window.location.href = 'homepage.php';
          }, 1500);
        } else {
          const data = await response.text();
          if (data.includes('Invalid password')) {
            showToast('Invalid password. Please try again.', 'error');
          } else if (data.includes('Email not found')) {
            showToast('Email not found. Please check your email or sign up.', 'error');
          } else {
            showToast('An error occurred. Please try again.', 'error');
          }
        }
      } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
      } finally {
        loading.style.display = 'none';
      }
    });
  </script>

</body>
</html>
