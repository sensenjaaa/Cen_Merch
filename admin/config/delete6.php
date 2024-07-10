<?php
include "order.php";
$merch_id = $_GET["merch_id"];
$sql = "DELETE FROM `merchandise details` WHERE merch_id = $merch_id";
$result6 = mysqli_query($con, $sql);

if ($result6) {
  header("Location: http://localhost/cenmerch/admin/merchandise.php?msg=Data deleted successfully");
} else {
  echo "Failed: " . mysqli_error($con);
}
