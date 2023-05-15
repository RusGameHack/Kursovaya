<?php
    session_start();
    if (!$_SESSION['user']) {
        header('Location: /');
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Личный кабинет</title>
  <link rel="stylesheet" href="profile.css">
</head>
<body>
  <div class="container">
    <div class="profile">
        <a href="../vendor/logout.php" class="logout">Выход</a>
        <div class="profile-info">
            <h2><?= $_SESSION['user']['name'] ?> <?= $_SESSION['user']['surname'] ?></h2>
            <h3><?= $_SESSION['user']['login'] ?></h3>
            <img src="<?= $_SESSION['user']['avatar'] ?>" width="200" alt="">
        </div>
        <div class="tasks">
            <h3>Список задач</h3>
            <ul>
                <?
                    require_once '../vendor/connect.php';
                    $userId = $_SESSION['user']['id'];
                    $check_user = mysqli_query($connect, "SELECT * FROM `tasks`");
                    while ($tasks = mysqli_fetch_assoc($check_user)) {
                        echo $tasks['idUser'];
                        if($tasks['idUser'] == $userId) {
                            echo '
                                <li class="task">
                                    <span>
                                        <span class="task-title">'.$tasks['title'].'</span>
                                        <span class="deadline">Осталось времени: <span class="countdown">01:00:00</span></span>
                                    </span>
                                    <button class="complete-btn">Задача выполнена</button>
                                </li>
                            ';
                        }
                        echo '<br>';
                    }

                ?>
            <li class="task">
                <span>
                    <span class="task-title">Задача 1</span>
                    <span class="deadline">Осталось времени: <span class="countdown">01:00:00</span></span>
                </span>
                <button class="complete-btn">Задача выполнена</button>
            </li>
            <li class="task">
                <span>
                    <span class="task-title">Задача 2</span>
                    <span class="deadline">Осталось времени: <span class="countdown">02:30:00</span></span>
                </span>
                <button class="complete-btn">Задача выполнена</button>
            </li>
            <!-- Добавьте остальные задачи здесь -->
            </ul>
        </div>
    </div>
  </div>

  <div class="popup-overlay" style="display: none;">
    <div class="popup-container">
        <div class="popup">
            <h3>Отчет о задаче</h3>
            <textarea placeholder="Краткое описание выполненной задачи"></textarea>
            <button class="submit-btn">Отправить</button>
            <button class="close-btn">Закрыть</button>
        </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="profile.js"></script>
</body>
</html>