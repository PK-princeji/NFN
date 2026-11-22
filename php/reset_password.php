<?php
session_start();

require_once __DIR__ . '/db.php';

function csrfField(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

$token = (string) ($_POST['csrf_token'] ?? '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['csrf_token']) || $token === '' || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        exit('Invalid or expired form. Please try again.');
    }

    $username = trim((string) ($_POST['username'] ?? ''));
    $newPassword = (string) ($_POST['new_password'] ?? '');
    $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

    if ($username === '' || $newPassword === '' || $confirmPassword === '') {
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

    $find = $db->prepare('SELECT id FROM user_info WHERE username = :username LIMIT 1');
    $find->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $find->execute();
    $user = $result ? $result->fetchArray(SQLITE3_ASSOC) : false;

    if (!$user) {
        http_response_code(404);
        exit('User not found.');
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $update = $db->prepare('UPDATE user_info SET password = :password WHERE id = :id');
    $update->bindValue(':password', $hashedPassword, SQLITE3_TEXT);
    $update->bindValue(':id', (int) $user['id'], SQLITE3_INTEGER);

    if ($update->execute()) {
        unset($_SESSION['csrf_token']);
        header('Location: ../index.php?msg=passwordreset');
        exit;
    }

    http_response_code(500);
    exit('Error resetting password.');
}
