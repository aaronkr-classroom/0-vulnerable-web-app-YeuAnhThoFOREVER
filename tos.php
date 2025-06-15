<<<<<<< HEAD
<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: /vulnerable/index.html");
    exit();
}

$allowed_files = ['service.html', 'privacy.html', 'terms.html'];
$file = basename($_GET['file'] ?? '');

if (!in_array($file, $allowed_files)) {
    die("Access denied.");
}

$full_path = __DIR__ . "/tos_pages/" . $file;
if (!file_exists($full_path)) {
    die("File not found.");
}

include($full_path);
?>
=======
<?php
session_start();

// Optional: deny access unless logged in
if (!isset($_SESSION['login_user'])) {
    header("Location: /vulnerable/index.html");
    exit();
}

// Define safe directory and whitelist
$allowed_files = [
    'service.html',
    'privacy.html',
    'terms.html'
];

$file = basename($_GET['file'] ?? '');

// Check whitelist
if (!in_array($file, $allowed_files)) {
    die("Access denied.");
}

// Use full path to prevent path traversal
$full_path = __DIR__ . "/tos_pages/" . $file;

// Confirm file exists before including
if (!file_exists($full_path)) {
    die("File not found.");
}

// Safe include
include($full_path);
?>
>>>>>>> 9c1afbf034a274f20b305748136d2bd1cd333140
