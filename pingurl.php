<?php
include("config.php");
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: /vulnerable/index.html");
    exit();
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token validation failed.");
}

$url = trim($_POST['url']);
if (empty($url)) {
    header("Location: /vulnerable/settings.php");
    exit();
}

if (!preg_match('/^[a-zA-Z0-9\.\-]+$/', $url)) {
    die("Invalid hostname or IP address.");
}

echo "<!DOCTYPE html><html><head><meta http-equiv='X-Frame-Options' content='DENY'></head><body>";
echo "<h1>Result from Secure Server</h1>";
$escaped = escapeshellarg($url);
system("ping -c 4 $escaped");
echo "</body></html>";
?>