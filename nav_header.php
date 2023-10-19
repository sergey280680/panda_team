<?php
session_start();
?>

<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <p class="nav-link">Hello <?= $_SESSION['user']['name'] ?></p>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Услуги</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link" href="vendor/logout.php">Exit</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
