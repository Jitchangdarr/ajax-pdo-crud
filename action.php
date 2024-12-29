<?php
include 'conection.php';

$name = htmlspecialchars($_POST['nm']);
$adress = htmlspecialchars($_POST['te']);
$phone = htmlspecialchars($_POST['ph']);
$email = filter_var($_POST['em'], FILTER_SANITIZE_EMAIL);
$password = htmlspecialchars($_POST['pass']);
$conform = htmlspecialchars($_POST['con']);
$gendar = htmlspecialchars($_POST['gen']);
$lanuage = htmlspecialchars($_POST['lang']);
$file = $_FILES['file'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}

if (empty($file['name'])) {
    echo 'Please upload the file';
    exit;
}

$allowestype = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
if (!in_array($file['type'], $allowestype)) {
    echo 'Only jpg, png, gif, and pdf files are allowed.';
    exit;
}

$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$fileName = uniqid() . "_" . basename($file['name']);
$filePath = $uploadDir . $fileName;

if (!move_uploaded_file($file['tmp_name'], $filePath)) {
    echo "Failed to upload file.";
    exit;
}

$key = 'your-encryption-key';
$iv = substr(hash('sha256', 'your-initialization-vector'), 0, 16);
$encryptedEmail = openssl_encrypt($email, 'AES-256-CBC', $key, 0, $iv);

$sql = "SELECT * FROM `exam` WHERE `email` = :em";
$query = $con->prepare($sql);
$query->bindParam(':em', $encryptedEmail);
$query->execute();

if ($query->rowCount()) {
    echo "User already present.";
} else {
    if ($password === $conform) {
        try {
            $passwordprotected = password_hash($password, PASSWORD_BCRYPT);
            $type = "user";

            $sql = "INSERT INTO `exam`(`name`, `adress`, `phone`, `email`, `password`, `confirm`, `gendar`, `language`, `type`, `img`) 
                    VALUES (:nm, :t, :ph, :em, :pa, :con, :gen, :lan, :ty, :img)";
            $query = $con->prepare($sql);
            $query->bindParam(':nm', $name);
            $query->bindParam(':t', $adress);
            $query->bindParam(':ph', $phone);
            $query->bindParam(':em', $encryptedEmail); // Store encrypted email
            $query->bindParam(':pa', $passwordprotected);
            $query->bindParam(':con', $conform);
            $query->bindParam(':gen', $gendar);
            $query->bindParam(':lan', $lanuage);
            $query->bindParam(':ty', $type);
            $query->bindParam(':img', $filePath);
            $query->execute();

            echo "<script>
                    alert('Registration successful! Redirecting to login page...');
                    setTimeout(() => {
                        window.location.href = 'login.php';
                    }, 500);
                  </script>";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Passwords do not match.";
    }
}
