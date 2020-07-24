<?php
include('connection_file.php');
$no = 1;
$months = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December', ];
$data = mysqli_query($con, "SELECT * FROM `posts` ");
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css ">

    <title>It's Just Movies</title>

    <style>
        body {margin:0;}

        .box:hover {
            box-shadow: silver;
        }
        .main-logo {
            height: 50px;
        }
        .poster {
            height:250px;
            width:auto;
            border:1px solid black;
            border-radius: 20%;
        }
        .shadow-text {
            color: red;
            text-shadow: 2px 2px 4px #000000;
        }
        .box-background {
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(229,229,240,1) 0%);
        }
        .small-text{
            font-size: 12px;
        }
        .navbar {
            left: 0;
            min-height: 70px;
            position: fixed;
            z-index:1;
            overflow: hidden;
            top: 0;
            width: 100%;
        }
        @media only screen and (max-width: 796px) {
           .navbar {
                left: 0;
                min-height: 70px;
                position: relative;
                z-index:1;
                margin-bottom:0px;
                top: 0;
                width: 100%;
           }
        }
    </style>

</head>
<body>
    <div class='container-fluid fixe-top'>
        <nav class="navbar box-background navbar-expand-md navbar-light border border-secondary rounded-bottom" id="myHeader">
            <div class="col-md-1"></div>
            <a href="#" class="navbar-brand">
                <img src="images/backgrounds/main_logo.png" alt="It’s Just Movies" class="main-logo">
            </a>
            <div class="col-md-1"></div>
            <a href="#" class="nav-item nav-link active btn btn-circle">Home</a>
            <div class="col-md-1"></div>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <form action="" class="form-inline mx-3">
                    <input type="text" class="form-control mr-sm-2" placeholder="Search">
                    <button type="submit" class="btn btn-outline-light text-black-50 border">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div class="navbar-nav mx-3">
                    <a href="#" class="nav-item nav-link mx-2">
                        <i class="far fa-user"></i> Profile
                    </a>
                    <a href="my_movies_page.php" class="nav-item nav-link mx-2">
                        <i class="fas fa-th-list"></i> Movies
                    </a>
                    <button onclick="confirmLogout()" class="btn nav-item nav-link mx-2">
                        Log Out  <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>

            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>
    <div class="container-fluid mt-5">
        <div class="justify-content-center row p-4">
            <?php
                while ($selected_data = mysqli_fetch_array($data)) {
                    if ($no%3 == 0) {
                        echo '<div class="box-background box col-lg-6 col-md-4 text-center mt-4 mr-4 p-4 border border rounded">';
                    } else {
                        echo '<div class="box-background box col-lg-4 col-md-4 text-center mt-4 mr-4 p-4 border border rounded">';
                    } ?>
                <img src="<?php echo 'images/posts/'.$selected_data['movie_image'] ?>" class="poster">
                <h5 class="m-2 btn btn-block btn-outline-dark">
                    <?php echo $selected_data['movie_name'] ?>
                </h5>
                <a href="youtube.com" class="btn btn-link btn-block shadow-text">TRAILER</a>

                <!-- <p class="">
                    <?php
                        $released_date = explode('-', $selected_data['released_date']);
                    echo $released_date[2].' '.$months[$released_date[1]-1].' '.$released_date[0]; ?>
                </p> ---->
                <div class="col-12">
                    <i class="far btn btn-primary text-light fa-thumbs-up mt-3 ml-3"></i>
                    <i class="far btn btn-primary text-light fa-share-square mt-3 ml-3"></i>
                    <!-- <i class="far fa-comment-alt mt-3 ml-3 btn btn-link"></i> -->
                </div>
            </div>

            <?php
                $no ++;
                }
            ?>

        </div>
    </div>
    <div class="container-fluid text-center bg-dark text-light p-3 small-text">
        <p col-12>
            ExtraMovies – Download And Watch Movies Online For Free © 2020 All Rights Reserved
        </p>
        <p col-12>
            <Strong>Disclaimer - All My Post are Free Available On INTERNET Posted By Somebody Else<br>
            I'm Not VIOLATING Any COPYRIGHTED LAW. If Anything Is Against LAW, Please Notify Us
        </p>
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

    <script>
        function confirmLogout() {
            alertify.confirm('Confirm', "Are You Sure to LogOut ?",
                function() {
                    window.location.href = "action.php?logout";
                },
                function() {}
            );
        }

    </script>

</body>
</html>