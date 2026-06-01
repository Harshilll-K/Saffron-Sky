<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - Saffron Sky</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .confirmation-container {
            background: white;
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            position: relative;
        }

        .checkmark-circle {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #4CAF50;
            position: relative;
        }

        .checkmark-stem {
            position: absolute;
            width: 8px;
            height: 30px;
            background: white;
            left: 30px;
            top: 20px;
            transform: rotate(45deg);
        }

        .checkmark-kick {
            position: absolute;
            width: 8px;
            height: 20px;
            background: white;
            left: 20px;
            top: 40px;
            transform: rotate(-45deg);
        }

        h1 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        p {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .order-details {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            text-align: left;
        }

        .order-details h2 {
            color: #333;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            color: #666;
        }

        .total {
            font-weight: bold;
            color: #333;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .home-btn {
            background: #4CAF50;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .home-btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <div class="checkmark">
            <div class="checkmark-circle">
                <div class="checkmark-stem"></div>
                <div class="checkmark-kick"></div>
            </div>
        </div>
        <h1>Order Confirmed!</h1>
        <p>Thank you for your order. Your food will be prepared and delivered to you shortly.</p>
        
        <div class="order-details">
            <h2>Order Summary</h2>
            <div id="order-items">
                <!-- Order items will be populated by JavaScript -->
            </div>
            <div class="total" id="order-total">
                <!-- Total will be populated by JavaScript -->
            </div>
        </div>

        <a href="homepage.php" class="home-btn">Return to Homepage</a>
    </div>

    <script>
        // Get cart items from localStorage
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const orderItemsContainer = document.getElementById('order-items');
        const orderTotalContainer = document.getElementById('order-total');
        
        // Calculate total
        let total = 0;
        
        // Populate order items
        cart.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.className = 'order-item';
            itemElement.innerHTML = `
                <span>${item.name} x ${item.quantity}</span>
                <span>₹${item.price * item.quantity}</span>
            `;
            orderItemsContainer.appendChild(itemElement);
            total += item.price * item.quantity;
        });
        
        // Display total
        orderTotalContainer.textContent = `Total: ₹${total}`;
        
        // Clear the cart after showing the order
        localStorage.removeItem('cart');
    </script>
</body>
</html> 