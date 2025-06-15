<?php
include('dp.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM user_info WHERE username = '$username'");
    if ($check->fetchArray()) {
        echo "Username already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO user_info (username, password, status) VALUES (:username, :password, 1)");
        $stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $stmt->bindValue(':password', $password, SQLITE3_TEXT);
        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: ../index.php?msg=registered");
            exit;
        } else {
            echo "Failed to register!";
        }
    }
}
?>
