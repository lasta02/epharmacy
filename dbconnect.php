<?php
// dbconnect.php

$host = 'localhost';
$dbname = 'carebasket';
$username = 'root';
$password = 'password';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
