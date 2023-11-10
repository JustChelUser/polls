<?php
require_once 'functions.php';
checkAccessAdmin();

$pdo = connect();

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    try {
        $sql = "DELETE FROM teachers WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        header("Location: EditTeacher.php");
        exit();
    } catch (PDOException $e) {
        echo "Ошибка при удалении учителя: " . $e->getMessage();
        exit();
    }
}

$id = $_GET['id'];
$sql = "SELECT t.id,t.id_user, t.Fio, t.class_id, u.login, u.password 
        FROM teachers t 
        JOIN users u ON t.id_user = u.id
        WHERE t.id=:id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$teacher = $stmt->fetch();
if (!$teacher) {
    echo "Учитель не найден";
    exit();
}
$fio = $teacher['Fio'];
$class_id = $teacher['class_id'];
$login = $teacher['login'];
$password = $teacher['password'];

$sql = "SELECT * FROM classes ORDER BY name";
$result = $pdo->query($sql);
$classes = $result->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fio = $_POST['fio'];
    $class_id = $_POST['class_id'];
    $login = $_POST['login'];
    $password = $_POST['password'];

    $errors = 0;
    if ($errors === 0) {
        try {
            $sql = "UPDATE teachers SET Fio=:fio, class_id=:class_id WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['fio' => $fio, 'class_id' => $class_id, 'id' => $id]);

            if (!empty($login) && !empty($password)) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET login=:login, password=:password WHERE id=:id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['login' => $login, 'password' => $hash, 'id' => $teacher['id_user']]);
            }
            header("Location: EditTeacher.php");
            exit();
        } catch (PDOException $e) {
            echo "Ошибка при редактировании учителя:" . $e->getMessage();
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Редактирование учителя</title>
</head>
<body>
<h1>Редактирование учителя</h1>
<form method="post">
    <p>
        <label for="fio">ФИО:</label>
        <input type="text" name="fio" value="<?= htmlspecialchars($fio) ?>">
        <?php if (isset($errors['fio'])) : ?>
            <span style="color: red;"><?= $errors['fio'] ?></span>
        <?php endif; ?>
    </p>
    <p>
        <label for="class_id">Класс:</label>
        <select name="class_id">
            <?php foreach ($classes as $class) : ?>
                <option value="<?= $class['id'] ?>" <?= $class_id == $class['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($class['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label for="login">Логин:</label>
        <input type="text" name="login" value="<?= htmlspecialchars($login) ?>">
    </p>
    <p>
        <label for="password">Пароль:</label>
        <input type="password" name="password">
    </p>
    <input type="submit" value="Сохранить">
</form>
<form method="post">
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="submit" name="delete" value="Удалить">
</form>
</body>
</html>