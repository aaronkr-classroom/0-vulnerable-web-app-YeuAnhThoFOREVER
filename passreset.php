<?php
include("config.php");

$token = $_GET['token'] ?? '';
$user = $_GET['user'] ?? '';

if (empty($token) || empty($user)) {
    die("Invalid request.");
}

// Validate token using a prepared statement
$stmt = $db->prepare("SELECT username FROM register WHERE username = ? AND reset_token = ?");
$stmt->bind_param("ss", $user, $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Generate a new secure random password
    $new_pass = bin2hex(random_bytes(4)); // 8 hex chars
    $hashed = hash('sha256', $new_pass);

    // Update password and remove token
    $update = $db->prepare("UPDATE register SET password = ?, reset_token = NULL WHERE username = ?");
    $update->bind_param("ss", $hashed, $user);
    $update->execute();

    echo "✅ Your new password is: <strong>" . htmlspecialchars($new_pass) . "</strong>";
} else {
    echo "❌ Invalid token or user.";
}
?>
