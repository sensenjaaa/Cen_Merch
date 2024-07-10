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

if (isset($_SESSION["student_id"])) {
    // Define the variables
    $merch_id = $_POST["merch_id"];
    $order_amount = $_POST["order_amount"];
    $size = $_POST["size"] ?? null;

    // Fetch merch_name and price from the merchandise table
    $query_merchandise = "SELECT merch_name, price FROM `merchandise details` WHERE merch_id = ?";
    $stmt_merchandise = $conn->prepare($query_merchandise);
    $stmt_merchandise->bind_param("i", $merch_id);
    $stmt_merchandise->execute();
    $stmt_merchandise->bind_result($merch_name, $price);
    $stmt_merchandise->fetch();
    $stmt_merchandise->close();

    // Calculate total price
    $total_price = $price * $order_amount;

    // Check if the item is already in the cart
    $query_check_cart = "SELECT cartId FROM `add to cart` WHERE student_id = ? AND merch_id = ?";
    $stmt_check_cart = $conn->prepare($query_check_cart);
    $stmt_check_cart->bind_param("ii", $_SESSION["student_id"], $merch_id);
    $stmt_check_cart->execute();
    $stmt_check_cart->bind_result($existing_cartId);
    $stmt_check_cart->fetch();
    $stmt_check_cart->close();

    if ($existing_cartId) {
        // Item already exists in the cart, handle accordingly (e.g., update quantity)
        echo '<script>alert("Item is already in the cart. You may want to update the quantity.");</script>';
        echo '<script>window.location.href = "cart.php";</script>';
    } else {
        // Insert data into add_to_cart table
        $query_insert_cart = "INSERT INTO `add to cart` (student_id, merch_id, merch_name, order_amount, price, total_price, size) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_cart = $conn->prepare($query_insert_cart);
        $stmt_insert_cart->bind_param("iisiiis", $_SESSION["student_id"], $merch_id, $merch_name, $order_amount, $price, $total_price, $size);

        if ($stmt_insert_cart->execute()) {
            $cartId = $conn->insert_id;

            $_SESSION['cart'][$cartId] = array(
                'cartId' => $cartId,
                'student_id' => $_SESSION["student_id"],
                'merch_id' => $merch_id,
                'merch_name' => $merch_name,
                'order_amount' => $order_amount,
                'price' => $price,
                'total_price' => $total_price,
                'size' => $size
            );

            echo '<script>alert("Order successfully added.");</script>';
            echo '<script>window.location.href = "products.html";</script>';
            exit();
        } else {
            // Log error
            error_log("Error executing query: " . $stmt_insert_cart->error);
            // Provide a user-friendly message
            echo '<script>alert("Error adding item to cart. Please try again later.");</script>';
        }

        $stmt_insert_cart->close();
    }
} else {
    echo '<script>alert("Error: Student ID not set in the session.");</script>';
}

$conn->close();
?>
