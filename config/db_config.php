<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "Mero_blogs";

#Connecting with MySQL
try {
    $conn = new mysqli($servername, $username, $password);
//     echo "<br>MySQL connected Successfully...";
} catch (Exception $e) {
    die("<b>MySQL connection Failed: </b>" . $e->getMessage());
}

#Creating and Selecting the Database
try {
    $sql = "CREATE database if not exists $dbname";
    $conn->query($sql);
    $conn->select_db($dbname);
//     echo "<br>Database Selected Successfully...";
} catch (Exception $e) {
    die("<b>Database Creation Failed: </b>" . $e->getMessage());
}

// Users Table Creation Code
try {
    $sql = "CREATE TABLE if not exists users (
          userId INT AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(100) NOT NULL,
          email VARCHAR(150) NOT NULL UNIQUE,
          password VARCHAR(255) NOT NULL,
          photo VARCHAR(255) DEFAULT NULL,
          gender ENUM('male', 'female', 'other') DEFAULT NULL,
          phone VARCHAR(20) DEFAULT NULL UNIQUE,
          address VARCHAR(255) DEFAULT NULL,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
          )";

    $conn->query($sql);
//     echo "<br>Users Table Created Successfully...";
} catch (Exception $e) {
    die("<b>Users Table Creation Failed: </b>" . $e->getMessage());
}

// Category Table Creation Code
try {
    $sql = "CREATE TABLE if not exists categories (
          categoryId INT AUTO_INCREMENT PRIMARY KEY,
          categoryName VARCHAR(100) NOT NULL UNIQUE
          )";

    $conn->query($sql);
//     echo "<br>Categories Table Created Successfully...";
} catch (Exception $e) {
    die("<b>Categories Table Creation Failed: </b>" . $e->getMessage());
}

// Blogs Table Creation Code
try {
    $sql = "CREATE TABLE if not exists blogs (
               blogId INT AUTO_INCREMENT PRIMARY KEY,
               title VARCHAR(255) NOT NULL,
               blogContent MEDIUMTEXT NOT NULL,
               photo VARCHAR(255) DEFAULT NULL,
               categoryId INT NOT NULL,
               userId INT NOT NULL,
               createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
               updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
               )";

    $conn->query($sql);
//     echo "<br>Blogs Table Created Successfully...";
} catch (Exception $e) {
    die("<b>Blogs Table Creation Failed: </b>" . $e->getMessage());
}

echo "<br>All tables are already created successfully...";


#Inserting default categories
try {
    $sql = "INSERT INTO categories (categoryName) VALUES
    ('Technology'),
    ('Health'),
    ('Travel'),
    ('Food'),
    ('Education'),
    ('Lifestyle'),
    ('Entertainment'),
    ('Finance'),
    ('Sports'),
    ('Science'),
    ('Fashion'),
    ('Music'),
    ('Movies'),
    ('Books'),
    ('Gaming'),
    ('Photography'),
    ('Environment'),
    ('DIY & Crafts'),
    ('News'),
    ('Personal Development'),
    ('Other')";

    $conn->query($sql);
    echo "<br>Categories Inserted Successfully...";
} catch (Exception $e) {
    die("<b>Error while inserting Category records: </b>" . $e->getMessage());
}
