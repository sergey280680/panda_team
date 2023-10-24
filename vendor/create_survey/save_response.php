<?php
session_start();
require_once '../connect.php';

global $connect;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!$connect) {
        die("Помилка підключення до бази даних: " . mysqli_connect_error());
    }

    $user_id = intval($_SESSION['user']['id']);
    $name_survey = mysqli_real_escape_string($connect, $_POST['name_survey']);
    $questions = $_POST['questions'];
    $answers = $_POST['answers'];
    $surveyStatus = isset($_POST['survey_status']) ? 1 : 0;

    // Inserting data into the `surveys' table
    $insertSurveyQuery = "INSERT INTO surveys (user_id, name_survey) VALUES ($user_id, '$name_survey')";
    if (mysqli_query($connect, $insertSurveyQuery)) {
        $survey_id = mysqli_insert_id($connect); // Отримуємо ID нового опитування
    } else {
        echo "Помилка при вставці даних в таблицю `surveys`: " . mysqli_error($connect);
    }

    // We iterate over the $questions and $answers arrays
    foreach ($questions as $questionId => $questionText) {
        // We are getting answers for this question
        $answerOptions = $answers[$questionId];

        // Preparation of an SQL query for inserting data into the `survey questions' table
        $insertQuestionQuery = "INSERT INTO survey_questions (
                                  survey_id,
                                  question,
                                  1_answer,
                                  2_answer,
                                  3_answer,
                                  4_answer,
                                  5_answer
                              ) VALUES ";
        $insertQuestionQuery .= "($survey_id, '$questionText'";

        // We add answer options to the SQL query
        for ($i = 1; $i <= 5; $i++) {
            if (isset($answerOptions[$i])) {
                $answerText = $answerOptions[$i];
                $insertQuestionQuery .= ", '$answerText'";
            } else {
                $insertQuestionQuery .= ", NULL";
            }
        }

        $insertQuestionQuery .= ")";

        if ($surveyStatus) {
            $_SESSION['user']['name_surveys'][$survey_id] = $_POST['name_survey'];
        }

        mysqli_query($connect, $insertQuestionQuery);

    }

// Checking the existence of a record in the counter_surveys table
    $checkCounterQuery = "SELECT * FROM counter_surveys WHERE survey_id = $survey_id";
    $checkResult = mysqli_query($connect, $checkCounterQuery);
    $nameSurvey = $_SESSION['user']['name_surveys'][$survey_id];

    // If the entry does not exist, add it
    if (mysqli_num_rows($checkResult) == 0) {

        $insertCounterQuery = "INSERT INTO counter_surveys (
                             user_id,
                             survey_id,
                             name_survey,
                             survey_question_id,
                             question,
                             answer,
                             count
                             ) VALUES ";

        foreach ($questions as $questionId => $questionText) {


            // We are getting answers for this question
            $answerOptions = $answers[$questionId];

            // Get question ID from survey_questions table
            $getQuestionIdQuery = "SELECT id FROM survey_questions WHERE survey_id = $survey_id AND question = '$questionText'";
            $result = mysqli_query($connect, $getQuestionIdQuery);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $questionId = $row['id'];

                // You can now use $questionId when inserting into the counter_surveys table
                foreach ($answerOptions as $answerText) {
                    if (!empty($answerText)) {
                        $insertCounterQuery .= "($user_id, $survey_id, '$nameSurvey', $questionId, '$questionText', '$answerText', 0), ";
                    }
                }
            }
        }

        // Remove the last extra comma and space
        $insertCounterQuery = rtrim($insertCounterQuery, ', ');

        // Executing an SQL query
        if (!empty($insertCounterQuery)) {
            mysqli_query($connect, $insertCounterQuery);
        }
    }

    // Close the database connection
    mysqli_close($connect);

    header('Location: ../../profile.php');
} else {
    header('Location: ../../bad_request.php');
}
?>
