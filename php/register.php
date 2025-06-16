<?php
include 'db.php';  // Ensure this file sets up $db as your SQLite3 or PDO object

$error = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'signup') {
    // Sanitize inputs
    $user = trim($_POST['new_username'] ?? '');
    $email = trim($_POST['new_email'] ?? '');
    $pass = $_POST['new_password'] ?? '';
    $confirm_pass = $_POST['confirm_password'] ?? '';

    // Basic validations
    if (empty($user) || empty($email) || empty($pass) || empty($confirm_pass)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif ($pass !== $confirm_pass) {
        $error = "Passwords do not match.";
    } else {
        // Check if username or email already exists
        $checkStmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE username = :user OR email = :email");
        $checkStmt->bindValue(':user', $user);
        $checkStmt->bindValue(':email', $email);
        $result = $checkStmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        if ($row['count'] > 0) {
            $error = "Username or email already exists.";
        } else {
            // Hash password before storing (very important for security)
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

            // Insert into DB
            $insertStmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:user, :email, :pass)");
            $insertStmt->bindValue(':user', $user);
            $insertStmt->bindValue(':email', $email);
            $insertStmt->bindValue(':pass', $hashedPass);

            if ($insertStmt->execute()) {
                $success_message = "✅ Registered successfully! You can now <a href='../php/login.php'>login</a>.";
            } else {
                $error = "⚠️ Registration failed, please try again.";
            }
        }
    }
}
?>

