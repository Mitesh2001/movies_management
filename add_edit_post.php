<?php
session_start();
include('connection_file.php');
if (!$_SESSION['user']) {
    header('location:index.php');
}

if (isset($_POST['edit_movie'])) {
    $movie_id = $_POST['movie_id'];
    $selectedMovie = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `posts` WHERE post_id = '$movie_id'"));
}

function addMovieName()
{
    if (isset($_GET['add'])) {
        echo 'value = "'.$_GET['add'].'"';
    }
}

function editMovieData($data)
{
    global $con;
    global $selectedMovie ;
    if (isset($_POST['edit_movie'])) {
        echo  $selectedMovie[$data] ;
    }
}

if (isset($_POST['add_movie'])) {
    $image = $_FILES['poster_image'];
    $tmp_name = $image['tmp_name'];
    $location = 'images/posts/';
    $poster_name = $image['name'];
    $add_by =$_SESSION['user']['user_id'];
    $movie_name = $_POST['movie-name'];
    $released_date = $_POST['released-date'];
    $description = $_POST['description'];
    $insert_data = mysqli_query($con, "INSERT INTO `posts`(`movie_name`, `description`, `movie_image`, `released_date`, `add_by`) VALUES ('$movie_name','$description','$poster_name','$released_date','$add_by')");
    if ($movie_name == "" or $released_date == "" or $description == "" or $poster_name == "") {
        $_SESSION["alertMessage"] = " Please fill all fields !";
        header("location:add_edit_post.php");
    } else {
        if ($insert_data) {
            $save_poster = move_uploaded_file($tmp_name, $location.$poster_name);
            $_SESSION["SuccessMessage"] = "Movie Added successfully";
            header("location:my_movies.php");
        } else {
            $_SESSION["alertMessage"] = "Error Found at adding movie";
            header("location:add_edit_post.php");
        }
    }
}

if (isset($_POST['update_movie'])) {
    $movie_id = $_POST['post_id'];
    $movie_name = $_POST['movie-name'];
    $released_date = $_POST['released-date'];
    $description = $_POST['description'];
    $update_data = mysqli_query($con, "UPDATE `posts` SET `movie_name`= '$movie_name',`description`= '$description',`released_date`= '$released_date' WHERE post_id = $movie_id");
    if ($update_data) {
        $_SESSION["SuccessMessage"] = "Movie Updated successfully";
        header("location:my_movies.php");
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('header.php'); ?>
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
            <a href="index.php" class="navbar-brand">
                <img src="images/backgrounds/main_logo.png" alt="It’s Just Movies" class="main-logo">
            </a>
            <div class="col-md-1"></div>
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
    <div id="add-movie-box" class="box-background border border-dark rounded col-lg-6 container p-4 my-4">
        <h3 class="text-center">
            New Post
        </h3>
        <form action="add_edit_post.php" method="post" class="col-12" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php editMovieData('post_id') ?>">
            <label class="col-12 my-3">
                Movie Name :
                <input type="text"
                    name="movie-name"
                    id="movie-name"
                    class="form-control"
                    <?php  addMovieName(); ?>
                    value="<?php editMovieData('movie_name') ?>"
                    required
                >
            </label>
            <label class="col-12 my-3">
                Released Date :
                <input type="date" name="released-date" placeholder="yyyy-mm-dd" class="form-control" value="<?php editMovieData('released_date') ?>" required>
            </label>
            <label class="col-12 my-3">
                About this Movie :
                <textarea name="description" class="form-control" required >
                    <?php  editMovieData('description'); ?>
                </textarea>
            </label>
            <?php if (!isset($_POST['edit_movie'])) { ?>
            <div class="col-12 my-3">
                <input type="file" class="custom-file-input" id="#poster" name="poster_image" required accept="image/*">
                <label class="custom-file-label" for="poster">Poster</label>
            </div>
            <?php } ?>
            <div class="col-12 text-center my-3">
                <button type="button" class="btn btn-danger mt-3" onclick="window.location = 'my_movies.php';">
                    <i class="fas fa-arrow-left"></i> Cancel
                </button>
                <button type="submit"
                    class="btn btn-primary mt-3"
                    name="<?php echo isset($_POST['edit_movie']) ? 'update_movie' : 'add_movie';  ?>"
                >
                    <?php echo isset($_POST['edit_movie']) ? 'Update Movie' : 'Add Movie';  ?>
                </button>
            </div>
        </form>
    </div>
    <?php include('footer.php') ?>
    <script>
        function logout() {
           window.location.href = "?logout";
        }
    </script>
    <?php
        if (isset($_SESSION['alertMessage'])) {
            $message = $_SESSION['alertMessage'];
            echo '<script type = "text/javascript">
                            alertify.alert("'.$message.'");
                    </script>';
            unset($_SESSION["alertMessage"]);
        }
    ?>
</body>
</html>
