<?php
// Подключаемся к базе данных
require_once 'functions.php';
checkAccess();
$pdo = connect();
// Получаем список опросов из базы данных
$sql = "SELECT id, title FROM polls";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$polls = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Список опросов</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            background-color: #f2f2f2;
        }

        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .menu {
            background-color: #4CAF50;
            padding: 10px;
            display: flex;
            justify-content: flex-end;
        }

        .menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-end;
        }

        .menu li {
            margin-left: 20px;
        }

        h1 {
            margin-top: 20px;
            text-align: center;
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

        @media only screen and (max-width: 768px) {
            .wrapper {
                padding: 10px;
            }

            .menu {
                padding: 5px;
                justify-content: center;
            }

            .menu ul {
                justify-content: center;
            }

            h1 {
                margin-top: 10px;
            }

            ul {
                margin-top: 10px;
            }

            li {
                margin-bottom: 5px;
                padding: 5px;
            }

            a {
                font-size: 16px;
            }
        }

        footer {
            background-color: #308631;
            color: white;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
<h1>Список опросов</h1>
<div class="wrapper">
    <!--    <div class="menu">-->
    <!--        <ul class="ul">-->
    <!--            <li>--><?php //echo(profile()); ?><!--</li>-->
    <!--        </ul>-->
    <!--    </div>-->
    <ul>
        <?php foreach ($polls as $poll): ?>
            <li>
                <a href="poll.php?poll_id=<?php echo $poll['id']; ?>"><?php echo $poll['title']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<!--<footer>-->
<!--    <p>Все права защищены &copy; --><?php //echo date("Y"); ?><!--</p>-->
<!--</footer>-->
</body>
</html>