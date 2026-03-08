<!-- user Login process code here -->
<?php
    session_start();

    // Redirect to home page if already logged in
    if ($_SESSION['email']) {
    header("location:/mero-blogs/src/home.php");
    exit();
    }

    // Check if login form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Check if fields are empty
    if (empty($email) || empty($password)) {
        header("Location: login.php?error=All fields are required");
        exit();
    }

    // Fetch user from database
    try {
        require_once 'config/db_connect.php';
        $sql    = "SELECT * FROM users WHERE email = '{$email}'";
        $result = $conn->query($sql);

    } catch (Exception $e) {
        die("<b>Error: </b>" . $e->getMessage());
    }

    if ($result->num_rows === 0) {
        // No user found
        header("Location: login.php?error=Wrong email or password");
        exit();
    }

    $user = $result->fetch_assoc();

    // Verify password
    if ($_POST["password"] !== $user['password']) {
        header("Location: login.php?error=Wrong email or password");
        exit();
    }

    // Password matched → login successful
    $_SESSION['userId'] = $user['userId'];
    $_SESSION['name']   = $user['name'];
    $_SESSION['email']  = $user['email'];
    $_SESSION['photo']  = $user['photo'];

    header("Location:src/home.php?success=Login successful");
    exit();
    }
?>

<!-- Show Login form if not logged in or Wrong login Details.... -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mero Blogs | Login</title>
     <link rel="stylesheet" href="/mero-blogs/public/css/auth.style.css" />
</head>
<body>
  <nav class="navbar">
    <h1>Mero Blogs</h1>
  </nav>

  <div class="wrapper">
    <div class="login-box">
      <h2>Login</h2>
      <form action="" method="POST">
        <div class="form-group">
          <label>Email</label>
          <input type="text" name="email" placeholder="Enter your email" value="bishal@gmail.com" required />
        </div>
        <div class="form-group relative">
          <label>Password</label>
          <input type="password" name="password" id="password" value="password123" placeholder="Enter your password" required />
          <button id="toggle-password" type="button" class="toggle-password"></button>
        </div>


        <button class="btn" type="submit">Login</button>
        <div class="extra">Don’t have an account? <a href="register.php">Register</a></div>
      </form>
    </div>
  </div>

  <!-- Error or Success message container -->
  <?php include 'src/show-message.php'; ?>
  <script>
       window.onload = function hide() {
              const error = document.getElementById('error-message');  // Fetches Error Element
              const success = document.getElementById('success-message'); // Fetches Success Element
              if (error) {
                     setTimeout(() => { // Hides Error Element after 3 Seconds
                            error.style.display = "none";
                     }, 3000);
              }
              if (success) {
                     setTimeout(() => { // Hides Success Element after 3 Seconds
                            success.style.display = "none";
                     }, 3000);
              }
       }


const togglePassword = document.getElementById("toggle-password");
const passwordInput = document.getElementById("password");

togglePassword.addEventListener("click", function (e) {
  e.preventDefault();
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    togglePassword.style.background = `url("/mero-blogs/public/images/eye-open.png") no-repeat center`;
    togglePassword.style.backgroundSize = `contain`;
  } else {
    passwordInput.type = "password";
    togglePassword.style.background = `url("/mero-blogs/public/images/eye-close.png") no-repeat center`;
    togglePassword.style.backgroundSize = `contain`;
  }
});

</script>
</body>
</html>
