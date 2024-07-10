<?php 

    $con = mysqli_connect("localhost", "usera", "123098", "cen merch");

    if (!$con) {
        die("Connection Error: " . mysqli_connect_error());
    }

?>
