<?php
// dbconnect.php

$host = 'localhost';      // Database host
$dbname = 'carebasket'; // Your database name
$username = 'root';        // Database username
$password = '$hrestha1415*';            // Database password

try {
    // Establish the PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for errors
} catch (PDOException $e) {
    // If the connection fails, show an error message
    die("Connection failed: " . $e->getMessage());
}
?>
