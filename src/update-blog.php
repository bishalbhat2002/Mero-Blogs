<?php
    // This code snipped checks if the user is authenticated before allowing access to the create blog page. If the user is not authenticated, they will be redirected to the login page.
    require_once 'authenticator.php';
?>

<?php
    // check if the update from was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once "../config/db_connect.php";

    // Get POST data
    $blogId     = intval($_POST['blogId'] ?? 0);
    $title      = trim($_POST['title'] ?? '');
    $categoryId = trim($_POST['category'] ?? '');
    $content    = trim($_POST['content'] ?? '');
    $userId     = $_SESSION['userId'];

    if (! $blogId) {
          header("Location: manage-blogs.php?error=Cannot read blog without an id parameter");
          exit();
    }


    /* ---------------- VALIDATION ---------------- */

    if (strlen($title) < 10 || strlen($title) > 60) {
        header("Location:?id=$blogId&error=Title must be 10-60 characters.");
        exit();
    }

    if (empty($categoryId)) {
        header("Location:?id=$blogId&error=Please select a category.");
        exit();
    }

    if (strlen($content) < 50 || strlen($content) > 1000000) {
        header("Location:?id=$blogId&error=Content must be 50-1000000 characters.");
        exit();
    }


    try{
        $sql = "SELECT photo from blogs where blogId = $blogId and userId = $userId";
        $result = $conn->query($sql);
    }catch(Exception $e){
        die("Error validating input: " . $e->getMessage());
    }

    if($result->num_rows === 0){
        header("Location: manage-blogs.php?error=Blog not found or you don't have permission to edit it");
        exit();
    }

    // get the URL of old photo to delete it if a new photo is uploaded
    $queryResult = $result->fetch_assoc();
    $existingPhoto = $queryResult['photo'];


    /* ---------------- PHOTO HANDLING ---------------- */

    $photoSql = "";

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {

        $file    = $_FILES['photo'];
        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];

        if (! in_array($file['type'], $allowed)) {
            header("Location:?id=$blogId&error=Only JPEG, PNG, or JPG images are allowed.");
            exit();
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            header("Location:?id=$blogId&error=Image must be under 2MB.");
            exit();
        }

        $uploadDir = "../uploads/";
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $newName   = "blog_photo_" . time() . '_' . basename($file['name']);
        $photoPath = $uploadDir . $newName;
        move_uploaded_file($file['tmp_name'], $photoPath);

        $photoEsc = $conn->real_escape_string($photoPath);
        $photoSql = ", photo = '$photoEsc'";
    }


    // include the delete photo function to delete the old photo if a new one is uploaded
    require_once "deletePhoto.php";
    // delete the old photo if a new one was uploaded
    if ($photoSql  !== "" && $existingPhoto !== '') {
        deletePhoto($existingPhoto);
    }


    // ---------------- UPDATE QUERY ----------------
    // Escape user inputs to make it safe
    $titleEsc   = $conn->real_escape_string($title);
    $contentEsc = $conn->real_escape_string($content);

    $sql = "UPDATE blogs SET
            title = '$titleEsc',
            blogContent = '$contentEsc',
            categoryId = $categoryId";

    // Append photo part if a new photo was uploaded
    if ($photoSql) {
        $sql .= $photoSql;
    }

    // Add WHERE clause to target the specific blog and ensure only the owner can update
    $sql .= " WHERE blogId = $blogId AND userId = $userId";

    if ($conn->query($sql)) {
        header("Location: read-blog.php?id=$blogId&success=Blog updated successfully");
        exit();
    } else {
        echo "Update failed: " . $conn->error;
        exit();
    }
    }

?>


<?php
    // Fetch the blog to be updated from the database
    $updateBlogId = (int) $_GET['id'];
    if (! $updateBlogId) {
    header("Location: home.php?error=Cannot read blog without an id parameter");
    exit();
    }

     require_once "../config/db_connect.php";

    try {
          $sql = "SELECT * FROM blogs
                 WHERE blogId = {$updateBlogId}";

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

<!-- Select categories -->
 <?php
     try {
          $sql    = "SELECT * FROM categories";
          $result = $conn->query($sql);
    } catch (Exception $e) {
          die("Error fetching categories: " . $e->getMessage());
    }

?>


<!-- Show the blog edit form -->
<!doctype html>
<html lang="en">

<head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <title>Mero Blogs | Update Blog</title>
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
                    src="<?php echo $_SESSION['photo'] ?? '/mero-blogs/public/images/hero.jpg' ?>"
                    alt="Profile"
                    class="profilePictureIcon" />
          </a>
     </nav>

     <!-- Navbar code finished.... -->
     <main class="create-blog-wrapper">

  <form action="" method="POST" enctype="multipart/form-data" id="update-blog-form" class="create-blog-form">

    <h2 class="form-caption">Update Blog</h2>

    <input type="hidden" id="blogId" name="blogId" value="<?php echo $blog['blogId']; ?>" />

    <div class="update-blog-form-field">
        <!-- Blog Title -->
        <label for="title">Title</label>
        <input type="text" id="title" name="title" placeholder="Enter blog title" value="<?php echo htmlspecialchars($blog['title']); ?>" required />
        <p class="error-msg" id="titleError"></p>
    </div>

    <div class="update-blog-form-field-combined">
        <div class="category-select-wrapper">
        <!-- Dynamically add categories -->
            <label for="category">Category</label>
            <select id="category" name="category" class="category-select" required>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $row['categoryId'] ?>" <?php echo ($row['categoryId'] == $blog['categoryId']) ? 'selected' : ''; ?>><?php echo $row['categoryName'] ?></option>
                <?php
                    }
                    }
                ?>
                </select>
                <p class="error-msg" id="categoryError"></p>
        </div>

        <div class="photo-upload-wrapper">
            <!-- Blog Photo -->
            <label for="photo">Upload Photo</label>
            <input type="file" id="photo" name="photo" accept="image/*" />
            <p class="error-msg" id="photoError"></p>
        </div>
    </div>

    <div class="update-blog-form-field">
        <!-- Blog Content -->
        <label for="content">Blog Content</label>
        <textarea id="content" name="content" placeholder="Write your blog..." class="update-blog-content-container" required><?php echo htmlspecialchars($blog['blogContent']); ?></textarea>
        <p class="error-msg" id="contentError"></p>
    </div>    

    <!-- Update Post Button -->
    <button type="submit" class="update-blog-btn">Update Blog</button>

  </form>

</main>



<?php include 'show-message.php'; ?>
</body>
<script src="/mero-blogs/public/js/script.js"></script>


</html>