<?php
session_start();
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
    <title>sign up </title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/design.css">

</head>

<body class="signup-body">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-4 col-sm-12">

                <div class="box border col-12 row p-4">

                    <div>
                        <img src="images/backgrounds/main_logo.png" alt="" srcset="">
                    </div>

                    <form action="action.php" method="post" class="">

                        <label class="col-12 mt-3">
                            <input type="text" name="email" class="form-control" id="" placeholder="Enter your Email">
                        </label>

                        <label class="col-12 mt-3">
                            <input type="text" name="full-name" class="form-control" id="" placeholder="Full Name">
                        </label>

                        <label class="col-12 mt-3">
                            <input type="text" name="username" class="form-control" id="" placeholder="Username">
                        </label>

                        <label class="col-12 mt-3">
                            <input type="password" name="password" id="" class="form-control" placeholder="Password">
                        </label>

                        <button type="submit"
                        class="logn-button btn btn-outline-info btn-block mt-3 col-12 btn-sm"
                        name="signUp"
                        >
                            Sign Up
                        </button>

                        <hr class="m-4">

                        <?php
                           if (isset($_SESSION['successMessage'])) {
                               echo "<div class='alert alert-success text-center' id='Message'>
                                        $_SESSION[successMessage]
                                        <a href='#' onclick='clearMessage()' class='float-right'>
                                            <i class='fas fa-times text-success' id='success-times'></i>
                                        </a>
                                    </div>";
                           } elseif (isset($_SESSION['errorMessage'])) {
                               echo "<div class='alert alert-danger text-center' id='Message'>
                                        $_SESSION[errorMessage]
                                        <a href='#' onclick='clearMessage()' class='float-right'>
                                            <i class='fas fa-times text-danger' id='danger-times'></i>
                                        </a>
                                    </div>";
                           }
                        ?>
                        <p class="text-dark col-12 text-center">
                            By signing up, you agree to our Terms Data Policy .
                        </p>

                    </form>

                </div>

                <div class="box border col-12 text-center pt-3">

                    <p>Have an account ? <a href="login_page.php">Log In</a></p>

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
<script>

    function clearMessage() {clearMessage
        var message = document.getElementById('Message');
        message.remove()
        <?php session_destroy() ?>
    }

</script>
</body>
</html>