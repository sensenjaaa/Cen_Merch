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

}


$conn->close();
?>


<!-- ... rest of the HTML code ... -->
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Products</title>
    <link rel="stylesheet" href="paymentcom.css"/>
</head>
<body>
    <header>
		<h1 class="headingnav">CEN MERCH</h1>
		<div class="topnav">
			<a href="user.php" target="_parent">ACCOUNT</a>
			<a href="home.html" target="_parent">HOME</a>
			<a href="Merch.php" target="_parent">PRODUCTS</a>
			<a href="cart.php" target="_parent">CART</a>
			<a href="about.html" target="_parent">ABOUT</a>
		</div>
	</header>

    <?php if (isset($customer_info) && isset($result_customer_orders)) : ?>
        <section>
            
            <table>
            <div class="modal" id="successModal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <p>Your order has been successfully placed. Thank you for shopping with us!</p>
                    </div>
                </div>
                <thead>
                <h2>Customer Information</h2>
                    <tr>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                        <td><?php echo $customer_info['student_id']; ?></td>
                        <td><?php echo $customer_info['first_name']; ?></td>
                        <td><?php echo $customer_info['middle_name']; ?></td>
                        <td><?php echo $customer_info['last_name']; ?></td>
                        <td><b><br>Street address: </b> <?php echo $customer_info['street_address'] ; ?> 
                        <b><br>Baranggay address: </b> <?php echo $customer_info['baranggay_address']  ; ?>
                        <b><br>City: </b> </b> <?php echo $customer_info['city_address']   ; ?>
                        <b><br>Province:</b> <?php echo $customer_info['province_address']   ; ?>
                        <b><br>Zip code: </b><?php echo $customer_info['zip_code']  ; ?> 
                        <b><br>Contact No: </b><?php echo $customer_info['contact_no']  ; ?> </td>
                    </tr>
                </tbody>
            </table>
     </section>

<section>
           
            <?php if ($result_customer_orders->num_rows > 0) : ?>
    <table>
                    <thead>
                    <h2>Customer Orders</h2>
                        <tr>
                            <th>Order ID</th>
                            <th>Merchandise Name</th>
                            <th>Order Amount</th>
                            <th>Price</th>
                            <th>Ordered Date</th>
                            <th>Order Status</th>
                            <th>Expected Arrival</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalPrice = 0;
                        while ($orderRow = $result_customer_orders->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $orderRow['order_id']; ?></td>
                                <td><?php echo $orderRow['merch_name']; ?></td>
                                <td><?php echo $orderRow['order_amount']; ?></td>
                                <td>$<?php echo $orderRow['price']; ?></td>
                                <td><?php echo $orderRow['ordered_date']; ?></td>
                                <td><?php echo $orderRow['order_status']; ?></td>
                                <td><?php echo $orderRow['expected_arrival'] ?? 'N/A'; ?></td>
                                </tr>
                                <tr>
                            <td><?php $totalPrice += $orderRow['order_amount'] * $orderRow['price'];endwhile; ?>
                            <p>Total Price: $<?php echo $totalPrice; ?></p>

                        </td>

                        </tr>
                        <tr>
                       <td> <button class="cancellation-btn" id="cancelBtn" onclick="cancelOrder(<?php echo $student_id; ?>)">Cancel Order</button>
               
            <?php else : ?>
                <p>No orders found for the specified student ID.</p>
            <?php endif; ?>
        </section>
    <?php endif; ?>
            </td></tr>
                        
                    </tbody>
                    

                </table>
           

      

<script>
    function closeModal() {
        var modal = document.getElementById("successModal");
        modal.style.display = "none";
    }
    
    function openSuccessModal() {
        var modal = document.getElementById("successModal");
        modal.style.display = "block";
    }

    function cancelOrder(studentId) {
        var confirmation = confirm("Are you sure you want to cancel your order?");
        if (confirmation) {
            // AJAX request to cancel the order on the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "cancel_order.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    // Handle the response, e.g., display a success message
                    alert(xhr.responseText);
                    // Reload the page or perform additional actions as needed
                    location.reload();
                }
            };
            xhr.send("student_id=" + studentId);
        }
    }

    openSuccessModal();</script>

</section>
</body>
</html>