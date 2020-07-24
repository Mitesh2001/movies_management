<?php
    $con = mysqli_connect('localhost', 'root', '12345678', 'movies_management');
    if (!$con) {
        echo "Can't connect to the database";
    }
