<?php
session_start();
include 'conection.php';
$id = $_SESSION['id'];
$sql = "DELETE FROM `exam` WHERE `user_id` = :i";
$query = $con->prepare($sql);
$query->bindParam(':i', $id);
$query->execute();
header("location:user.php");
?>
