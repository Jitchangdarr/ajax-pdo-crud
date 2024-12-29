<?php
include 'connection.php';

$email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
$code = filter_var($_GET['code'], FILTER_SANITIZE_STRING);

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($code)) {
    die("Invalid verification request.");
}

// Check if the code is valid and not expired
$sql = "SELECT * FROM users WHERE email = :email AND verification_code = :code AND expires_at > NOW()";
$stmt = $con->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':code', $code);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Mark the user as verified
    $sql = "UPDATE users SET is_verified = 1, verification_code = NULL, expires_at = NULL WHERE email = :email";
    $updateStmt = $con->prepare($sql);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->execute();

    echo "Email verification successful! You can now log in.";
} else {
    echo "Invalid or expired verification link.";
}
?>
