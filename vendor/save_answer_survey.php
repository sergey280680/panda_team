<?php
session_start();
require_once 'connect.php';

global $connect;

//echo '<pre>';
//print_r($_SESSION);
//print_r($_POST);
//print_r($_GET);
//echo '</pre>';
//die();

if (!$connect) {
    die("Помилка підключення до бази даних: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
    // Получаем ответы из формы
    $answers = $_POST['answers'];

    // Получение ID опроса из URL
    if (isset($_SESSION['user']['survey_id'])) {
        $survey_id = $_SESSION['user']['survey_id'];

        // Получение данных опроса
        $survey_query = mysqli_query($connect, "SELECT * FROM `surveys` WHERE id = $survey_id");
        $survey_data = mysqli_fetch_assoc($survey_query);
        $survey_name = mysqli_real_escape_string($connect, $survey_data['name_survey']);

        // Проверяем, что пользователь авторизован
        if (isset($_SESSION['user']['id'])) {
            $user_id = intval($_SESSION['user']['id']);

            foreach ($answers as $question_id => $selected_answer) {
                $question_id = intval($question_id);
                $selected_answer = mysqli_real_escape_string($connect, $selected_answer);

                // Получение данных вопроса
                $question_query = mysqli_query($connect, "SELECT * FROM `survey_questions` WHERE id = $question_id");
                $question_data = mysqli_fetch_assoc($question_query);
                $question_name = mysqli_real_escape_string($connect, $question_data['question']);

                // Вставка ответа в таблицу answers_surveys
                $insertAnswerQuery = "INSERT INTO answers_surveys (
                             survey_id,
                             survey_question_id,
                             user_id,
                             name_survey,
                             name_question,
                             answer
                             ) 
                    VALUES (
                           $survey_id,
                           $question_id,
                           $user_id,
                           '$survey_name',
                           '$question_name',
                           '$selected_answer'
                           )";
                if (!mysqli_query($connect, $insertAnswerQuery)) {
                    echo "Ошибка при сохранении ответов: " . mysqli_error($connect);
                }
            }
        } else {
            echo "Пользователь не авторизован. Вы не можете отправить ответы.";
        }
    } else {
        echo "Неправильный запрос.";
    }
} else {
    echo "Неправильный запрос.";
}
header('Location: ../profile.php');
// Закрытие соединения с базой данных
mysqli_close($connect);
?>