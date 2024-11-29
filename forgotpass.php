<?php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

session_start();

if (isset($_POST['send'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $verificationCode = rand(100000, 999999);
        $_SESSION['email'] = $email;
        $_SESSION['verification_code'] = $verificationCode;

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hidalgosapartment@gmail.com';
            $mail->Password = 'xecqkpbyajbrjmun';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('hidalgosapartment@gmail.com','Verification Code');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Verification Code';
            $mail->Body = "Your verification code is: <b>$verificationCode</b>";

            $mail->send();

            echo "
            <script>
                alert('Verification code sent to your email!');
                window.location.href = 'verify.php';
            </script>
            ";
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Email not found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="post" action="">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <button type="submit" name="send">Send Verification Code</button><br><br>
        <a href="index.php">Back</a>
    </form>
</body>
</html>
