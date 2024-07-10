<?php
session_start();

$servername = "127.0.0.1";
$username = "usera";
$password_db = "123098";
$database = "cen merch";

$conn = new mysqli($servername, $username, $password_db, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate form data
    if (isset($_POST["student_id"]) && isset($_POST["payment_method"])) {
        $student_id = $_POST["student_id"];
        $payment_method = $_POST["payment_method"];

        // Calculate total price from the order details
        $query_calculate_total = "SELECT SUM(od.order_amount * od.price) AS total_price
                                   FROM `order details` od
                                   WHERE od.student_id = ?";
        $stmt_calculate_total = $conn->prepare($query_calculate_total);
        $stmt_calculate_total->bind_param("s", $student_id);
        $stmt_calculate_total->execute();
        $result_calculate_total = $stmt_calculate_total->get_result();

        if ($result_calculate_total) {
            $total_price_row = $result_calculate_total->fetch_assoc();
            $total_price = $total_price_row["total_price"];

            // Insert payment details into the database
            $query_insert_payment = "INSERT INTO `payment method` (student_id, payment_method, total_price) VALUES (?, ?, ?)";
            $stmt_insert_payment = $conn->prepare($query_insert_payment);
            $stmt_insert_payment->bind_param("ssd", $student_id, $payment_method, $total_price);

            if ($stmt_insert_payment->execute()) {
                // Payment successful, you may want to update the order status or do other post-payment actions

                // Redirect to payment confirmation page
                header("Location: payment_confirmation.php");
                exit();
            } else {
                // Handle payment insertion error
                $_SESSION["error"] = "Failed to process payment. Please try again.";
            }
        } else {
            // Handle calculation error
            $_SESSION["error"] = "Failed to calculate total price. Please try again.";
        }
    } else {
        // Invalid form data
        $_SESSION["error"] = "Invalid form data.";
    }

    // Redirect back to the order confirmation page with an error message
    header("Location: order_confirmation.php");
    exit();
} else {
    // Redirect if accessed directly without submitting the form
    header("Location: order_confirmation.php");
    exit();
}
?>
