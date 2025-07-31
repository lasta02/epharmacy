<?php
session_start();


// Don't echo or print here for now

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}