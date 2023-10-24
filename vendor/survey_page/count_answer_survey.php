<?php
session_start();
require_once '../connect.php';
//print_r(1111111);die();

global $connect;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$connect) {
        die("Помилка підключення до бази даних: " . mysqli_connect_error());
    }

    $answers = $_POST['answers'];

    // Loop through the responses array and update the count column in the counter_surveys table.
    foreach ($answers as $questionId => $selectedAnswer) {
        // Update the number of votes in the 'count' column.
        $updateCountQuery = "UPDATE counter_surveys SET count = count + 1 WHERE survey_question_id = $questionId AND answer = '$selectedAnswer'";

        mysqli_query($connect, $updateCountQuery);
    }

    mysqli_close($connect);

    header('Location: ../../profile.php');
} else {
    echo "Неправильний запит.";
}

?>