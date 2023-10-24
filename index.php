<?php
    session_start();
    if ($_SESSION['user']) {
        header('Location: profile.php');
    }
include 'template/head.php';

?>

<body>

<!-- Login form. -->
<div class="container">
    <div class="col-12 col-md-8 offset-md-4 d-flex align-items-center" style="height: 100vh;">
        <div class="card" style="max-width: 300px;">
            <div class="card-body">
                <form action="vendor/signin.php" method="post">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
                    <div class="form-group"><p>No account <a href="/register.php">Sign up!</a></p></div>
                    <?php include 'vendor/index/index.php'; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/js/bootstrap.min.js"></script>
</body>
</html>
