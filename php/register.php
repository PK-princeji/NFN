<?php
session_start();

require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], (string) $_POST['csrf_token'])) {
    http_response_code(403);
    exit('Invalid or expired form. Please try again.');
}

$user = trim((string) ($_POST['new_username'] ?? ''));
$email = trim((string) ($_POST['new_email'] ?? ''));
$password = (string) ($_POST['new_password'] ?? '');
$confirmPassword = (string) ($_POST['confirm_password'] ?? '');

if ($user === '' || $email === '' || $password === '' || $confirmPassword === '') {
    http_response_code(400);
    exit('Please fill in all fields.');
}

if (!preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $user)) {
    http_response_code(400);
    exit('Username must be 3–50 characters and contain only letters, numbers, dots, underscores, or hyphens.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit('Invalid email address.');
}

if (strlen($password) < 8) {
    http_response_code(400);
    exit('Password must be at least 8 characters long.');
}

if (!hash_equals($password, $confirmPassword)) {
    http_response_code(400);
    exit('Passwords do not match.');
}

$stmt = $db->prepare('SELECT COUNT(*) AS count FROM user_info WHERE username = :username OR email = :email');
$stmt->bindValue(':username', $user, SQLITE3_TEXT);
$stmt->bindValue(':email', $email, SQLITE3_TEXT);
$result = $stmt->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);

if ((int) $row['count'] > 0) {
    http_response_code(409);
    exit('Username or email already exists.');
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$insert = $db->prepare('INSERT INTO user_info (username, email, password) VALUES (:username, :email, :password)');
$insert->bindValue(':username', $user, SQLITE3_TEXT);
$insert->bindValue(':email', $email, SQLITE3_TEXT);
$insert->bindValue(':password', $hashedPassword, SQLITE3_TEXT);

if (!$insert->execute()) {
    http_response_code(500);
    exit('Registration failed. Please try again.');
}

unset($_SESSION['csrf_token']);
header('Location: ../html/login.php?registered=1');
exit;
