<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cancellation - Saffron Sky</title>
    <style>
        .cancellation-window {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            max-width: 400px;
            width: 90%;
            text-align: center;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translate(-50%, -60%);
                opacity: 0;
            }
            to {
                transform: translate(-50%, -50%);
                opacity: 1;
            }
        }

        .cancellation-window h2 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .cancellation-window p {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .timer {
            font-size: 2rem;
            font-weight: bold;
            color: #ff4444;
            margin: 1rem 0;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .cancel-btn, .keep-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
        }

        .cancel-btn {
            background: #ff4444;
            color: white;
        }

        .cancel-btn:hover {
            background: #cc0000;
        }

        .keep-btn {
            background: #f8f9fa;
            color: #333;
        }

        .keep-btn:hover {
            background: #e9ecef;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="cancellation-window">
        <h2>Cancel Order?</h2>
        <p>You have 1 minute to cancel your order. After this time, your order will be processed and cannot be cancelled.</p>
        <div class="timer" id="timer">01:00</div>
        <div class="button-group">
            <button class="cancel-btn" onclick="cancelOrder()">Cancel Order</button>
            <button class="keep-btn" onclick="keepOrder()">Keep Order</button>
        </div>
    </div>

    <script>
        let timeLeft = 60;
        const timerElement = document.getElementById('timer');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                window.location.href = 'order_confirmed.php';
            }
            timeLeft--;
        }

        const timerInterval = setInterval(updateTimer, 1000);

        function cancelOrder() {
            if (confirm('Are you sure you want to cancel your order?')) {
                // Clear the cart
                localStorage.removeItem('cart');
                // Redirect to homepage
                window.location.href = 'homepage.php';
            }
        }

        function keepOrder() {
            window.location.href = 'order_confirmed.php';
        }
    </script>
</body>
</html> 