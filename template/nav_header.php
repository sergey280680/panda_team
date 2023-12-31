<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <p class="nav-link">Hello <strong><?= $_SESSION['user']['name'] ?></strong></p>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="api.php">Загрузить JSON</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">Головна</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create_survey.php">Створити опитування</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vendor/logout.php">Exit</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
