-- Delete all data from order_details table
DELETE FROM order_details;

-- Delete all data from orders table
DELETE FROM orders;

-- Reset auto-increment counters
ALTER TABLE order_details AUTO_INCREMENT = 1;
ALTER TABLE orders AUTO_INCREMENT = 1; 