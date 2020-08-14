<?php
session_start();
if (!$_SESSION['user']) {
    header('location:login.php');
}
include('connection_file.php');
if (isset($_POST["searchResult"])) {
    $search = $_POST['search-keyword'];
    $data = mysqli_query(
        $con,
        "select * from posts where
        movie_name like '%$search%' OR
        description like '%$search%' OR
        released_date like '%$search%'"
    );
    if (mysqli_num_rows($data) < 1) {
        $_SESSION['alertMessage'] = "No movies found for this keyword !";
        $data = mysqli_query($con, "SELECT * FROM `posts` ");
    }
} else {
    $data = mysqli_query($con, "SELECT * FROM `posts` ");
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
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
            height: 250px;
            cursor:pointer;
        }
        .box-background {
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(229,229,240,1) 0%);
        }
        .small-text{
            font-size: 12px;
        }
        .navbar{
            left: 0;
            min-height: 70px;
            position: relative;
            z-index:1;
            overflow:visible;
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
        body {
            background-color: #f0ede9;
            background-image: url('images/backgrounds/pattern34.png');
        }
    </style>

</head>
<body>
    <div class='container-fluid'>
        <nav class="navbar box-background navbar-expand-md navbar-light bg-light text-light border border-secondary rounded-bottom" id="myHeader">
            <div class="col-md-1"></div>
            <a href="#" class="navbar-brand">
                <img src="images/backgrounds/main_logo.png" alt="It’s Just Movies" class="main-logo">
            </a>
            <div class="col-md-1"></div>
            <a href="index.php" class="nav-item nav-link active btn btn-circle">Home</a>
            <div class="col-md-1"></div>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <form action="index.php" class="form-inline mx-3" method="post">
                    <input type="text" list="movies" autocomplete="off" class="form-control mr-sm-2" name="search-keyword" placeholder="Search Movie">
                    <datalist id="movies">
                        <?php
                            $selectuserMovies = mysqli_query($con, "SELECT * FROM `posts`");
                            while ($moviedata = mysqli_fetch_array($selectuserMovies)) {
                                echo "<option value = '$moviedata[movie_name]'></option>";
                            }
                        ?>
                    </datalist>
                    <button type="submit" class="btn btn-outline-light text-black-50 border" name="searchResult">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div class="navbar-nav mx-3">
                    <a href="my_movies.php" class="nav-item nav-link mx-2">
                        <i class="fas fa-th-list"></i> Movies
                    </a>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION['user']['full_name'] ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Profile</a>
                            <button class="dropdown-item btn" onclick="logout()">
                                     <i class="fas fa-sign-out-alt"></i> Log Out
                            </button>
                        </div>
                    </li>
                </div>
            </div>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>
    <div class="container-fluid">
        <div class="justify-content-center row my-4">
            <?php
                if (mysqli_num_rows($data) == 0) {
                    echo '<p class= my-2 >No Movies Found As Your Keyword</p>';
                }
                while ($selected_data = mysqli_fetch_array($data)) {
                    ?>
            <div class="col-lg-2 col-sm-4 col-xs-6 mx-lg-3">
                <img src="<?php echo 'images/posts/'.$selected_data['movie_image'] ?>"
                    class="poster col-12"
                    onclick="goToMoviePage(<?php echo $selected_data['post_id'] ?>)"
                >
                <div class=" text-center col-12">
                    <button class="btn btn-secondary my-2 btn-block"
                        onclick="goToMoviePage(<?php echo $selected_data['post_id'] ?>)"
                    >
                        <?php echo $selected_data['movie_name'] ?>
                    </button>
                </div>
                <!-- <div class="text-center col-12 border">
                    <span class="btn btn-danger btn-sm"><i class="fab fa-youtube"></i></span>
                    <span class="btn btn-info btn-sm text-dark"><i class="far fa-heart" onclick="like(this)"></i></span>
                </div> -->
            </div>
            <?php
                }
            ?>
        </div>
    </div>
    <div class="container-fluid text-center bg-dark text-light p-3 small-text">
        <p col-12>
            Download And Watch Movies Online For Free © 2020 All Rights Reserved
        </p>
        <p col-12>
            <Strong>Disclaimer - All My Post are Free Available On INTERNET Posted By Somebody Else<br>
            I'm Not VIOLATING Any COPYRIGHTED LAW. If Anything Is Against LAW, Please Notify Us
        </p>
    </div>

    <?php include('footer.php') ?>

    <script>
        function logout() {
           window.location.href = "?logout";
        }
        function goToMoviePage(id){
            window.location.href = "movie.php?post_id="+id;
        }
        function like(element){
            if (element.className == "far fa-heart") {
                element.className = "fas fa-heart";
            } else {
                element.className = "far fa-heart";
            }
        }
    </script>
    <?php
        if (isset($_SESSION['alertMessage'])) {
            $message = $_SESSION['alertMessage']; ?>
        <script>
            alertify.confirm("Error","<?php echo $message ?>",function () {
                window.location = 'add_movie.php?add=<?php echo $search ?>';
                },
                function () {
                }
            ).set('labels', {ok:'&#10010 Add This Movie to my Movie List', cancel:'&#10008; Cancel'});
        </script>
        <?php
            unset($_SESSION["alertMessage"]);
        }
    ?>

</body>
</html>