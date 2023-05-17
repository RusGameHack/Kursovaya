<?php
    session_start();
    require_once 'connect.php';
    $idTask = $_POST['idTask'];

    mysqli_query($connect, "DELETE FROM `tasks` WHERE `id`='$idTask'");
?>