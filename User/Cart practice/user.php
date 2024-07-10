<?php
session_start();

$servername = "127.0.0.1";
$username = "usera";
$password_db = "123098";
$database = "cen merch"; // Corrected the database name

$conn = new mysqli($servername, $username, $password_db, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assume you have a way to identify the customer (e.g., through session)
if (isset($_SESSION["student_id"])) {
    $student_id = $_SESSION['student_id'];

    // Retrieve customer information
    $query_customer_info = "SELECT * FROM `customer's information` WHERE student_id = ?";
    $stmt_customer_info = $conn->prepare($query_customer_info);
    $stmt_customer_info->bind_param("s", $student_id);
    $stmt_customer_info->execute();
    $result_customer_info = $stmt_customer_info->get_result();

    // Check if the query executed successfully
    if (!$result_customer_info) {
        die("Error retrieving customer information: " . $stmt_customer_info->error);
    }

    $customer_info = $result_customer_info->fetch_assoc();

    // Retrieve customer's orders
    $query_customer_orders = "SELECT DISTINCT od.order_id, od.merch_name, od.order_amount, od.price, od.ordered_date, os.order_status, os.expected_arrival
        FROM `order details` od
        LEFT JOIN `order status` os ON od.order_id = os.order_id
        WHERE od.student_id = ?";
    $stmt_customer_orders = $conn->prepare($query_customer_orders);
    $stmt_customer_orders->bind_param("s", $student_id);
    $stmt_customer_orders->execute();
    $result_customer_orders = $stmt_customer_orders->get_result();

    // Check if the query executed successfully
    if (!$result_customer_orders) {
        die("Error retrieving customer orders: " . $stmt_customer_orders->error);
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect to login if the user is not logged in
    header("Location: login.html");
    exit();
}

// Include the HTML portion
include('user.html');
?>
