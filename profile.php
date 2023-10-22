<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: index.php');
}
include 'head.php';

?>

<body>
<?php include 'nav_header.php'; ?>

<!-- Login form. -->
<div class="container">
    <div class="col-12 col-md-8 offset-md-4 d-flex align-items-center" style="height: 100vh;">
        <div class="card" style="max-width: 300px;">
            <div class="card-body">
                id: <?= $_SESSION['user']['id'] ?>
            </div>
            <div class="card-body">
                name: <?= $_SESSION['user']['name'] ?>
            </div>
            <div class="card-body">
                email: <?= $_SESSION['user']['email'] ?>
            </div>
        </div>
        <div class="card" style="max-width: 300px;">
            <div class="card-body">
                <h4>list surveys.</h4>
            </div>
            <div class="card-body">
                <ul>
                    <?php
                    if (isset($_SESSION['user']['name_surveys']) && is_array($_SESSION['user']['name_surveys'])) {
                        foreach ($_SESSION['user']['name_surveys'] as $id => $name) {
                            echo  "<li>
                                       <a class='nav-link' href='vendor/survey_page.php?id={$id}' >$name</a> 
                                  </li>";
                        }
                    }
                    ?>
                </ul>
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/js/bootstrap.min.js"></script>
</body>
</html>
