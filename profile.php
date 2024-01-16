<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <?php
    include('session.php');
    $_SESSION['pageStore'] = "profile.php";

    if (!isset($_SESSION['login_id'])) {
        header("location: login.php"); // Redirecting To login
    }
    ?>

    <div class="profile-container">
        <div class="profile-header">
            <h1>User Profile</h1>
        </div>
        <div class="profile-content">
            <div class="profile-avatar">
                <!-- Include user's profile picture here -->
                <img src="Memes.jpeg" alt="User Profile Picture">
            </div>
            <div class="profile-details">
                <h2><?php echo $session_fullName; ?></h2>
            </div>
        </div>
        <div class="profile-actions">
            <a href="index.php">Back to Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
