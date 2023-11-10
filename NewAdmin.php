<?php
require_once 'functions.php';
checkAccessAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Подключаемся к базе данных
    $pdo = connect();
// Получаем данные из формы
    $login = $_POST['login'];
    $password = $_POST['password'];
    $fio = $_POST['fio'];
    $password = password_hash($password, PASSWORD_DEFAULT);
// Создаем пользователя
    $stmt = $pdo->prepare("INSERT INTO users (role, login, password) VALUES ('admin', :login, :password)");
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user_id = $pdo->lastInsertId();
// Создаем администратора
    $stmt = $pdo->prepare("INSERT INTO admins (id_user, fio) VALUES (:id_user, :fio)");
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
        <title>Добавление нового администратора</title>
    </head>
    <body>
    <h1>Добавление нового администратора</h1>
    <form method="post">
        <label for="login">Логин пользователя:</label>
        <input type="text" id="login" name="login" required>
        <br>
        <label for="password">Пароль пользователя:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="fio">ФИО администратора:</label>
        <input type="text" id="fio" name="fio" required>
        <br>
        <br>
        <input type="submit" value="Сохранить">
    </form>
    </body>
    </html>
<?php
