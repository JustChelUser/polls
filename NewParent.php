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
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($password, PASSWORD_DEFAULT);

// Создаем пользователя
    $stmt = $pdo->prepare("INSERT INTO users (role, login, password) VALUES ('parent', :login, :password)");
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':password', $password);

    $stmt->execute();
    $user_id = $pdo->lastInsertId();

// Создаем родителя
    $stmt = $pdo->prepare("INSERT INTO parents (id_user, fio, email, phone) VALUES (:id_user, :fio, :email, :phone)");
    $stmt->bindParam(':id_user', $user_id);
    $stmt->bindParam(':fio', $fio);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->execute();
    Header("Refresh:0");//////
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Добавление нового родителя</title>
    </head>
    <body>
    <h1>Добавление нового родителя</h1>
    <form method="post">
        <label for="login">Логин пользователя:</label>
        <input type="text" id="login" name="login" required>
        <br>
        <label for="password">Пароль пользователя:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="fio">ФИО родителя:</label>
        <input type="text" id="fio" name="fio" required>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="phone">Телефон:</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
        <br>
        <br>
        <input type="submit" value="Сохранить">
    </form>
    </body>
    </html>
<?php
