<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:user, :pass)");
    $stmt->bindValue(':user', $user);
    $stmt->bindValue(':pass', $pass);
    if ($stmt->execute()) {
        echo "✅ Registered!";
    } else {
        echo "⚠️ Username may already exist!";
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
