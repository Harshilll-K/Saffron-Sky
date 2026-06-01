<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Saffron Sky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }
        }

        .delivery-form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .order-summary {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            border-color: #ff4444;
            outline: none;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .proceed-btn {
            background-color: #ff4444;
            color: white;
            padding: 14px 28px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        .proceed-btn:hover {
            background-color: #ff2222;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            color: #555;
        }

        .summary-total {
            font-weight: 600;
            color: #333;
            border-top: 1px solid #eee;
            padding-top: 12px;
            margin-top: 12px;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: none;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="delivery-form">
            <h2 class="text-2xl font-bold mb-6">Delivery Details</h2>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-input" id="firstName" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-input" id="lastName" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-input" id="email" required>
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="tel" class="form-input" id="phone" required>
            </div>

            <div class="form-group">
                <label class="form-label">Delivery Address</label>
                <textarea class="form-input" rows="3" id="address" required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">City</label>
                    <input type="text" class="form-input" id="city" required>
                </div>
                <div class="form-group">
                    <label class="form-label">State</label>
                    <input type="text" class="form-input" id="state" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">ZIP Code</label>
                <input type="text" class="form-input" id="zipCode" required>
            </div>

            <div class="form-group">
                <label class="form-label">Delivery Instructions (Optional)</label>
                <textarea class="form-input" rows="2" id="instructions"
                    placeholder="Any specific instructions for delivery"></textarea>
            </div>

            <button class="proceed-btn mt-6" onclick="proceedToPayment()">Proceed to Payment</button>
        </div>

        <div class="order-summary">
            <h2 class="text-2xl font-bold mb-6">Order Summary</h2>
            <div id="order-items">
                <!-- Order items will be populated dynamically -->
            </div>
            <div class="summary-item summary-total">
                <span>Total</span>
                <span id="total-amount">₹0.00</span>
            </div>
        </div>
    </div>

    <div id="notification" class="notification"></div>

    <script>
        function loadOrderSummary() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const orderItems = document.getElementById('order-items');
            let subtotal = 0;
            let deliveryFee = cart.length > 0 ? 50 : 0;

            orderItems.innerHTML = '';

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                orderItems.innerHTML += `
                    <div class="summary-item">
                        <span>${item.name} × ${item.quantity}</span>
                        <span>₹${itemTotal.toFixed(2)}</span>
                    </div>
                `;
            });

            const tax = subtotal * 0.05; // 5% tax

            orderItems.innerHTML += `
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>₹${subtotal.toFixed(2)}</span>
                </div>
                <div class="summary-item">
                    <span>Delivery Fee</span>
                    <span>₹${deliveryFee.toFixed(2)}</span>
                </div>
                <div class="summary-item">
                    <span>Tax (5%)</span>
                    <span>₹${tax.toFixed(2)}</span>
                </div>
            `;

            const total = subtotal + deliveryFee + tax;
            document.getElementById('total-amount').textContent = `₹${total.toFixed(2)}`;
        }

        function validateForm() {
            const required = ['firstName', 'lastName', 'email', 'phone', 'address', 'city', 'state', 'zipCode'];
            let isValid = true;
            let firstInvalid = null;

            // Email validation
            const email = document.getElementById('email').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('email').style.borderColor = '#ff4444';
                isValid = false;
                if (!firstInvalid) firstInvalid = document.getElementById('email');
                showNotification('Please enter a valid email address', 'error');
                return false;
            }

            // Phone validation
            const phone = document.getElementById('phone').value.trim();
            const phoneRegex = /^[0-9]{10}$/;
            if (!phoneRegex.test(phone)) {
                document.getElementById('phone').style.borderColor = '#ff4444';
                isValid = false;
                if (!firstInvalid) firstInvalid = document.getElementById('phone');
                showNotification('Please enter a valid 10-digit phone number', 'error');
                return false;
            }

            // ZIP code validation
            const zipCode = document.getElementById('zipCode').value.trim();
            const zipRegex = /^[0-9]{6}$/;
            if (!zipRegex.test(zipCode)) {
                document.getElementById('zipCode').style.borderColor = '#ff4444';
                isValid = false;
                if (!firstInvalid) firstInvalid = document.getElementById('zipCode');
                showNotification('Please enter a valid 6-digit ZIP code', 'error');
                return false;
            }

            required.forEach(field => {
                const element = document.getElementById(field);
                const value = element.value.trim();

                if (!value) {
                    element.style.borderColor = '#ff4444';
                    isValid = false;
                    if (!firstInvalid) firstInvalid = element;
                } else {
                    element.style.borderColor = '#ddd';
                }
            });

            if (!isValid) {
                firstInvalid.focus();
                showNotification('Please fill in all required fields', 'error');
            }

            return isValid;
        }
        function proceedToPayment() {
            if (!validateForm()) return;

            // Collect items from cart
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                showNotification('Your cart is empty!', 'error');
                return;
            }
            const itemsString = cart.map(item => `${item.name} × ${item.quantity}`).join(', ');

            const deliveryDetails = {
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                city: document.getElementById('city').value,
                state: document.getElementById('state').value,
                zipCode: document.getElementById('zipCode').value,
                instructions: document.getElementById('instructions').value,
                items: itemsString
            };

            fetch('save_delivery.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(deliveryDetails)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        localStorage.setItem('deliveryDetails', JSON.stringify(deliveryDetails));
                        window.location.href = 'payment_page.php';
                    } else {
                        const errorMessage = data.message || "Unknown error occurred";
                        showNotification('Failed to save delivery details: ' + errorMessage, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while saving details', 'error');
                });
        }

        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.style.backgroundColor = type === 'success' ? '#4CAF50' : '#f44336';
            notification.style.display = 'block';

            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', loadOrderSummary);
    </script>
</body>

</html>