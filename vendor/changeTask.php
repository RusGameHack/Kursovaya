<?php

    session_start();
    require_once 'connect.php';
    $idTask = $_POST['id'];
    $title = $_POST['title'];
    $descr = $_POST['descr'];
    $dateTime = date('y-m-d h:i:s', strtotime($_POST['date'].' '.$_POST['time']));

    mysqli_query($connect, "UPDATE `tasks` SET `title`='$title', `descr`='$descr', `time`='$dateTime' WHERE `id`='$idTask'");
    echo 'title: '.$title.' descr: '.$descr.' time: '.$dateTime;

?>