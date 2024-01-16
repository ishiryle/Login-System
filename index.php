<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php
    include('session.php');
    $_SESSION['pageStore'] = "welcome.php";

    if (!isset($_SESSION['login_id'])) {
        header("location: login.php"); // Redirecting To login
    }
    ?>

    <div class="welcome-container">
        <div class="welcome-content">
            <h1>Welcome, <?php echo $session_fullName; ?>!</h1>
            <p>You have successfully logged in to your profile.</p>
            <a href="profile.php">View Profile</a>
            <a href="setting.php">Settings</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
