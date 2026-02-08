
<?php
    // This code snipped checks if the user is authenticated before allowing access to the create blog page. If the user is not authenticated, they will be redirected to the login page.
    require_once 'authenticator.php';
?>

<!-- Code to update profile.. -->
<?php
    // Check if register form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $gender   = $_POST['gender'] ?? '';
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');


    // Check if required fields are empty
    if (empty($name) || empty($email)  || empty($gender) || empty($phone) || empty($address)) {
        header("Location:?error=All fields are required");
        exit();
    }

     // Connect to DB
     require_once "../config/db_connect.php";
     require_once "deletePhoto.php";

    try {
        // Check if email already exists
        $checkSql = "SELECT * FROM users WHERE email = '$email' && userId != {$_SESSION['userId']}";
        $result   = $conn->query($checkSql);
    } catch (Exception $e) {
        die("<b>Error: </b>" . $e->getMessage());
    }

    if ($result->num_rows > 0) {
        header("Location:?error=Email already registered");
        exit();
    }
    

    // Upload photo if provided with validation
    $photoPath = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file         = $_FILES['photo'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        if (! in_array($file['type'], $allowedTypes)) {
            header("Location: ?error=Only JPG, JPEG, or PNG files allowed.");
            exit();
        } elseif ($file['size'] > 2 * 1024 * 1024) { // 2MB
            header("Location: ?error=Image size must be less than 2MB.");
            exit();
        } else {
            // Ensure upload folder exists
            $uploadDir = '../uploads/';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $newName  = "user_photo_" . time() . "_" . basename($file['name']);
            $fullPath = $uploadDir . $newName;

            if (move_uploaded_file($file['tmp_name'], $fullPath)) {
                $photoPath = $fullPath; // save path to DB
            } else {
                header("Location: ?error=Photo upload failed.");
                exit();
            }
        }
    }

    try {
        
     $updateSql = "UPDATE users SET 
                    name = '$name', 
                    email = '$email',
                    gender = '$gender',
                    phone = '$phone',
                    address = '$address'";

    if($photoPath !== '') {
        $updateSql .= ", photo = '$photoPath'";
    }

     $updateSql .= " WHERE userId = {$_SESSION['userId']}";

     $conn->query($updateSql);

    //  Delete old photo if new one is uploaded and old photo exists
    if($photoPath !== '' && isset($_SESSION['photo'])) {
        deletePhoto($_SESSION['photo'] ?? '');
    }
     // Store data in session and redirect to home page
     $_SESSION['name']  = $name;
     $_SESSION['email'] = $email;
     if($photoPath !== '') {
          $_SESSION['photo'] = $photoPath;
     }

        header("location:profile.php?success= User updated Successfully");
        exit();
    } catch (Exception $e) {
        exit("location:?error= Error While updating user: " . $e->getMessage());
    }

    }
?>



<?php
    // Fetch categories from the database
    require_once "../config/db_connect.php";

    try {
    $sql    = "SELECT * from users where userId = {$_SESSION['userId']}";
    $result = $conn->query($sql);
    $user   = $result->fetch_assoc();
    } catch (Exception $e) {
    die("Error fetching blogs: " . $e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <title>Edit Profile | Mero Blogs</title>
     <link rel="stylesheet" href="/mero-blogs/public/css/style.css" />
</head>

<body>

     <!-- NAVBAR (same as profile page) -->
     <nav class="navbar">
          <div class="logo">
               <a href="home.php">Mero Blogs</a>
          </div>

          <div class="nav-link-container">
               <a href="home.php">All Blogs</a>
               <a href="search-blogs.php">Search Blogs</a>
               <a href="manage-blogs.php">Manage Blogs</a>
          </div>

          <a class="profile" href="profile.php">
               <img
                    src="<?php echo $_SESSION['photo'] ?? '/mero-blogs/public/images/hero.jpg' ?>"
                    alt="Profile"
                    class="profilePictureIcon" />
          </a>
     </nav>

     <!-- EDIT PROFILE FORM -->
     <div class="edit-profile-form-container">
          <div class="edit-profile-card ">

          <h2 class="edit-title text-center">Edit Profile</h2>

          <form action="" method="POST" enctype="multipart/form-data" class="edit-profile-form">

               <div class="field">
                    <label>Full Name</label>
                    <input type="text" placeholder="Enter your name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? '') ?>" required>
                      <p class="error-msg" id="nameError"></p>
               </div>

               <div class="field">
                    <label>Email</label>
                    <input type="email" placeholder="Enter your email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? '') ?>" required>
                      <p class="error-msg" id="emailError"></p>
               </div>

               <div class="field">
                    <label>Gender</label>
                    <select name="gender" required>
                         <option value="Male" <?php echo($user['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Male</option>
                         <option value="Female" <?php echo($user['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Female</option>
                         <option value="Other" <?php echo($user['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                      <p class="error-msg" id="genderError"></p>
               </div>

               <div class="field">
                    <label>Phone</label>
                    <input type="text" placeholder="98XXXXXXXX" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? '') ?>" required>
                      <p class="error-msg" id="phoneError"></p>
               </div>

               <div class="field">
                    <label>Address</label>
                    <input type="text" placeholder="Your address" name="address" value="<?php echo htmlspecialchars($user['address'] ?? '') ?>" required>
                      <p class="error-msg" id="addressError"></p>
               </div>

               <div class="field">
                    <label>Profile Photo</label>
                    <input type="file" name="photo" >
                      <p class="error-msg" id="photoError"></p>
               </div>

               <div class="edit-form-actions">
                    <a href="profile.php" class="cancel-btn">Cancel</a>
                    <button type="submit" class="save-btn">Save Changes</button>
               </div>

          </form>
     </div>
     </div>


<?php include 'show-message.php'; ?>
</body>
<script src="/mero-blogs/public/js/script.js"></script>
</html>