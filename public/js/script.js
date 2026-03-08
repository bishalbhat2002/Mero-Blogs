// Message shower code start
window.onload = function hide() {
  const error = document.getElementById("error-message"); // Fetches Error Element
  const success = document.getElementById("success-message"); // Fetches Success Element
  if (error) {
    setTimeout(() => {
      // Hides Error Element after 3 Seconds
      error.style.display = "none";
    }, 3000);
  }
  if (success) {
    setTimeout(() => {
      // Hides Success Element after 3 Seconds
      success.style.display = "none";
    }, 3000);
  }
};
// Message shower code end

// Create Blogs form Start here
const createBlogForm = document.getElementById("createBlogForm");

if (createBlogForm) {
  createBlogForm.addEventListener("submit", function (e) {
    // Clear previous errors
    document
      .querySelectorAll(".error-msg")
      .forEach((p) => (p.textContent = ""));

    let valid = true;

    const title = document.getElementById("title").value.trim();
    const category = document.getElementById("category").value;
    const photo = document.getElementById("blogPhoto").files[0];
    const content = document.getElementById("content").value.trim();

    // Title validation
    if (title.length < 10 || title.length > 255) {
      document.getElementById("titleError").textContent =
        "Title must be 10-255 characters.";
      valid = false;
    }

    // Category validation
    if (!category) {
      document.getElementById("categoryError").textContent =
        "Please select a category.";
      valid = false;
    }

    // Photo validation
    if (!photo) {
      document.getElementById("photoError").textContent =
        "Please upload a photo.";
      valid = false;
    } else {
      const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
      if (!allowedTypes.includes(photo.type)) {
        document.getElementById("photoError").textContent =
          "Photo must be JPEG, PNG, or JPG.";
        valid = false;
      }
      if (photo.size > 2 * 1024 * 1024) {
        // 2MB limit
        document.getElementById("photoError").textContent =
          "Photo size must be less than 2MB.";
        valid = false;
      }
    }

    // Content validation
    if (content.length < 50 || content.length > 1000000) {
      document.getElementById("contentError").textContent =
        "Content must be 50-1000000 characters.";
      valid = false;
    }

    // Prevent form submission if invalid
    if (!valid) e.preventDefault();
  });
}

// Create Blogs form End here

// Code for validating User profile Update form start here
const editProfileForm = document.querySelector(".edit-profile-form");
if (editProfileForm) {
  editProfileForm.addEventListener("submit", function (e) {
    let valid = true;

    // clear previous errors
    document
      .querySelectorAll(".error-msg")
      .forEach((p) => (p.textContent = ""));

    const name = editProfileForm.name.value.trim();
    const email = editProfileForm.email.value.trim();
    const gender = editProfileForm.gender.value;
    const phone = editProfileForm.phone.value.trim();
    const address = editProfileForm.address.value.trim();
    const photo = editProfileForm.photo.files[0];

    // Name
    if (name.length < 3 || name.length > 50) {
      document.getElementById("nameError").textContent =
        "Name must be 3–50 characters long.";
      valid = false;
    }

    // Email
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i;
    if (!emailPattern.test(email)) {
      document.getElementById("emailError").textContent =
        "Enter a valid email address.";
      valid = false;
    }

    // Gender
    if (!gender) {
      document.getElementById("genderError").textContent =
        "Please select gender.";
      valid = false;
    }

    // Phone (Nepal format)
    const phonePattern = /^9\d{9}$/;
    if (!phonePattern.test(phone)) {
      document.getElementById("phoneError").textContent =
        "Enter a valid 10-digit phone number.";
      valid = false;
    }

    // Address
    if (address.length < 3) {
      document.getElementById("addressError").textContent =
        "Address must be at least 3 characters.";
      valid = false;
    }

    // Photo (optional)
    if (photo) {
      const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

      if (!allowedTypes.includes(photo.type)) {
        document.getElementById("photoError").textContent =
          "Only JPG, JPEG, PNG allowed.";
        valid = false;
      } else if (photo.size > 2 * 1024 * 1024) {
        document.getElementById("photoError").textContent =
          "Photo must be less than 2MB.";
        valid = false;
      }
    }

    if (!valid) e.preventDefault();
  });
}

// Code for validating User profile Update ends here

// Code for validating edit blog starts here
// Code for validating Update Blog form start here
const updateBlogForm = document.getElementById("update-blog-form");

