<?php
session_start();
include 'dbconnect.php';

if (isset($_POST['Submit'])) {
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $Cpassword = $_POST['Cpassword'];

    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    } elseif ($Password != $Cpassword) {
        echo "<script>alert('Passwords do not match');</script>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "<script>alert('Email already registered');</script>";
        } else {
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
            $role = 'customer'; // or 'admin' if you want to create an admin
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $Name, $Email, $hashedPassword, $role);
            if ($stmt->execute()) {
                echo "<script>alert('Registration Successful'); window.location.href='http://127.0.0.1:8000/project.php';</script>";
            } else {
                echo "<script>alert('Registration Failed');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CareBasket - Signup</title>
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
    
    input[type=text], input[type=email], input[type=password] {
      width: 100%;
      padding: 15px 15px 15px 45px;
      border: 2px solid #e1e1e1;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
      background: #f9f9f9;
    }
    
    input[type=text]:focus, input[type=email]:focus, input[type=password]:focus {
      outline: none;
      border-color: #2e7d32;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
    }
    
    input[type=text]::placeholder, input[type=email]::placeholder, input[type=password]::placeholder {
      color: #999;
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
    
    .login-text {
      text-align: center;
      margin-top: 25px;
      color: #666;
      font-size: 14px;
    }
    
    .login-text a {
      color: #2e7d32;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    
    .login-text a:hover {
      color: #43a047;
      text-decoration: underline;
    }
    
    .password-requirements {
      margin-top: 15px;
      padding: 10px;
      background: #f8f9fa;
      border-radius: 6px;
      font-size: 12px;
      color: #666;
      border-left: 3px solid #2e7d32;
    }
    
    .password-requirements ul {
      margin: 5px 0 0 20px;
    }
    
    .password-requirements li {
      margin-bottom: 3px;
    }
    
    @media (max-width: 480px) {
      .container {
        padding: 30px 20px;
        margin: 10px;
      }
      
      h2 {
        font-size: 24px;
      }
      
      input[type=text], input[type=email], input[type=password] {
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
      <h2>Create Account</h2>
      
      <div class="form-group">
        <i class="fas fa-user"></i>
        <input type="text" name="Name" placeholder="Full Name" required />
      </div>
      
      <div class="form-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="Email" placeholder="Email Address" required />
      </div>
      
      <div class="form-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="Password" placeholder="Password" required />
      </div>
      
      <div class="form-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="Cpassword" placeholder="Confirm Password" required />
      </div>
      
      <div class="password-requirements">
        <strong>Password Requirements:</strong>
        <ul>
          <li>At least 8 characters long</li>
          <li>Include uppercase and lowercase letters</li>
          <li>Include at least one number</li>
          <li>Include at least one special character</li>
        </ul>
      </div>
      
      <button type="submit" name="Submit">Create Account</button>
      
      <p class="login-text">
        Already have an account? <a href="login.php">Sign in here</a>
      </p>
    </form>
  </div>
</body>
</html>
