<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - Saffron Sky</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }
    body {
      background-color: #f5f5f5;
      padding: 20px;
    }
    .nav-menu {
      background: white;
      padding: 15px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }
    .nav-item {
      padding: 10px 20px;
      background: #f8f9fa;
      border-radius: 30px;
      color: #333;
      text-decoration: none;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    .nav-item:hover, .nav-item.active {
      background: #3498db;
      color: white;
      transform: translateY(-2px);
    }
    .category-title {
      font-size: 32px;
      color: #333;
      margin: 20px 0;
      padding-bottom: 10px;
      border-bottom: 2px solid #ff4444;
    }
    .menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 24px;
      padding: 20px 0;
    }
    .menu-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }
    .menu-card:hover {
      transform: translateY(-5px);
    }
    .menu-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .menu-content {
      padding: 20px;
    }
    .veg-badge {
      background-color: #4CAF50;
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      display: inline-block;
      margin-bottom: 8px;
    }
    .nonveg-badge {
      background-color: #ff4444;
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      display: inline-block;
      margin-bottom: 8px;
    }
    .menu-title {
      font-size: 20px;
      font-weight: bold;
      color: #333;
      margin-bottom: 8px;
    }
    .menu-price {
      font-size: 18px;
      color: #ff4444;
      font-weight: bold;
      margin-bottom: 12px;
    }
    .menu-description {
      color: #666;
      font-size: 14px;
      line-height: 1.5;
      margin-bottom: 20px;
    }
    .add-to-cart-btn {
      width: 100%;
      background-color: #3498db;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .add-to-cart-btn:hover {
      background-color: #2980b9;
      transform: translateY(-2px);
    }
    .add-to-cart-btn.added {
      background-color: #2ecc71;
    }
    .cart-icon {
      position: fixed;
      top: 20px;
      right: 20px;
      background: #3498db;
      color: white;
      padding: 12px 24px;
      border-radius: 30px;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      transition: transform 0.3s ease;
    }
    .cart-icon:hover {
      transform: translateY(-2px);
    }
    .cart-count {
      background: white;
      color: #3498db;
      padding: 2px 8px;
      border-radius: 50%;
      font-weight: bold;
    }
    .notification {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background: #2ecc71;
      color: white;
      padding: 12px 24px;
      border-radius: 30px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      display: none;
    }
  </style>
