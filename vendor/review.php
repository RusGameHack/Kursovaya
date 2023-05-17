<?php
    session_start();
    require_once 'connect.php';
    $review = $_POST['review'];
    $idTask = $_POST['idTask'];
    $minus = ($_POST['minus'] === '-' ? 1 : 0);
    $time = $_POST['time'];
    
    mysqli_query($connect, "UPDATE `tasks` SET `isFinal`=1, `late`='$minus', `review`='$review', `finalTime`='$time' WHERE `id`='$idTask'");
    echo 'minus: '.$minus.' review: '.$review.' time: '.$time;
?>