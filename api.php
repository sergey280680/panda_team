<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: index.php');
}
require_once 'vendor/connect.php';
global $connect;

// Receive surveys for a user
$user_id = $_SESSION['user']['id'];

$query = "SELECT name_survey, question, answer, count FROM counter_surveys WHERE user_id = $user_id";

$result = mysqli_query($connect, $query);

$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $result->free();
}
mysqli_close($connect);

// Создаем пустой массив для группированных данных
$groupedData = [];

// Перебираем исходный массив
foreach ($data as $item) {
    $nameSurvey = $item['name_survey'];
    $question = $item['question'];
    $answer = $item['answer'];
    $count = $item['count'];

    if (!isset($groupedData[$nameSurvey])) {
        $groupedData[$nameSurvey] = [];
    }

    if (!isset($groupedData[$nameSurvey][$question])) {
        $groupedData[$nameSurvey][$question] = [];
    }

    if (!isset($groupedData[$nameSurvey][$question][$answer])) {
        $groupedData[$nameSurvey][$question][$answer] = $count;
    }
}

$jsonData = json_encode($groupedData, JSON_UNESCAPED_UNICODE);

if (file_put_contents('data.json', $jsonData)) {
    header('Location: api_page.php');
    exit();
} else {
    echo 'Ошибка при записи данных в файл.';
}
?>