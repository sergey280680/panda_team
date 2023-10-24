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
    <div class="col-12 col-md-8 offset-md-4 d-flex align-items-center" style="height: 100vh;">

        <div class="card" style="width: auto; ">
            <div class="card-body" >
                <h2>Деталі опитування</h2>
                <?php include 'vendor/my_survey_page/my_survey_page.php'; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/js/bootstrap.min.js"></script>
</body>
</html>