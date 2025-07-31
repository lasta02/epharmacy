<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // User is logged in
} else {
    header("Location: login.php");
    exit();
}
