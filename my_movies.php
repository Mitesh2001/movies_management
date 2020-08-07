<?php
session_start();
include('connection_file.php');
if (!$_SESSION['user']) {
    header('location:index.php');
}
$userid = $_SESSION['user']['user_id'];
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
if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
    crossorigin="anonymous">
    <link href='css/select2.min.css' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css ">

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
        .poster {
            height:250px;
            width:auto;
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
            <a href="#" class="navbar-brand">
                <img src="images/backgrounds/main_logo.png" alt="It’s Just Movies" class="main-logo">
            </a>
            <div class="col-md-1"></div>
            <a href="index.php" class="nav-item nav-link btn btn-circle">Home</a>
            <div class="col-md-1"></div>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <form action="my_movies.php" class="form-inline mx-3" method="POST">
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
                            <a class="dropdown-item" href="#">Profile</a>
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
                                foreach (explode(",", $movie['download_links']) as $link) {
                                    echo '<p><a href="#">'.$link.'</a></p>';
                                }
                            ?>
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
                            <button type="button" class="btn btn-primary p-3">
                                <i class="fas fa-edit "></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='js/select2.min.js' type='text/javascript'></script>

    <script>
       function logout() {
             window.location.href = "?logout";
        }

        function confirmDelete(id) {
            alertify.confirm('Confirm', "Are You Sure to Delete this Movie ?",
                function() {
                    window.location.href = "action.php?DeleteMovieId="+id;
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