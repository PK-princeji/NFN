<?php
include('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo "Please enter username and password.";
        exit;
    }

    $stmt = $db->prepare("SELECT * FROM user_info WHERE username = :username");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../index.php?msg=loggedin");
        exit;
    } else {
        echo "Invalid username or password!";
    }
} else {
    // GET या अन्य method से आए तो redirect कर दें login page पर या simple message दिखाएं
    header("Location: ../html/login.html"); // या login.php जहां आपका login form है
    exit;
}
?>
