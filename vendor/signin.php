<?php
session_start();
require_once 'connect.php';

    global $connect;

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'");

    if (mysqli_num_rows($check_user) > 0){
        $user = mysqli_fetch_assoc($check_user);

        // Выполнение SQL-запроса
        $result = mysqli_query($connect, "SELECT * FROM surveys");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $name_surveys[$row['id']] = $row["name_survey"];
            }
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'name_surveys' => $name_surveys,
        ];
        header('Location: ../profile.php');
    }else{
        $_SESSION['message'] = 'Invalid email or password.';
        $_SESSION['message_type'] = 'error';
        header('Location: ../index.php');
    }
?>