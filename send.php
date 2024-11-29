<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

session_start(); // Start the session to store the verification code

if (isset($_POST["send"])) {
    $mail = new PHPMailer(true);

    try {
        // Generate a random 6-digit verification code
        $verificationCode = rand(100000, 999999);

        // Store the code in session for later verification
        $_SESSION['verification_code'] = $verificationCode;

        $subject = "Your Verification Code";
        $message = "Your verification code is: " . $verificationCode;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hidalgosapartment@gmail.com'; // Your Gmail
        $mail->Password = 'sgqgqejxbhlccnvw'; // Gmail app password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('hidalgosapartment@gmail.com'); // Your Gmail
        $mail->addAddress($_POST["email"]);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();

        // Display the form to input the verification code
        echo "
        <h3>Email Sent Successfully!</h3>
        <p>Please enter the verification code sent to your email:</p>
        <form action='verify.php' method='post'>
            <label for='verification_code'>Verification Code:</label>
            <input type='text' id='verification_code' name='verification_code' required>
            <button type='submit'>Submit</button>
        </form>
        ";
    } catch (Exception $e) {
        echo "
        <script>
        alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
        </script>
        ";
    }
}
?>
