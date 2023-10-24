<?php include 'vendor/survey_page/get_id_survey.php'; ?>
<body>
<?php include 'template/nav_header.php'; ?>

<div class="container">
    <div class="col-12 col-md-8 offset-md-4 d-flex align-items-center">
        <div class="card" style="max-width: 300px;">
            <div class="card-body">
                <h2>Опитування на тему:</h2>
                <h4><?= $surveyName ?></h4>
                <form method="post" action="vendor/survey_page/count_answer_survey.php" onsubmit="return validateForm()">
                    <?php include 'vendor/survey_page/questions.php'; ?>
                    <input type="submit" value="Відправити">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="vendor/survey_page/js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/js/bootstrap.min.js"></script>
</body>
</html>