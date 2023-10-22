<?php
session_start();
require_once 'connect.php';

global $connect;

if (!$connect) {
    die("Помилка підключення до бази даних: " . mysqli_connect_error());
}

//echo '<pre>';
//print_r($_GET);
//print_r($_SESSION);
//echo '</pre>';
//die();

// Получение ID опроса из URL
if (isset($_GET['id'])) {
    $survey_id = $_GET['id'];

    $questionsSurvey = mysqli_query($connect, "SELECT * FROM `survey_questions` WHERE survey_id = $survey_id");
    $surveyName = mysqli_query($connect, "SELECT name_survey FROM `surveys` WHERE id = $survey_id");

    $row = mysqli_fetch_assoc($surveyName);
    $surveyName = $row['name_survey'];

    echo "<h2>Опитування на тему: $surveyName</h2>";
    echo '<form method="post" action="save_answer_survey.php" onsubmit="return validateForm()">'; // Открываем форму

    if (mysqli_num_rows($questionsSurvey) > 0) {
        while ($row = mysqli_fetch_assoc($questionsSurvey)) {
            echo "<h3>{$row['question']}</h3>";
            $questionId = $row['id'];
            $radioButtons = array();

            for ($i = 1; $i <= 5; $i++) {
                $answerKey = $i . '_answer';
                if (!empty($row[$answerKey])) {
                    $radioButton = "<input type='radio' name='answers[{$questionId}]' value='{$row[$answerKey]}' required />{$row[$answerKey]}</br> ";
                    array_push($radioButtons, $radioButton);
                }
            }

            // Выводим radio buttons для этого вопроса
            echo implode($radioButtons);
        }
    } else {
        echo "Опрос не найден.";
    }

    echo '<input type="submit" value="Отправить ответы">'; // Добавляем кнопку отправки

    echo '</form>'; // Закрываем форму
    echo "<a class='nav-link' href='../profile.php' >Назад</a>";
} else {
    echo "Неправильный запрос.";
}

$_SESSION['user']['survey_id'] = intval($_GET['id']);

//echo '<pre>';
//print_r($_GET);
//print_r($_SESSION);
//echo '</pre>';
//die();

// Закрытие соединения с базой данных
mysqli_close($connect);
?>

<script>
    function validateForm() {
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        let isAtLeastOneChecked = false;

        for (let radioButton of radioButtons) {
            if (radioButton.checked) {
                isAtLeastOneChecked = true;
                break;
            }
        }

        if (!isAtLeastOneChecked) {
            alert("Пожалуйста, ответьте на все вопросы.");
            return false; // Остановка отправки формы
        }

        return true; // Разрешение отправки формы
    }
</script>