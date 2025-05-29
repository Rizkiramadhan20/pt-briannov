<?php
/**
 * Database Configuration
 * 
 * This file contains the database connection settings and provides a reusable
 * database connection function.
 */

// Database configuration constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'compon');

/**
 * Get database connection
 * 
 * @return mysqli Database connection object
 * @throws Exception If connection fails
 */
function getDBConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Set charset to utf8mb4
        $conn->set_charset("utf8mb4");
        
        return $conn;
    } catch (Exception $e) {
        // Log error (you can modify this to log to a file or error tracking service)
        error_log("Database connection error: " . $e->getMessage());
        throw $e;
    }
}

// Create a global connection instance
try {
    $db = getDBConnection();
} catch (Exception $e) {
    // Handle connection error
    die("Database connection failed. Please try again later.");
}
?>
