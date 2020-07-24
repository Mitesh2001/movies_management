<?php
session_start();
include('connection_file.php');
$no = 1;
$userid = $_SESSION['user']['user_id'];
$months = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December', ];
$data = mysqli_query($con, "SELECT * FROM `posts` WHERE add_by = '$userid'");
while ($movie = mysqli_fetch_array($data)) {
    echo $movie['movie_name'];
}
