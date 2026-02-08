
<!-- user Registration process code here -->
<?php
    session_start();
    
    // Redirect to home page if already logged in
    if (!isset($_SESSION['email'])) {
         header("Location:/mero-blogs/login.php?error=Cannot logout because you are not logged in");
         exit();
     }

     session_destroy();
     header("Location:/mero-blogs/login.php?success=User logged out successfully");
     exit();

?>