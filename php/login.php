<?php
session_start();

require_once __DIR__ . '/db.php';

function redirectWithMessage(string $message): never {
    header('Location: ../index.php?msg=' . urlencode($message));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../html/login.html');
    exit;
}

if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], (string) $_POST['csrf_token'])) {
    http_response_code(403);
    exit('Invalid or expired form. Please try again.');
}

$username = trim((string) ($_POST['username'] ?? ''));
$password = (string) ($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    http_response_code(400);
    exit('Please enter username and password.');
}

$stmt = $db->prepare('SELECT id, username, password FROM user_info WHERE username = :username LIMIT 1');
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();
$user = $result->fetchArray(SQLITE3_ASSOC);

if (!$user || !password_verify($password, (string) $user['password'])) {
    http_response_code(401);
    exit('Invalid username or password!');
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['username'] = (string) $user['username'];
unset($_SESSION['csrf_token']);

redirectWithMessage('loggedin');
