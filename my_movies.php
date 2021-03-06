<?php
session_start();
include('connection_file.php');
if (!$_SESSION['user']) {
    header('location:index.php');
}
$userid = $_SESSION['user']['user_id'];
$username = $_SESSION['user']['username'];



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

if (isset($_POST["searchResult"])) {
    $search = $_POST['search-keyword'];
    $userMovies  = mysqli_query(
        $con,
        "select * from posts where
        movie_name like '%$search%' OR
        description like '%$search%' OR
        released_date like '%$search%'"
    );
    if (mysqli_num_rows($userMovies) < 1) {
        $_SESSION['alertMessage'] = "No Movies Found !";
        $userMovies = mysqli_query($con, "SELECT * FROM `posts` WHERE add_by = '$userid'");
    }
} else {
    $userMovies = mysqli_query($con, "SELECT * FROM `posts` WHERE add_by = '$userid'");
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
        .deleteLink {
            text-decoration: none;
            cursor:pointer;
        }
        .box-background {
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(229,229,240,1) 0%);
        }
        .poster {
            height:250px;
            width:auto;
            max-width: 250px;
            border:1px solid black;
            border-radius: 20%;
        }
        .navbar {
            left: 0;
            min-height: 70px;
            position:fixed;
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
                <form action="my_movies.php" class="form-inline mx-3" method="POST">
                    <input type="text" list="movies" class="form-control mr-sm-2" placeholder="Search Movie" name="search-keyword" id="search-movie" autocomplete="off" required>
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
                    <a href="add_edit_post.php" class="nav-item nav-link mx-2">
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
    <div class="container-fluid mt-5 pt-5">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>Poster</th>
                    <th>Movie Name</th>
                    <th>Movie Description</th>
                    <th>Released Date</th>
                    <th>Download Links</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($movie = mysqli_fetch_array($userMovies)) { ?>
                    <tr class="text-center">
                        <td class="">
                            <img src="<?php echo 'images/posts/'.$movie['movie_image'] ?>"
                            alt="" class="poster">
                        </td>
                        <td class="font-weight-bold"><?php echo $movie['movie_name'] ?></td>
                        <td style="width:250px;"><?php echo $movie['description'] ?></td>
                        <td><?php echo $movie['released_date'] ?></td>
                        <td>
                            <?php
                                $post_id = $movie["post_id"];
                        $selectLinks = mysqli_query($con, "SELECT * FROM `download_links` WHERE add_by = '$username' AND link_for = '$post_id'");
                        while ($LinksOfUser = mysqli_fetch_array($selectLinks)) {
                            $download_link = $LinksOfUser['download_link'];
                            $link_name = $LinksOfUser['link_name']; ?>
                                    &#10148;
                                    <a href="<?php echo $download_link ?>"
                                        class="btn btn-link"
                                        target="_blank"
                                    >
                                        <?php echo $link_name ?>
                                    </a>
                                    <a onclick="confirmDeleteLink(<?php echo $LinksOfUser['link_id'] ?>)" class="deleteLink">
                                        <i class="fas fa-minus-circle text-success"></i>
                                    </a>
                                    <hr>
                            <?php
                        } ?>
                            <br>
                            <div class="btn btn-info btn-block"
                                id="btn-<?php echo $movie['post_id'] ?>"
                                onclick='addLinkForm(<?php echo $movie["post_id"] ?>)'
                            >
                                <i class="fas fa-plus"></i> Download Link
                            </div>
                            <form action="my_movies.php"
                                method="post"
                                class="d-none"
                                id="form-<?php echo $movie['post_id'] ?>"
                            >
                                <div class="border border-dark p-3 rounded">
                                    <a href="my_movies.php" class="float-right h3 text-danger">
                                        <i class="fas fa-window-close"></i>
                                    </a>
                                    <input type="hidden" value="<?php echo $movie["post_id"] ?>" name="post_id">
                                    <input type="text" name="down_link" placeholder="paste your link ..." autocomplete="off" class="form-control my-3">
                                    <input type="text" name="link_name" placeholder="Link Name"
                                    class="form-control my-3">
                                    <button type="submit" class="btn btn-info text-dark" name="add_link">
                                        + Add
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td>
                            <button type="button"
                            class="btn btn-danger p-3"
                            onclick="confirmDelete(<?php echo $movie["post_id"]; ?>)"
                            >
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                        <td>
                            <form action="add_edit_post.php" method="post">
                                <input type="hidden" name="movie_id" value="<?php echo $movie['post_id'] ?>">
                                <button type="submit" class="btn btn-primary p-3" name="edit_movie">
                                    <i class="fas fa-edit "></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php
                    } ?>
            </tbody>
        </table>
    </div>

    <?php include('footer.php') ?>

    <script>
        function addLinkForm(formNo) {
            var formId = "form-"+formNo ;
            var btnId = "btn-"+formNo ;
            var form = document.getElementById(formId).className = "d-block";
            var btn = document.getElementById(btnId).className = "d-none" ;
        }

        function logout() {
                window.location.href = "?logout";
        }

        function confirmDelete(id) {
            alertify.confirm('Confirm', "Are You Sure to Delete this Movie ?",
                function() {
                    window.location.href = "my_movies.php?DeleteMovieId="+id;
                },
                function() {}
            );
        }

        function confirmDeleteLink(link_id) {
            alertify.confirm('Confirm', "Are You Sure to Delete Download Link ?",
                function() {
                    window.location.href = "my_movies.php?DeleteLinkId="+link_id;
                },
                function() {}
            );
        }

    </script>
    <?php
        if (isset($_SESSION["SuccessMessage"])) {
            $message = $_SESSION["SuccessMessage"] ;
            echo '<script type = "text/javascript">
                        alertify.success("'.$message.'");
                </script>';
            unset($_SESSION["SuccessMessage"]);
        }
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