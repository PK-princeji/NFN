<?php
// Include the database connection file
include('dp.php');

// Start session to manage login state
session_start();

// Initialize error and success message
$error = "";
$success_message = "";

// Check if form is submitted for signup
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'signup') {

    // Get form data safely
    $username = trim($_POST['new_username']);
    $email = trim($_POST['new_email']);
    $password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validations
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Username, Email, and Password cannot be empty.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $checkUsernameSQL = "SELECT * FROM user_info WHERE username = ?";
        $stmt = $conn->prepare($checkUsernameSQL);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username already taken.";
        } else {
            // Check if email already exists
            $checkEmailSQL = "SELECT * FROM user_info WHERE email = ?";
            $stmt = $conn->prepare($checkEmailSQL);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Email is already associated with an account.";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $status = 1;

                // Insert new user
                $insertSQL = "INSERT INTO user_info (username, email, pasword, status) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insertSQL);
                $stmt->bind_param("sssi", $username, $email, $hashed_password, $status);

                if ($stmt->execute()) {
                    // Fetch the user to login (using username as PK)
                    $sql = "SELECT * FROM user_info WHERE username = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();

                    if ($user && $user['status'] == 1) {
                        $_SESSION['user_id'] = $user['username'];
                        $_SESSION['username'] = $user['username'];

                        // Send welcome email
                        $to = $email;
                        $subject = "Welcome to Natural Farming Network!";
                        $message = "Hello $username,\n\nThank you for signing up on Natural Farming Network.\nWe are happy to have you on board!\n\nRegards,\nTeam Natural Farming Network";
                        $headers = "From: no-reply@naturalfarming.com";

                        mail($to, $subject, $message, $headers);

                        // Redirect with success
                        header("Location: ../index.php?msg=signup_success");
                        exit();
                    }
                } else {
                    $error = "Error creating account. Please try again.";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/signup.css">
    <script src="../js/signup.js"></script>
</head>
<body>

<!-- Background overlay -->
<div class="modal-overlay">
    <div class="logo">
        <img src="../img/bg_signup.png" alt="Natural Farming Network Logo">
    </div>
</div>

<!-- Signup Modal Box -->
<div class="signup-modal">
    <h2>Sign Up</h2>

    <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
    <?php if (!empty($success_message)) { echo "<p class='success'>$success_message</p>"; } ?>

    <form method="POST">
        <input type="text" name="new_username" placeholder="Username" required>
        <input type="email" name="new_email" placeholder="Email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
        <input type="password" name="new_password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="hidden" name="action" value="signup">
        <button type="submit">Create Account</button>
    </form>

    <p>Already have an account? <a href="../php/login.php">Log In</a></p>
</div>

</body>
</html>
