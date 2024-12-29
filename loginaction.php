<?php
session_start();
include 'conection.php';
$name = htmlspecialchars($_POST['nm']);
$email = htmlspecialchars($_POST['em']);
$password = htmlspecialchars($_POST['pa']);
// Check if fields are empty
if (empty($name) || empty($email) || empty($password)) {
    echo "All fields are required.";
    exit;
}

// Prepare SQL query
$sql = "SELECT * FROM `exam` WHERE `email` = :ems AND `name` = :nms";
$query = $con->prepare($sql);
$query->bindParam(':ems', $email);
$query->bindParam(':nms', $name);
$query->execute();
$data = $query->fetch(PDO::FETCH_ASSOC);
if ($data) {
    // Verify the password
    if (password_verify($password, $data['password'])) {
        $type = $data['type'];
        if ($type === 'user') {
            $_SESSION['id'] = $data['user_id'];
            echo "<script>
            alert('hello user');
            setTimeout(() => {
                window.location.href = 'user.php';
            }, 500); // Redirect after 3 seconds
          </script>";
        } elseif ($type === 'admin') {
            $_SESSION['admin_id'] = $id;
            echo "Hello admin";
        } else {
            echo "Unknown user type.";
        }
    } else {
        echo "Invalid password.";
    }
} else {
    echo "User not found.";
}
