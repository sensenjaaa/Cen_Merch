<?php
    define("DB_SERVER", "192.168.18.30");
    define("DB_USERNAME", "usera");
    define("DB_PASSWORD", "123098");
    define("DB_DATABASE", "cen merch");

    $db=mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if($db){
        echo'Connected';
    }else{
        echo'No';
    }
?>