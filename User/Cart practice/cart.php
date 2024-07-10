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

// Function to calculate the total price of the cart
function calculateCartTotal($cart)
{
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['order_amount'];
    }
    return $total;
}

// Check if the cart is not empty
if (!empty($_SESSION['cart'])) {
    // Handle cart updates (if any)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
        foreach ($_POST['order_amount'] as $cartId => $newOrderAmount) {
            // Ensure the new order amount is a positive integer
            $newOrderAmount = max(0, (int)$newOrderAmount);

            // Update the session
            if (isset($_SESSION['cart'][$cartId])) {
                $_SESSION['cart'][$cartId]['order_amount'] = $newOrderAmount;

                // Calculate new total price
                $newTotalPrice = $newOrderAmount * $_SESSION['cart'][$cartId]['price'];

                // Update the database
                $query_update_cart = "UPDATE `add to cart` SET order_amount = ?, total_price = ? WHERE cartId = ?";
                $stmt_update_cart = $conn->prepare($query_update_cart);
                $stmt_update_cart->bind_param("idi", $newOrderAmount, $newTotalPrice, $cartId);
                $stmt_update_cart->execute();
                $stmt_update_cart->close();
            }
        }
    }

    // Handle cart removal (if any)
    if (isset($_GET['remove_item']) && isset($_SESSION['cart'][$_GET['remove_item']])) {
        $cartIdToRemove = $_GET['remove_item'];

        // Remove from session
        unset($_SESSION['cart'][$cartIdToRemove]);

        // Remove from the database
        $query_remove_cart = "DELETE FROM `add to cart` WHERE cartId = ?";
        $stmt_remove_cart = $conn->prepare($query_remove_cart);
        $stmt_remove_cart->bind_param("i", $cartIdToRemove);
        $stmt_remove_cart->execute();
        $stmt_remove_cart->close();
    }
}
include('cart.html');
$conn->close();
?>
