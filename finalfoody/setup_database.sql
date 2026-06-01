-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS login17;

-- Use the database
USE login17;

-- Drop the table if it exists (to ensure clean creation)
DROP TABLE IF EXISTS users;

-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 
 
 
 