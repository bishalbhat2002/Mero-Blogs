
<?php
    // This code snipped checks if the user is authenticated before allowing access to the create blog page. If the user is not authenticated, they will be redirected to the login page.
    require_once 'authenticator.php';
?>


<?php
    // Fetch categories from the database
    require_once "../config/db_connect.php";

    try {
    $sql = "SELECT * from users where userId = '{$_SESSION['userId']}'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    } catch (Exception $e) {
     die("Error fetching user: " . $e->getMessage());
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <title>Profile | Mero Blogs</title>
     <link rel="stylesheet" href="/mero-blogs/public/css/style.css" />
</head>

<body>

     <nav class="navbar">
          <div class="logo">
               <a href="home.php">Mero Blogs</a>
          </div>

          <div class="nav-link-container">
               <a href="home.php">All Blogs</a>
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


     <div class="flex-center">

          <div class="profile-container">
               <div class="profile-header">
                    <!-- <img src="/mero-blogs/public/images/boy.jpg" alt="Profile Photo" class="profile-img"> -->
                    <img src="<?php echo $user['photo'] ?? '/mero-blogs/public/images/boy.jpg' ?>" alt="Profile Photo" class="profile-img">
                    <div class="profile-name"><?php echo htmlspecialchars($user['name']); ?></div>
                    <div class="profile-email"><?php echo htmlspecialchars($user['email']); ?></div>

                    <div class="profile-actions-container">
                         <a href="edit-profile.php" class="edit-profile-btn">Edit Profile</a>
                         <a href="change-password.php" class="edit-profile-btn">Change Password</a>
                    </div>


               </div>


               <div class="profile-info">
                    <div class="info-row">
                         <span>Phone</span>
                         <span><?php echo htmlspecialchars($user['phone']); ?></span>
                    </div>

                    <div class="info-row">
                         <span>Address</span>
                         <span><?php echo htmlspecialchars($user['address']); ?></span>
                    </div>

                    <div class="info-row">
                         <span>Gender</span>
                         <span><?php echo htmlspecialchars($user['gender']); ?></span>
                    </div>
               </div>
               <a href="/mero-blogs/src/logout.php" class="logout-btn">Logout</a>


          </div>
     </div>

<?php include 'show-message.php'; ?>
</body>
<script src="/mero-blogs/public/js/script.js"></script>

</html>