<?php
session_start();
require_once '../connect.php';

global $connect;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status_update'])) {

    $statusUpdateArray = json_decode($_POST['status_update'], true);

//    Getting the current survey status from the database
    function getSurveyStatus($connection, $survey_id) {
        $stmt = mysqli_prepare($connection, "SELECT status FROM surveys WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $survey_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $status);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $status;
    }

    // We iterate through the array and update the statuses in the table
    foreach ($statusUpdateArray as $survey_id => $new_status) {
        // Get current status from database
        $current_status = getSurveyStatus($connect, $survey_id);

        // Check if the new status is different from the current one
        if ($current_status !== $new_status) {
            // Используем подготовленное выражение для безопасности
            $stmt = mysqli_prepare($connect, "UPDATE surveys SET status = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'ii', $new_status, $survey_id);
            mysqli_stmt_execute($stmt);
        }
    }

//    Update $_SESSION to display the "take survey" list
    $result = mysqli_query($connect, "SELECT * FROM surveys WHERE status = 1");

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $name_surveys[$row['id']] = $row["name_survey"];
        }
    }

    $_SESSION['user']['name_surveys'] = $name_surveys;
    $_SESSION['user']['sort_criteria'] = $_POST['sort_criteria'];

    mysqli_close($connect);

    header('Location: ../../profile.php');
} else {
    header('Location: ../../index.php');
}