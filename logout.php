<?php
session_start(); //Starting session

if(session_destroy()) {//Destroying All sessions
    header("location: login.php");//Redirecting to login page
}
?>