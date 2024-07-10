<?php
session_start();

// Connect to your database (replace with your credentials)
$servername = "127.0.0.1";
$username = "usera";
$password_db = "123098";
$database = "cen merch"; // Corrected the database name

$conn = new mysqli($servername, $username, $password_db, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Products</title>
    <link rel="stylesheet" href="otherpro.css"/>
</head>
<body>
    <header>
		<h1 class="headingnav">CEN MERCH</h1>
		<div class="topnav">
            <a href="user.php" target="_parent">ACCOUNT</a>
			<a href="home.html" target="_parent">HOME</a>
			<a href="products.html" target="_parent">PRODUCTS</a>
			<a href="cart.php" target="_parent">CART</a>
			<a href="about.html" target="_parent">ABOUT</a>
            <a href="otherpro.php" target="_parent">OTHER ITEMS</a>
		</div>
        
	</header>
    <div id="cart" class="cart-container">
        <div>
            <h3>Products</h3>
            <?php
            if (isset($_GET["msg"])) {
                $msg = $_GET["msg"];
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        ' . $msg . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
            ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Merch ID</th>
                    <th>Merch Name</th>
                    <th>Price</th>
                    <th>Stocks</th>
                    <th>Size and Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `merchandise details`";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row["merch_id"] ?> &nbsp;</td>
                            <td>&nbsp;<?php echo $row["merch_name"] ?> &nbsp;</td>
                            <td>PHP<?php echo $row["price"] ?> &nbsp;</td>
                            <td>&nbsp;<?php echo $row["stock_available"] ?> &nbsp;</td>
                            <td>
                                <form action="products.php" method="POST">
                                    <input type="hidden" name="merch_id" value="<?php echo $row['merch_id']; ?>">
                                    <label for="order_amount">Qty: <input type="number" name="order_amount" value="1" min="1" max="<?php echo $row['stock_available']; ?>" required></label>
                                    <label for="size">Size: </label>
                                    <select name="size" required>
                                        <option value="N/A">N/A</option>
                                        <option value="XtraSmall">XS</option>
                                        <option value="Small">S</option>
                                        <option value="Medium">M</option>
                                        <option value="Large">L</option>
                                        <option value="XtraLarge">XL</option>
                                        <option value="XXLarge">XXL</option>
                                    </select>
                                </form>
                            </td>
                            <td><input class="addtocart" type="submit" value="Add to Cart"></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
