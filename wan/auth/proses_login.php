<?php
session_start();
include "../koneksi.php";

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header("Location: login.php?error=1");
    exit;
}

$username = trim($_POST['username']);
$password = $_POST['password'];

$logFile = __DIR__ . '/login_attempts.log';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

// Prepared statement to fetch user by username
$stmt = mysqli_prepare($koneksi, "SELECT * FROM user WHERE username = ? LIMIT 1");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    $user = null;
}

if (!$user) {
    // Log attempt (no sensitive data)
    $msg = sprintf("%s - LOGIN FAIL - user not found - username=%s ip=%s\n", date('Y-m-d H:i:s'), $username, $ip);
    @file_put_contents($logFile, $msg, FILE_APPEND | LOCK_EX);
    header("Location: login.php?error=2");
    exit;
}

$stored = $user['password'];
$valid = false;

if (password_verify($password, $stored)) {
    $valid = true;
} elseif ($password === $stored) {
    // fallback for plain-text stored passwords
    $valid = true;
}

if ($valid) {
    $_SESSION['login'] = true;
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role']; // admin / mahasiswa
    $msg = sprintf("%s - LOGIN OK - username=%s ip=%s\n", date('Y-m-d H:i:s'), $username, $ip);
    @file_put_contents($logFile, $msg, FILE_APPEND | LOCK_EX);
    header("Location: ../index.php");
    exit;
} else {
    $msg = sprintf("%s - LOGIN FAIL - wrong password - username=%s ip=%s\n", date('Y-m-d H:i:s'), $username, $ip);
    @file_put_contents($logFile, $msg, FILE_APPEND | LOCK_EX);
    header("Location: login.php?error=3");
    exit;
}
