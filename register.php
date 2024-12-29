<?php
include 'connection.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Generate a unique verification code
    $verificationCode = bin2hex(random_bytes(16));
    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour')); // 1 hour expiry

    // Insert user data into the database
    $sql = "INSERT INTO verify (name, email, password, verification_code, expires_at) VALUES (:name, :email, :password, :code, :expires)";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':code', $verificationCode);
    $stmt->bindParam(':expires', $expiresAt);

    if ($stmt->execute()) {
        // Send verification email
        $verificationLink = "http://yourdomain.com/verify.php?email=" . urlencode($email) . "&code=" . $verificationCode;
        $subject = "Verify Your Email";
        $message = "Hi $name,\n\nPlease click the link below to verify your email address:\n\n" . $verificationLink;
        $headers = "From: no-reply@yourdomain.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "Registration successful! A verification email has been sent to $email.";
        } else {
            echo "Failed to send verification email.";
        }
    } else {
        echo "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>