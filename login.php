<?php
session_start();
include('connection_file.php');
if (isset($_REQUEST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "" || $password =="") {
        $_SESSION['loginError'] = 'Enter username & password';
    } elseif ($user = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `users` WHERE username = '$username'"))) {
        if ($user['password'] != $password) {
            $_SESSION['loginError'] = 'Incorrect Password';
        } else {
            $_SESSION['user'] = $user;
            header('location:index.php');
        }
    } else {
        $_SESSION['loginError'] = 'Username or Password Incorrect';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <title>Login</title>
    <style>
        .box {
            height:auto;
            margin:40px;
            padding: 5px;
            background-color:white;
        }
        .form-control {
            background-color:lightgray;
            font-size:15px;
        }
        .login-body {
            background:url('images/backgrounds/login_page_bg.jpg');
            background-size:cover;
        }

        @media only screen and (max-width: 768px) {
            .login-body {
                background:none;
            }
        }

    </style>

</head>

<body class="login-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5"></div>

            <div class="col-md-4 col-sm-12">
                <div class="box col-12 row p-4">
                    <div>
                        <img src="images/backgrounds/main_logo.png" alt="" srcset="">
                    </div>

                    <form action="login.php" method="post">
                        <label class="col-12 mt-3">
                            <input type="text" name="username" class="form-control" id="" placeholder="Username" required>
                        </label>

                        <label class="col-12 mt-3">
                            <input type="password" name="password" id="" class="form-control" placeholder="Password" required>
                        </label>

                        <button type="submit" class="logn-button btn btn-outline-dark btn-block mt-3 col-12 btn-sm" name="login">
                            Login
                        </button>

                        <hr class="m-4">

                        <p class="text-primary col-12 text-center"> <a href="#">Forgot Password ?</a></p>

                    </form>

                </div>

                <div class="box col-12 text-center pt-3">
                    <p>Don't have an account ? <a href="signup.php">Sign Up</a></p>
                </div>

            </div>

        </div>

    </div>

    <?php include('footer.php') ?>

    <?php
        if (isset($_SESSION["loginError"])) {
            $message = $_SESSION["loginError"] ;
            echo '<script type = "text/javascript">
                alertify.set("notifier","position","top-center");
                alertify.error("' . $message . '");
            </script>';
            unset($_SESSION["loginError"]);
        }
        if (isset($_SESSION["successMessage"])) {
            $message = $_SESSION["successMessage"] ;
            echo '<script type = "text/javascript">
            alertify.set("notifier","position","top-center");
            alertify.success("' . $message . '");
            </script>';
            unset($_SESSION["successMessage"]);
        }
    ?>

</body>
</html>