<?php
session_start();
include('connection_file.php');
$no = 1;
$userid = $_SESSION['user']['user_id'];
$months = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December', ];
$userMovies = mysqli_query($con, "SELECT * FROM `posts` WHERE add_by = '$userid'");
$allMovies = mysqli_query($con, "SELECT * FROM `posts` ");

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
            position:relative;
            z-index:1;
            overflow: hidden;
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
                <form action="" class="form-inline mx-3">
                    <input type="text" class="form-control mr-sm-2" placeholder="Search">
                    <button type="submit" class="btn btn-outline-light text-black-50 border">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div class="navbar-nav mx-3">
                    <a href="#" class="nav-item nav-link mx-2">
                        <i class="far fa-user"></i> Profile
                    </a>
                    <a href="#" class="nav-item nav-link mx-2 active">
                        <i class="fas fa-th-list"></i> Movies
                    </a>
                    <button onclick="confirmLogout()" class="btn nav-item nav-link mx-2">
                        Log Out  <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>

            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>
    <div class="d-flex flex-row-reverse col-12 my-3">
        <button class="btn btn-outline-primary" type="button" onclick="focusToAddMovies()">
            <i class="fas fa-plus"></i> Add Movies
        </button>
    </div>
    <div class="container-fluid mt-3">
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
                        <td class=""><?php echo $movie['description'] ?></td>
                        <td><?php echo $movie['released_date'] ?></td>
                        <td>
                            <?php
                                foreach (explode(",", $movie['download_links']) as $link) {
                                    echo '<p><a href="#">'.$link.'</a></p>';
                                }
                            ?>
                        </td>
                        <td>
                            <i class="far fa-trash-alt btn btn-primary p-3"></i>
                        </td>
                        <td>
                            <i class="fas fa-edit btn btn-danger p-3"></i>
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div id="add-movie-box" class="border border-dark rounded col-lg-6 container p-4 my-4">
        <h3 class="text-center">Add Movie</h3>
        <form action="" method="post" class="col-12">
            <label class="col-12 my-3">
                Movie Name :
                <input type="text" name="movie-name" id="movie-name" class="form-control">
            </label>
            <label class="col-12 my-3">
                Released Date :
                <input type="text" name="released_date" placeholder="yyyy-mm-dd" class="form-control">
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
                <button type="submit" class="btn btn-outline-primary">
                    Add Movie
                </button>
            </div>
        </form>
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
        $(document).ready(function(){
            // Initialize select2
            $("#selUser").select2();

            // Read selected option
            $('#but_read').click(function(){
                var username = $('#selUser option:selected').text();
                var userid = $('#selUser').val();
                $('#result').html("id : " + userid + ", name : " + username);
            });
            });

        function focusToAddMovies() {
            document.getElementById("movie-name").focus();
        }
    </script>
</body>
</html>