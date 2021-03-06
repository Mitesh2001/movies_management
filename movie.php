<?php
session_start();
include('connection_file.php');
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $selectedMovie = mysqli_fetch_array(
        mysqli_query($con, "SELECT * FROM `posts` WHERE post_id = '$post_id'")
    );
} else {
    header('location:index.php');
}
$selectLink = mysqli_query($con, "SELECT * FROM `download_links` WHERE link_for = '$post_id'")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <title>It's Just Movies</title>
    <style>
        body {margin:0;}
        .main-logo {
            height: 50px;
        }
        .box-background {
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(229,229,240,1) 0%);
        }
        .movie-box {
            border: 1px solid black;
            margin: 10px;
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
        .poster {
            height:400px;
        }
        .small-text{
            font-size: 12px;
        }
        .movie-title  {
            font-family: 'Aclonica';
            font-weight: 400;
            font-size: 34px;
        }
        .description-font {
            color: #555;
            font-size: large;
            font-family: times, serif;
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
        <nav class="navbar box-background navbar-expand-md navbar-light border border-secondary rounded-bottom" id="myHeader">
            <div class="col-md-1"></div>
            <a href="index.php" class="navbar-brand">
                <img src="images/backgrounds/main_logo.png" alt="It’s Just Movies" class="main-logo">
            </a>
            <div class="col-md-1"></div>
            <div class="col-md-1"></div>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <form action="index.php" class="form-inline mx-3" method="POST">
                    <input type="text" list="movies" class="form-control mr-sm-2" placeholder="Search Movie" name="search-keyword" id="search-movie" autocomplete="off">
                    <datalist id="movies">
                        <?php
                            $selectuserMovies = mysqli_query($con, "SELECT * FROM `posts` WHERE add_by = '$userid'");
                            while ($moviedata = mysqli_fetch_array($selectuserMovies)) {
                                echo "<option value = '$moviedata[movie_name]'</option>";
                            }
                        ?>
                    </datalist>
                    <button type="submit" class="btn btn-outline-light text-black-50 border" name="searchResult">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div class="navbar-nav mx-3">
                    <a href="my_movies.php" class="nav-item nav-link mx-2 active">
                        <i class="fas fa-th-list"></i> Movies
                    </a>
                    <a href="add_movie.php" class="nav-item nav-link mx-2">
                        <i class="fas fa-plus"></i> New Post
                    </a>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION['user']['full_name'] ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
    <center>
    <div class="movie-box bg-light col-md-8">
        <div>
            <h1 class="movie-title my-3 text-center">
                <?php echo ucwords($selectedMovie['movie_name']) ?> Full Movie
            </h1>
        </div>
        <div class="row">
            <img src="images/posts/<?php echo $selectedMovie['movie_image'] ?>" class="poster col-4 m-3">
            <div class="col-7 text-left">
                <p class="description-font mt-3"><?php echo $selectedMovie['description'] ?></p>
                <p>Director : <b><?php  $selectedMovie['category'] ?></b></p>
                <p>Realesed on : <b><?php echo $selectedMovie['released_date'] ?></b></p>
                <p>Category : <b><?php echo $selectedMovie['category'] ?></b></p>

                <div>
                    <button type="button" class="btn btn-outline-danger float-left">
                        <i class="fa fa-heart"></i> Like
                    </button>
                    <button type="button" class="btn btn-outline-info float-right">
                        <i class="fa fa-share-alt" aria-hidden="true"></i> Share
                    </button>
                </div>
                <br><br>
                <div class="dropdown mt-5">
                    <button type="button"
                        class="btn btn-block dropdown-toggle btn-success"
                        data-toggle="dropdown"
                    >
                        Download <?php $selectedMovie['movie_name'] ?> Full Movie
                    </button>
                    <div class="row my-4">
                        <button type="button"
                            class="btn col-4 btn-secondary"
                            onclick="window.history.back()"
                        >
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <div class="col-4"></div>
                        <button type="button" class="btn box-background col-4">
                            <i class="fab fa-youtube" aria-hidden="true"></i> Watch Trailer
                        </button>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right bg-success">
                        <?php
                            if (mysqli_num_rows($selectLink) < 1) {
                                echo '
                                    <div class="dropdown-item text-dark"
                                    href="#"
                                    >
                                    No Download links found !!
                                    </div>
                                ';
                            } else {
                                while ($link = mysqli_fetch_array($selectLink)) {
                                    echo '
                                    <a class="dropdown-item text-dark"
                                    href="'.$link['download_link'].'"
                                    target="_blank"
                                    >
                                    <i class="fa fa-download"></i> '.ucwords($link['link_name']).'
                                    </a>
                                ';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </center>
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
    </script>

</body>
</html>