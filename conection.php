<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$db = 'employee';

try {
    // Correct DSN Syntax
    $con = new PDO("mysql:host={$servername};dbname={$db}", $username, $password);

    // Set PDO Error Mode to Exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle Connection Failure
    echo "Connection failed: " . $e->getMessage();
}
// error_reporting(E_ALL); remove the error
//ini_set('display_errors', 0);
?>