</head>
<body>
  <div id="notification" class="notification">Item added to cart!</div>
  
  <a href="cart_page2.php" class="cart-icon">
    🛒 Cart <span class="cart-count" id="cart-count">0</span>
  </a>

  <nav class="nav-menu">
    <a href="#" class="nav-item" onclick="filterCategory('starter')">Starters</a>
    <a href="#" class="nav-item" onclick="filterCategory('vegmain')">Veg Main Course</a>
    <a href="#" class="nav-item" onclick="filterCategory('nonvegmain')">Non-Veg Main Course</a>
    <a href="#" class="nav-item" onclick="filterCategory('bread')">Breads</a>
    <a href="#" class="nav-item" onclick="filterCategory('drinks')">Drinks</a>
  </nav>

  <h1 class="category-title" id="category-title">All Items</h1>
  
  <div class="menu-grid" id="menu-items-container">
    <!-- Menu items will be dynamically loaded here -->
  </div>

  <script>
    const menuItems = [
      // Starters
      {
        id: 1,
        name: "Paneer Tikka",
        price: 260,
        image: "./images/paneer-tikka.jpg",
        description: "Cottage cheese cubes marinated with yogurt and spices, grilled to perfection in a tandoor.",
        isVeg: true,
        category: "starter"
      },
      {
        id: 2,
        name: "Hara Bhara Kebab",
        price: 230,
        image: "./images/hara-bhara-kebab.jpg",
        description: "Spinach and green pea patties flavored with aromatic spices and herbs.",
        isVeg: true,
        category: "starter"
      },
      {
        id: 3,
        name: "Crispy Corn",
        price: 200,
        image: "./images/crispy-corn.jpg",
        description: "Sweet corn kernels tossed with mild spices and deep-fried until golden and crispy.",
        isVeg: true,
        category: "starter"
      },
      // Veg Main Course
      {
        id: 4,
        name: "Paneer Butter Masala",
        price: 280,
        image: "./images/Paneer Butter Masala.jpeg",
        description: "Cottage cheese cubes in rich, creamy tomato gravy.",
        isVeg: true,
        category: "vegmain"
      },
      {
        id: 5,
        name: "Dal Tadka",
        price: 180,
        image: "./images/Dal Tadka.jpeg",
        description: "Yellow lentils tempered with cumin, garlic, and spices.",
        isVeg: true,
        category: "vegmain"
      },
      // Non-Veg Main Course
      {
        id: 6,
        name: "Butter Chicken",
        price: 320,
        image: "./images/butter-chicken.jpg",
        description: "Tender chicken pieces in rich tomato and butter gravy.",
        isVeg: false,
        category: "nonvegmain"
      },
      // Breads
      {
        id: 7,
        name: "Tandoori Roti",
        price: 30,
        image: "./images/Tandoori Roti.jpeg",
        description: "Whole wheat bread baked in tandoor.",
        isVeg: true,
        category: "bread"
      },
      // Drinks
      {
        id: 8,
        name: "Sweet Lassi",
        price: 80,
        image: "./images/lassi.jpg",
        description: "Traditional yogurt-based sweet drink.",
        isVeg: true,
        category: "drinks"
      }
    ];

    let currentCategory = 'all';

    // Initialize cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function updateCartCount() {
      const count = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
      document.getElementById('cart-count').textContent = count;
    }

    function showNotification(message) {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.style.display = 'block';
      setTimeout(() => {
        notification.style.display = 'none';
      }, 2000);
    }

    function addToCart(itemId) {
      const item = menuItems.find(item => item.id === itemId);
      if (!item) return;

      const existingItemIndex = cart.findIndex(cartItem => cartItem.id === itemId);
      
      if (existingItemIndex >= 0) {
        cart[existingItemIndex].quantity = (cart[existingItemIndex].quantity || 1) + 1;
      } else {
        cart.push({
          id: item.id,
          name: item.name,
          price: item.price,
          image: item.image,
          quantity: 1
        });
      }
      
      localStorage.setItem('cart', JSON.stringify(cart));
      updateCartCount();
      
      const btn = document.getElementById(`add-btn-${itemId}`);
      btn.classList.add('added');
      btn.textContent = 'Added to Cart!';
      showNotification(`${item.name} added to cart!`);
      
      setTimeout(() => {
        btn.classList.remove('added');
        btn.textContent = 'Add to Cart';
      }, 1500);
    }

    function filterCategory(category) {
      currentCategory = category;
      const categoryTitles = {
        'starter': 'Starters',
        'vegmain': 'Vegetarian Main Course',
        'nonvegmain': 'Non-Vegetarian Main Course',
        'bread': 'Breads',
        'drinks': 'Beverages',
        'all': 'All Items'
      };
      
      document.getElementById('category-title').textContent = categoryTitles[category];
      
      // Update active nav item
      document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('active');
        if (item.textContent.toLowerCase().includes(category)) {
          item.classList.add('active');
        }
      });
      
      renderMenuItems();
    }

    function renderMenuItems() {
      const container = document.getElementById('menu-items-container');
      container.innerHTML = '';
      
      const filteredItems = currentCategory === 'all' 
        ? menuItems 
        : menuItems.filter(item => item.category === currentCategory);
      
      filteredItems.forEach(item => {
        const menuCard = document.createElement('div');
        menuCard.className = 'menu-card';
        menuCard.innerHTML = `
          <img src="${item.image}" alt="${item.name}" class="menu-image">
          <div class="menu-content">
            <span class="${item.isVeg ? 'veg-badge' : 'nonveg-badge'}">
              ${item.isVeg ? 'VEG' : 'NON-VEG'}
            </span>
            <h2 class="menu-title">${item.name}</h2>
            <div class="menu-price">₹${item.price}</div>
            <p class="menu-description">${item.description}</p>
            <button class="add-to-cart-btn" id="add-btn-${item.id}" onclick="addToCart(${item.id})">
              Add to Cart
            </button>
          </div>
        `;
        container.appendChild(menuCard);
      });
    }

    // Initialize the page
    document.addEventListener('DOMContentLoaded', () => {
      // Check if there's a category in the URL
      const urlParams = new URLSearchParams(window.location.search);
      const category = urlParams.get('category') || 'all';
      filterCategory(category);
      updateCartCount();
    });
  </script>
</body>
</html>
