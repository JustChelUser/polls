<?php
require_once 'functions.php'; // Подключаем файл с функцией checkAccess
//checkAccess();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = connect();
    $poll_title = $_POST['poll_title'];
// Вставляем данные опроса в таблицу polls
    $sql = "INSERT INTO polls (title) VALUES (:title)";
    print_r($_POST);
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['title' => $poll_title]);
    // Получаем id последней вставленной записи в таблицу polls
    $poll_id = $pdo->lastInsertId();
    // Вставляем данные вопросов и ответов в таблицы questions и answers
    foreach ($_POST as $key => $value) {
        // Проверяем, что это поле вопроса
        if (strpos($key, 'question_') === 0) {
            // Получаем номер вопроса из имени поля
            $questionNumber = substr($key, strlen('question_'));
            // Получаем текст вопроса
            $question = $value;
            // Получаем тип вопроса
            $answer_type = $_POST["type_$questionNumber"];

            // Вставляем данные вопроса в таблицу questions
            $sql = "INSERT INTO questions (poll_id, question, answer_type) VALUES (:poll_id, :question, :answer_type)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['poll_id' => $poll_id, 'question' => $question, 'answer_type' => $answer_type]);
            $question_id = $pdo->lastInsertId();
            $i = 1;
            echo("answer_{$questionNumber}_$i");
            foreach ($_POST as $key2 => $value2) {
                if (strpos($key2, "answer_{$questionNumber}_$i") === 0) {
                    $answer = $_POST["answer_{$questionNumber}_$i"];
                    $points = $_POST["points_${questionNumber}_$i"];
                    $sql = "INSERT INTO answers (question_id, answer, points) VALUES (:question_id, :answer, :points)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['question_id' => $question_id, 'answer' => $answer, 'points' => $points]);
                    $i++;
                }

            }
        }
    }
// Перенаправляем пользователя на страницу со списком опросов
    header("Location: polls.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <!--    <link rel="stylesheet" href="styles.css">-->
    <title>Конструктор опросов</title>
    <script>
        let questionNumber = 0;

        function addQuestion() {
            let type = document.getElementById(`type`).value;
            let answerCount = 0;
            if (type !== "scale" && type !== "open_answer") {
                answerCount = prompt('Введите количество ответов на новый вопрос:');
                if (answerCount === null) {
                    return;
                }
                if (!answerCount || isNaN(answerCount) || answerCount < 1) {
                    alert('Некорректное количество ответов!');
                    return;
                }
            }
            questionNumber++;
            let newQuestion = document.createElement('div');
            newQuestion.classList.add('question');
            newQuestion.innerHTML = `
            <label for="question_${questionNumber}">Вопрос ${questionNumber}:</label>
            <input type="text" name="question_${questionNumber}" required>
            <input type="hidden" name="type_${questionNumber}" value="${type}" required>
            ${generateAnswerFields(answerCount, type)}
            <button type="button" class="btndel" onclick="removeQuestion(this)">Удалить вопрос</button>`;
            let form = document.getElementById('poll-form');
            form.lastElementChild.insertAdjacentElement('afterend', newQuestion);
        }

        // Обработчик события для удаления вопроса
        function removeQuestion(button) {
            let question = button.parentNode;
            question.parentNode.removeChild(question);
            let questions = document.querySelectorAll('.question');
            questionNumber--;
            for (let i = 0; i < questions.length; i++) {
                let label = questions[i].querySelector('label');
                let input = questions[i].querySelector('input[type="text"]');
                let typeField = questions[i].querySelector('input[type="hidden"]');
                let oldNumber = input.attributes.item(1).value.substring(9);
                label.innerHTML = `Вопрос ${i + 1}:`;
                label.setAttribute('for', `question_${i + 1}`);
                input.setAttribute('name', `question_${i + 1}`);
                typeField.setAttribute('name', `type_${i + 1}`);
                let inputAnswer = questions[i].querySelectorAll(`input[name^="answer_${oldNumber}_"]`);
                let labelAnswer = questions[i].querySelectorAll(`label[for^="answer_${oldNumber}_"]`);
                let inputPoints = questions[i].querySelectorAll(`input[name^="points_${oldNumber}_"]`);
                let labelPoints = questions[i].querySelectorAll(`label[for^="points_${oldNumber}_"]`);
                for (let j = 0; j < inputAnswer.length; j++) {
                    inputAnswer[j].setAttribute('name', `answer_${i + 1}_${j + 1}`)
                    labelAnswer[j].setAttribute('for', `answer_${i + 1}_${j + 1}`)
                    inputPoints[j].setAttribute('name', `points_${i + 1}_${j + 1}`)
                    labelPoints[j].setAttribute('for', `points_${i + 1}_${j + 1}`)
                }
            }
        }

        function generateAnswerFields(answerCount, type) {
            let container = '';
            if (type === 'single_choice' || type === 'multiple_choice') {
                for (let i = 1; i <= answerCount; i++) {
                    container += `
                    <div>
                        <label for="answer_${questionNumber}_${i}">Ответ${i}:</label>
                        <input type="text" name="answer_${questionNumber}_${i}" required>
                        <label for="points_${questionNumber}_${i}">Количество баллов:</label>
                        <input type="number" name="points_${questionNumber}_${i}" min="0" max="10" step="1" value="1">
                    </div>`;
                }
            }
            return container;
        }
    </script>
</head>
<body>
<div class="wrapper">
    <header>
        <h1>Конструктор опросов</h1>
        <?php
        //echo(profile());
        ?>
    </header>
    <form id="poll-form" method="post" class="poll-form">
        <label> Заголовок опроса:</label>
        <input type="text" name="poll_title" required>
        <button type="button" id="add-question-btn" onclick="addQuestion()">Добавить вопрос</button>
        <button type="submit" class="btnsave">Сохранить опрос</button>
        <div>
            <label>Тип вопроса:</label>
            <select id="type">
                <option value="single_choice">Выбор одного варианта</option>
                <option value="multiple_choice">Выбор нескольких вариантов</option>
                <option value="scale">Шкала от 0 до 10</option>
                <option value="open_answer">Открытый ответ</option>
            </select>
        </div>
    </form>
</div>
</body>
</html>
