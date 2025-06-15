<?php 
include("config.php");
session_start();

// Check login
if (!isset($_SESSION['login_user'])) {
    header("Location: /vulnerable/index.html");
    exit();
}

$check = $_SESSION['login_user'];

// Use prepared statement to prevent SQL Injection
$stmt = $db->prepare("SELECT username, email, gender FROM register WHERE username = ?");
$stmt->bind_param("s", $check);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $a = htmlspecialchars($row["username"]);
    $email = htmlspecialchars($row["email"]);
    $gender = htmlspecialchars($row["gender"]);
} else {
    die("User not found");
}

// CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$csrf = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta charset="UTF-8">
    <title>Settings</title>
</head>
<body>
<h1>Welcome <?php echo $a; ?></h1>
<center>
<h2>Profile setting</h2>
<form action="Profileupdate.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
    Username: <input type="text" name="username" value="<?php echo $a; ?>" readonly /> <br>
    Email: <input type="email" name="email" value="<?php echo $email; ?>"> <br>
    Gender:
    <input type="radio" name="gender" value="male" <?php if ($gender == 'male') echo 'checked'; ?>> Male
    <input type="radio" name="gender" value="female" <?php if ($gender == 'female') echo 'checked'; ?>> Female <br>
    <input type="submit" name="update" value="Update">
</form>

<br>
<h2>Change password</h2>
<form action="changepasswd.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
    <input type="hidden" name="username" value="<?php echo $a; ?>">
    Old Password: <input type="password" name="oldpasswd" value=""> <br>
    New Password: <input type="password" name="newpasswd" value=""> <br>
    <input type="submit" name="update" value="Update">
</form>

<br>
<h2>Delete account</h2>
<form action="deleteaccount.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
    <input type="hidden" name="username" value="<?php echo $a; ?>">
    Old Password: <input type="password" name="oldpasswd" value=""> <br>
    <input type="submit" name="update" value="Delete Account">
</form>

<br>
<h2>Ping website</h2>
<form action="pingurl.php" method="POST">
    Enter URL: <input type="text" name="url" value=""> <br>
    <input type="submit" name="submit" value="Ping">
</form>

<br><br>
<h2>Terms of Service</h2>
<a href="tos.php?file=service.html">Click here</a>

<br><br><br>
<a href="logout.php">Logout</a>
</center>

<script>
// JS Clickjacking protection
if (top !== window) {
    top.location = window.location;
}
</script>
</body>
</html>
