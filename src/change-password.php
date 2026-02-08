<?php
    // This code snipped checks if the user is authenticated before allowing access to the create blog page. If the user is not authenticated, they will be redirected to the login page.
    require_once 'authenticator.php';
?>


<!-- Code to update password.. -->
<?php
    // Check if change password form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $currentPassword = trim($_POST['current_password'] ?? '');
    $newPassword     = trim($_POST['new_password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    // Check if required fields are empty
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        header("Location:?error=All fields are required");
        exit();
    }

    if(strlen($newPassword) < 6 || strlen($newPassword) > 20) {
        header("Location:?error=New password must be 6-20 characters long");
        exit();
    }
    if(strlen($confirmPassword) < 6 || strlen($confirmPassword) > 20) {
        header("Location:?error=Confirm password must be 6-20 characters long");
        exit();
    }

    if($newPassword === $currentPassword) {
          header("Location:?error=Current and new passwords can't be same.");
          exit();
      }

    // Check if new passwords match
    if ($newPassword !== $confirmPassword) {
        header("Location:?error=New passwords do not match");
        exit();
    }

    // Connect to DB
    require_once "../config/db_connect.php";

    try {
        // Fetch current password from DB
        $userId   = $_SESSION['userId'];
        $sql      = "SELECT password FROM users WHERE userId = $userId";
        $result   = $conn->query($sql);
        $userData = $result->fetch_assoc();

        // Verify current password
        if ($currentPassword !== $userData['password']) {
            header("Location:?error=Current password is incorrect");
            exit();
        }

        // Update password in DB
        $updateSql = "UPDATE users SET password = '$newPassword' WHERE userId = $userId";
        $conn->query($updateSql);

        session_destroy(); // Log out the user after password change

        header("Location:/mero-blogs/login.php?success=Password updated successfully");
        exit();

    } catch (Exception $e) {
        die("Location:?error=Error updating password: " . $e->getMessage());
    }
    }

?>







<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password | Mero Blogs</title>
  <link rel="stylesheet" href="/mero-blogs/public/css/style.css">
</head>

<body>

    <nav class="navbar">
    <div class="logo">
      <a href="home.php">Mero Blogs</a>
    </div>

    <div class="nav-link-container">
      <a href="home.php" class="active">All Blogs</a>
      <a href="search-blogs.php">Search Blogs</a>
      <a href="manage-blogs.php">Manage Vlogs</a>
    </div>

    <a class="profile" href="profile.php">
      <img
         src="<?php echo $_SESSION['photo'] ?? '/mero-blogs/public/images/boy.jpg' ?>"
        alt="Profile"
        class="profilePictureIcon" />
    </a>
  </nav>



  <div class="change-password-wrapper">
    <div class="change-password-box">
      <h2>Change Password</h2>

      <form action="" method="POST" id="change-password-form"">

        <div class="form-group relative">
          <label>Current Password</label>
          <input type="password" name="current_password" id="current-password" placeholder="Enter current password" required>
          <button id="toggle-current-password" type="button" class="toggle-current-password"></button>
          <p class="error-msg" id="currentPasswordError"></p>
        </div>

        <div class="form-group relative">
          <label>New Password</label>
          <input type="password" name="new_password" id="new-password" placeholder="Enter new password" required>
          <button id="toggle-new-password" type="button" class="toggle-new-password"></button>
          <p class="error-msg" id="newPasswordError"></p>
        </div>

        <div class="form-group relative">
          <label>Confirm New Password</label>
          <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirm new password" required>
          <button id="toggle-confirm-password" type="button" class="toggle-confirm-password"></button>
          <p class="error-msg" id="confirmPasswordError"></p>
        </div>

        <button type="submit" class="btn-change-password">
          Update Password
        </button>

      </form>
    </div>
  </div>

  <?php include 'show-message.php'; ?>
  <script src="/mero-blogs/public/js/script.js"></script>

</body>
</html>
