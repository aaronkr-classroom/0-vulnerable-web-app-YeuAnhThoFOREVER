<<<<<<< HEAD
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
=======
<?php
include("config.php");
session_start();

// Session check
if (!isset($_SESSION['login_user'])) {
    header("Location: /vulnerable/index.html");
    exit();
}

// CSRF token check
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token validation failed.");
}

// Get and validate input
$url = trim($_POST['url']);
if (empty($url)) {
    header("Location: /vulnerable/settings.php");
    exit();
}

// Whitelist: Only allow domain names or IPs (basic regex)
if (!preg_match('/^[a-zA-Z0-9\.\-]+$/', $url)) {
    die("Invalid hostname or IP address.");
}

echo "<!DOCTYPE html><html><head><meta http-equiv='X-Frame-Options' content='DENY'><meta charset='UTF-8'></head><body>";
echo "<h1>Result from Secure Server</h1>";

// Escape shell args to prevent injection
$escaped = escapeshellarg($url);
system("ping -c 4 $escaped");

echo "</body></html>";
?>
<script>
if(top != window) {
  top.location = window.location;
}
</script>
>>>>>>> 9c1afbf034a274f20b305748136d2bd1cd333140
