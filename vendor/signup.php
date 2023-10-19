<?php
session_start();
require_once 'connect.php';

global $connect;

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email'");

if (mysqli_num_rows($check_user) === 0) {
    if ($password === $password_confirm) {
        $password = md5($password);
        mysqli_query($connect, "INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES (NULL, '$name', '$email', '$password', CURRENT_TIMESTAMP)");
        $_SESSION['message'] = 'Registration completed successfully.';
        header('Location: ../index.php');
    }else{
        $_SESSION['message'] = 'Password mismatch';
        header('Location: ../register.php');
    }
}else{
    $_SESSION['message'] = 'A user with this email already exists.';
    header('Location: ../register.php');
}

