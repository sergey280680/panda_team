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
    <div class="col-12 col-md-6 offset-md-3 d-flex align-items-center" style="height: 100vh;">
        <div class="card" style="width: 350px; height: 300px;">
            <div class="card-body">
                <h4>Мої опитування.</h4>
            </div>

            <div class="card-body" style="overflow: auto;">
                <?php if ($_SESSION['user']['has_surveys'] > 0): ?>
                    <form action="vendor/profile/update_survey_status.php" method="post" id="status-update-form">
                        <label for="sort-criteria" class="form-label">Сортувати</label>
                        <select name="sort_criteria" id="sort-criteria">
                            <?= $sort_criteria = $_SESSION['user']['sort_criteria']?>
                            <option value="created_at" <?= ($sort_criteria === 'created_at') ? 'selected' : '' ?>>Дата створення</option>
                            <option value="name_survey" <?= ($sort_criteria === 'name_survey') ? 'selected' : '' ?>>Назва опитування</option>
                            <option value="status" <?= ($sort_criteria === 'status') ? 'selected' : '' ?>>Статус</option>
                        </select>
                        <ul style="list-style-type: none; padding: 0;">
                            <?php include 'vendor/profile/my_surveys_list.php'; ?>
                        </ul>
                        <button type="button" onclick="submitForm()">Застосувати зміни</button>
                    </form>
                <?php else: ?>
                    <h4>Ви покищо не створили жодного опитування.</h4>
                <?php endif; ?>

            </div>
        </div>

        <div class="card" style="width: 350px; height: 300px;">
            <div class="card-body">
                <h4>Пройти опитування.</h4>
            </div>
            <div class="card-body" style="overflow: auto;">
                <ul>
                    <?php include 'vendor/profile/all_published_surveys_list.php'; ?>
                </ul>
            </div>
        </div>

    </div>
</div>

<script src="vendor/profile/js/checkbox_processing.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/js/bootstrap.min.js"></script>
</body>
</html>
