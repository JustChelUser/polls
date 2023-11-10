<?php
require_once 'functions.php'; // Подключаем файл с функцией checkAccess
checkAccessAdmin();
// Получение названия класса из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_name = $_POST['class_name'];
    $pdo = connect();
// Добавление нового класса в базу данных
    $stmt = $pdo->prepare("INSERT INTO classes (name) VALUES (:class_name)");
    $stmt->bindParam(':class_name', $class_name);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Добавление нового класса</title>
</head>
<body>
<a href="profile_admin.php">Профиль</a>
<h1>Добавление нового класса</h1>
<form method="post">
    <label for="class_name">Название класса:</label><br>
    <input type="text" id="class_name" name="class_name"><br><br>
    <input type="submit" value="Добавить">
</form>
</body>
</html>
