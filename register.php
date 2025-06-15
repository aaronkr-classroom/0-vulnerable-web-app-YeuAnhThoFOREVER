<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-Frame-Options" content="DENY">
  <title>Register</title>
</head>
<body>

<?php
include("config.php");
session_start();

// CSRF protection
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token validation failed.");
}

// Get and sanitize input
$a = trim($_POST['username']);
$b = trim($_POST['passwd']);
$c = trim($_POST['email']);
$d = trim($_POST['gender']);

// Validate inputs
if (empty($a) || empty($b) || empty($c) || empty($d)) {
    die("All fields are required.");
}
if (!filter_var($c, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}

// Hash password securely
$hashed_pass = hash('sha256', $b);

// Use prepared statement
$stmt = $db->prepare("INSERT INTO register (username, password, email, gender) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $a, $hashed_pass, $c, $d);

if ($stmt->execute()) {
    echo "<h2>Successfully registered as " . htmlspecialchars($a) . "</h2>";
} else {
    echo "<h2>Username is taken or registration error</h2>";
}

$stmt->close();
mysqli_close($db);
?>

<br>
<a href="/vulnerable/index.html">Go back</a>

<script>
if (top !== window) {
    top.location = window.location;
}
</script>
</body>
</html>
