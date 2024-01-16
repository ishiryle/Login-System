<?php
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "test";

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if($conn->connect_errno){
    echo json_encode(['status' => $conn->connect_error]);
    exit();
}
?>