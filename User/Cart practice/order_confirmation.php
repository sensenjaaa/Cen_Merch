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
}
?>

<!-- ... rest of the HTML code ... -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #721315;
            color: white;
            padding: 1em;
            text-align: center;
        }

        h1, h2 {
            color: #721315;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #721315;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        p {
            color: #721315;
        }

        
.paymentbtn{
	display: block;
	margin-top:10px;
	width:200px;;
	height: 50px;
	font-size: 20px;
	background-color: maroon;
	color:white;
	border-radius:8px;
	border:1px solid black;
	transition-duration: 0.4s;
}

.modal {
	display: none;
	position: fixed;
	z-index: 1;
	padding-top: 150px;
	right: 0;
	top: 0;
	width: 100%;
	height: 100%;
	overflow: auto;
	background-color: rgba(0,0,0,0.6);
}

.modal-content {
	background-color: #fefefe;
	margin: auto;
	padding: 20px;
	border: 1px solid #888;
	width: 500px;
}

.close {  
	color: #aaaaaa;
	float: right;
	font-size: 28px;
	font-weight: bold;
}

.close:hover,
.close:focus {
	color: #000;
	text-decoration: none;
	cursor: pointer;
}

.paymentbtn:hover{
	background-color: #ffc3a0;
	color: black;
}

.paymenttitle{
	color:black;
	text-align:center;
}

input[type="submit"]{
	display: block;
	width: 60%;
	margin: 1em auto;
	height: 2em;
	font-size: 1.1rem;
	background-color: maroon;
	border-color: white;
	min-width: 300px;
	color:white;
}


        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .close {
            color: #721315;
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        .paymenttitle {
            color: #721315;
        }

        .paymentcontent {
            margin-top: 20px;
        }

        .info {
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #721315;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #721315;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        body{
	background: white;
	color: #1b1b32;
	font-family: Helvetica;
	margin: 0;
}

header {
   width: 100%;
   height: 100px;
   background-color: #721315;
   display: flex;
   align-items: center;
   justify-content:center;
   position: fixed;
   top: 0;
}

.topnav{
   background-color:#721315;
   overflow:hidden;
}

.topnav a{
   float:left;
   color:white;
   text-align: center;
   padding:14px 16px;
   text-decoration:none;
   font-size:17px;
}

.topnav a:hover{
   background-color:#ddd;
   color:black;
}

.topnav a.active{
   background-color:blue;
   color:white;
}

.topnav input[type=text] {
   float: right;
   padding: 6px;
   border: none;
   margin-top: 8px;
   margin-right: 16px;
   font-size: 17px;
}

.topnav input[type=text] {
   border: 1px solid #ccc;
}

h1{color: white;}
h1:not(.headingnav,.productname,.productsec,.modalproduct,){
   margin: 0 auto;
   margin-left: 100px;
   text-align:center;
   color: #1b1b32;
}

.headingnav{
   font-size:50px;
   text-align:center;
   margin-right:170px;
}
    </style>
</head>
<body>

<header>

        <h1>CEN MERCH</h1>
        <div class="topnav">
            <a href="user.php" target="_parent">ACCOUNT</a>
            <a href="home.html" target="_parent">HOME</a>
            <a href="Merch.php" target="_parent">PRODUCTS</a>
            <a href="cart.php" target="_parent">CART</a>
            <a href="about.html" target="_parent">ABOUT</a>
        </div>
    <h1>Order Summary</h1>
</header>

    <?php if (isset($customer_info) && isset($result_customer_orders)) : ?>
        <section>
            <h2>Customer Information</h2>
            <table>
                <thead>
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
            <h2>Customer Orders</h2>
            <?php if ($result_customer_orders->num_rows > 0) : ?>
                <table>
                    <thead>
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
                            <?php $totalPrice += $orderRow['order_amount'] * $orderRow['price'];
                        endwhile; ?>
                    </tbody>
                </table>

                <p>Total Price: $<?php echo $totalPrice; ?></p>
                <button class="paymentbtn">Pay</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="paymenttitle">Payment Method</h1>
                        <div class="paymentcontent">
                            <div class="info">
                                <form action="payment.php" method="POST">
                                    <label for="student_id">Student ID:</label>
                                    <input type="text" id="student_id" name="student_id" maxlength="10" placeholder="Enter Your Student ID" required>
                                    <br>
                                    <br>
                                    <label for="payment_method">Payment Method:</label>
                                    <select name="payment_method" required>
                                        <option value="CashonHand">Cash-on-Hand</option>
                                        <option value="GCash">GCash</option>
                                    </select>
                                    <br>
                                    <input type="submit" value="Pay">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <p>No orders found for the specified student ID.</p>
            <?php endif; ?>
        </section>
    <?php else : ?>
        <p>Unable to retrieve customer information or orders.</p>
    <?php endif; ?>

    <script>
        var modalBtns = document.querySelectorAll(".paymentbtn");
        modalBtns.forEach(function(btn) {
            btn.onclick = function() {
                var modal = this.nextElementSibling;
                modal.style.display = "block";
            };
        });

        var closeBtns = document.querySelectorAll(".close");
        closeBtns.forEach(function(btn) {
            btn.onclick = function() {
                var modal = this.parentElement.parentElement;
                modal.style.display = "none";
            };
        });

        window.onclick = function(event) {
            if (event.target.className === "modal") {
                event.target.style.display = "none";
            }
        };
    </script>

</body>
</html>
