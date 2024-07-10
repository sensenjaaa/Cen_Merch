<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cenmerch/Project Update and Delete/config/order.php';

// Add your validation and sanitation code here

// Perform the delete query for each table
$tables = ["add to cart", "order details", "order status", "payment method", "customer's information"];
foreach ($tables as $table) {
    // Ensure the table name is safe to use in the query (to prevent SQL injection)
    $table = mysqli_real_escape_string($con, $table);

    // Construct the DELETE query
    $deleteQuery = "DELETE FROM `$table`";

    // Execute the query
    mysqli_query($con, $deleteQuery);
}

// Respond with a success message or handle errors as needed
echo "Records deleted successfully";
?>
