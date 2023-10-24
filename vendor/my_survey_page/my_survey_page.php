<?php
require_once 'vendor/connect.php';
global $connect;

$surveyId = $_GET['id'];
$nameSurvey = $_SESSION['user']['name_surveys'][$surveyId];

// Get unique questions from table "counter_surveys" based on $surveyId
$getQuestionsQuery = "SELECT DISTINCT question FROM counter_surveys WHERE survey_id = $surveyId";
$questionsResult = mysqli_query($connect, $getQuestionsQuery);

if ($questionsResult && mysqli_num_rows($questionsResult) > 0) {
    echo "<h3>$nameSurvey :</h3>";
    echo '<ul>';
    while ($questionRow = mysqli_fetch_assoc($questionsResult)) {
        $question = $questionRow['question'];
        // Отобразите вопрос
        echo "<li>$question</li>";
        echo "<ul>";

        // Get answers and summary results for a given question
        $getAnswersQuery = "SELECT answer, SUM(count) as total_count 
                            FROM counter_surveys 
                            WHERE survey_id = $surveyId 
                            AND question = '$question' 
                            GROUP BY answer";
        $answersResult = mysqli_query($connect, $getAnswersQuery);

        while ($answerRow = mysqli_fetch_assoc($answersResult)) {
            $answer = $answerRow['answer'];
            $total_count = $answerRow['total_count'];
            echo "<li>$answer: $total_count</li>";
        }
        echo "</ul>";
    }
    echo '</ul>';
}

mysqli_close($connect);
?>