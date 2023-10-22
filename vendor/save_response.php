<?php
session_start();
require_once 'connect.php';

global $connect;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!$connect) {
        die("Помилка підключення до бази даних: " . mysqli_connect_error());
    }

    $user_id = $_SESSION['user']['id'];
    $name_survey = $_POST['name_survey'];
    $questions = $_POST['questions'];
    $answers = $_POST['answers'];

    // Вставка даних в таблицю `surveys`
    $insertSurveyQuery = "INSERT INTO surveys (user_id, name_survey) VALUES ($user_id, '$name_survey')";
    if (mysqli_query($connect, $insertSurveyQuery)) {
        $survey_id = mysqli_insert_id($connect); // Отримуємо ID нового опитування
    } else {
        echo "Помилка при вставці даних в таблицю `surveys`: " . mysqli_error($connect);
    }

    // Ітеруємось по масивам $questions та $answers
    foreach ($questions as $questionId => $questionText) {
        // Отримуємо відповіді для цього питання
        $answerOptions = $answers[$questionId];

        // Підготовка SQL-запиту для вставки даних в таблицю `survey_questions`
        $insertQuestionQuery = "INSERT INTO survey_questions (
                                  survey_id,
                                  name_survey,
                                  question,
                                  1_answer,
                                  2_answer,
                                  3_answer,
                                  4_answer,
                                  5_answer
                              ) VALUES ";
        $insertQuestionQuery .= "($survey_id, '$name_survey', '$questionText'";

        // Додаємо варіанти відповідей до SQL-запиту
        for ($i = 1; $i <= 5; $i++) {
            if (isset($answerOptions[$i])) {
                $answerText = $answerOptions[$i];
                $insertQuestionQuery .= ", '$answerText'";
            } else {
                $insertQuestionQuery .= ", NULL";
            }
        }

        $insertQuestionQuery .= ")";

        $_SESSION['user']['name_surveys'][$survey_id] = $_POST['name_survey'];


        if (mysqli_query($connect, $insertQuestionQuery)) {
            header('Location: ../profile.php');
        } else {
            echo "Помилка при вставці даних в таблицю `survey_questions`: " . mysqli_error($connect);
        }
    }

    // Закрити з'єднання з базою даних
    mysqli_close($connect);
} else {
    echo "Неправильний запит.";
}
?>
