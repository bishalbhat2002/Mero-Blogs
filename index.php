<?php
session_start();

// Store name, email, role, photo in session....

if (!isset($_SESSION['email'])) {
       header('location:login.php');
       exit();
}


$success_msg = "Welcome " . $_SESSION['name'] . "!";

if ($_SESSION['email']) {
       header("location:/mero-blogs/src/home.php?success=" . urlencode($success_msg));
       exit();
}

?>