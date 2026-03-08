# Blogging Website

A simple blogging platform built using **PHP, MySQL, HTML, CSS, and JavaScript** to help friends in their minor project for college. This project allows users to create, manage, and explore blogs easily. It was developed as a college project to help students share ideas, write articles, and read content from others.

---

<!-- ## Project Demo
- Since the project is not deployed online, a video demonstration is available on YouTube.

### Watch Project Demo video:
https://youtu.be/c4v0d0vCfNs -->

<!-- --- -->

## Features

### User Authentication
- User registration
- Secure login and logout system
- Session-based authentication

### Blog Management
- Create new blog posts
- Edit and update existing blogs
- Delete personal blog posts
- View blogs written by other users

### Blog Search and Filtering
Users can easily find blogs using:
- Blog title
- Blog description
- Blog category
- Keywords

### User Profile Management
Users can manage their personal information including:
- Profile photo
- Full name
- Gender
- Address
- Other profile details

### Blog Viewing
- Read blogs posted by other users
- Browse blogs by category
- View detailed blog content

---

## Technologies Used

### Frontend
- HTML
- CSS
- JavaScript

### Backend
- PHP

### Database
- MySQL

### Server
- Apache (XAMPP)


---

# 📁 Project Structure

```
Mero-Blogs/
    ├── config/
    │   ├── seeders/
    │   │   ├── database-seed.php
    │   ├── db_config.php
    │   ├── db_connect.php
    ├── public/
    │   ├── css/
    │   │   ├── auth.style.css
    │   │   ├── style.css
    │   ├── images/
    │   │   ├── boy.jpg
    │   │   ├── eye-close.png
    │   │   ├── eye-open.png
    │   ├── js/
    │   │   ├── registerScript.js
    │   │   └── script.js
    ├── src/
    │   ├── authenticator.php
    │   ├── change-password.php
    │   ├── create-blog.php
    │   ├── delete-blog.php
    │   ├── deletePhoto.php
    │   ├── edit-profile.php
    │   ├── home.php
    │   ├── logout.php
    │   ├── manage-blogs.php
    │   ├── page404.php
    │   ├── profile.php
    │   ├── read-blog.php
    │   ├── search-blogs.php
    │   ├── show-message.php
    │   ├── update-blog.php
    │   ├── view-user.php
    ├── uploads/
    ├── index.php
    ├── login.php
    ├── README.md
    └── register.php
```