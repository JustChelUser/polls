<?php
require_once 'functions.php';
checkAccessAdmin();
$loginErr = $passErr = $fioErr = $parentErr = $classErr = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Подключаемся к базе данных
    require_once 'functions.php'; // Подключаем файл с функцией checkAccess
    $pdo = connect();
    // Получаем данные из формы
    $flagValidation = 0;
    $login = check_input($_POST['login']);
    $password = check_input($_POST['password']);
    $fio = check_input($_POST['fio']);
    $parent_id = check_input($_POST['parent_id']);
    $class_id = check_input($_POST['class_id']);
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    if (empty($login)) {
        $loginErr = "Введите логин";
        $flagValidation = 1;
    } elseif (!preg_match("/^[a-z0-9-_]{8,20}$/i", ($login))) {
        $loginErr = "Логин может содержать только латинские буквы, 
        цифры, тире и знак подчёркивания и длиной не меньше 
        8 символов и не больше 20";
        $flagValidation = 1;
    }
    if ($flagValidation === 0) {
        $pdo = connect();
        // Вставляем данные опроса в таблицу polls
        $sql = "SELECT COUNT(*) FROM users WHERE login = :login";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['login' => $login]);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            $loginErr = 'Такой логин уже существует';
            $flagValidation = 1;
        }
    }
    if (empty($password)) {
        $passErr = "Введите пароль";
        $flagValidation = 1;
    }elseif(!preg_match("/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{8,20}$/i", ($password)))
    {
        $passErr = "Пароль должен содержать хотя бы 1 число, 1 спецсимвол, 
        1 латинскую букву в нижнем и верхнем регистрах,общая длина не менее 8 и не больше 20 символов";
        $flagValidation = 1;
    }
    if (empty($fio)) {
        $fioErr = "Введите ФИО";
        $flagValidation = 1;
    }
    if (empty($parent_id)) {
        $parentErr = "Выберите родителя";
        $flagValidation = 1;
    }
    if (empty($class_id)) {
        $classErr = "Выберите класс";
        $flagValidation = 1;
    }
    if ($flagValidation === 0) {
// Создаем пользователя
        $stmt = $pdo->prepare("INSERT INTO users (role, login, password) VALUES ('student', :login, :password)");
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->execute();
        $user_id = $pdo->lastInsertId();

// Создаем ученика
        $stmt = $pdo->prepare("INSERT INTO students (id_user, fio, class_id, parent_id) VALUES (:id_user, :fio, :class_id, :parent_id)");
        $stmt->bindParam(':id_user', $user_id);
        $stmt->bindParam(':fio', $fio);
        $stmt->bindParam(':class_id', $class_id);
        $stmt->bindParam(':parent_id', $parent_id);
        $stmt->execute();
        //Header("Refresh:0");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Добавление нового ученика</title>
    <style>
        /* Стили для основного блока wrapper */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            background-color: #f2f2f2;
        }

        span {
            color: red;
            word-wrap: break-word;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Стили для формы */
        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }

        select {
            width: 100%;
        }

        /* Стили для заголовка */
        h1 {
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
        }

        footer {
            background-color: #308631;
            color: white;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        /* Медиа-запрос для адаптивной верстки */
        @media (max-width: 768px) {
            form {
                width: 80%;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h1>Добавление нового ученика</h1>
    <form method="post">
        <span class="error"><?php echo $loginErr; ?></span>
        <label for="login">Логин пользователя:</label>
        <input type="text" id="login" name="login" >
        <span class="error"><?php echo $passErr; ?></span>
        <label for="password">Пароль пользователя:</label>
        <input type="password" id="password" name="password" >
        <span class="error"><?php echo $fioErr; ?></span>
        <label for="fio">ФИО ученика:</label>
        <input type="text" id="fio" name="fio" >
        <span class="error"><?php echo $classErr; ?></span>
        <div>
            <label for="class_id">Класс:</label>
            <select id="class_id" name="class_id">
                <option value="">Выберите класс</option>
                <?php
                // Получаем список классов из таблицы classes
                require_once 'functions.php';
                $pdo = connect();
                $stmt = $pdo->query("SELECT id, name FROM classes");
                while ($row = $stmt->fetch()) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <span class="error"><?php echo $parentErr; ?></span>
        <div>
            <label for="parent_id">Родитель:</label>
            <select id="parent_id" name="parent_id">
                <option value="">Выберите родителя</option>
                <?php
                // Получаем список родителей из таблицы parents
                $stmt = $pdo->query("SELECT id, fio FROM parents");
                while ($row = $stmt->fetch()) {
                echo '<option value="' . $row['id'] . '">' . $row['fio'] . '</option>';
                }
                ?>
            </select>
        </div>
        <br>
        <br>
        <input type="submit" value="Сохранить">
    </form>
    <footer>
        <p>Все права защищены &copy; <?php echo date("Y"); ?></p>
    </footer>
</div>
</body>
</html>
<?php
