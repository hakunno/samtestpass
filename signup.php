<?php
include 'db.php'; 

if (isset($_POST['signup'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('This email is already signed up. Please use a different email.');</script>";
    } else {
      
        $insertQuery = "INSERT INTO users (email, password) VALUES ('$email', '$hashedPassword')";

        if (mysqli_query($conn, $insertQuery)) {
            echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Error during registration. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit" name="signup">Sign Up</button><br><br>
        <a href="index.php">Back</a>
    </form>
</body>
</html>
