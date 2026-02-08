<?php
    // This code snipped checks if the user is authenticated before allowing access to the create blog page. If the user is not authenticated, they will be redirected to the login page.
    require_once 'authenticator.php';
?>

<?php
    // Fetch categories from the database
    require_once "../config/db_connect.php";

    $readBlogId = (int)$_GET['id'];

    if(!$readBlogId){
        header("Location: home.php?error=Cannot read blog without an id parameter");
        exit();
    }

    try {
    $sql = "SELECT blogs.*, users.name, categories.categoryName
          FROM blogs
          JOIN users ON blogs.userId = users.userId
          JOIN categories ON blogs.categoryId = categories.categoryId
          WHERE blogs.blogId = {$readBlogId}";

    $result = $conn->query($sql);

    } catch (Exception $e) {
    die("Error fetching blogs: " . $e->getMessage());
    }

    if ($result->num_rows === 0) {
    header("Location: home.php?error=Blog not found");
    exit();
    }
    $blog = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">

<head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <title>Mero Vlogs</title>
     <link rel="stylesheet" href="/mero-blogs/public/css/style.css" />
</head>

<body>
     <nav class="navbar">
          <div class="logo">
               <a href="home.php">Mero Blogs </a>
          </div>

          <div class="nav-link-container">
               <a href="home.php">All Blogs</a>
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


     <main class="read-blog-wrapper">


          <article class="read-blog">

               <!-- Action buttons -->
          <?php
          if ($_SESSION['userId'] == $blog['userId']) {?>
               <div class="blog-actions">
                    <a href="update-blog.php?id=<?php echo $blog['blogId']; ?>" class="blog-btn edit">Edit</a>
                    <a href="delete-blog.php?id=<?php echo $blog['blogId']; ?>" class="blog-btn delete" onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
               </div>
          <?php }?>
               <!-- Blog Image -->
               <img
                    src="<?php echo $blog['photo'] ?>"
                    alt="Blog Cover"
                    class="read-blog-image"
               />
               <h2 class="read-blog-title"><?php echo htmlspecialchars($blog['title']); ?></h2>

                   <div>
                   <a href="view-user.php?id=<?php echo htmlspecialchars($blog['userId']); ?>">
                        <h4 class="blog-extra-info">By: <?php echo htmlspecialchars($blog['name']); ?></h4>
                    </a> 
                    <h4 class="blog-extra-info"><?php echo htmlspecialchars($blog['createdAt']); ?></h4>
                    <h4 class="blog-extra-info"><?php echo htmlspecialchars($blog['categoryName']); ?></h4>
               </div>

               <!-- Blog Content -->
               <div class="read-blog-content">
                    <p>
                         <?php echo nl2br(htmlspecialchars($blog['blogContent'])); ?>
                    </p>
               </div>

          </article>

     </main>



<?php include 'show-message.php'; ?>
</body>
<script src="/mero-blogs/public/js/script.js"></script>

</html>