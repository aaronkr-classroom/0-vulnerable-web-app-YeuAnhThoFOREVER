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
=======
<?php
include("config.php");
session_start();

// Validate session
if (!isset($_SESSION['login_user'])) {
    header("Location: /vulnerable/index.html");
    exit();
}

// CSRF token check
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token validation failed.");
}

// Get and sanitize input
$user = $_SESSION['login_user'];
$em = trim($_POST['email']);
$gen = trim($_POST['gender']);

// Basic validation
if (empty($em) || empty($gen)) {
    header("Location: /vulnerable/settings.php");
    exit();
}

// Prepare SQL to prevent SQLi
$stmt = $db->prepare("UPDATE register SET email = ?, gender = ? WHERE username = ?");
$stmt->bind_param("sss", $em, $gen, $user);
$stmt->execute();

// Output result
$msg = "";
if ($stmt->affected_rows > 0) {
    $msg = "Account updated successfully.";
} else {
    $msg = "No modification done to profile.";
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
<a href="/vulnerable/settings.php"><h3>Go back</h3></a>

<script>
if (top !== window) {
  top.location = window.location;
}
</script>
</body>
</html>
>>>>>>> 9c1afbf034a274f20b305748136d2bd1cd333140
