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