<?php
include 'db.php';
session_start();

if (!isset($_SESSION['email'])) {
    echo "<script>alert('No session found. Please try the forgot password process again.'); window.location.href = 'forgotpass.php';</script>";
    exit;
}

if (isset($_POST['reset'])) {
    $email = $_SESSION['email'];
    $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE email = '$email'";

    if (mysqli_query($conn, $updateQuery)) {
        unset($_SESSION['email']);
        echo "<script>alert('Password reset successful!'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Error resetting password. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="post" action="">
        <label for="new_password">Enter your new password:</label>
        <input type="password" name="new_password" id="new_password" required>
        <br>
        <button type="submit" name="reset">Reset Password</button>
    </form>
</body>
</html>