if (updateBlogForm) {
  updateBlogForm.addEventListener("submit", function (e) {
    let valid = true;

    // clear previous errors
    document
      .querySelectorAll(".error-msg")
      .forEach((p) => (p.textContent = ""));

    const title = updateBlogForm.title.value.trim();
    const category = updateBlogForm.category.value;
    const content = updateBlogForm.content.value.trim();
    const image = updateBlogForm.image.files[0]; // optional in update

    // Title
    if (title.length < 10 || title.length > 255) {
      document.getElementById("titleError").textContent =
        "Title must be 10–60 characters long.";
      valid = false;
    }

    // Category
    if (!category) {
      document.getElementById("categoryError").textContent =
        "Please select a category.";
      valid = false;
    }

    // Content
    if (content.length < 50 || content.length > 1000000) {
      document.getElementById("contentError").textContent =
        "Content must be 50–1000000 characters long.";
      valid = false;
    }

    // Image (optional in update)
    if (image) {
      const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

      if (!allowedTypes.includes(image.type)) {
        document.getElementById("imageError").textContent =
          "Only JPG, JPEG, PNG images are allowed.";
        valid = false;
      } else if (image.size > 2 * 1024 * 1024) {
        document.getElementById("imageError").textContent =
          "Image size must be less than 2MB.";
        valid = false;
      }
    }

    if (!valid) e.preventDefault();
  });
}

// Code for validating edit blog end here

// Script to toggle password view start here..

// code to toggle view of current password
const currentPasswordInput = document.getElementById("current-password");
const toggleCurrentPassword = document.getElementById(
  "toggle-current-password",
);

if (toggleCurrentPassword) {
  toggleCurrentPassword.addEventListener("click", function (e) {
    e.preventDefault();
    if (currentPasswordInput.type === "password") {
      currentPasswordInput.type = "text";
      toggleCurrentPassword.style.background = `url("/mero-blogs/public/images/eye-open.png") no-repeat center`;
      toggleCurrentPassword.style.backgroundSize = `contain`;
    } else {
      currentPasswordInput.type = "password";
      toggleCurrentPassword.style.background = `url("/mero-blogs/public/images/eye-close.png") no-repeat center`;
      toggleCurrentPassword.style.backgroundSize = `contain`;
    }
  });
}

// Code to toggle view of new password
const passwordInput = document.getElementById("new-password");
const toggleNewPassword = document.getElementById("toggle-new-password");
if (toggleNewPassword) {
  toggleNewPassword.addEventListener("click", function (e) {
    e.preventDefault();
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleNewPassword.style.background = `url("/mero-blogs/public/images/eye-open.png") no-repeat center`;
      toggleNewPassword.style.backgroundSize = `contain`;
    } else {
      passwordInput.type = "password";
      toggleNewPassword.style.background = `url("/mero-blogs/public/images/eye-close.png") no-repeat center`;
      toggleNewPassword.style.backgroundSize = `contain`;
    }
  });
}

// Code to toggle view of new confirm password
const confirmPasswordInput = document.getElementById("confirm-password");
const toggleConfirmPassword = document.getElementById(
  "toggle-confirm-password",
);

if(toggleConfirmPassword){
toggleConfirmPassword.addEventListener("click", function (e) {
  e.preventDefault();
  if (confirmPasswordInput.type === "password") {
    confirmPasswordInput.type = "text";
    toggleConfirmPassword.style.background = `url("/mero-blogs/public/images/eye-open.png") no-repeat center`;
    toggleConfirmPassword.style.backgroundSize = `contain`;
  } else {
    confirmPasswordInput.type = "password";
    toggleConfirmPassword.style.background = `url("/mero-blogs/public/images/eye-close.png") no-repeat center`;
    toggleConfirmPassword.style.backgroundSize = `contain`;
  }
});
}
// Script to toggle password view start end..

// JS code to validate change password form start here
const changePasswordForm = document.getElementById("change-password-form");

if (changePasswordForm) {
  changePasswordForm.addEventListener("submit", function (e) {
    let valid = true;

    // clear previous errors
    document
      .querySelectorAll(".error-msg")
      .forEach((el) => (el.textContent = ""));

    const currentPassword = changePasswordForm.current_password.value.trim();
    const newPassword = changePasswordForm.new_password.value.trim();
    const confirmPassword = changePasswordForm.confirm_password.value.trim();

    // Current password
    if (currentPassword.length < 6 || currentPassword.length > 20) {
      document.getElementById("currentPasswordError").textContent =
        "Current password must be 6-20 characters long.";
      valid = false;
    }

    // New password
    if (newPassword.length < 6 || newPassword.length > 20) {
      document.getElementById("newPasswordError").textContent =
        "New password must be 6-20 characters long.";
      valid = false;
    }

    // Confirm password
    if (newPassword !== confirmPassword) {
      document.getElementById("confirmPasswordError").textContent =
        "New and confirm passwords do not match.";
      valid = false;
    }

    // New password should not be same as current
    if (currentPassword && newPassword && currentPassword === newPassword) {
      document.getElementById("newPasswordError").textContent =
        "New password must be different from current password.";
      valid = false;
    }

    if (!valid) e.preventDefault();
  });
}

// JS code to validate change password form ends here
