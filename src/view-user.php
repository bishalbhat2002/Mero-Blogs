<?php
    // This code snipped checks if the user is authenticated before allowing access to the create blog page. If the user is not authenticated, they will be redirected to the login page.
    require_once 'authenticator.php';

    // Get user id from URL
    $viewUserId = (int) $_GET['id'];

    if (! $viewUserId) {
    header("Location: home.php?error=Please provide a valid user ID.");
    exit();
    }
?>


<?php
    // Fetch user details from the database
    require_once "../config/db_connect.php";

    try {
    $sql    = "SELECT * from users where userId = '{$viewUserId}'";
    $result = $conn->query($sql);
    } catch (Exception $e) {
    die("Error fetching user: " . $e->getMessage());
    }

    if ($result->num_rows === 0) {
    header("Location: home.php?error=User not found for provided ID.");
    exit();
    }

    $user = $result->fetch_assoc();
?>


<?php
    // Fetch blogs from the database
    try {
        $sql = "SELECT blogs.*, users.name, categories.categoryName
               FROM blogs JOIN users ON blogs.userId = users.userId
               JOIN categories ON blogs.categoryId = categories.categoryId
               WHERE blogs.userId = '$viewUserId'
               ORDER BY blogs.createdAt DESC";

    $result = $conn->query($sql);

    } catch (Exception $e) {
    die("Error fetching blogs: " . $e->getMessage());
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <title>View Profile | Mero Blogs</title>
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

                    <img src="<?php echo $user['photo'] ?? '/mero-blogs/public/images/boy.jpg' ?>" alt="Profile Photo" class="profile-img">
                    <div class="profile-name"><?php echo htmlspecialchars($user['name']); ?></div>
                    <div class="profile-email"><?php echo htmlspecialchars($user['email']); ?></div>
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
          </div>
     </div>


     <!-- user posts... -->
     <div class="user-posts-wrapper">

     <?php
          if ($result->num_rows > 0) {
               while ($blog = $result->fetch_assoc()) {
               ?>

               <a href="read-blog.php?id=<?php echo htmlspecialchars($blog['blogId']); ?>" class="search-card">
                    <div class="image-container">
                         <img class="image-container-image" src="<?php echo htmlspecialchars($blog['photo']); ?>" alt="Blog Image">
                    </div>
                    <div class="search-card-content">
                         <h3><?php echo htmlspecialchars($blog['title']); ?></h3>
                         <div>
                              <h4>By: <?php echo htmlspecialchars($blog['name']); ?></h4>
                              <h4><?php echo htmlspecialchars($blog['createdAt']); ?></h4>
                              <h4><?php echo htmlspecialchars($blog['categoryName']); ?></h4>
                         </div>

                         <p><?php echo substr(strip_tags($blog['blogContent']), 0, 150); ?>...</p>

                    </div>
               </a>
          <?php
              }
              } else {
          ?>

               <div class="no-blogs-home">
                    <p class="">No blogs found. The user hasn't created any blog yet.</p>
                    <a href="home.php" class="create-blog-btn">Read other blogs.</a>.
               </div>
          <?php 
                 }
          ?>

    </div>


     </div>

<?php include 'show-message.php'; ?>
</body>
<script src="/mero-blogs/public/js/script.js"></script>

</html>