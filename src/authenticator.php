<?php 
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: /mero-blogs/login.php");
    exit();
}

?>