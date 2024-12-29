<?php

session_start();
include 'conection.php';
$userID = $_SESSION['id'];
$name = $_POST['nm'];
$adress = $_POST['te'];
$phone = $_POST['ph'];
$email = $_POST['em'];
$password = $_POST['pass'];
$conform = $_POST['con'];
$gendar = $_POST['gen'];
$lanuage = $_POST['lang'];
$file = $_FILES['file'];

if (empty($file['name'])) {
    echo "Please select a file.";
    exit;
}

$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
if (!in_array($file['type'], $allowedTypes)) {
    echo "Only JPG, PNG, and PDF files are allowed.";
    exit;
}

// Ensure upload directory exists
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$filePath = $uploadDir . basename($file['name']);
move_uploaded_file($file['tmp_name'], $filePath);

try {
    $passwordprotected = password_hash($password, PASSWORD_BCRYPT);
    $type = "user";

    $sql =  "UPDATE `exam` SET 
        `user_id` = :id,
        `name` = :nm,
        `adress` = :ad,
        `phone` = :ph,
        `email` = :em,
        `password` = :pa,
        `confirm` = :co,
        `gendar` = :ge,
        `language` = :la,
        `type` = :ua,
        `img` = :im 
        WHERE `user_id` = :userID";

    $query = $con->prepare($sql);
    $query->bindParam(':id', $userID);
    $query->bindParam(':nm', $name);
    $query->bindParam(':ad', $adress);
    $query->bindParam(':ph', $phone);
    $query->bindParam(':em', $email);
    $query->bindParam(':pa', $passwordprotected);
    $query->bindParam(':co', $conform);
    $query->bindParam(':ge', $gendar);
    $query->bindParam(':la', $lanuage);
    $query->bindParam(':ua', $type);
    $query->bindParam(':im', $filePath);
    $query->bindParam(':userID', $userID);
    $query->execute();

    header('Location: user.php');
    exit;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>
