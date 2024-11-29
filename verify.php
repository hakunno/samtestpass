<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['verification_code'])) {
    echo "
    <script>
        alert('Session expired or verification code not found. Please try again.');
        window.location.href = 'forgotpassword.php';
    </script>
    ";
    exit;
}

$email = $_SESSION['email'];


if (isset($_POST['verify'])) {
    $inputCode = trim($_POST['verification_code']); 


    var_dump($inputCode, $_SESSION['verification_code']); 

    if ((string)$inputCode === (string)$_SESSION['verification_code']) {
        echo "
        <script>
            alert('Verification successful! You can now reset your password.');
            window.location.href = 'resetpassword.php';
        </script>
        ";
        exit;
    } else {
        echo "<script>alert('Invalid verification code! Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
</head>
<body>
    <h2>Verify Your Email</h2>
    <p>A verification code has been sent to your email: <strong><?php echo htmlspecialchars($email); ?></strong></p>
    <form method="post" action="">
        <label for="verification_code">Enter Verification Code:</label>
        <input type="text" name="verification_code" id="verification_code" required>
        <br>
        <button type="submit" name="verify">Verify</button><br><br>
        <a href="index.php">Back</a>

    </form>
</body>
</html>
