<?php
session_start();
include 'db.php'; 

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);  

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $hashedPassword = $user['password']; 

        if (password_verify($password, $hashedPassword)) {

            $_SESSION['email'] = $email;

            echo "
            <script>
                alert('Login successful!');
                window.location.href = 'index.php';  // Redirect to dashboard
            </script>
            ";
        } else {
            echo "<script>alert('Invalid password. Please try again.');</script>";


        }
    } else {
        echo "<script>alert('No account found with that email. Please sign up.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <button type="submit" name="login">Login</button><br><br>
        <a href="forgotpassword.php">Forgot Password?</a><br>
        <a href="signup.php">Sign Up</a>
    </form>
</body>
</html>
