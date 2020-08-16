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
