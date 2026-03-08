
<!-- Code to register process -->
<!-- user Registration process code here -->
<?php
    session_start();

    // Redirect to home page if already logged in
    if (isset($_SESSION['email'])) {
    header("Location: src/home.php");
    exit();
    }

    // Check if register form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm-password'] ?? '');
    $gender   = $_POST['gender'] ?? '';
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    // $photo    = $_FILES['photo']['name'] ?? '';

    // Check if required fields are empty
    if (empty($name) || empty($email) || empty($password) || empty($confirm) || empty($gender) || empty($phone) || empty($address)) {
        header("Location: register.php?error=All fields are required");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm) {
        header("Location: register.php?error=Passwords do not match");
        exit();
    }

    // Connect to DB
    require_once 'config/db_connect.php';

    try {
        // Check if email already exists
        $checkSql = "SELECT * FROM users WHERE email = '$email'";
        $result   = $conn->query($checkSql);
    } catch (Exception $e) {
        die("<b>Error: </b>" . $e->getMessage());
    }

    if ($result->num_rows > 0) {
        header("Location: register.php?error=Email already registered");
        exit();
    }

    // Upload photo if provided with validation
    $photoPath = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file         = $_FILES['photo'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        if (! in_array($file['type'], $allowedTypes)) {
            header("Location:?error=Only JPG, JPEG, or PNG files allowed.");
            exit();
        } elseif ($file['size'] > 2 * 1024 * 1024) { // 2MB
            header("Location:?error=Image size must be less than 2MB.");
            exit();
        } else {
            // Ensure upload folder exists
            $uploadDir = 'uploads/';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique file name to prevent overwriting
            $newName  = "user_photo_" . time() . "_" . basename($file['name']);
            $fullPath = $uploadDir . $newName;

            if (move_uploaded_file($file['tmp_name'], $fullPath)) { 
                $photoPath = "../" . $fullPath; // save path to DB
            } else {
                header("Location:?error=Photo upload failed.");
                exit();
            }
        }
    }
    try {
        // Insert user into DB
        $insertSql = "INSERT INTO users (name, email, password, gender, phone, address, photo)
                  VALUES ('$name', '$email', '$_POST[password]', '$gender', '$phone', '$address', '$photoPath')";

        $conn->query($insertSql);

    } catch (Exception $e) {
        header("location:register.php?error= Error While registering user: " . $e->getMessage());
        exit();
    }

    // fetch data to store in session
    try {
        $sql    = "SELECT name, email, photo, userId from users where email = '{$email}'";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();

        $_SESSION['userId'] = $user['userId'];
        $_SESSION['name']   = $user['name'];  
        $_SESSION['email']  = $user['email'];
        $_SESSION['photo']  = $user['photo'];

        // exit($_SESSION['photo']);
        
        // Redirect to home page with success message
        header("location: /mero-blogs/src/home.php?success= User Registered Successfully");
        exit();
    } catch (Exception $e) {
        die("Error fetching user: " . $e->getMessage());
    }
    }
?>


<!-- Show Registration form if not submitted or error in registration -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mero Blogs | Register</title>
     <link rel="stylesheet" href="/mero-blogs/public/css/auth.style.css" />
</head>
<>
  <nav class="navbar">
    <h1>Mero Blogs</h1>
  </nav>

  <main class="w-full flex-center">
    <!-- Registration form will go here -->
  <div class="registration-wrapper">
    <div class="register-box">
      <h2>Create Account</h2>
      <form id="registerForm" class="register-form" method="POST" action="register.php" enctype="multipart/form-data">

  <div class="form-group">
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" placeholder="Enter your full name" value="" required />
    <p class="error-msg" id="nameError"></p>
  </div>

  <div class="form-group">
    <label for="email">Email</label>
    <input type="text" id="email" name="email" placeholder="Enter your email" value="bishal@gmail.com" required />
    <p class="error-msg" id="emailError"></p>
  </div>

  <div class="form-group relative">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Create a password" value="password123" required />
    <button id="toggle-password" type="button" class="toggle-password"></button>
    <p class="error-msg" id="passwordError"></p>
  </div>

  <div class="form-group relative">
    <label for="confirm_password">Confirm Password</label>
    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" value="password123" required />
    <button id="toggle-confirm-password" type="button" class="toggle-password"></button>
    <p class="error-msg" id="confirmError"></p>
  </div>

  <div class="form-group">
    <label for="gender">Gender</label>
    <select id="gender" name="gender" required>
      <option value="" selected disabled>Select gender</option>
      <option value="male" >Male</option>
      <option value="female">Female</option>
      <option value="other">Other</option>
    </select>
    <p class="error-msg" id="genderError"></p>
  </div>

  <div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" id="phone" name="phone" placeholder="98XXXXXXXX" value="" required />
    <p class="error-msg" id="phoneError"></p>
  </div>

  <div class="form-group">
    <label for="address">Address</label>
    <input type="text" id="address" name="address" placeholder="Your address" value="Mnr, kanchanpur" required />
    <p class="error-msg" id="addressError"></p>
  </div>

  <div class="form-group">
    <label for="photo">Profile Photo</label>
    <input type="file" id="photo" name="photo" />
    <p class="error-msg" id="photoError"></p>
  </div>

  <button class="btn" type="submit">Register</button>
  <div class="extra">Already have an account? <a href="login.php">Login</a></div>
</form>


  </div>
  </div>
</main>

  <!-- Error or Success message container -->
<?php include 'src/show-message.php'; ?>
<script src="/mero-blogs/public/js/registerScript.js"></script>
</body
</html>




