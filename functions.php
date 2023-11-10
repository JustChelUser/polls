<?php
if (session_status() == PHP_SESSION_NONE) {
    // Если сессия еще не была начата, то начинаем ее
    session_start();
}
function isAuth()
{
    if (!empty($_SESSION['auth'])) {
        if ($_SESSION['user_role'] == 'admin') {
            header("Location: profile_admin.php");
        } else if ($_SESSION['user_role'] == 'teacher') {
            header("Location: profile_teacher.php");
        } else {
            header("Location: profile_student_parent.php");
        }
        exit;
    }
}

function check_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function notAuth()
{
    if (empty($_SESSION['auth'])) {
        header("Location: login.php");
        exit;
    }
}

function checkAccess()
{
    notAuth();
    if ($_SESSION['user_role'] == 'admin') {
    } else if ($_SESSION['user_role'] == 'teacher') {
        // Если пользователь не имеет требуемой роли, перенаправляем его на страницу авторизации
    } else {
        header("Location: login.php");
        exit;
    }

}
function isSetCustom($data)
{
    if (isset($data))
    {
        echo $data;
    }
}

function checkAccessAdmin()
{
    notAuth();
    if ($_SESSION['user_role'] != 'admin') {
        header("Location: login.php");
    }
}

function connect()
{
    // Подключаемся к базе данных
    $host = 'localhost';
    $dbname = 'myPolls';
    $userDB = 'root';
    $passwordDB = '';
    return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $userDB, $passwordDB);
}

function profile()
{
    if ($_SESSION['user_role'] == 'admin') {
        return ('<a href="profile_admin.php">Профиль</a>');
    } else if ($_SESSION['user_role'] == 'teacher') {
        return ('<a href="profile_teacher.php">Профиль</a>');
    } else {
        return ('<a href="profile_student_parent.php">Профиль</a>');
    }
}

function PollAccess($user_id, $poll_id)
{
    if (empty($poll_id)) {
        isAuth();
    } else if ($_SESSION['user_role'] == 'student' || $_SESSION['user_role'] == 'parent') {
        $pdo = connect();
// Проверка наличия записи в таблице access
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM access WHERE user_id = ? AND poll_id = ?');
        $stmt->execute([$user_id, $poll_id]);
        $count = $stmt->fetchColumn();
        if ($count == 0) {
            Header("Location: profile_student_parent.php");
        }

    }
    return true;
}

function fio($id)
{
    $pdo = connect();
// Получаем id пользователя
    $user_id = $id; // замените на реальный id
// Выполняем SQL-запрос на поиск имени пользователя
    $sql = "SELECT data.Fio
        FROM (
          SELECT Fio FROM admins WHERE id_user = :user_id
          UNION ALL
          SELECT Fio FROM parents WHERE id_user = :user_id
          UNION ALL
          SELECT Fio FROM students WHERE id_user = :user_id
          UNION ALL
          SELECT Fio FROM teachers WHERE id_user = :user_id
        ) as data";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $result = $stmt->fetch();
    if ($result) {
        return $result['Fio'];
    } else {
        return 'user';
    }
}

function pollResponses($type, $selected_answers, $question, $poll_id, $user_id, $pdo)
{
    if ($type === 'multiple_choice') {
        $selected_answers_for_question = $selected_answers[$question['id']];
        ///
        foreach ($selected_answers_for_question as $answer) {
            if (!empty(check_input($answer))) {
                $sql = "INSERT INTO poll_responses (poll_id, question_id, answer, id_user) VALUES (:poll_id, :question_id, :answer, :id_user)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':poll_id', $poll_id);
                $stmt->bindValue(':question_id', $question['id']);
                $stmt->bindValue(':answer', $answer);
                $stmt->bindValue(':id_user', $user_id);
                $stmt->execute();
            }

        }
    } else {
        $selected_answer = $selected_answers[$question['id']];
        if (!empty(check_input($selected_answer))) {
            $sql = "INSERT INTO poll_responses (poll_id, question_id, answer, id_user) VALUES (:poll_id, :question_id, :answer, :id_user)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':poll_id', $poll_id);
            $stmt->bindValue(':question_id', $question['id']);
            $stmt->bindValue(':answer', $selected_answer);
            $stmt->bindValue(':id_user', $user_id);
            $stmt->execute();
        }
    }
}

