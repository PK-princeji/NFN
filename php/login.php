<?php
session_start();
include('dp.php');  // अपनी DB connection फाइल का सही path दें

$error = "";  // error message के लिए वेरिएबल

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please enter username and password.";
    } else {
        $sql = "SELECT * FROM user_info WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $error = "Username does not exist.";
        } else {
            $user = $result->fetch_assoc();
           if ($password !== $user['pasword']) {
                $error = "Incorrect password.";
            } else {
                // Login successful: status 1 update करें
                $update_sql = "UPDATE user_info SET status = 1 WHERE username = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("i", $user['id']);
                $update_stmt->execute();

                // Session सेट करें
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect करें और success message दिखाएं
                header("Location: ../index.php?msg=login_success");
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css" />
</head>
<body>
    <div class="login-container">
        <h2 class="login-heading">Login</h2>
    
       <!-- Error message container -->
       <?php if (!empty($error)) : ?>
          <div id="error-message"><?php echo htmlspecialchars($error); ?></div>
       <?php endif; ?>

 

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Login</button>&nbsp;
            <p><a href="reset_password.php">Forgot Password?</a></p>
        </form>
        <p class="signup-link">
            Don't have an account? <a href="signup.php">Sign Up</a>
        </p>
    </div>
</body>
</html>
