<?php
include "config/order.php";
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Products</title>
    <link rel="stylesheet" href="merchandise.css"/>
</head>
<body>
    <script src="merchandise_search.js"></script>
    <header>
        <h1 class="headingnav">CEN MERCH</h1>
        <div class="topnav">
            <a href="admin_dashboard.php" target="_parent">ADMIN</a>
            <a href="merchandise.php" target="_parent">INVENTORY</a>
            <a href="order_status.php" target="_parent">ORDER</a>
        </div>
        <div class="search-container">
            <input type="text" id="search-item" placeholder="Search Merchandise" name="search" onkeyup="merch_search()">
        </div>
        <button type="button" class="addprodbtn">Add Products</button>
        <div class="addprodmodal">
            <div class="addprodmodal-content">
                <span class="close">&times;</span>
                <div id="cart" class="cart-container">
                    <div><h3>Your Products</h3>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div id="cart-items"> 
                            <?php
                                $sql = "SELECT * FROM `merchandise details`";
                                $result = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row["merch_id"] ?> &nbsp;</td>
                                <td>&nbsp;<?php echo $row["merch_name"] ?> &nbsp;</td>
                                <td>PHP<?php echo $row["price"] ?> &nbsp;</td>
                                <td>&nbsp;<?php echo $row["stock_available"] ?>
                                <td>
                                <form action="config/update.php?merch_id=<?php echo $row['merch_id']; ?>" method="post">
                                    <center><button class="productbtn">Update</button></center>
                                </form>
                                <form action="config/delete.php?merch_id=<?php echo $row["merch_id"] ?>" method="post">
                                <center><button class="productbtn">Delete</button></center>
                                </form>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <form action="config/add-new.php" method="post">
                        <center><button class="productbtn">Add New</button></center>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="productcontainer">
        <h1 class="productsec">SHIRTS</h1>
        <div class="listofproducts">
            <div class="products">
                <h1 class="productname">SHIRT1</h1>
                <img class="product-img" src="shirt1.jpg">
                <button class="productbtn">Buy</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="modalproduct">SHIRT1</h1>
                        <div class="productinfo">
                            <div class="productimgsec">
                                <img class="product-img" src="shirt1.jpg">
                            </div>
                            <div class="info">
                                <?php
                                    include "config/order.php";
                                    $merch_id = 1; // Change this value based on the current product

                                    $sql = "SELECT * FROM `merchandise details` WHERE merch_id = $merch_id";
                                    $result0 = mysqli_query($con, $sql);
                                    $row0 = mysqli_fetch_assoc($result0);

                                    if ($row0) {
                                ?>
                                <b><p class="modaldescription">Merch ID:</b> <?php echo $row0["merch_id"] ?> <br>
                                <label><b>Merch Name:</b> <?php echo $row0["merch_name"] ?></label><br>
                                <label><b>Price:</b> <?php echo $row0["price"] ?></label><br>
                                <label><b>Stocks:</b> <?php echo $row0["stock_available"] ?></label><br>

                                <!-- Add any other dynamic content here based on your database fields -->
                                <form action="config/update0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                    <center><button class="productbtn">Update</button></center>
                                </form>
                                <form action="config/delete0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                <center><button class="productbtn">Delete</button></center>
                                </form>
                                <?php
                                    } else {
                                    echo "Product not found"; // Display a message if the product is not found
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products">
                <h1 class="productname">SHIRT2</h1>
                <img class="product-img" src="shirt2.jpg">
                <button class="productbtn">Buy</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="modalproduct">SHIRT2</h1>
                        <div class="productinfo">
                            <div class="productimgsec">
                                <img class="product-img" src="shirt2.jpg">
                            </div>
                            <div class="info">
                                <?php
                                    include "config/order.php";
                                    $merch_id = 2; // Change this value based on the current product

                                    $sql = "SELECT * FROM `merchandise details` WHERE merch_id = $merch_id";
                                    $result0 = mysqli_query($con, $sql);
                                    $row0 = mysqli_fetch_assoc($result0);

                                    if ($row0) {
                                ?>
                                <b><p class="modaldescription">Merch ID:</b> <?php echo $row0["merch_id"] ?> <br>
                                <label><b>Merch Name:</b> <?php echo $row0["merch_name"] ?></label><br>
                                <label><b>Price:</b> <?php echo $row0["price"] ?></label><br>
                                <label><b>Stocks:</b> <?php echo $row0["stock_available"] ?></label><br>

                                <!-- Add any other dynamic content here based on your database fields -->

                                <form action="config/update0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                    <center><button class="productbtn">Update</button></center>
                                </form>
                                <form action="config/delete0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                <center><button class="productbtn">Delete</button></center>
                                </form>
                                <?php
                                    } else {
                                    echo "Product not found"; // Display a message if the product is not found
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products">
                <h1 class="productname">SHIRT3</h1>
                <img class="product-img" src="shirt3.jpg">
                <button class="productbtn">Buy</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="modalproduct">SHIRT3</h1>
                        <div class="productinfo">
                            <div class="productimgsec">
                                <img class="product-img" src="shirt3.jpg">
                            </div>
                            <div class="info">
                                <?php
                                    include "config/order.php";
                                    $merch_id = 3; // Change this value based on the current product

                                    $sql = "SELECT * FROM `merchandise details` WHERE merch_id = $merch_id";
                                    $result0 = mysqli_query($con, $sql);
                                    $row0 = mysqli_fetch_assoc($result0);

                                    if ($row0) {
                                ?>
                                <b><p class="modaldescription">Merch ID:</b> <?php echo $row0["merch_id"] ?> <br>
                                <label><b>Merch Name:</b> <?php echo $row0["merch_name"] ?></label><br>
                                <label><b>Price:</b> <?php echo $row0["price"] ?></label><br>
                                <label><b>Stocks:</b> <?php echo $row0["stock_available"] ?></label><br>

                                <!-- Add any other dynamic content here based on your database fields -->

                                <form action="config/update0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                    <center><button class="productbtn">Update</button></center>
                                </form>
                                <form action="config/delete0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                <center><button class="productbtn">Delete</button></center>
                                </form>
                                <?php
                                    } else {
                                    echo "Product not found"; // Display a message if the product is not found
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products">
                <h1 class="productname">SHIRT4</h1>
                <img class="product-img" src="shirt4.jpg">
                <button class="productbtn">Buy</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="modalproduct">SHIRT4</h1>
                        <div class="productinfo">
                            <div class="productimgsec">
                                <img class="product-img" src="shirt4.jpg">
                            </div>
                            <div class="info">
                                <?php
                                    include "config/order.php";
                                    $merch_id = 4; // Change this value based on the current product

                                    $sql = "SELECT * FROM `merchandise details` WHERE merch_id = $merch_id";
                                    $result0 = mysqli_query($con, $sql);
                                    $row0 = mysqli_fetch_assoc($result0);

                                    if ($row0) {
                                ?>
                                <b><p class="modaldescription">Merch ID:</b> <?php echo $row0["merch_id"] ?> <br>
                                <label><b>Merch Name:</b> <?php echo $row0["merch_name"] ?></label><br>
                                <label><b>Price:</b> <?php echo $row0["price"] ?></label><br>
                                <label><b>Stocks:</b> <?php echo $row0["stock_available"] ?></label><br>

                                <!-- Add any other dynamic content here based on your database fields -->

                                <form action="config/update0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                    <center><button class="productbtn">Update</button></center>
                                </form>
                                <form action="config/delete0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                <center><button class="productbtn">Delete</button></center>
                                </form>
                                </p>
                                <?php
                                    } else {
                                    echo "Product not found"; // Display a message if the product is not found
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products">
                <h1 class="productname">SHIRT5</h1>
                <img class="product-img" src="shirt5.jpg">
                <button class="productbtn">Buy</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="modalproduct">SHIRT5</h1>
                        <div class="productinfo">
                            <div class="productimgsec">
                                <img class="product-img" src="shirt5.jpg">
                            </div>
                            <div class="info">
                                <?php
                                    include "config/order.php";
                                    $merch_id = 5; // Change this value based on the current product

                                    $sql = "SELECT * FROM `merchandise details` WHERE merch_id = $merch_id";
                                    $result0 = mysqli_query($con, $sql);
                                    $row0 = mysqli_fetch_assoc($result0);

                                    if ($row0) {
                                ?>
                                <b><p class="modaldescription">Merch ID:</b> <?php echo $row0["merch_id"] ?> <br>
                                <label><b>Merch Name:</b> <?php echo $row0["merch_name"] ?></label><br>
                                <label><b>Price:</b> <?php echo $row0["price"] ?></label><br>
                                <label><b>Stocks:</b> <?php echo $row0["stock_available"] ?></label><br>

                                <!-- Add any other dynamic content here based on your database fields -->

                                <form action="config/update0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                    <center><button class="productbtn">Update</button></center>
                                </form>
                                <form action="config/delete0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                <center><button class="productbtn">Delete</button></center>
                                </form>
                                </p>
                                <?php
                                    } else {
                                    echo "Product not found"; // Display a message if the product is not found
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="productsec">TOTEBAGS</h1>
        <div class="listofproducts">
            <div class="products">
                <h1 class="productname">Totebag1</h1>
                <img class="product-img" src="tote1.jpg">
                <button class="productbtn">Buy</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="modalproduct">Totebag1</h1>
                        <div class="productinfo">
                            <div class="productimgsec">
                                <img class="product-img" src="tote1.jpg">
                            </div>
                            <div class="info">
                                <?php
                                    include "config/order.php";
                                    $merch_id = 6; // Change this value based on the current product

                                    $sql = "SELECT * FROM `merchandise details` WHERE merch_id = $merch_id";
                                    $result0 = mysqli_query($con, $sql);
                                    $row0 = mysqli_fetch_assoc($result0);

                                    if ($row0) {
                                ?>
                                <b><p class="modaldescription">Merch ID:</b> <?php echo $row0["merch_id"] ?> <br>
                                <label><b>Merch Name:</b> <?php echo $row0["merch_name"] ?></label><br>
                                <label><b>Price:</b> <?php echo $row0["price"] ?></label><br>
                                <label><b>Stocks:</b> <?php echo $row0["stock_available"] ?></label><br>

                                <!-- Add any other dynamic content here based on your database fields -->

                                <form action="config/update0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                    <center><button class="productbtn">Update</button></center>
                                </form>
                                <form action="config/delete0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                <center><button class="productbtn">Delete</button></center>
                                </form>
                                </p>
                                <?php
                                    } else {
                                    echo "Product not found"; // Display a message if the product is not found
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products">
                <h1 class="productname">Totebag2</h1>
                <img class="product-img" src="tote2.jpg">
                <button class="productbtn">Buy</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="modalproduct">Totebag2</h1>
                        <div class="productinfo">
                            <div class="productimgsec">
                                <img class="product-img" src="tote2.jpg">
                            </div>
                            <div class="info">
                                <?php
                                    include "config/order.php";
                                    $merch_id = 7; // Change this value based on the current product

                                    $sql = "SELECT * FROM `merchandise details` WHERE merch_id = $merch_id";
                                    $result0 = mysqli_query($con, $sql);
                                    $row0 = mysqli_fetch_assoc($result0);

                                    if ($row0) {
                                ?>
                                <b><p class="modaldescription">Merch ID:</b> <?php echo $row0["merch_id"] ?> <br>
                                <label><b>Merch Name:</b> <?php echo $row0["merch_name"] ?></label><br>
                                <label><b>Price:</b> <?php echo $row0["price"] ?></label><br>
                                <label><b>Stocks:</b> <?php echo $row0["stock_available"] ?></label><br>

                                <!-- Add any other dynamic content here based on your database fields -->

                                <form action="config/update0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                    <center><button class="productbtn">Update</button></center>
                                </form>
                                <form action="config/delete0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                <center><button class="productbtn">Delete</button></center>
                                </form>
                                </p>
                                <?php
                                    } else {
                                    echo "Product not found"; // Display a message if the product is not found
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products">
                <h1 class="productname">Totebag3</h1>
                <img class="product-img" src="tote3.jpg">
                <button class="productbtn">Buy</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="modalproduct">Totebag3</h1>
                        <div class="productinfo">
                            <div class="productimgsec">
                                <img class="product-img" src="tote3.jpg">
                            </div>
                            <div class="info">
                                <?php
                                    include "config/order.php";
                                    $merch_id = 8; // Change this value based on the current product

                                    $sql = "SELECT * FROM `merchandise details` WHERE merch_id = $merch_id";
                                    $result0 = mysqli_query($con, $sql);
                                    $row0 = mysqli_fetch_assoc($result0);

                                    if ($row0) {
                                ?>
                                <b><p class="modaldescription">Merch ID:</b> <?php echo $row0["merch_id"] ?> <br>
                                <label><b>Merch Name:</b> <?php echo $row0["merch_name"] ?></label><br>
                                <label><b>Price:</b> <?php echo $row0["price"] ?></label><br>
                                <label><b>Stocks:</b> <?php echo $row0["stock_available"] ?></label><br>

                                <!-- Add any other dynamic content here based on your database fields -->

                                <form action="config/update0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                    <center><button class="productbtn">Update</button></center>
                                </form>
                                <form action="config/delete0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                <center><button class="productbtn">Delete</button></center>
                                </form>
                                </p>
                                <?php
                                    } else {
                                    echo "Product not found"; // Display a message if the product is not found
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="productsec">LANYARDS</h1>
        <div class="listofproducts">
            <div class="products">
                <h1 class="productname">Lanyard1</h1>
                <img class="product-img" src="lanyard1.jpg">
                <button class="productbtn">Buy</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="modalproduct">Lanyard1</h1>
                        <div class="productinfo">
                            <div class="productimgsec">
                                <img class="product-img" src="lanyard1.jpg">
                            </div>
                            <div class="info">
                                <?php
                                    include "config/order.php";
                                    $merch_id = 9; // Change this value based on the current product

                                    $sql = "SELECT * FROM `merchandise details` WHERE merch_id = $merch_id";
                                    $result0 = mysqli_query($con, $sql);
                                    $row0 = mysqli_fetch_assoc($result0);

                                    if ($row0) {
                                ?>
                                <b><p class="modaldescription">Merch ID:</b> <?php echo $row0["merch_id"] ?> <br>
                                <label><b>Merch Name:</b> <?php echo $row0["merch_name"] ?></label><br>
                                <label><b>Price:</b> <?php echo $row0["price"] ?></label><br>
                                <label><b>Stocks:</b> <?php echo $row0["stock_available"] ?></label><br>

                                <!-- Add any other dynamic content here based on your database fields -->

                                <form action="config/update0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                    <center><button class="productbtn">Update</button></center>
                                </form>
                                <form action="config/delete0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                <center><button class="productbtn">Delete</button></center>
                                </form>
                                </p>
                                <?php
                                    } else {
                                    echo "Product not found"; // Display a message if the product is not found
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products">
                <h1 class="productname">Lanyard2</h1>
                <img class="product-img" src="lanyard2.jpg">
                <button class="productbtn">Buy</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 class="modalproduct">Lanyard2</h1>
                        <div class="productinfo">
                            <div class="productimgsec">
                                <img class="product-img" src="lanyard2.jpg">
                            </div>
                            <div class="info">
                                <?php
                                    include "config/order.php";
                                    $merch_id = 10; // Change this value based on the current product

                                    $sql = "SELECT * FROM `merchandise details` WHERE merch_id = $merch_id";
                                    $result0 = mysqli_query($con, $sql);
                                    $row0 = mysqli_fetch_assoc($result0);

                                    if ($row0) {
                                ?>
                                <b><p class="modaldescription">Merch ID:</b> <?php echo $row0["merch_id"] ?> <br>
                                <label><b>Merch Name:</b> <?php echo $row0["merch_name"] ?></label><br>
                                <label><b>Price:</b> <?php echo $row0["price"] ?></label><br>
                                <label><b>Stocks:</b> <?php echo $row0["stock_available"] ?></label><br>

                                <!-- Add any other dynamic content here based on your database fields -->

                                <form action="config/update0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                    <center><button class="productbtn">Update</button></center>
                                </form>
                                <form action="config/delete0.php?merch_id=<?php echo $row0["merch_id"] ?>" method="post">
                                <center><button class="productbtn">Delete</button></center>
                                </form>
                                </p>
                                <?php
                                    } else {
                                    echo "Product not found"; // Display a message if the product is not found
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var modalBtns = document.querySelectorAll(".productbtn,.addprodbtn");
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
            if (event.target.className === "modal,.addprodmodal") {
                event.target.style.display = "none";
            }
        };
    </script>
</body>
</html>
