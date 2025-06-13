<script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const username = form.querySelector('input[name="new_username"]');
  const email = form.querySelector('input[name="new_email"]');
  const password = form.querySelector('input[name="new_password"]');
  const confirmPassword = form.querySelector('input[name="confirm_password"]');

  form.addEventListener("submit", function (e) {
    let errors = [];

    // Username minimum 4 characters
    if (username.value.length < 4) {
      errors.push("Username must be at least 4 characters.");
    }

    // Password minimum 6 characters and at least one letter & one number
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/;
    if (!passwordPattern.test(password.value)) {
      errors.push("Password must be at least 6 characters and contain letters and numbers.");
    }

    // Password and Confirm Password match
    if (password.value !== confirmPassword.value) {
      errors.push("Passwords do not match.");
    }

    // Email format check
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value)) {
      errors.push("Please enter a valid email address.");
    }

    // If there are errors, prevent form submission and show them
    if (errors.length > 0) {
      e.preventDefault();
      alert(errors.join("\n"));
    }
  });
});
</script>
