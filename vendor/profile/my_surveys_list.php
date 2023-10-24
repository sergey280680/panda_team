<?php
session_start();
require_once 'vendor/connect.php';
global $connect;

// Receive surveys for a user
$sort_criteria = $_SESSION['user']['sort_criteria'] ?? 'created_at';
$user_id = $_SESSION['user']['id'];

$getSurveysQuery = "SELECT id, name_survey, status FROM surveys WHERE user_id = $user_id ORDER BY $sort_criteria";
$surveysResult = mysqli_query($connect, $getSurveysQuery);

if ($surveysResult && mysqli_num_rows($surveysResult) > 0) {
    while ($row = mysqli_fetch_assoc($surveysResult)) {
        $surveyId = $row['id'];
        $surveyName = $row['name_survey'];
        $status = $row['status'];

        // Generating a checkbox
        $checkboxHTML = '<input type="checkbox" name="' . $surveyId . '" value="1"';
        if ($status == 1) {
            $checkboxHTML .= ' checked';
        }
        $checkboxHTML .= '>';

        // Displaying the checkbox and survey name
        echo "<li>
                <label class='d-flex align-items-center'>
                    $checkboxHTML
                    <a class='nav-link ms-2' href='my_survey_page.php?id={$surveyId}'>$surveyName</a>
                </label>
            </li>";
    }
}

mysqli_close($connect);
?>