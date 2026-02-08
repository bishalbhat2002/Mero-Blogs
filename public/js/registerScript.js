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



// Script to toggle password view start here..


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

// Code to toggle view of confirm password
const toggleConfirmPassword = document.getElementById("toggle-confirm-password");
const confirmPasswordInput = document.getElementById("confirm-password");

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

// Script to toggle password view start end..




// Handle register form submission Code start
const registerForm = document.getElementById("registerForm");

if (registerForm) {
  registerForm.addEventListener("submit", function (e) {
    let isValid = true;

    // Clear all previous errors
    document.querySelectorAll(".error-msg").forEach((p) => (p.innerText = ""));

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirm = document.getElementById("confirm-password").value.trim();
    const gender = document.getElementById("gender").value;
    const phone = document.getElementById("phone").value.trim();
    const address = document.getElementById("address").value.trim();
    const photo = document.getElementById("photo").files[0];

    // Clear all previous errors
    document
      .querySelectorAll(".error-msg")
      .forEach((p) => (p.textContent = ""));

    // Name
    if (name.length < 3) {
      document.getElementById("nameError").innerText =
        "Name must be at least 3 characters";
      isValid = false;
    }

    // Email
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!emailPattern.test(email)) {
      document.getElementById("emailError").innerText = "Enter a valid email";
      isValid = false;
    }

    // Password
    if (password.length < 6) {
      document.getElementById("passwordError").innerText =
        "Password must be at least 6 characters";
      isValid = false;
    }
    if (password !== confirm) {
      document.getElementById("confirmError").innerText =
        "Passwords do not match";
      isValid = false;
    }

    // Gender
    if (!gender) {
      document.getElementById("genderError").innerText = "Select your gender";
      isValid = false;
    }

    // Phone
    const phonePattern = /^9\d{9}$/;
    if (!phonePattern.test(phone)) {
      document.getElementById("phoneError").innerText =
        "Enter a valid phone number";
      isValid = false;
    }

    // Address
    if (address.length < 3) {
      document.getElementById("addressError").innerText =
        "Enter a valid address";
      isValid = false;
    }

    // Photo
    if (photo) {
      const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
      if (!allowedTypes.includes(photo.type)) {
        document.getElementById("photoError").innerText =
          "Only JPG, JPEG, or PNG photo allowed";
        isValid = false;
      } else if (photo.size > 2 * 1024 * 1024) {
        document.getElementById("photoError").innerText =
          "Photo must be less than 2MB";
        isValid = false;
      }
    }

    // Prevent form submission if invalid
    if (!isValid) 
      e.preventDefault();
  });
}

// Handle register form submission Code End