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

//search 
require_once('order_status_search.php');

$query_all_orders = "SELECT od.order_id, od.student_id, c.first_name, c.middle_name, c.last_name, c.street_address, c.baranggay_address, c.city_address,
c.province_address, c.zip_code, c.contact_no,
    GROUP_CONCAT(DISTINCT od.merch_name) AS merch_name, 
    SUM(od.order_amount) AS order_amount, SUM(od.price) AS price, 
    MAX(od.ordered_date) AS ordered_date, MAX(os.order_status) AS order_status, MAX(os.expected_arrival) AS expected_arrival,
    pm.payment_method, pm.total_price
    FROM `order details` od
    LEFT JOIN `order status` os ON od.order_id = os.order_id
    LEFT JOIN `payment method` pm ON od.student_id = pm.student_id
    LEFT JOIN `customer's information` c ON od.student_id = c.student_id
    GROUP BY od.order_id, od.student_id";
                  
$result_all_orders = $conn->query($query_all_orders);

if (!$result_all_orders) {
    die("Error retrieving orders: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'])) {
        // Handle status update form submission
        $order_id = $_POST['order_id'];
        $new_status = $_POST['new_status'];
        
        updateOrderStatus($order_id, $new_status);
        
        // Redirect to the same page to avoid resubmission
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } elseif (isset($_POST['delete_order'])) {
        // Handle delete order form submission
        $order_id = $_POST['order_id'];
        deleteOrder($order_id);
        
        // Redirect to the same page to avoid resubmission
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } elseif (isset($_POST['delete_all'])) {
        // Handle delete all orders form submission
        deleteAllOrders();
        
        // Redirect to the same page to avoid resubmission
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

function updateOrderStatus($order_id, $new_status) {
    global $conn;
    
    $query_update_status = "UPDATE `order status` SET order_status = ? WHERE order_id = ?";
    $stmt_update_status = $conn->prepare($query_update_status);
    $stmt_update_status->bind_param("ii", $new_status, $order_id);
    $stmt_update_status->execute();
    $stmt_update_status->close();
}

function deleteOrder($order_id) {
    global $conn;
    
    $query_delete_order_status = "DELETE FROM `order status` WHERE order_id = ?";
    $stmt_delete_order_status = $conn->prepare($query_delete_order_status);
    $stmt_delete_order_status->bind_param("i", $order_id);
    $stmt_delete_order_status->execute();
    $stmt_delete_order_status->close();
    
    $query_delete_order_details = "DELETE FROM `order details` WHERE order_id = ?";
    $stmt_delete_order_details = $conn->prepare($query_delete_order_details);
    $stmt_delete_order_details->bind_param("i", $order_id);
    $stmt_delete_order_details->execute();
    $stmt_delete_order_details->close();
    
    $query_delete_payment_method = "DELETE FROM `payment method` WHERE student_id = ?";
    $stmt_delete_payment_method = $conn->prepare($query_delete_payment_method);
    $stmt_delete_payment_method->bind_param("i", $order_id);
    $stmt_delete_payment_method->execute();
    $stmt_delete_payment_method->close();
}

function deleteAllOrders() {
    global $conn;
    
    $query_delete_all_order_status = "DELETE FROM `order status`";
    $conn->query($query_delete_all_order_status);
    
    $query_delete_all_order_details = "DELETE FROM `order details`";
    $conn->query($query_delete_all_order_details);
}
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Orders</title>
    <link rel="stylesheet" href="order_status.css"/>
    <style>
    </style>
</head>
<body>

    <header>
        <h1 class="headingnav">CEN MERCH</h1>
        <div class="topnav">
            <a href="admin_dashboard.php" target="_parent">ADMIN</a>
            <a href="merchandise.php" target="_parent">INVENTORY</a>
            <a href="order_status.php" target="_parent">ORDER</a>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
            <input type="text" id="search-item" placeholder="Search IDs" name="searchStudentOrder">
        </form>
    </header>


    <?php
        // SEARCH 
        $searchParam = isset($_GET['searchStudentOrder']) ? $_GET['searchStudentOrder'] : '';
        $query_all_orders = "SELECT od.order_id, od.student_id, c.first_name, c.middle_name, c.last_name, c.street_address, c.baranggay_address, c.city_address,
        c.province_address, c.zip_code, c.contact_no,
        GROUP_CONCAT(DISTINCT od.merch_name) AS merch_name, 
        SUM(od.order_amount) AS order_amount, SUM(od.price) AS price, 
        MAX(od.ordered_date) AS ordered_date, MAX(os.order_status) AS order_status, MAX(os.expected_arrival) AS expected_arrival,
        pm.payment_method, pm.total_price
        FROM `order details` od
        LEFT JOIN `order status` os ON od.order_id = os.order_id
        LEFT JOIN `payment method` pm ON od.student_id = pm.student_id
        LEFT JOIN `customer's information` c ON od.student_id = c.student_id";

        if (!empty($searchParam)) {
        $query_all_orders .= " WHERE od.student_id LIKE '%$searchParam%' OR od.order_id LIKE '%$searchParam%'";
        }

        $query_all_orders .= " GROUP BY od.order_id, od.student_id";

        $result_all_orders = $conn->query($query_all_orders);

        if (!$result_all_orders) {
        die("Error retrieving orders: " . $conn->error);
        }
        ?>

    <div class="baba">
        <h2>All Orders (Admin View)</h2>

        <?php if ($result_all_orders->num_rows > 0) : ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table border="1">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Student ID</th>
                            <th>Customer Information</th>
                            <th>Merchandise Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Payment Method</th>
                            <th>Total Price</th>
                            <th>Ordered Date</th>
                            <th>Order Status</th>
                            <th>Expected Arrival</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $result_all_orders->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $row['order_id']; ?></td>
                                <td><?php echo $row['student_id']; ?></td>
                                <td>
                                    <b>First name:</b> <?php echo $row['first_name']; ?> <br>
                                    <b>Middle name:</b> <?php echo $row['middle_name']; ?> <br>
                                    <b>Last name:</b> <?php echo $row['last_name']; ?> <br>
                                    <b>Street address:</b> <?php echo $row['street_address']; ?> <br>
                                    <b>Baranggay address:</b> <?php echo $row['baranggay_address']; ?> <br>
                                    <b>City:</b> <?php echo $row['city_address']; ?> <br>
                                    <b>Province:</b> <?php echo $row['province_address']; ?> <br>
                                    <b>Zip code:</b> <?php echo $row['zip_code']; ?> <br>
                                    <b>Contact No:</b> <?php echo $row['contact_no']; ?>
                                </td>
                                <td><?php echo $row['merch_name']; ?></td>
                                <td><?php echo $row['order_amount']; ?></td>
                                <td>PHP<?php echo $row['price']; ?></td>
                                <td><?php echo $row['payment_method']; ?></td>
                                <td>PHP<?php echo $row['total_price']; ?></td>
                                <td><?php echo $row['ordered_date']; ?></td>
                                <td><?php echo $row['order_status']; ?></td>
                                <td><?php echo $row['expected_arrival'] ?? 'N/A'; ?></td>
                                <td>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                        <select name="new_status">
                                            <option value="1" <?php echo $row['order_status'] == 1 ? 'selected' : ''; ?>>Pending</option>
                                            <option value="2" <?php echo $row['order_status'] == 2 ? 'selected' : ''; ?>>Shipping</option>
                                            <option value="3" <?php echo $row['order_status'] == 3 ? 'selected' : ''; ?>>Completed</option>
                                            <option value="4" <?php echo $row['order_status'] == 4 ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                        <button type="submit" name="update_status">Update Status</button>
                                        <button type="submit" name="delete_order">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <div>
                            <button type="submit" name="delete_all">Delete All Orders</button>
                        </div>
                    </tbody>
                </table>
            </form>
        <?php else : ?>
            <table>
            <tr>
            <td>No Match Found. Enter a valid STUDENT ID or ORDER ID.</td>
            </tr>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>