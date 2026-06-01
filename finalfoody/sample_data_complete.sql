-- Insert sample items
INSERT INTO items (name, price, description, category) VALUES
('Margherita Pizza', 200, 'Classic pizza with tomato sauce and mozzarella', 'Pizza'),
('Chicken Burger', 250, 'Juicy chicken patty with fresh vegetables', 'Burger'),
('Vegetable Pasta', 300, 'Pasta with mixed vegetables in white sauce', 'Pasta'),
('Chocolate Brownie', 180, 'Warm chocolate brownie with ice cream', 'Dessert');

-- Insert sample orders
INSERT INTO orders (customer_id, address, description, date, payment_type, total, status) VALUES
(1, '123 Main Street, City, State', 'Regular delivery', '2024-03-01 12:30:00', 'Wallet', 450, 'Delivered'),
(1, '456 Park Avenue, City, State', 'Express delivery', '2024-03-05 18:45:00', 'Card', 780, 'Delivered'),
(1, '789 Oak Road, City, State', 'Regular delivery', '2024-03-10 20:15:00', 'Wallet', 620, 'Yet to be delivered');

-- Insert sample order details
INSERT INTO order_details (order_id, item_id, quantity, price) VALUES
(1, 1, 2, 200),  -- Order 1: 2x Margherita Pizza
(1, 2, 1, 250),  -- Order 1: 1x Chicken Burger
(2, 3, 3, 300),  -- Order 2: 3x Vegetable Pasta
(2, 4, 1, 180),  -- Order 2: 1x Chocolate Brownie
(3, 1, 1, 200),  -- Order 3: 1x Margherita Pizza
(3, 3, 2, 300);  -- Order 3: 2x Vegetable Pasta 