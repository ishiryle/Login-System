<?php

session_start(); 

//if session exit, user nither need to signin nor need to signup
if(isset($_SESSION['login_id'])){
  if (isset($_SESSION['pageStore'])) {
      $pageStore = $_SESSION['pageStore'];
header("location: $pageStore"); // Redirecting To Profile Page
    }
}

//Login progess start, if user press the signin button
if (isset($_POST['signIn'])) {
  if (empty($_POST['email']) || empty($_POST['password'])) {
      echo "Username & Password should not be empty";
  } else {
      $email = $_POST['email'];
      $password = $_POST['password'];

      // Make a connection with MySQL server.
      include('config.php');

      $sQuery = "SELECT id, password from account where email=? LIMIT 1";

      // To protect MySQL injection for Security purpose
      $stmt = $conn->prepare($sQuery);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->bind_result($id, $hash);
      $stmt->store_result();

      if ($stmt->fetch()) {
          if (password_verify($password, $hash)) {
              $_SESSION['login_id'] = $id;
              $_SESSION['email'] = $email; // Set the email in the session

              if (isset($_SESSION['pageStore'])) {
                  $pageStore = $_SESSION['pageStore'];
              } else {
                  $pageStore = "loginOtp.php"; // Redirect to loginOtp.php
              }
              header("location: $pageStore"); // Redirecting To Profile
              $stmt->close();
              $conn->close();
          } else {
              echo 'Invalid Username & Password';
          }
      } else {
          echo 'Invalid Username & Password';
      }
      $stmt->close();
      $conn->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="forms.css">
</head>
<body>
  <header class="header">
    <nav>
      <ul class="nav-menu">
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </nav>
  </header>
  <main class="content">
    <section class="intro">
      <h1>Welcome to Software Engineering</h1>
      <h2>Class of 2023 - 2024</h2>
      <p>If you don't have an account</p>
      <p>You can <a href="register.php">Register here!</a></p>
      <img class="pic" src="Saly-14.png" alt="Illustration">
    </section>
    
    <section class="login-form">
      <h2>Sign in</h2>
      <form action="login.php" method="post" id="login-form">
        <div class="form-group">
          <label for="email">Email or Username</label>
          <input type="email" name="email" id="email" class="form-input" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" class="form-input" required>
        </div>
        <button type="submit" class="form-btn" name="signIn">Login</button>
      </form>
      <p class="text-foot">Don't have an account? <a href="register.php">Register</a></p>
    </section>
  </main>

  <footer class="footer">
    <div class="footer-content">
      <p>&copy; 2023 Shieryl Tendilla</p>
      <ul class="social-icons">
        <li><a href="#"><img src="facebook-icon.png" alt="Facebook"></a></li>
        <li><a href="#"><img src="twitter-icon.png" alt="Twitter"></a></li>
        <li><a href="#"><img src="instagram-icon.png" alt="Instagram"></a></li>
      </ul>
    </div>
  </footer>
</body>
</html>
