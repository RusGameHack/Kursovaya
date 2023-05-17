<?php
    session_start();
    require_once 'connect.php';
    $userId = $_SESSION['user']['id'];
    $online = $_POST['online'];
    mysqli_query($connect, "UPDATE `users` SET `isOnline`='$online' WHERE `id`='$userId'");
    echo $online;
?>