<?php
    session_start();
if ($_SESSION['user']) {
    header('Location: profile.php');
}
?>

<?php include 'head.php'; ?>
<body>

<!-- Form register -->
<div class="container">
    <div class="col-12 col-md-8 offset-md-4 d-flex align-items-center" style="height: 100vh;">
        <div class="card" style="max-width: 300px;">
            <div class="card-body">
                <form action="vendor/signup.php" method="post">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                    </div>
                    <div class="mb-3">
                        <label>Confirm password</label>
                        <input type="password" name="password_confirm" class="form-control" placeholder="Confirm password">
                    </div>
                    <?php
                        if ($_SESSION['message']) {
                            echo '<div class="msg error">' . $_SESSION['message'] . '</div>';
                        }
                        unset($_SESSION['message']);
                    ?>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Sign up</button>
                    </div>
                    <div class="mb-3">
                        <p>Already have an account. <a href="/index.php">Sign in!</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/js/bootstrap.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>-->
<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
</body>
</html>
