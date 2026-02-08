<?php
    // This code snipped checks if the user is authenticated before allowing access to the create blog page. If the user is not authenticated, they will be redirected to the login page.
    require_once 'authenticator.php';
?>

<?php
    // Fetch blogs from the database
    require_once "../config/db_connect.php";

    try {
    $sql = "SELECT blogs.*, users.name, categories.categoryName
          FROM blogs
          INNER JOIN users ON blogs.userId = users.userId
          INNER JOIN categories ON blogs.categoryId = categories.categoryId
          ORDER BY blogs.createdAt DESC";

    $result = $conn->query($sql);

    } catch (Exception $e) {
    die("Error fetching blogs: " . $e->getMessage());
    }

?>






<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mero Blogs</title>
  <link rel="stylesheet" href="/mero-blogs/public/css/style.css" />
</head>

<body>
  <nav class="navbar">
    <div class="logo">
      <a href="home.php">Mero Blogs</a>
    </div>

    <div class="nav-link-container">
      <a href="home.php" class="active">All Blogs</a>
      <a href="search-blogs.php">Search Blogs</a>
      <a href="manage-blogs.php">Manage Blogs</a>
    </div>

    <a class="profile" href="profile.php">
      <img
        src="<?php echo $_SESSION['photo'] ?? '/mero-blogs/public/images/boy.jpg' ?>"
        alt="Profile"
        class="profilePictureIcon" />
    </a>
  </nav>
  <!-- Navbar code finished.... -->

  </div>
      <!-- Single Blog Card -->


  <!-- Main Section code Start -->
  <main class="main-content">

       <?php
           if ($result->num_rows > 0) {
               while ($blog = $result->fetch_assoc()) {
               ?>

    <!-- One container code -->
    <div class="vlog-box">
      <img src="<?php echo $blog['photo'] ?? '/mero-blogs/public/images/hero.jpg'; ?>" alt="Vlog Image" class="vlog-image" />

      <div class="vlog-content">
        <div class="vlog-title"><?php echo htmlspecialchars($blog['title']); ?></div>
        <div class="user-link-parent">
          <a href="view-user.php?id=<?php echo htmlspecialchars($blog['userId']); ?>" class="user-link">
            <?php echo htmlspecialchars($blog['name']); ?>
          </a>
          <h4 id="category-indicator"><?php echo htmlspecialchars($blog['categoryName']); ?></h4>
        </div>
        <div class="vlog-description">
          <?php echo htmlspecialchars(substr($blog['blogContent'], 0, 100)) . '...'; ?>
        </div>
        <div class="flex-between">
          <small class="vlog-date"><?php echo htmlspecialchars($blog['createdAt']); ?></small>
          <a href="read-blog.php?id=<?php echo htmlspecialchars($blog['blogId']); ?>" class="read-more">Read More</a>
        </div>
      </div>
    </div>

      <?php
               }
          }
          ?>
   <!-- </main> -->

      <?php
          if ($result->num_rows == 0) {
              ?>
      <div class="no-blogs-container-home">

        <div class="no-blogs-home">
          <p class="">No blogs found. Please check back later</p>
          <span class="no-blog-or">or,</span>
          <a href="create-blog.php" class="create-blog-btn">Create a new blog</a>.
        </div>
      </div>
  <?php
      }
    ?>

  </main>


  <!-- <div class="pagination">
    <a href="#" class="page-btn prev">Prev</a>
    <a href="#" class="page-btn active">1</a>
    <a href="#" class="page-btn">2</a>
    <a href="#" class="page-btn">3</a>
    <span class="page-dots">...</span>
    <a href="#" class="page-btn">10</a>
    <a href="#" class="page-btn next">Next</a>
  </div> -->
  <!-- Main Section code End -->

  <!-- Footer code start -->
  <footer>
    <div class="footer-container">
      <div class="footer-section">
        <h3>About Mero blogs</h3>
        <p>
          Mero Blogs is your go-to place for latest blogs and updates. Stay
          tuned for exciting content!
        </p>
      </div>

      <div class="footer-section">
        <h3>Quick Links</h3>
        <a href="home.php">Home</a>
        <a href="search-blogs.php">Search Blogs</a>
        <a href="manage-blogs.php">Manage blogs</a>
        <a href="create-blog.php">Create Blog</a>
      </div>

      <div class="footer-section">
        <h3>Follow Us</h3>
        <div class="social-links">
          <a href="https://www.facebook.com" target="_blank">F</a>
          <a href="https://www.twitter.com" target="_blank">T</a>
          <a href="https://www.instagram.com" target="_blank">I</a>
          <a href="https://www.youtube.com" target="_blank">Y</a>
        </div>
      </div>
    </div>
  </footer>


  <?php include 'show-message.php'; ?>
</body>
<script src="/mero-blogs/public/js/script.js"></script>

</html>