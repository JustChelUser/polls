<?php
require_once 'functions.php';
checkAccessAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Подключаемся к базе данных
    // Подключаем файл с функцией checkAccess
    $pdo = connect();
// Получаем данные из формы
    $login = $_POST['login'];
    $password = $_POST['password'];
    $fio = $_POST['fio'];
    $password = password_hash($password, PASSWORD_DEFAULT);
// Создаем пользователя
    $stmt = $pdo->prepare("INSERT INTO users (role, login, password) VALUES ('teacher', :login, :password)");
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user_id = $pdo->lastInsertId();
// Создаем учителя
    $stmt = $pdo->prepare("INSERT INTO teachers (id_user, fio) VALUES (:id_user, :fio)");
    $stmt->bindParam(':id_user', $user_id);
    $stmt->bindParam(':fio', $fio);
    $stmt->execute();
    Header("Refresh:0");//////
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Добавление нового учителя</title>
</head>
<body class="wrapper">
<h1>Добавление нового учителя</h1>
<div class="menu">
    <ul class="ul">
        <li><?php echo(profile());?></li>
    </ul>
</div>
<form method="post" class="new_teacher">
    <label for="login">Логин пользователя:</label>
    <input type="text" id="login" name="login" required>
    <br>
    <label for="password">Пароль пользователя:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label for="fio">ФИО учителя:</label>
    <input type="text" id="fio" name="fio" required>
    <button type="submit" value="Сохранить" class="new_teacher_button">Добавить</button>
</form>
</body>
</html>
