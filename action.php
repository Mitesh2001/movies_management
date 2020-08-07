<?php
session_start();
include('connection_file.php');
if (isset($_GET['DeleteMovieId'])) {
    echo $post_id = $_GET['DeleteMovieId'];
    echo $poster = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `posts` WHERE post_id = '$post_id'"))['movie_image'];
    $poster_folder = "images/posts/";
    $delete_poster = unlink($poster_folder.$poster);
    $delete_record = mysqli_query($con, "DELETE FROM `posts` WHERE post_id = '$post_id'");
    if ($delete_poster && $delete_record) {
        $_SESSION["SuccessMessage"] = "Movie deleted successfully..";
        header("location:my_movies.php");
    }
}
