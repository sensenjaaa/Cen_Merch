<?php

$servername = "127.0.0.1";
$username = "usera";
$password_db = "123098";
$database = "cen merch";

$conn = new mysqli($servername, $username, $password_db, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve student ID from the POST data
    $student_id = $_POST["student_id"];

    

    // Perform cancellation logic (delete records from the database)
    try {
        $conn = new mysqli($servername, $username, $password_db, $database);

        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Example: Delete records from order status, order details, and payment method tables
        $delete_order_status_query = "DELETE FROM `order status` WHERE student_id = ?";
        $delete_order_details_query = "DELETE FROM `order details` WHERE student_id = ?";
        $delete_payment_method_query = "DELETE FROM `payment method` WHERE student_id = ?";

        $stmt_order_status = $conn->prepare($delete_order_status_query);
        $stmt_order_status->bind_param("s", $student_id);
        $stmt_order_status->execute();

        $stmt_order_details = $conn->prepare($delete_order_details_query);
        $stmt_order_details->bind_param("s", $student_id);
        $stmt_order_details->execute();

        $stmt_payment_method = $conn->prepare($delete_payment_method_query);
        $stmt_payment_method->bind_param("s", $student_id);
        $stmt_payment_method->execute();

        echo "Order canceled successfully.";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        if ($conn) {
            $conn->close();
        }
    }
} else {
    echo "Invalid request method.";
}
?>
