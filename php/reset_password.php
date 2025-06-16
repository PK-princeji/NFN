<?php
include('dp.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE user_info SET password = :password WHERE username = :username");
    $stmt->bindValue(':password', $new_password, SQLITE3_TEXT);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);

    if ($stmt->execute()) {
        echo "Password reset successful!";
        header("Location: ../index.php?msg=passwordreset");
        exit;
    } else {
        echo "Error resetting password!";
    }
}
?>
