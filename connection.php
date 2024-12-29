<?php
// Database connection settings
$host = 'localhost'; // Database host (e.g., localhost)
$dbname = 'employee'; // Name of your database
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    // Create a new PDO instance
    $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Set PDO error mode to exception for better error handling
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Uncomment for debugging (optional)
    // echo "Connected successfully!";
} catch (PDOException $e) {
    // If the connection fails, display an error message
    die("Database connection failed: " . $e->getMessage());
}
?>
