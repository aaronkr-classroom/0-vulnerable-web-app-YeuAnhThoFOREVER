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
$em = trim($_POST['email']);
$gen = trim($_POST['gender']);

if (empty($em) || empty($gen)) {
    header("Location: /vulnerable/settings.php");
    exit();
}

$stmt = $db->prepare("UPDATE register SET email = ?, gender = ? WHERE username = ?");
$stmt->bind_param("sss", $em, $gen, $user);
$stmt->execute();

$msg = $stmt->affected_rows > 0 ? "Account updated successfully." : "No modification done to profile.";

$stmt->close();
mysqli_close($db);
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="X-Frame-Options" content="DENY"></head>
<body><br>
<h2><?php echo htmlspecialchars($msg); ?></h2>
<a href="/vulnerable/settings.php"><h3>Go back</h3></a>
</body>
</html>