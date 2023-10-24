<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: index.php');
}
require_once 'vendor/connect.php';

global $connect;

if (!$connect) {
    die("Помилка підключення до бази даних: " . mysqli_connect_error());
}

// Get survey ID from URL
if (isset($_GET['id'])) {
    $survey_id = $_GET['id'];

    $questionsSurvey = mysqli_query($connect, "SELECT * FROM `survey_questions` WHERE survey_id = $survey_id");
    $surveyName = mysqli_query($connect, "SELECT name_survey FROM `surveys` WHERE id = $survey_id");

    $row = mysqli_fetch_assoc($surveyName);
    $surveyName = $row['name_survey'];
    include 'template/head.php';
} else {
    print_r("Неправильный запрос.") ;
}

mysqli_close($connect);
?>