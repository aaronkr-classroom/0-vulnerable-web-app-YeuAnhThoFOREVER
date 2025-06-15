<<<<<<< HEAD
<?php
include("config.php");
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: /vulnerable/index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    $user = trim($_POST['username']);
    $old = trim($_POST['oldpasswd']);
    $new = trim($_POST['newpasswd']);

    if (empty($user) || empty($old) || empty($new)) {
        header("Location: /vulnerable/settings.php");
        exit();
    }

    $old_hashed = hash('sha256', $old);
    $new_hashed = hash('sha256', $new);

    $stmt = $db->prepare("UPDATE register SET password = ? WHERE username = ? AND password = ?");
    $stmt->bind_param("sss", $new_hashed, $user, $old_hashed);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $msg = "Password updated successfully.";
    } else {
        $msg = "Incorrect password or username.";
    }

    $stmt->close();
    mysqli_close($db);
}
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

// Check session else redirect to login
if (!isset($_SESSION['login_user'])) {
    header("Location: /vulnerable/index.html");
    exit();
}

// CSRF token check
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    // Get POST parameters safely
    $user = trim($_POST['username']);
    $old = trim($_POST['oldpasswd']);
    $new = trim($_POST['newpasswd']);

    // Validate inputs
    if (empty($user) || empty($old) || empty($new)) {
        header("Location: /vulnerable/settings.php");
        exit();
    }

    // Hash passwords
    $old_hashed = hash('sha256', $old);
    $new_hashed = hash('sha256', $new);

    // Use prepared statement to prevent SQL Injection
    $stmt = $db->prepare("UPDATE register SET password = ? WHERE username = ? AND password = ?");
    $stmt->bind_param("sss", $new_hashed, $user, $old_hashed);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $msg = "Password updated successfully.";
    } else {
        $msg = "Incorrect password or username.";
    }

    $stmt->close();
    mysqli_close($db);
} else {
    header("Location: /vulnerable/settings.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-Frame-Options" content="DENY">
</head>
<body>
<br>
<h2><?php echo htmlspecialchars($msg); ?></h2>

<a href="/vulnerable/settings.php"><h3>Go back</h3></a>
</body>
</html>
>>>>>>> 9c1afbf034a274f20b305748136d2bd1cd333140
