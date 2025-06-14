<?php
include('dp.php');  // SQLite3 connection file
session_start();

$error = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'signup') {
    $username = trim($_POST['new_username']);
    $email = trim($_POST['new_email']);
    $password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Username, Email, and Password cannot be empty.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username exists
        $stmt = $conn->prepare("SELECT * FROM user_info WHERE username = :username");
        $stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $result = $stmt->execute();
        $userExists = $result->fetchArray(SQLITE3_ASSOC);
        
        if ($userExists) {
            $error = "Username already taken.";
        } else {
            // Check if email exists
            $stmt = $conn->prepare("SELECT * FROM user_info WHERE email = :email");
            $stmt->bindValue(':email', $email, SQLITE3_TEXT);
            $result = $stmt->execute();
            $emailExists = $result->fetchArray(SQLITE3_ASSOC);

            if ($emailExists) {
                $error = "Email is already associated with an account.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $status = 1;

                // Insert new user
                $insertSQL = "INSERT INTO user_info (username, email, pasword, status) VALUES (:username, :email, :password, :status)";
                $stmt = $conn->prepare($insertSQL);
                $stmt->bindValue(':username', $username, SQLITE3_TEXT);
                $stmt->bindValue(':email', $email, SQLITE3_TEXT);
                $stmt->bindValue(':password', $hashed_password, SQLITE3_TEXT);
                $stmt->bindValue(':status', $status, SQLITE3_INTEGER);

                $result = $stmt->execute();

                if ($result) {
                    // Set session and redirect
                    $_SESSION['user_id'] = $username;
                    $_SESSION['username'] = $username;

                    // Send welcome email
                    $to = $email;
                    $subject = "Welcome to Natural Farming Network!";
                    $message = "Hello $username,\n\nThank you for signing up on Natural Farming Network.\nWe are happy to have you on board!\n\nRegards,\nTeam Natural Farming Network";
                    $headers = "From: no-reply@naturalfarming.com";

                    mail($to, $subject, $message, $headers);

                    header("Location: ../index.php?msg=signup_success");
                    exit();
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
