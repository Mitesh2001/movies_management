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
    <?php include('header.php'); ?>
    <title>Edit Your Movie List</title>
    <style>
        body {
            background-color: #f0ede9;
            background-image: url('images/backgrounds/pattern34.png');
        }
        .box-background {
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(229,229,240,1) 0%);
        }
    </style>
</head>
<body>
    <div id="add-movie-box" class="box-background border border-dark rounded col-lg-6 container p-4 my-4">
        <h3 class="text-center">
            Edit Post
        </h3>
        <form action="edit_movie.php" method="post" class="col-12" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo $selectedMovie['post_id'] ?>">
            <label class="col-12 my-3">
                Movie Name :
                <input type="text"
                    name="movie-name"
                    id="movie-name"
                    class="form-control"
                    value="<?php  echo $selectedMovie['movie_name'] ?>"
                >
            </label>
            <label class="col-12 my-3">
                Released Date :
                <input type="date"
                    name="released-date"
                    placeholder="yyyy-mm-dd"
                    class="form-control"
                    value="<?php  echo $selectedMovie['released_date']; ?>"
                >
            </label>
            <label class="col-12 my-3">
                About this Movie :
                <textarea name="description" class="form-control">
                    <?php  echo $selectedMovie['description']; ?>
                </textarea>
            </label>
            <div class="col-12 text-center my-3">
                <button type="button" class="btn btn-danger mt-3" onclick="window.location = 'my_movies.php';">
                    <i class="fas fa-arrow-left"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary mt-3" name="update_movie">
                    Update Movie
                </button>
            </div>
        </form>
    </div>
</body>
</html>