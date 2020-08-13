<?php
session_start();
include('connection_file.php');
if (isset($_POST['signUp'])) {
    $email = $_POST['email'];
    $full_name = $_POST['full-name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($email=="" || $full_name=="" || $username=="" || $password=="") {
        $_SESSION['errorMessage'] = "All Fields require !";
    } elseif ($save_data =
                mysqli_query($con, "INSERT INTO `users`(`full_name`, `email`, `username`, `password`) VALUES ('$full_name','$email','$username','$password')")
            ) {
        $_SESSION['successMessage'] = "Account created Successfully !!!";
        header('location:login.php');
    } else {
        $_SESSION['errorMessage'] = "Can't create an Account !";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <title>Signup Page</title>
    <style>
        .signup-body {
            background: url('images/backgrounds/login_page_bg.jpg');
            background-size: cover;
        }
        .form-control {
            background-color:lightgray;
            font-size:15px;
        }
        .box {
            height:auto;
            margin:40px;
            padding: 5px;
            background-color:white;
        }
        @media only screen and (max-width: 768px) {
            .signup-body {
                background: none;
            }
        }
    </style>
</head>

<body class="signup-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5"></div>
            <div class="col-md-4 col-sm-12">
                <div class="box border col-12 row p-4">
                    <div>
                        <img src="images/backgrounds/main_logo.png" alt="" srcset="">
                    </div>

                    <form action="signup.php" method="post" class="">
                        <label class="col-12 mt-3">
                            <input type="email" name="email" class="form-control" id="" placeholder="Enter your Email" required>
                        </label>

                        <label class="col-12 mt-3">
                            <input type="text" name="full-name" class="form-control" id="" placeholder="Full Name" required>
                        </label>

                        <label class="col-12 mt-3">
                            <input type="text" name="username" class="form-control" id="" placeholder="Username" required>
                        </label>

                        <label class="col-12 mt-3">
                            <input type="password" name="password" id="" class="form-control" placeholder="Password" required>
                        </label>

                        <button type="submit"
                        class="logn-button btn btn-outline-info btn-block mt-3 col-12 btn-sm"
                        name="signUp"
                        >
                            Sign Up
                        </button>

                        <hr class="m-4">

                        <p class="text-dark col-12 text-center">
                            By signing up, you agree to our Terms Data Policy .
                        </p>

                    </form>

                </div>

                <div class="box border col-12 text-center pt-3">
                    <p>Have an account ? <a href="login.php">Log In</a></p>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>

<?php
    if (isset($_SESSION["errorMessage"])) {
        $message = $_SESSION["errorMessage"] ;
        echo '<script type = "text/javascript">
            alertify.set("notifier","position","top-center");
            alertify.error("' . $message . '");
        </script>';
        unset($_SESSION["errorMessage"]);
    }
?>
</body>
</html>