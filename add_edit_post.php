<?php
session_start();
include('connection_file.php');
if (!$_SESSION['user']) {
    header('location:index.php');
}

function addMovieName()
{
    if (isset($_GET['add'])) {
        echo $_GET['add'];
    }
}

if (isset($_POST['edit_movie'])) {
    $file ='edit_movie.php';
    $movie_id = $_POST['movie_id'];
    $selectedMovie = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `posts` WHERE post_id = '$movie_id'"));
} else {
    $file ='add_movie.php';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('header.php'); ?>
    <?php
        if ($file == 'add_movie.php') {
            echo '<title>New Post</title>';
        } else {
            echo '<title>Edit in '.$selectedMovie['movie_name'].'</title>';
        }
    ?>
    <style>
        body {
            margin:0;
            background-color: #f0ede9;
            background-image: url('images/backgrounds/pattern34.png');
        }
         .main-logo {
            height: 50px;
        }
        .box-background {
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(229,229,240,1) 0%);
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
                    z-index: 1;
                    margin-bottom:0px;
                    top: 0;
                    width: 100%;
            }
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
    <?php include($file) ?>
    <?php include('footer.php') ?>
</body>
</html>
