<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Saffron Sky</title>
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

        .payment-form {
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

        .payment-methods {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .payment-method {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .place-order-btn {
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

        .place-order-btn:hover {
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

        .demo-cards {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 14px;
        }

        .demo-cards h3 {
            margin-bottom: 10px;
            color: #666;
        }

        .demo-card-info {
            color: #666;
            margin-bottom: 5px;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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

        /* Add UPI QR code modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        .modal img {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            cursor: pointer;
            color: white;
        }

        .confirm-payment-btn {
            background-color: #6b21dc;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .confirm-payment-btn:hover {
            background-color: #5b16c5;
        }

        /* Cancellation Window Styles */
        .cancellation-window {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .cancellation-window h3 {
            margin-bottom: 20px;
            color: #333;
        }

        .cancellation-window p {
            margin-bottom: 20px;
            color: #666;
        }

        .cancellation-window .timer {
            font-size: 24px;
            font-weight: bold;
            color: #6b21dc;
            margin-bottom: 20px;
        }

        .cancellation-window .buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .cancellation-window button {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .cancel-order-btn {
            background-color: #dc2626;
            color: white;
        }

        .cancel-order-btn:hover {
            background-color: #b91c1c;
        }

        .continue-order-btn {
            background-color: #6b21dc;
            color: white;
        }

        .continue-order-btn:hover {
            background-color: #5b16c5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="payment-form">
            <h2 class="text-2xl font-bold mb-6">Payment Details</h2>
            
            <div class="form-group">
                <label class="form-label">Payment Method</label>
                <div class="payment-methods">
                    <div class="payment-method">
                        <input type="radio" id="credit" name="payment" value="credit" checked>
                        <label for="credit">Credit/Debit Card</label>
                    </div>
                    <div class="payment-method">
                        <input type="radio" id="upi" name="payment" value="upi">
                        <label for="upi">UPI Payment</label>
                    </div>
                    <div class="payment-method">
                        <input type="radio" id="cash" name="payment" value="cash">
                        <label for="cash">Cash on Delivery</label>
                    </div>
                </div>
            </div>

            <div id="card-details">
                <div class="form-group">
                    <label class="form-label">Card Number</label>
                    <input type="text" class="form-input" placeholder="1234 5678 9012 3456" maxlength="19" id="card-number">
                </div>

                <div class="card-row">
                    <div class="form-group">
                        <label class="form-label">Expiry Date</label>
                        <input type="text" class="form-input" placeholder="MM/YY" maxlength="5">
                    </div>
                    <div class="form-group">
                        <label class="form-label">CVV</label>
                        <input type="text" class="form-input" placeholder="123" maxlength="3">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Name on Card</label>
                    <input type="text" class="form-input" placeholder="John Doe">
                </div>
            </div>

            <div class="demo-cards">
                <h3>Demo Cards for Testing:</h3>
                <div class="demo-card-info">✅ Success Card: 4242 4242 4242 4242</div>
                <div class="demo-card-info">❌ Decline Card: 4000 0000 0000 0002</div>
                <div class="demo-card-info">🏦 Different Card Types:</div>
                <div class="demo-card-info">- Visa Debit: 4000 0566 5566 5556</div>
                <div class="demo-card-info">- Mastercard: 5555 5555 5555 4444</div>
                <div class="demo-card-info">- American Express: 3782 822463 10005</div>
                <div class="demo-card-info">- Discover: 6011 1111 1111 1117</div>
                <div class="demo-card-info">💳 Any future date for expiry (MM/YY)</div>
                <div class="demo-card-info">🔒 Any 3 digits for CVV (4 digits for Amex)</div>
            </div>

            <button class="place-order-btn mt-6" onclick="processPayment()">Place Order</button>
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

    <!-- Add UPI QR Modal -->
    <div id="upiModal" class="modal">
        <span class="close-modal" onclick="closeUpiModal()">&times;</span>
        <div class="modal-content">
            <h3 class="text-xl font-bold mb-4">Pay using PhonePe</h3>
            <p class="mb-4">Scan the QR code using any UPI app</p>
            <img src="./images/qr.jpg" alt="PhonePe QR Code">
            <p class="text-sm mb-4">After successful payment, click the button below</p>
            <button class="confirm-payment-btn" onclick="confirmUpiPayment()">Confirm Payment</button>
        </div>
    </div>

    <!-- Add Cancellation Window Modal -->
    <div id="cancellationWindow" class="cancellation-window">
        <h3>Order Cancellation Window</h3>
        <p>You have <span id="countdown">60</span> seconds to cancel your order</p>
        <div class="timer" id="timer">01:00</div>
        <div class="buttons">
            <button class="cancel-order-btn" onclick="cancelOrder()">Cancel Order</button>
            <button class="continue-order-btn" onclick="continueOrder()">Continue Order</button>
        </div>
    </div>

    <script>
        // Format card number input
        document.getElementById('card-number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';
            for(let i = 0; i < value.length; i++) {
                if(i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            e.target.value = formattedValue;
        });

        // Load and display cart items
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

        // Add payment method change handler
        function handlePaymentMethodChange() {
            const selectedMethod = document.querySelector('input[name="payment"]:checked').value;
            const cardDetails = document.getElementById('card-details');
            const placeOrderBtn = document.querySelector('.place-order-btn');
            const demoCards = document.querySelector('.demo-cards');
            
            if (selectedMethod === 'cash') {
                cardDetails.style.display = 'none';
                demoCards.style.display = 'none';
                placeOrderBtn.textContent = 'Place Order (Cash on Delivery)';
            } else if (selectedMethod === 'upi') {
                cardDetails.style.display = 'none';
                demoCards.style.display = 'none';
                placeOrderBtn.textContent = 'Pay with UPI';
            } else {
                cardDetails.style.display = 'block';
                demoCards.style.display = 'block';
                placeOrderBtn.textContent = 'Place Order';
            }
        }

        // Add event listeners to payment method radio buttons
        document.querySelectorAll('input[name="payment"]').forEach(radio => {
            radio.addEventListener('change', handlePaymentMethodChange);
        });

        let countdownTimer;
        let timeLeft = 60;
        let paymentMethod = '';

        function showCancellationWindow(method) {
            paymentMethod = method;
            document.getElementById('cancellationWindow').style.display = 'block';
            startCountdown();
        }

        function startCountdown() {
            timeLeft = 60;
            updateTimerDisplay();
            countdownTimer = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();
                if (timeLeft <= 0) {
                    clearInterval(countdownTimer);
                    continueOrder();
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('timer').textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            document.getElementById('countdown').textContent = timeLeft;
        }

        function cancelOrder() {
            clearInterval(countdownTimer);
            document.getElementById('cancellationWindow').style.display = 'none';
            
            if (paymentMethod === 'Cash on Delivery') {
                showNotification('Order cancelled. Please come again!', 'error');
                setTimeout(() => {
                    window.location.href = 'homepage.php';
                }, 2000);
            } else {
                showNotification('Order cancelled. Refund will be processed within 3-5 business days.', 'error');
                setTimeout(() => {
                    window.location.href = 'homepage.php';
                }, 2000);
            }
        }

        function continueOrder() {
            clearInterval(countdownTimer);
            document.getElementById('cancellationWindow').style.display = 'none';
            window.location.href = 'order_placed.php';
        }

        // Modify payment processing functions
        function processPayment() {
            const selectedMethod = document.querySelector('input[name="payment"]:checked').value;
            
            if (selectedMethod === 'cash') {
                showNotification('Order placed successfully!');
                showCancellationWindow('Cash on Delivery');
                return;
            }

            if (selectedMethod === 'upi') {
                showUpiModal();
                return;
            }

            // Handle card payment
            const cardNumber = document.getElementById('card-number').value.replace(/\s/g, '');
            const expiryDate = document.querySelector('input[placeholder="MM/YY"]').value;
            const cvv = document.querySelector('input[placeholder="123"]').value;
            const cardName = document.querySelector('input[placeholder="John Doe"]').value;

            // Validate card details
            if (!cardNumber || !expiryDate || !cvv || !cardName) {
                showNotification('Please fill in all card details', 'error');
                return;
            }

            // Test card scenarios
            const testCards = {
                '4242424242424242': { status: 'success', message: 'Payment successful!' },
                '4000000000000002': { status: 'error', message: 'Card declined. Your card was declined.' },
                '4000056655665556': { status: 'success', message: 'Visa Debit payment successful!' },
                '5555555555554444': { status: 'success', message: 'Mastercard payment successful!' },
                '378282246310005': { status: 'success', message: 'American Express payment successful!' },
                '6011111111111117': { status: 'success', message: 'Discover payment successful!' }
            };

            const cardResult = testCards[cardNumber];
            
            if (cardResult) {
                showNotification(cardResult.message, cardResult.status);
                if (cardResult.status === 'success') {
                    showCancellationWindow('Credit Card');
                } else {
                    showNotification('Payment failed. Please try again.', 'error');
                }
            } else {
                showNotification('Invalid card number. Please use one of the test cards.', 'error');
            }
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

        function showUpiModal() {
            document.getElementById('upiModal').style.display = 'flex';
        }

        function closeUpiModal() {
            document.getElementById('upiModal').style.display = 'none';
        }

        function confirmUpiPayment() {
            showNotification('Payment successful!');
            showCancellationWindow('UPI Payment');
        }

        // Initialize payment method display
        document.addEventListener('DOMContentLoaded', () => {
            loadOrderSummary();
            handlePaymentMethodChange();
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('upiModal');
            if (event.target === modal) {
                closeUpiModal();
            }
        }
    </script>
</body>
</html> 