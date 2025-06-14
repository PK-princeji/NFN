<?php
include('dp.php');
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // SQLite3 में prepared statement
    $sql = "UPDATE user_info SET status = 0 WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->execute();

    // Session destroy करें
    session_unset();
    session_destroy();
}

// Redirect to login page
header("Location: ../index.php?msg=logout_success");
exit();
?>
