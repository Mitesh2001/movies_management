<?php
session_start();
include('connection_file.php');
if (isset($_REQUEST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "" || $password =="") {
        $_SESSION['loginError'] = 'Enter both username and password';
    } elseif ($user = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `users` WHERE username = '$username'"))) {
        if ($user['password'] != $password) {
            $_SESSION['loginError'] = 'Incorrect Password';
        } else {
            $_SESSION['user'] = $user;
        }
    } else {
        $_SESSION['loginError'] = 'No Record Found';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
    crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css ">
    <title>Login</title>

    <style>

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

    <link rel="stylesheet" href="css/design.css">

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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

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