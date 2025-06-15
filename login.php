<?php
// login.php — secured version

include("config.php");
session_start();

// Only handle POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // CSRF check
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    // Get input and sanitize
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $msg = "Please fill in both fields.";
    } else {
        // Hash input password
        $hashed = hash('sha256', $password);

        // Use prepared statement
        $stmt = $db->prepare("SELECT username FROM register WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $hashed);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            session_regenerate_id(true); // prevent session fixation
            $_SESSION['login_user'] = $username;
            header("Location: settings.php");
            exit();
        } else {
            $msg = "Login failed.";
        }

        $stmt->close();
    }
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <title>Login</title>
</head>
<body>
<center>
<h2>Login</h2>
<?php if (!empty($msg)) echo "<p>" . htmlspecialchars($msg) . "</p>"; ?>
<form method="post" action="">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>
</center>
</body>
</html>
