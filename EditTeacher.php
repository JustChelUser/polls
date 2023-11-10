<!DOCTYPE html>
<html>
<head>
    <title>Список учителей</title>
</head>
<body>
<table>
    <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Класс</th>
        <th>Действия</th>
    </tr>
    <?php
    require_once 'functions.php'; // Подключаем файл с функцией checkAccess
    checkAccessAdmin();

    $pdo = connect();
    // SQL-запрос для получения данных об учителях и классах
    $sql = "SELECT t.id, t.Fio, c.name AS class_name
            FROM teachers t LEFT JOIN classes c ON t.class_id = c.id
            ORDER BY t.id";
    // Выполнение SQL-запроса и получение результата
    $result = $pdo->query($sql);
    // Отображение данных об учителях и классах в HTML таблице
    while ($row = $result->fetch()) {
        $id = $row['id'];
        $fio = $row['Fio'];
        $class_name = $row['class_name'];
        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$fio</td>";
        echo "<td>$class_name</td>";
        echo "<td><a href='EditTeacherData.php?id=$id'>Редактировать</a></td>";
        echo "</tr>";
    }
    ?>
</table>