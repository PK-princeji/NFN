<?php
include('dp.php');
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Update status to 0 using username as primary key
    $sql = "UPDATE user_info SET status = 0 WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // Destroy session
    session_unset();
    session_destroy();
}

// Redirect to login page
header("Location: ../index.php?msg=logout_success");
exit();
?>
