<?php
    // This code snipped checks if the user is authenticated before allowing access to the create blog page. If the user is not authenticated, they will be redirected to the login page.
    require_once 'authenticator.php';
?>

<!-- Create blog process code start -->

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get POST data
    $title      = trim($_POST['title'] ?? '');
    $categoryId = trim($_POST['category'] ?? '');
    $content    = trim($_POST['content'] ?? '');
    $userId     = $_SESSION['userId'];

    // Validate Title
    if (strlen($title) < 10 || strlen($title) > 60) {
        header("Location: create-blog.php?error=" . urlencode("Title must be 10-60 characters."));
        exit();
    }

    // Validate Category
    if (empty($categoryId)) {
        header("Location: create-blog.php?error=" . urlencode("Please select a category."));
        exit();
    }

    // Validate Content
    if (strlen($content) < 50 || strlen($content) > 1000000) {
        header("Location: create-blog.php?error=" . urlencode("Content must be 50-1000000 characters."));
        exit();
    }

    // Validate Photo
    $photoPath = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file    = $_FILES['photo'];
        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];

        if (! in_array($file['type'], $allowed)) {
            header("Location: create-blog.php?error=" . urlencode("Photo must be JPEG, PNG, or JPG."));
            exit();
        } elseif ($file['size'] > 2 * 1024 * 1024) { // 2MB limit
            header("Location: create-blog.php?error=" . urlencode("Photo size must be less than 2MB."));
            exit();
        } else {
            $uploadDir = "../uploads/";
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // create folder if not exists
            }
            $newName   ="blog_photo"."_". time() . '_' . basename($file['name']);
            $photoPath = $uploadDir . $newName;
            move_uploaded_file($file['tmp_name'], $photoPath);
        }

    } else {
        header("Location: create-blog.php?error=" . urlencode("Please upload a photo."));
        exit();
    }

    //   Create blog in database
    try {
        require_once "../config/db_connect.php";
     
        // Escape user inputs to make it safe
        $titleEsc   = $conn->real_escape_string($title);
        $contentEsc = $conn->real_escape_string($content);
        $photoEsc   = $conn->real_escape_string($photoPath);

        $sql = "INSERT INTO blogs (title, blogContent, photo, categoryId, userId)
            VALUES ('{$titleEsc}', '{$contentEsc}', '{$photoEsc}', {$categoryId}, {$userId})";

        if ($conn->query($sql)) {
            header("Location: manage-blogs.php?success=Blog created successfully");
            exit();
        }
    } catch (Exception $e) {
        //    header("location:?error= Error While creating blog: " . $e->getMessage());
        echo("Error While creating blog: " . $e->getMessage());
        exit();
    }

    }

?>



<?php
    // Fetch categories from the database
    require_once "../config/db_connect.php";

    try {
    $sql    = "SELECT * FROM categories";
    $result = $conn->query($sql);
    } catch (Exception $e) {
    die("Error fetching categories: " . $e->getMessage());
    }
?>
<!-- Show Blog creation form -->
<!doctype html>
<html lang="en">

<head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <title>Mero Blogs | Create Blog</title>
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
               <a href="manage-blogs.php" class="active">Manage Vlogs</a>
          </div>

          <a class="profile" href="profile.php">
               <img
                    src="<?php echo $_SESSION['photo'] ?? '/mero-blogs/public/images/boy.jpg' ?>"
                    alt="Profile"
                    class="profilePictureIcon" />
          </a>
     </nav>
          <!-- Navbar code finished.... -->


     <main class="create-blog-wrapper">

 <form id="createBlogForm" action="" method="POST" enctype="multipart/form-data" class="create-blog-form">

    <h2 class="form-caption">Create Blog</h2>

    <!-- Blog Title -->
    <div class="create-blog-form-field">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" placeholder="Enter blog title" value="" required />
        <p class="error-msg" id="titleError"></p>
    </div>
    
    <div class="create-blog-form-field-combined">
        <!-- Dynamically add categories -->
        <div class="category-select-wrapper">
            <label for="category">Category</label>
            <select id="category" name="category" class="category-select" required>
            <option value="">Select a category</option>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                <option value="<?php echo $row['categoryId'] ?>"><?php echo $row['categoryName'] ?></option>
        <?php
            }
            }
        ?>
            </select>
            <p class="error-msg" id="categoryError"></p>
         </div>

         <!-- Blog Photo -->
        <div class="photo-upload-wrapper">
            <label for="blogPhoto">Upload Photo</label>
            <input type="file" id="blogPhoto" name="photo" accept="image/jpeg, image/png, image/jpg" required />
            <p class="error-msg" id="photoError"></p>
        </div>

    </div>

    <!-- Blog Content -->
    <div class="create-blog-form-field">
        <label for="content">Blog Content</label>
        <textarea id="content" name="content" placeholder="Write your blog..." required></textarea>
        <p class="error-msg" id="contentError"></p>
    </div>

    <!-- Create Post Button -->
    <button type="submit" class="create-post-btn">Create Blog</button>

</form>

</main>

<?php include 'show-message.php'; ?>
</body>
<script src="/mero-blogs/public/js/script.js"></script>

</html>