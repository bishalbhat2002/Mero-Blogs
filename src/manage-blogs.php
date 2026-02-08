<?php
    // This code snipped checks if the user is authenticated before allowing access to the create blog page. If the user is not authenticated, they will be redirected to the login page.
    require_once 'authenticator.php';
?>

<?php
    // Fetch categories from the database
    require_once "../config/db_connect.php";

    try {
    $sql    = "SELECT blogs.*, categories.categoryName FROM 
              blogs INNER JOIN categories ON blogs.categoryId = categories.categoryId
              Where userId = {$_SESSION['userId']} ORDER BY createdAt DESC";

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
  <title>Mero Blogs | Manage Blogs</title>
  <link rel="stylesheet" href="/mero-blogs/public/css/style.css" />
</head>

<body>
  <nav class="navbar">
    <div class="logo">
      <a href="home.php">Mero Blogs</a>
    </div>

    <div class="nav-link-container">
      <a href="home.php" >All Blogs</a>
      <a href="search-blogs.php">Search Blogs</a>
      <a href="manage-blogs.php" class="active">Manage Blogs</a>
    </div>

    <a class="profile" href="profile.php">
      <img
         src="<?php echo $_SESSION['photo'] ?? '/mero-blogs/public/images/boy.jpg' ?>"
        alt="Profile"
        class="profilePictureIcon" />
    </a>
  </nav>
  <!-- Navbar code finished.... -->

  <!-- Main Section code Start -->
   <main class="manage-blogs-wrapper">

  <!-- Create New Blog Button -->
  <div class="manage-header">
    <h2>Manage Blogs</h2>
    <a href="create-blog.php" class="create-blog-btn">+ Create New Blog</a>
  </div>

  <div class="manage-blog-list">
    <!-- Single Blog Card -->
     <?php
         if ($result->num_rows > 0) {
             while ($blog = $result->fetch_assoc()) {
             ?>

  <!-- Blog List -->

      <div class="manage-blog-card">
      <img src="<?php echo $blog['photo'] ?>" alt="Blog Image" />
      <div class="blog-card-content">
        <h3 class="blog-title"><?php echo $blog['title'] ?></h3>

        <h4 id="category-indicator-manage-blogs"><?php echo htmlspecialchars($blog['categoryName']); ?></h4>

        <p class="blog-excerpt">
          <?php echo substr($blog['blogContent'], 0, 100) . '...' ?>
        </p>
        <div class="pb-2">
           <small class="vlog-date mb-1">Date:<?php echo $blog['createdAt'] ?></small>
        </div>

        <div class="blog-card-actions">
          <a href="read-blog.php?id=<?php echo $blog['blogId'] ?>" class="blog-btn read">Read</a>
          <a href="update-blog.php?id=<?php echo $blog['blogId'] ?>" class="blog-btn edit">Update</a>
          <a href="delete-blog.php?id=<?php echo $blog['blogId'] ?>" onclick="return confirm('Are you sure you want to delete this blog?')" class="blog-btn delete">Delete</a>
        </div>
      </div>
    </div>


      <?php
          }
          } else {
          ?>
          <!-- <div class="no-blogs">
            <p >No blogs found. Start by creating a new blog!</p>
          </div> -->
          <div class="no-blog-manage-container">
            <div class="no-blogs-manage">
              <p class="">You haven't created any blogs yet.</p>
              <a href="create-blog.php" class="create-blog-btn">Create a blog</a>.
            </div>
          </div>




        <?php
            }

        ?>
    </div>

  </div>
</main>

<!--
  <div class="pagination">
    <a href="#" class="page-btn prev">Prev</a>
    <a href="#" class="page-btn active">1</a>
    <a href="#" class="page-btn">2</a>
    <a href="#" class="page-btn">3</a>
    <span class="page-dots">...</span>
    <a href="#" class="page-btn">10</a>
    <a href="#" class="page-btn next">Next</a>
  </div> -->
  <!-- Main Section code End -->

<?php include 'show-message.php'; ?>
</body>
<script src="/mero-blogs/public/js/script.js"></script>
</html>