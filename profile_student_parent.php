<?php
require_once 'functions.php';
notAuth();
$user_id = $_SESSION['user_id'];
$pdo = connect();

// Получаем доступные опросы для ученика
$sql = "SELECT polls.id, polls.title FROM polls 
        INNER JOIN access ON polls.id = access.poll_id 
        WHERE access.user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id);
$stmt->execute();
$polls = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Set background color for the body */
        body {
            background-color: #f9f9f9;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Style the header */
        header {
            background-color: #fff;
            color: #333;
            padding: 10px;
            text-align: center;
        }

        /* Style the main content */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        /* Style the navigation menu */
        nav {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        nav ul {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav li {
            margin: 10px;
        }
        h3
        {
            margin-bottom: 10px;
        }
        nav a {
            color: #333;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #308631;
            color: #fff;
        }

        /* Style the footer */
        footer {
            background-color: #308631;
            color: white;
            text-align: center;
            padding: 10px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        /* Style the dropdown content (hidden by default) */
        .dropdown-content {
            display: none;
            position: absolute;
            z-index: 1;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        /* Style the links inside the dropdown */
        .dropdown-content a {
            color: #333;
            padding: 10px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {
            background-color: #4b4b4b;
            color: #ffffff;
        }

        /* Show the dropdown menu on hover */
        li:hover .dropdown-content {
            display: block;
        }

        ul {
            margin-top: 20px;
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        a {
            color: #000;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <header>
    </header>
    <main>
        <nav>
            <ul>
                <li><a href="logout.php">Выйти</a></li>
            </ul>
        </nav>
    </main>
    <ul>
        <?php
        // Если доступных опросов нет, выводим сообщение
        if (empty($polls)) {
            echo "<h3>Доступных опросов нет</h3>";
        } else {
        // Выводим список доступных опросов
        echo "<h3>Доступные опросы</h3>";
        ?>
        <?php foreach ($polls as $poll): ?>
            <li>
                <a href="poll.php?poll_id=<?php echo $poll['id']; ?>"><?php echo $poll['title']; ?></a>
            </li>
        <?php endforeach;
        }?>
    </ul>

</div>
<footer>
    <p>Все права защищены &copy; <?php echo date("Y"); ?></p>
</footer>
</body>
</html>