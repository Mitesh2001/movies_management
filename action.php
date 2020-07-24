<?php
session_start();
include('connection_file.php');
if (isset($_POST['signUp'])) {
    $email = $_POST['email'];
    $full_name = $_POST['full-name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $save_data = mysqli_query($con, "INSERT INTO `users`(`full_name`, `email`, `username`, `password`) VALUES ('$full_name','$email','$username','$password')");

    if ($save_data) {
        $_SESSION['successMessage'] = "Account created Successfully !!!";
        header('location:signup_page.php');
    } else {
        $_SESSION['errorMessage'] = "Can't create an Account !";
        header('location:signup_page.php');
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "" || $password =="") {
        $_SESSION['loginError'] = 'Enter both username and password';
        header('location:login.php');
    } elseif ($user = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `users` WHERE username = '$username'"))) {
        if ($user['password'] != $password) {
            $_SESSION['loginError'] = 'Incorrect Password';
            header('location:login.php');
        } else {
            $_SESSION['user'] = $user;
            header('location:index.php');
        }
    } else {
        $_SESSION['loginError'] = 'No Record Found';
        header('location:login.php');
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header('location:login.php');
}
