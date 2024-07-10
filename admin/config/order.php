<?php
$servername = "127.0.0.1";
$username = "usera";
$password = "123098";
$dbname = "cen merch"; 

$con = new mysqli($servername, $username, $password, $dbname);

// Check the connection
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }
  // echo "Connected successfully";