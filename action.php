<?php
session_start();
include('connection_file.php');

if (isset($_POST['add_link'])) {
    $post_id = $_POST['post_id'];
    $add_by = $_SESSION['user']['username'];
    $link_name = $_POST['link_name'];
    $download_link = $_POST['down_link'];
    $save_link = mysqli_query($con, "INSERT INTO `download_links`(`link_for`, `add_by`, `download_link`, `link_name`) VALUES ('$post_id','$add_by','$download_link','$link_name')");
    if ($save_link) {
        header('location:my_movies.php');
    }
}
if (isset($_GET['DeleteLinkId'])) {
    $link_id = $_GET['DeleteLinkId'];
    $selectedLink = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `download_links` WHERE link_id = '$link_id'"));
    if ($_SESSION['user']['username'] == $selectedLink['add_by']) {
        $deleteLink = mysqli_query($con, "DELETE FROM `download_links` WHERE link_id = '$link_id'");
        header('location:my_movies.php');
    } else {
        header('location:my_movies.php');
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
    if ($insert_data) {
        $save_poster = move_uploaded_file($tmp_name, $location.$poster_name);
        $_SESSION["SuccessMessage"] = "Movie Added successfully";
        header("location:my_movies.php");
    } else {
        $_SESSION["alertMessage"] = "Error Found at adding movie";
        header("location:my_movies.php");
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


if (isset($_GET['DeleteMovieId'])) {
    $post_id = $_GET['DeleteMovieId'];
    $poster = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `posts` WHERE post_id = '$post_id'"))['movie_image'];
    $poster_folder = "images/posts/";
    $delete_poster = unlink($poster_folder.$poster);
    $delete_down_links =mysqli_query($con, "DELETE FROM `download_links` WHERE link_for = '$post_id'");
    $delete_post = mysqli_query($con, "DELETE FROM `posts` WHERE post_id = '$post_id'");
    if ($delete_poster && $delete_post) {
        $_SESSION["SuccessMessage"] = "Movie deleted successfully..";
        header("location:my_movies.php");
    }
}
