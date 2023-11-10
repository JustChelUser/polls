<?php
require_once 'functions.php'; // Подключаем файл с функцией checkAccess
notAuth();
$fio = $_SESSION['fio'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Вход на сайт</title>
</head>
<body>
<h1>Здравствуйте,<?php echo($fio);?></h1>
<a href="create_poll.php">Создать опрос</a>
<a href="profile_teacher.php">Профиль</a>
<a href="polls.php">Список опросов</a>
<a href="logout.php">Выйти</a>
</body>
</html>