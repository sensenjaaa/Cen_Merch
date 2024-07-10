<?php
session_start();

// Connect to your database (replace with your credentials)
$servername = "127.0.0.1";
$username = "usera";
$password_db = "123098";
$database = "cen merch";

$conn = new mysqli($servername, $username, $password_db, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve student_id from the session (adapt as needed)
$student_id = $_SESSION['student_id']; // Replace with how student_id is retrieved

// Insert order details into the `order details` table
$query_insert_order_details = "INSERT INTO `order details` (student_id, merch_id, merch_name, order_amount, ordered_date, price) VALUES ";
$values = [];
foreach ($_SESSION['cart'] as $item) {
    $values[] = "($student_id, {$item['merch_id']}, '{$item['merch_name']}', {$item['order_amount']}, NOW(), {$item['price']})";
}
$query_insert_order_details .= implode(",", $values);

$stmt_insert_order_details = $conn->prepare($query_insert_order_details);
if ($stmt_insert_order_details->execute()) {
    // Retrieve the last inserted order ID
    $order_id = $conn->insert_id;

    // Insert order details into the `order status` table
    $query_insert_order_status = "INSERT INTO `order status` (order_id, student_id, merch_id, ordered_date) VALUES ";
    $values = [];
    foreach ($_SESSION['cart'] as $item) {
        $values[] = "($order_id, $student_id, {$item['merch_id']}, NOW())";
    }
    $query_insert_order_status .= implode(",", $values);

    $stmt_insert_order_status = $conn->prepare($query_insert_order_status);
    if ($stmt_insert_order_status->execute()) {
        // Delete items from the `add to cart` table
        $cart_ids = array_column($_SESSION['cart'], 'cartId'); // Assuming 'cartId' is the primary key
        $cart_ids_str = implode(",", $cart_ids);
        $query_delete_cart_items = "DELETE FROM `add to cart` WHERE cartId IN ($cart_ids_str)";
        
        $stmt_delete_cart_items = $conn->prepare($query_delete_cart_items);
        if ($stmt_delete_cart_items->execute()) {
            // Clear the cart session
            unset($_SESSION['cart']);

            // Success message and redirect
            $_SESSION['message'] = "Order placed successfully!";
            header("Location: order_confirmation.php?order_id=$order_id"); // Redirect to order confirmation page with order ID
            exit();
        } else {
            // Handle error deleting from `add to cart` table
            $_SESSION['error'] = "Failed to delete items from cart. Please contact support.";
            header("Location: cart.php"); // Redirect back to cart
            exit();
        }
    } else {
        // Handle error inserting into `order status` table
        $_SESSION['error'] = "Failed to place order. Please try again.";
        header("Location: cart.php"); // Redirect back to cart
        exit();
    }
} else {
    // Handle error inserting into `order details` table
    $_SESSION['error'] = "Failed to place order. Please try again.";
    header("Location: cart.php"); // Redirect back to cart
    exit();
}

// Close the database connection
$conn->close();
?>
