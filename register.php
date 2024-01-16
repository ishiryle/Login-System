<?php
session_start();// Starting Session

//if session exit, user nither need to signin nor need to signup
if(isset($_SESSION['login_id'])){
  if (isset($_SESSION['pageStore'])) {
      $pageStore = $_SESSION['pageStore'];
header("location: $pageStore"); // Redirecting To Profile Page
    }
}

//Register progess start, if user press the signup button
if (isset($_POST['signUp'])) {
if (empty($_POST['fullName']) || empty($_POST['email']) || empty($_POST['newPassword'])) {
echo "Please fill up all the required field.";
}
else
{

$fullName = $_POST['fullName'];
$email = $_POST['email'];
$password = $_POST['newPassword'];
$hash = password_hash($password, PASSWORD_DEFAULT);

$password = $_POST['newPassword'];
if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)){
  echo "Your password is strong.";
  } else {
  echo "Your password is not safe.";
  }//added for password rec.

// Make a connection with MySQL server.
include('config.php');

$sQuery = "SELECT id from account where email=? LIMIT 1";
$iQuery = "INSERT Into account (fullName, email, password) values(?, ?, ?)";

// To protect MySQL injection for Security purpose
$stmt = $conn->prepare($sQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($id);
$stmt->store_result();
$rnum = $stmt->num_rows;

if($rnum==0) { //if true, insert new data
          $stmt->close();
          
          $stmt = $conn->prepare($iQuery);
    	  $stmt->bind_param("sss", $fullName, $email, $hash);
          if($stmt->execute()) {
        echo 'Register successfully, Please login with your login details';}
        } else { 
       echo 'Someone already register with this email address.';
     }
$stmt->close();
$conn->close(); // Closing database Connection
}
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="register.css">
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
      <h1>Register for</h1>
      <h2>Software Engineering Class of 2023 - 2024</h2>
      <p>If you already have an account, you can <a href="login.php">Login here</a>.</p>
      <img class="pic" src="Saly-14.png" alt="Illustration">
    </section>

    <section class="register-form">
      <h2>Sign Up</h2>
      <form action="register.php" method="post" class="Register" onsubmit="return validateForm()">
        <p>Create a new account</p>

        <div class="form-group">
          <label for="fullName">Full Name</label>
          <input id="fullName" name="fullName" type="text" class="form-input" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" class="form-input" required>
        </div>

        <div class="form-group">
          <label for="newPass">Password</label>
          <input id="newPass" type="password" name="newPassword" class="form-input" required>
        </div>

        <div class="form-group">
          <label for="confirmPass">Confirm Password</label>
          <input id="confirmPass" name="confirmPassword" type="password" class="form-input" required>
        </div>

        <button class="form-btn" type="submit" name="signUp">Register</button>

        <div class="text-foot">
          Already have an account? <a href="login.php">Login</a>
        </div>
      </form>
    </section>
  </main>

  <footer class="footer">
    <div class="footer-content">
      <p>&copy; 2023 Shieryl Tendilla</p>
        <ul class="social-icons">
          <li><a href="#"><img src="facebook-icon.png" alt="Facebook"></a></li>
          <li><a href="#"><img src="twitter-icon.png" alt="Twitter"></a></li>
          <li><a href="#"><img src="instagram-icon.png" alt="LinkedIn"></a></li>
        </ul>
    </div>
  </footer>

  <script>
    function validateForm() {
      var newPassword = document.getElementById("newPass").value;
      var confirmPassword = document.getElementById("confirmPass").value;

      if (newPassword !== confirmPassword) {
        alert("Passwords do not match");
        return false;
      }
      return true;
    }
  </script>
</body>
</html>

