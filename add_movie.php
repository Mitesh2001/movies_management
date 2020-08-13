<?php
session_start();
if (!$_SESSION['user']) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <title>Add TO Your Movie List</title>
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
            New Post
        </h3>
        <form action="" method="post" class="col-12">
            <label class="col-12 my-3">
                Movie Name :
                <input type="text" name="movie-name" id="movie-name" class="form-control">
            </label>
            <label class="col-12 my-3">
                Released Date :
                <input type="date" name="released_date" placeholder="yyyy-mm-dd" class="form-control">
            </label>
            <label class="col-12 my-3">
                Download Links :
                <input type="text" name="released_date" class="form-control">
            </label>
            <div class="col-12 my-3">
                <input type="file" class="custom-file-input" id="#poster" name="poster" accept="image/*">
                <label class="custom-file-label" for="poster">Poster</label>
            </div>
            <div class="col-12 text-center my-3">
                <button type="button" class="btn btn-danger mt-3" onclick="window.history.back();">
                    <i class="fas fa-arrow-left"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary mt-3">
                    Add Movie
                </button>
            </div>
        </form>
    </div>
</body>
</html>