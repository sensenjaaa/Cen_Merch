<?php
include "order.php";
$merch_id = $_GET["merch_id"];
$sql = "DELETE FROM `merchandise details` WHERE merch_id = $merch_id";
$result7 = mysqli_query($con, $sql);

if ($result7) {
  header("Location: http://localhost/cenmerch/Project%20Update%20and%20Delete/merchandise.php?msg=Data deleted successfully");
} else {
  echo "Failed: " . mysqli_error($con);
}
