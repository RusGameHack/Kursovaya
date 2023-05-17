<?php
    session_start();
    $isAdmin = $_SESSION['user']['isAdmin'];
    if ($isAdmin == 0) {
        die();
    }
    require_once './connect.php';
    $title = $_POST['title'];
    $descr = $_POST['descr'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $dateTime = date('y-m-d h:i:s', strtotime($_POST['date'].' '.$_POST['time']));
    $idUser = $_POST['id'];
    $idAdmin = $_SESSION['user']['id'];
    
    $response = [
        "message" => $idUser,
    ];
    mysqli_query($connect, "INSERT INTO `tasks`(`id`, `title`, `descr`, `idUser`, `idCreator`, `time`) VALUES (NULL, '$title', '$descr', '$idUser', '$idAdmin', '$dateTime');");
    $response = [
        "message" => $idUser,
    ];
    echo json_encode($response);
?>