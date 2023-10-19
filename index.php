<?php
    session_start();
    if ($_SESSION['user']) {
        header('Location: profile.php');
    }
?>

<?php include 'head.php'; ?>
<body>

<!-- Login form. -->
<div class="container">
    <div class="col-12 col-md-8 offset-md-4 d-flex align-items-center" style="height: 100vh;">
        <div class="card" style="max-width: 300px;">
            <div class="card-body">
                <form action="vendor/signin.php" method="post">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
                    <?php
                    if ($_SESSION['message']) {
                        $class = ($_SESSION['message_type'] == 'error') ? 'msg error' : 'msg success';
                        echo '<div class="' . $class . '">' . $_SESSION['message'] . '</div>';
                    }else {
                        echo '<div class="form-group">' . '<p>No account <a href="/register.php">Sign up!</a></p>' . '</div>';
                    }
                    unset($_SESSION['message'], $_SESSION['message_type']);
                    ?>
<!--                    <div class="form-group">-->
<!--                        <p>No account <a href="/register.php">Sign up!</a></p>-->
<!--                    </div>-->
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
