<?php
require_once 'order.php';

function display_data() {
    global $con;

    $query = "SELECT * FROM `add to cart`";
    $result0 = mysqli_query($con, $query);

    $query = "SELECT * FROM `order status`";
    $result = mysqli_query($con, $query);

    $query = "SELECT * FROM `customer's information`";
    $result1 = mysqli_query($con, $query);

    $query = "SELECT * FROM `order details`";
    $result2 = mysqli_query($con, $query);

    $query = "SELECT * FROM `payment method`";
    $result3 = mysqli_query($con, $query);

    return array($result0, $result, $result1, $result2, $result3);
}

function display_specific_data($con, $id) {
    $query = "SELECT * FROM `order status` WHERE id = $id";
    $result = mysqli_query($con, $query);

    $query3 = "SELECT * FROM `payment method` WHERE id = $id";
    $result3 = mysqli_query($con, $query3);

    return array($result, $result3);
}
?>