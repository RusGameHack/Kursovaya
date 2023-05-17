<?php
    session_start();
    if (!$_SESSION['user']) {
        header('Location: /');
    }                                    
    date_default_timezone_set("Europe/Moscow");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="../fonts/fonts.css">
</head>
<body>
  <div class="container">
    <div class="profile">
        <a href="../vendor/logout.php" class="logout">Выход</a>
        <!-- Информация о пользователе -->
        <div class="profile-info">
            <h2><?= $_SESSION['user']['name'] ?> <?= $_SESSION['user']['surname'] ?></h2>
            <h3><?= $_SESSION['user']['login'] ?></h3>
            <img src="<?= $_SESSION['user']['avatar'] ?>" width="200" alt="">
        </div>
        <?php
            require_once '../vendor/connect.php';
            $userAdmin = $_SESSION['user']['isAdmin'];
            if ($userAdmin == 0) {
        ?>
                <div class="popup-overlay" style="display: none;">
                    <div class="popup-container">
                        <div class="popup">
                            <h3>Отчет о задаче</h3>
                            <form id="review-form">
                                <textarea name="review" placeholder="Краткое описание выполненной задачи"></textarea>
                                <input type="text" name="idTask" id="my-task" style="display:none;">
                                <input type="text" name="minus" id="minus-task" style="display:none;">
                                <input type="text" name="time" id="time-task" style="display:none;">
                                <button class="submit-btn">Отправить</button>
                                <div class="close-btn">Закрыть</div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tasks">
                    <h3>Список задач</h3>
                    <ul>
                        <?
                            $userId = $_SESSION['user']['id'];
                            // ORDER BY `id` DESC - сотрирует по id задом-наперед
                            $check_user = mysqli_query($connect, "SELECT * FROM `tasks` ORDER BY `id` DESC");
                            while ($tasks = mysqli_fetch_assoc($check_user)) {
                                if($tasks['idUser'] == $userId) {
                                    //Устанавливаем Московское время
                                    // Первая дата
                                    $d1 = $tasks['time'];
                                    // Вторая дата
                                    $d2 = date("y-m-d h:i:s");
                                    // timestamp первой даты
                                    $d1_ts = strtotime($d1);
                                    // timestamp второй даты
                                    $d2_ts = strtotime($d2);
                                    // Количество секунд
                                    // Функция abs нужна, чтобы не проверять какая из двух дат больше
                                    $seconds = abs($d1_ts - $d2_ts);
                                    $minus = '';
                                    if($d1_ts - $d2_ts < 0) {
                                        $minus = '-';
                                    }
                                    // Количество часов нужно округлить в меньшую сторону,
                                    // чтобы узнать точное количество прошедших часов
                                    // 3600 - количество секунд в 1 часе
                                    $secondsNormal = $seconds % 60;
                                    $minutes = floor(($seconds / 60) % 60);
                                    $hours = floor($seconds / 3600);
                                    if($hours < 10) {
                                        $hours = '0'.$hours;
                                    }
                                    if($minutes < 10) {
                                        $minutes = '0'.$minutes;
                                    }
                                    if($secondsNormal < 10) {
                                        $secondsNormal = '0'.$secondsNormal;
                                    }
                                    // Время в удобоваримом формате: часы:минуты:секунды
                                    $normTime = $hours.':'.$minutes.':'.$secondsNormal;
                                    // Конечное время, если пользователь закончил задачу
                                    $finalTime = explode( '.', $tasks['finalTime'] )[0];
                                    $late = $tasks['late'];
                                    if($late == 1) {
                                        $late = '-';
                                    }
                                    else $late = '';
                                    echo '
                                        <li class="task" dataId="'.$tasks['id'].'">
                                            <div class="task-up">
                                                <span class="task-title">'.$tasks['title'].'</span>
                                                <span class="deadline">
                                                    <span class="timeTitle">Осталось времени:</span>';
                                                    if($tasks['isFinal'] == 1) {
                                                        echo '<span class="minus">'.$late.'</span><span class="timeFinal">'.$finalTime.'</span>';
                                                    } else {
                                                        echo '<span class="minus">'.$minus.'</span><span class="countdown">'.$normTime.'</span>';
                                                    }
                                                echo '
                                                </span>
                                            </div>
                                            <div class="task-center">
                                                <span class="task-descr">'.$tasks['descr'].'</span>
                                            </div>';
                                    if($tasks['isFinal'] == 1) {
                                        echo '
                                            <div class="complete">Задача выполнена</div>
                                        </li>';
                                    } else {
                                        echo '
                                            <button class="complete-btn">Выполнить задачу</button>
                                        </li>';
                                    }
                                }
                            }
                        ?>
                    <!-- Добавьте остальные задачи здесь -->
                    </ul>
                </div>
        <?php
            } else {
        ?>
            <div class="popup-overlay" style="display: none;">
                <div class="popup-container">
                    <div class="popup">
                        <div class="popup-up">
                            <!-- Имя меняется динамически -->
                            <h3>Магомед</h3>
                        </div>

                        <!-- Форма создания задачи -->
                        <form class="admin-form" id='addTask'>
                            <input name="title" type="text" placeholder="Название задачи" require>
                            <textarea class="textarea" name="descr" type="text" placeholder="Описание задачи" require></textarea>
                            <input name="date" type="date" require>
                            <input name="time" type="time" require>
                            <input name="id" id="workingId" type="text" style="display: none;">
                            <div class="buttons">
                                <button class="submit-btn">Создать задачу</button>
                                <div class="close-btn">Закрыть</div>
                            </div>
                        </form>

                        <!-- Форма изменения задачи -->
                        <form class="admin-form" id='changeTask'>
                            <input name="title" type="text" placeholder="Название задачи" require>
                            <textarea class="textarea" name="descr" type="text" placeholder="Описание задачи" require></textarea>
                            <input name="date" type="date" require>
                            <input name="time" type="time" require>
                            <input name="id" id="workingId" type="text" style="display: none;">
                            <div class="buttons">
                                <button class="submit-btn">Изменить задачу</button>
                                <div class="close-btn">Закрыть</div>
                            </div>
                            <div class="form-message-changeTask error msg"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tasks">
                <h3>Сотрудники и их задачи:</h3>
                <ul>
                    <?
                        $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `isAdmin` = 0");
                        while ($user = mysqli_fetch_assoc($check_user)) {
                            $isOnline;
                            if($user['isOnline'] == 1) {
                                $isOnline = 'online';
                            } else {
                                $isOnline = 'notonline';
                            }
                            echo '
                                <li class="workman" dataId="'.$user['id'].'">
                                    <div class="workman-up">
                                        <div class="workman-nameBlock">
                                            <div class="workman-name">'.$user['name'].' '.$user['surname'].'</div>
                                            <div class="'.$isOnline.'"></div>
                                            </div>
                                        <button class="addTask">+</button>
                                    </div>';
                                    echo '<ul>';
                                        $check_tasks = mysqli_query($connect, "SELECT * FROM `tasks` ORDER BY `id` DESC");
                                        while ($tasks = mysqli_fetch_assoc($check_tasks)) {
                                            if($tasks['idUser'] == $user['id']) {
                                                // Создаем переменные для времени
                                                $d1 = $tasks['time'];
                                                $d2 = date("y-m-d h:i:s");
                                                $d1_ts = strtotime($d1);
                                                $d2_ts = strtotime($d2);
                                                $seconds = abs($d1_ts - $d2_ts);
                                                $minus = '';
                                                if($d1_ts - $d2_ts < 0) {
                                                    $minus = '-';
                                                }
                                                $secondsNormal = $seconds % 60;
                                                $minutes = floor(($seconds / 60) % 60);
                                                $hours = floor($seconds / 3600);
                                                if($hours < 10) {
                                                    $hours = '0'.$hours;
                                                }
                                                if($minutes < 10) {
                                                    $minutes = '0'.$minutes;
                                                }
                                                if($secondsNormal < 10) {
                                                    $secondsNormal = '0'.$secondsNormal;
                                                }
                                                $normTime = $hours.':'.$minutes.':'.$secondsNormal;
                                                $finalTime = explode( '.', $tasks['finalTime'] )[0];
                                                $late = $tasks['late'];
                                                if($late == 1) {
                                                    $late = '-';
                                                }
                                                else $late = '';
                                                echo '
                                                    <li class="task" dataId="'.$tasks['id'].'">
                                                        <div class="task-up">
                                                            <span class="task-title">'.$tasks['title'].'</span>
                                                            <span class="deadline">
                                                                <span class="timeTitle">Осталось времени:</span>';
                                                                if($tasks['isFinal'] == 1) {
                                                                    echo '<span class="minus">'.$late.'</span><span class="timeFinal">'.$finalTime.'</span>';
                                                                } else {
                                                                    echo '<span class="minus">'.$minus.'</span><span class="countdown">'.$normTime.'</span>';
                                                                }
                                                            echo '
                                                            </span>
                                                        </div>
                                                        <div class="task-center">';
                                                            if($tasks['isFinal'] == 1) {
                                                                echo 
                                                                    '<span class="task-descr">'
                                                                        .$tasks['descr'].
                                                                        '<div class="mini-title">Ревью задачи:</div>
                                                                        <div class="review">'.$tasks['review'].'</div>
                                                                    </span>';
                                                            } else {
                                                                echo '<span class="task-descr">'.$tasks['descr'].'</span>';
                                                            }
                                                        echo '
                                                        </div>';
                                                if($tasks['isFinal'] == 1) {
                                                    echo '
                                                        <div class="complete">Задача выполнена</div>
                                                    </li>';
                                                } else {
                                                    echo '
                                                        <div class="buttons">
                                                            <div class="change-btn">Изменить задачу</div>
                                                            <div class="delete-btn">Удалить задачу</div>
                                                        </div>
                                                    </li>';
                                                }
                                            }
                                        }
                                    echo '</ul>';
                            echo '
                                </li>';
                        }

                    ?>
                </ul>
            </div>
        <?php
            }
        ?>                
    </div>
  </div>
  <script src="../js/jQuery.min.js"></script>
  <script src="profile.js"></script>
  <script src="profileAdmin.js"></script>
  <script src="../js/checkActiveUser.js"></script>
</body>
</html>