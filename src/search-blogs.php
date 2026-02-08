<?php
    // This code snipped checks if the user is authenticated before allowing access to the create blog page. If the user is not authenticated, they will be redirected to the login page.
    require_once 'authenticator.php';

    $sql = "";

    if (isset($_GET['q'])) {
    $q = trim($_GET['q']);

    if ($q !== "") {
        $sql = "SELECT blogs.*, users.name, categories.categoryName
               FROM blogs
               JOIN users ON blogs.userId = users.userId
               JOIN categories ON blogs.categoryId = categories.categoryId
               WHERE blogs.title LIKE '%$q%'
               OR blogs.blogContent LIKE '%$q%'
               OR users.name LIKE '%$q%'
               OR categories.categoryName LIKE '%$q%'
               ORDER BY blogs.createdAt DESC";

    } else {
        // If search is empty, show all blogs
        $sql = "SELECT blogs.*, users.name, categories.categoryName
               FROM blogs JOIN categories ON blogs.categoryId = categories.categoryId
               JOIN users ON blogs.userId = users.userId
               ORDER BY blogs.createdAt DESC";
    }
    } else {
    // Default: show all blogs
    $sql = "SELECT blogs.*, users.name, categories.categoryName
               FROM blogs JOIN categories ON blogs.categoryId = categories.categoryId
               JOIN users ON blogs.userId = users.userId
               ORDER BY blogs.createdAt DESC";
    }

    require_once "../config/db_connect.php";
    $result = $conn->query($sql);
?>


<!doctype html>
<html lang="en">

<head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <title>Search Blogs | Mero Blogs</title>
     <link rel="stylesheet" href="/mero-blogs/public/css/style.css" />
</head>

<body>
     <!-- Navbar (unchanged) -->
     <nav class="navbar">
          <div class="logo">
               <a href="home.php">Mero Blogs</a>
          </div>

          <div class="nav-link-container">
               <a href="home.php">All Blogs</a>
               <a href="search-blogs.php" class="active">Search Blogs</a>
               <a href="manage-blogs.php">Manage Vlogs</a>
          </div>

       <a class="profile" href="profile.php">
      <img
        src="<?php echo $_SESSION['photo'] ?? '/mero-blogs/public/images/boy.jpg' ?>"
        alt="Profile"
        class="profilePictureIcon" />
    </a>
     </nav>
     <!-- Navbar end -->

     <!-- Search Section -->
     <main class="search-wrapper">

          <!-- Search Bar -->
          <form class="search-form" method="GET" action="">
               <input
                    type="text"
                    name="q"
                    placeholder="Search blogs by title, content, user, or category..."
                    autofocus
                    value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"
                    class="search-input" />
               <button type="submit" class="search-btn">Search</button>
          </form>
          <!-- Search Results -->
          <div class="search-results">
          <?php if(!empty($_GET['q'])) {?>     
                <p>Search result for:<b> <?php echo htmlspecialchars($q ?? ''); ?></b></p>
          <?php
                }else{
                    echo " <p>All Blogs:</p>";
                }
          ?>

          <?php
              if ($result->num_rows > 0) {
                  while ($blog = $result->fetch_assoc()) {
                  ?>
                                <!-- Single Result Item -->
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
                    <!-- <div class="no-blogs">
                         <p >No blogs found. Try other keywords!</p>
                    </div> -->

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


          </div>

     </main>


<?php include 'show-message.php'; ?>
</body>
<script src="/mero-blogs/public/js/script.js"></script>


</html>