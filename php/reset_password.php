<?php
session_start();

require_once __DIR__ . '/db.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method !== 'POST') {
    header('Location: reset_password.php');
    exit;
}

if (!isset($_SESSION['user_id'], $_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], (string) $_POST['csrf_token'])) {
    http_response_code(403);
    exit('Invalid or expired form. Please log in and try again.');
}

$currentPassword = (string) ($_POST['current_password'] ?? '');
$newPassword = (string) ($_POST['new_password'] ?? '');
$confirmPassword = (string) ($_POST['confirm_password'] ?? '');

if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
    http_response_code(400);
    exit('Please fill in all fields.');
}

if (strlen($newPassword) < 8) {
    http_response_code(400);
    exit('Password must be at least 8 characters long.');
}

if (!hash_equals($newPassword, $confirmPassword)) {
    http_response_code(400);
    exit('Passwords do not match.');
}

$userId = (int) $_SESSION['user_id'];
$stmt = $db->prepare('SELECT password FROM user_info WHERE id = :id LIMIT 1');
$stmt->bindValue(':id', $userId, SQLITE3_INTEGER);
$result = $stmt->execute();
$user = $result ? $result->fetchArray(SQLITE3_ASSOC) : false;

if (!$user || !password_verify($currentPassword, (string) $user['password'])) {
    http_response_code(401);
    exit('Current password is incorrect.');
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$update = $db->prepare('UPDATE user_info SET password = :password WHERE id = :id');
$update->bindValue(':password', $hashedPassword, SQLITE3_TEXT);
$update->bindValue(':id', $userId, SQLITE3_INTEGER);

if ($update->execute()) {
    unset($_SESSION['csrf_token']);
    header('Location: ../index.php?msg=passwordreset');
    exit;
}

http_response_code(500);
exit('Error resetting password.');
