<?php
session_start();
include 'conection.php';
$userId = $_SESSION['id'];
$sql = "SELECT * FROM `exam` where `user_id` =:us";
$query = $con->prepare($sql);
$query->bindParam(':us', $userId);
$query->execute();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table border="1px solid">
        <tr>
            <th>name</th>
            <th>adress</th>
            <th>phone</th>
            <th>email</th>
            <th>password</th>
            <th>confirm</th>
            <th>gendar</th>
            <th>language</th>
            <th>type</th>
            <th>img</th>
            <th>edit</th>
            <th>delete</th>
            <th>changepassword</th>
            <th>logout</th>
        </tr>
        <?php
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $data['name'] . "</td>";
            echo "<td>" . $data['adress'] . "</td>";
            echo "<td>" . $data['phone'] . "</td>";
            echo "<td>" . $data['email'] . "</td>";
            echo "<td>" . $data['password'] . "</td>";
            echo "<td>" . $data['confirm'] . "</td>";
            echo "<td>" . $data['gendar'] . "</td>";
            echo "<td>" . $data['language'] . "</td>";
            echo "<td>" . $data['type'] . "</td>";
            echo "<td><img src='" . $data['img'] . "' alt='Image' width='100' height='100'></td>";
            echo "<td><a href='edit.php?id=" . $data['user_id'] . "'>edit</a></td>";
            echo "<td><a href='delete.php?id=" . $data['user_id'] . "'>delete</a></td>";
            echo "<td><a href='change.php?id=" . $data['user_id'] . "'>changepassword</a></td>";
            echo "<td><a href='logout.php'>logout</a></td>";
            echo "</tr>";
        }
        ?>
        <tr>
    </table>
</body>

</html>