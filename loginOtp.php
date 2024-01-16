<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'config.php';
require 'vendor/autoload.php';

session_start();

if (!isset($_SESSION['login_id'])) {
    header("location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Check if the "Request OTP" button is clicked
if (isset($_POST['requestOtp'])) {
    // Generate OTP, update it in the database, and send the email
    $email = $_SESSION['email']; // Use $_SESSION['email'] to get the email
    $otp = rand(1111, 9999);
    $conn->query("update account set otp = $otp where email = '$email';");
    sendEmail($email, $otp);
    $_SESSION['otp_sent'] = true; // Set a session variable to indicate that OTP has been sent
    $successMessage = "OTP sent successfully!";
}

// Handle OTP submission
if (isset($_POST['submitOtp'])) {
    $userProvidedOtp = $conn->real_escape_string($_POST['otp']);
    $email = $_SESSION['email'];
    $result = $conn->query("SELECT * FROM account WHERE otp = $userProvidedOtp AND email = '$email';");

    if ($result->num_rows) {
        // OTP is correct, mark the user as logged in
        $_SESSION['LOGGEDIN'] = true;
        header("location: index.php"); // Redirect to the profile page
        exit();
    } else {
        $errorMessage = "Invalid OTP. Please try again.";
    }
}

function sendEmail($email, $otp){
   
    $mail = new PHPMailer(true);

    try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'blackydarkid28@gmail.com';
        $mail->Password = 'zwptcuxewezvbxat';
        $mail->SMTPAuth=true;
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->setFrom('tendillashieryle@gmail.com', 'Software Engineering');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject='Your OTP Code';
        $mail->Body = "Here is your OTP code: <br> $otp";
        $mail->send();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
    } catch(Exception $e)
        {echo $e;}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="otp.css">
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
      <p>If you don't have an account, <a href="register.php">Register here!</a></p>
      <img class="pic" src="Saly-14.png" alt="Illustration">
    </section>

    <section class="login-form">
      <form method="post">
        <h2>Request OTP</h2>
        <button type="submit" class="form-btn" name="requestOtp">Send OTP to your email</button>
      </form>

      <?php
      if (isset($errorMessage)) {
          echo '<div class="error-message">' . $errorMessage . '</div>';
      } elseif (isset($successMessage)) {
          echo '<div class="success-message">' . $successMessage . '</div>';
      }
      ?>

      <?php
      if (isset($_SESSION['otp_sent']) && $_SESSION['otp_sent']) {
          // Display the OTP input field and "Submit OTP" button only if OTP has been sent
          echo '<form method="post">
                <h2>Verify OTP</h2>
                <div class="form-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" name="otp" id="otp" class="rlform-input" required>
                </div>
                <button type="submit" class="rlform-btn" name="submitOtp">Submit OTP</button>
              </form>';
      }
      ?>
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

