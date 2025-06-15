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

$user = $_SESSION['login_user'];
$old = trim($_POST['oldpasswd']);

if (empty($old)) {
    header("Location: /vulnerable/settings.php");
    exit();
}

$old_hashed = hash('sha256', $old);

$stmt = $db->prepare("DELETE FROM register WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $user, $old_hashed);
$stmt->execute();

$msg = "";
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
<head><meta http-equiv="X-Frame-Options" content="DENY"></head>
<body><br>
<h2><?php echo htmlspecialchars($msg); ?></h2>
<a href="/vulnerable/settings.php"><h3>Go back</h3></a><br>
<a href="/vulnerable/index.html"><h3>Login page</h3></a>
</body>
</html>