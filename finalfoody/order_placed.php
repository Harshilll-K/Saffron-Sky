<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - Saffron Sky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .success-icon {
            width: 64px;
            height: 64px;
            background-color: #4CAF50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .success-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .order-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .status-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 20px;
        }

        .status-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .status-active {
            background-color: #4CAF50;
            color: white;
        }

        .status-pending {
            background-color: #e0e0e0;
            color: #666;
        }

        .status-text {
            flex-grow: 1;
        }

        .status-title {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .status-subtitle {
            color: #666;
            font-size: 0.9rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            color: #333;
        }

        .info-label {
            color: #666;
        }

        .restaurant-info {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .restaurant-image {
            width: 48px;
            height: 48px;
            background: #f0f0f0;
            border-radius: 8px;
        }

        .restaurant-details {
            flex-grow: 1;
        }

        .order-items {
            margin-bottom: 20px;
        }

        .payment-summary {
            border-top: 1px solid #eee;
            margin-top: 20px;
            padding-top: 20px;
        }

        .return-btn {
            display: block;
            width: 100%;
            padding: 14px;
            background-color: #1a1a1a;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .return-btn:hover {
            background-color: #333;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #f0f0f0;
            border-radius: 12px;
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-8">
            <div class="success-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold mb-2">Order Confirmed!</h1>
            <p class="text-gray-600" id="order-number">Your order #ORD-12345 has been received and is being prepared.</p>
        </div>

        <div class="order-grid">
            <div class="card">
                <h2 class="text-xl font-bold mb-4">Order Status</h2>
                
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="badge">Preparing</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Order Date:</span>
                    <span id="order-date"></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Order Time:</span>
                    <span id="order-time"></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Estimated Delivery:</span>
                    <span id="estimated-delivery"></span>
                </div>

                <div class="mt-6">
                    <h3 class="font-bold mb-4">Delivery Progress</h3>
                    
                    <div class="status-item">
                        <div class="status-icon status-active">✓</div>
                        <div class="status-text">
                            <div class="status-title">Order Received</div>
                            <div class="status-subtitle">Your order has been received by the restaurant.</div>
                        </div>
                    </div>

                    <div class="status-item">
                        <div class="status-icon status-active">✓</div>
                        <div class="status-text">
                            <div class="status-title">Preparing Your Order</div>
                            <div class="status-subtitle">The restaurant is preparing your food.</div>
                        </div>
                    </div>

                    <div class="status-item">
                        <div class="status-icon status-pending">•</div>
                        <div class="status-text">
                            <div class="status-title">Out for Delivery</div>
                            <div class="status-subtitle">Your order will be on its way soon.</div>
                        </div>
                    </div>

                    <div class="status-item">
                        <div class="status-icon status-pending">•</div>
                        <div class="status-text">
                            <div class="status-title">Delivered</div>
                            <div class="status-subtitle">Enjoy your meal!</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2 class="text-xl font-bold mb-4">Order Details</h2>
                
                <div class="restaurant-info">
                    <div class="restaurant-image"></div>
                    <div class="restaurant-details">
                        <h3 class="font-bold">Saffron Sky</h3>
                        <p class="text-gray-600 text-sm">📍 123 Main St, Anytown, USA</p>
                        <p class="text-gray-600 text-sm">📞 (555) 123-4567</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="font-bold mb-2">Delivery Address</h3>
                    <p class="text-gray-600" id="delivery-address"></p>
                    <p class="text-gray-500 text-sm italic" id="delivery-note"></p>
                </div>

                <div class="order-items" id="order-items">
                    <!-- Order items will be populated dynamically -->
                </div>

                <div class="payment-summary">
                    <div class="info-row">
                        <span>Subtotal</span>
                        <span id="subtotal"></span>
                    </div>
                    <div class="info-row">
                        <span>Delivery Fee</span>
                        <span id="delivery-fee"></span>
                    </div>
                    <div class="info-row">
                        <span>Service Fee</span>
                        <span id="service-fee"></span>
                    </div>
                    <div class="info-row font-bold">
                        <span>Total</span>
                        <span id="total"></span>
                    </div>
                    <div class="info-row text-gray-600 text-sm">
                        <span>Payment Method</span>
                        <span id="payment-method"></span>
                    </div>
                </div>

                <a href="homepage.php" class="return-btn">Return to Home</a>
            </div>
        </div>
    </div>

    <script>
        function generateOrderNumber() {
            const prefix = 'ORD';
            const random = Math.floor(10000 + Math.random() * 90000);
            return `${prefix}-${random}`;
        }

        function formatDate(date) {
            return date.toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
        }

        function formatTime(date) {
            return date.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
        }

        function getEstimatedDelivery(date) {
            const deliveryTime = new Date(date.getTime() + 45 * 60000); // Add 45 minutes
            return `${formatTime(date)} - ${formatTime(deliveryTime)}`;
        }

        function loadOrderDetails() {
            const now = new Date();
            const orderNumber = generateOrderNumber();
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const deliveryDetails = JSON.parse(localStorage.getItem('deliveryDetails')) || {};
            const paymentMethod = localStorage.getItem('paymentMethod') || 'Credit Card';

            // Update order number and date/time
            document.getElementById('order-number').textContent = `Your order ${orderNumber} has been received and is being prepared.`;
            document.getElementById('order-date').textContent = formatDate(now);
            document.getElementById('order-time').textContent = formatTime(now);
            document.getElementById('estimated-delivery').textContent = getEstimatedDelivery(now);

            // Update delivery address
            const address = `${deliveryDetails.address}, ${deliveryDetails.city}, ${deliveryDetails.state} ${deliveryDetails.zipCode}`;
            document.getElementById('delivery-address').textContent = address;
            document.getElementById('delivery-note').textContent = deliveryDetails.instructions || 'Note: Leave at door';

            // Update order items and payment summary
            const orderItemsContainer = document.getElementById('order-items');
            let subtotal = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                orderItemsContainer.innerHTML += `
                    <div class="info-row">
                        <span>${item.quantity} × ${item.name}</span>
                        <span>₹${itemTotal.toFixed(2)}</span>
                    </div>
                `;
            });

            const deliveryFee = 50;
            const serviceFee = 20;
            const total = subtotal + deliveryFee + serviceFee;

            document.getElementById('subtotal').textContent = `₹${subtotal.toFixed(2)}`;
            document.getElementById('delivery-fee').textContent = `₹${deliveryFee.toFixed(2)}`;
            document.getElementById('service-fee').textContent = `₹${serviceFee.toFixed(2)}`;
            document.getElementById('total').textContent = `₹${total.toFixed(2)}`;
            document.getElementById('payment-method').textContent = paymentMethod;
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', loadOrderDetails);
    </script>
</body>
</html> 