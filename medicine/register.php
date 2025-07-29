<?php
session_start();
require '../db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);
            if ($stmt->execute()) {
                $success = "Registration successful. You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Failed to register. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - CareBasket</title>
    <link rel="stylesheet" href="../assets/medicine.css">
</head>
<body>
    <h2 style="text-align:center; margin-top:2rem;">Register at CareBasket</h2>
    <form method="POST" action="" style="max-width: 400px; margin: 2rem auto;">
        <?php if ($error): ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>
        <label>Name:</label>
        <input type="text" name="name" required placeholder="Your full name" />
        <label>Email:</label>
        <input type="email" name="email" required placeholder="Your email address" />
        <label>Password:</label>
        <input type="password" name="password" required placeholder="Create a password" />
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required placeholder="Confirm password" />
        <button type="submit" style="margin-top:1rem;">Register</button>
    </form>
    <p style="text-align:center;">Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
