<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: index.php');
}
include 'head.php';
?>
<body>
<h1>Опитування:</h1>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'post' && isset($_GET['survey_id'])) {
    // Підключення до бази даних
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = 'password';
    $db_name = 'panda_team';

    $connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$connect) {
        die("Помилка підключення до бази даних: " . mysqli_connect_error());
    }

    $survey_id = $_GET['survey_id'];

    // Виберіть питання та варіанти відповідей для обраного опитування
    $selectSurveyQuery = "SELECT * FROM surveys WHERE id = $survey_id AND status = 'опублікований'";
    $surveyResult = mysqli_query($connect, $selectSurveyQuery);

    if (mysqli_num_rows($surveyResult) > 0) {
        $survey = mysqli_fetch_assoc($surveyResult);

        echo "<h2>{$survey['question']}</h2>";
        echo "<form method='post' action='save_response.php'>";
        echo "<input type='hidden' name='survey_id' value='{$survey_id}'>";

        // Виберіть варіанти відповідей для цього питання
        $selectAnswersQuery = "SELECT * FROM answers WHERE survey_id = $survey_id";
        $answersResult = mysqli_query($connect, $selectAnswersQuery);

        while ($answer = mysqli_fetch_assoc($answersResult)) {
            echo "<label><input type='checkbox' name='answers[]' value='{$answer['id']}'>{$answer['answer_text']}</label><br>";
        }

        echo "<input type='submit' value='Відповісти'>";
        echo "</form>";
    } else {
        echo "Опитування не знайдено або не опубліковано.";
    }

    // Закрити з'єднання з базою даних
    mysqli_close($connect);
} else {
    echo "Неправильний запит.";
}
?>
</body>
</html>