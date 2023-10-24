<?php
if (mysqli_num_rows($questionsSurvey) > 0) {
    while ($row = mysqli_fetch_assoc($questionsSurvey)) {
        echo "<h5>{$row['question']}:</h5>";
        $questionId = $row['id'];
        $radioButtons = array();

        for ($i = 1; $i <= 5; $i++) {
            $answerKey = $i . '_answer';
            if (!empty($row[$answerKey])) {
                $radioButton = "<input type='radio' name='answers[{$questionId}]' value='{$row[$answerKey]}' required />{$row[$answerKey]}</br> ";
                array_push($radioButtons, $radioButton);
            }
        }

        // We display radio buttons for this question
        echo implode($radioButtons);
    }
} else {
    echo '<div class="alert alert-danger" role="alert">
         Опитування не знайдено.
        </div>';
}
?>