<?php
session_start();
include 'dbconnect.php';

if (isset($_POST['Submit'])) {
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    // Use the correct case for the column name in the WHERE clause
    $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Use the correct case for the array key
        if (password_verify($Password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            if ($row['role'] === 'admin') {
                header("Location: admin/1.php");
            } else {
                header("Location: http://localhost:8000/project.php");
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('Email not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CareBasket - Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: linear-gradient(135deg, #2e7d32, #43a047);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
    }
    
    .container {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      position: relative;
      overflow: hidden;
    }
    
    .container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #2e7d32, #43a047);
    }
    
    .logo {
      text-align: center;
      margin-bottom: 30px;
      color: #2e7d32;
      font-size: 24px;
      font-weight: bold;
    }
    
    .logo i {
      margin-right: 10px;
      font-size: 28px;
    }
    
    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
      font-size: 28px;
      font-weight: 600;
    }
    
    .form-group {
      margin-bottom: 20px;
      position: relative;
    }
    
    .form-group i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
      font-size: 16px;
    }
    
    input[type=email], input[type=password] {
      width: 100%;
      padding: 15px 15px 15px 45px;
      border: 2px solid #e1e1e1;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
      background: #f9f9f9;
    }
    
    input[type=email]:focus, input[type=password]:focus {
      outline: none;
      border-color: #2e7d32;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
    }
    
    input[type=email]::placeholder, input[type=password]::placeholder {
      color: #999;
    }
    
    .password-toggle {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
      cursor: pointer;
      font-size: 16px;
      transition: color 0.3s ease;
    }
    
    .password-toggle:hover {
      color: #2e7d32;
    }
    
    button {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, #2e7d32, #43a047);
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      transition: all 0.3s ease;
      margin-top: 10px;
    }
    
    button:hover {
      background: linear-gradient(135deg, #1b5e20, #2e7d32);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
    }
    
    button:active {
      transform: translateY(0);
    }
    
    .signup-text {
      text-align: center;
      margin-top: 25px;
      color: #666;
      font-size: 14px;
    }
    
    .signup-text a {
      color: #2e7d32;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    
    .signup-text a:hover {
      color: #43a047;
      text-decoration: underline;
    }
    
    .forgot-password {
      text-align: center;
      margin-top: 15px;
    }
    
    .forgot-password a {
      color: #666;
      text-decoration: none;
      font-size: 12px;
      transition: color 0.3s ease;
    }
    
    .forgot-password a:hover {
      color: #2e7d32;
    }
    
    .demo-credentials {
      margin-top: 20px;
      padding: 15px;
      background: #f8f9fa;
      border-radius: 8px;
      border-left: 3px solid #2e7d32;
      font-size: 12px;
      color: #666;
    }
    
    .demo-credentials h4 {
      margin-bottom: 8px;
      color: #2e7d32;
      font-size: 14px;
    }
    
    .demo-credentials p {
      margin-bottom: 5px;
    }
    
    .demo-credentials strong {
      color: #333;
    }
    
    @media (max-width: 480px) {
      .container {
        padding: 30px 20px;
        margin: 10px;
      }
      
      h2 {
        font-size: 24px;
      }
      
      input[type=email], input[type=password] {
        padding: 12px 12px 12px 40px;
        font-size: 14px;
      }
      
      button {
        padding: 12px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <i class="fas fa-pills"></i>
      CareBasket
    </div>
    <form action="" method="POST">
      <h2>Welcome Back</h2>
      
      <div class="form-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="Email" placeholder="Email Address" required />
      </div>
      
      <div class="form-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="Password" id="password" placeholder="Password" required />
        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
      </div>
      
      <button type="submit" name="Submit">Sign In</button>
      
      <div class="forgot-password">
        <a href="forgot-password.php">Forgot Password?</a>
      </div>
      
      <p class="signup-text">
        Don't have an account? <a href="http://localhost:8000/reg.php">Sign up here</a>
      </p>
      
      <div class="demo-credentials">
        <h4><i class="fas fa-info-circle"></i> Demo Credentials</h4>
        <p><strong>Admin:</strong> admin@carebasket.com / admin123</p>
        <p><strong>Customer:</strong> Create a new account to test</p>
      </div>
    </form>
  </div>

  <script>
    // Password toggle functionality
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      
      // toggle the eye / eye slash icon
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
      const email = document.querySelector('input[name="Email"]').value;
      const password = document.querySelector('input[name="Password"]').value;
      
      if (!email || !password) {
        e.preventDefault();
        alert('Please fill in all fields');
        return false;
      }
      
      // Basic email validation
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address');
        return false;
      }
    });
  </script>
</body>
</html>
