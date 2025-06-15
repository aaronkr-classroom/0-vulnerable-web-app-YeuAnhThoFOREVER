<?php
include("config.php");
session_start();

// Ensure user is logged in
if (!isset($_SESSION['login_user'])) {
    header("Location: /vulnerable/index.html");
    exit();
}

// CSRF token validation
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token validation failed.");
}

// Get session username (always use session, not user input)
$user = $_SESSION['login_user'];
$old = trim($_POST['oldpasswd']);

// Validate input
if (empty($old)) {
    header("Location: /vulnerable/settings.php");
    exit();
}

// Hash password (assuming SHA-256)
$old_hashed = hash('sha256', $old);

// Secure query using prepared statement
$stmt = $db->prepare("DELETE FROM register WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $user, $old_hashed);
$stmt->execute();

// Set result message
if ($stmt->affected_rows > 0) {
    session_destroy();
    $msg = "Account deleted successfully.";
} else {
    $msg = "Incorrect password.";
}

$stmt->close();
mysqli_close($db);
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta charset="UTF-8">
</head>
<body>
<br>
<h2><?php echo htmlspecialchars($msg); ?></h2>

<a href="/vulnerable/settings.php"><h3>Go back</h3></a><br>
<a href="/vulnerable/index.html"><h3>Login page</h3></a>

<script>
if (top !== window) {
    top.location = window.location;
}
</script>
</body>
</html>
