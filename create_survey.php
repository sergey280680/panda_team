<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: index.php');
}
include 'template/head.php';
?>
<body>
<?php include 'template/nav_header.php'; ?>

<div class="container">
    <div class="col-12 col-md-6 offset-md-3 d-flex align-items-center">
        <div class="card" style="width: auto;">
            <div class="card-body">
                <h1>Створити нове опитування</h1>
            </div>
            <div class="card-body">
                <span id="nameSurveyMessage"></span>
                <form action="vendor/create_survey/save_response.php" method="post" id="survey-form" onsubmit="return validateForm()">
                    <input type="text" name="name_survey" placeholder="Назва опитування" required onblur="isNameSurveyUsed(this)">
                    <button type="button" onclick="addQuestion()">Додати питання</button>

                    <input class="btn_create_survey" type="submit" value="Створити опитування">
                    <div>
                        <input type="checkbox" name="survey_status" id="survey_status" value="1">
                        <label for="survey_status">Опублікувати</label>
                    </div>

                    <div id="nameSurveys" data-namesurveys='<?= json_encode($_SESSION['user']['name_surveys']) ?>'"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="vendor/create_survey/js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/js/bootstrap.min.js"></script>
</body>
</html>