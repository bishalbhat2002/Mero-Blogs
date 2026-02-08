<?php
    // This code snipped checks if the user is authenticated before allowing access to the create blog page. If the user is not authenticated, they will be redirected to the login page.
    require_once 'authenticator.php';
?>

<?php

    $deleteBlogId = (int) $_GET['id'];
    if (! $deleteBlogId) {
          header("Location: home.php?error=Cannot read blog without an id parameter");
          exit();
    }

    require_once "../config/db_connect.php";

    try {
          $sql    = "SELECT userId FROM blogs WHERE blogId = {$deleteBlogId}";
          $result = $conn->query($sql);
    } catch (Exception $e) {
           die("Error fetching blogs: " . $e->getMessage());
    }

    if ($result->num_rows === 0) {
          header("Location: home.php?error=Blog not found.");
          exit();
    }

    $blog = $result->fetch_assoc();
          if ($blog['userId'] !== $_SESSION['userId']) {
          header("Location: home.php?error= You are not allowed to delete the blog.");
          exit();
    }

    try {
          $sql = "DELETE FROM blogs WHERE blogId = {$deleteBlogId}";
          $conn->query($sql);
    } catch (Exception $e) {
          die("Error deleting blog: " . $e->getMessage());
    }

    // Redirect to manage blogs page with success message
    header("Location: manage-blogs.php?success=Blog deleted successfully");
    exit();
?>