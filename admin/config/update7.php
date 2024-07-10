
<?php
include "order.php";
$merch_id = $_GET["merch_id"];
if (isset($_POST["submit"])) {
  $merch_name = $_POST['merch_name'];
  $price = $_POST['price'];
  $stock_available = $_POST['stock_available'];

  $sql = "UPDATE `merchandise details` SET `merch_name`='$merch_name', `price`='$price', `stock_available`='$stock_available' WHERE merch_id = $merch_id";

  $result7 = mysqli_query($con, $sql);

  if ($result7) {
    header("Location: http://localhost/cenmerch/admin/merchandise.php?msg=Data updated successfully");
  } else {
    echo "Failed: " . mysqli_error($con);
  }
}

?>


<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Products</title>
    <link rel="stylesheet" href="update.css"/>
</head>
<body>
<header>
		<h1 class="headingnav">CEN MERCH</h1>
        <div class="topnav">
            <a href="User.html" target="_parent">ADMIN</a>
            <a href="Products.html" target="_parent">INVENTORY</a>
            <a href="About.html" target="_parent">ORDER</a>
           
        </div>
		</div>
	</header>
<body>
<div class="container">
    <div class="text-center mb-4">
      <h3>Edit Product Information</h3>
      <p class="text-muted">Click update after changing any information</p>
    </div>

    <?php
   $sql = "SELECT * FROM `merchandise details` WHERE merch_id = $merch_id LIMIT 1";
   $result7 = mysqli_query($con, $sql);
   $row7 = mysqli_fetch_assoc($result7);
   
    ?>

<div class="container d-flex justify-content-center">
      <form action="" method="post" style="width:50vw; min-width:300px;">
      <b><p class="modaldescription">Merch ID:</b> <?php echo $row7["merch_id"] ?> <br>

    <label><b>Merch Name:</b> <input type="text" id="merch_name" name="merch_name" maxlength="10" value="<?php echo htmlspecialchars($row7["merch_name"]) ?>" required></label><br>
<label><b>Price: PHP</b><input type="text" id="price" name="price" maxlength="10" value="<?php echo htmlspecialchars($row7["price"]) ?>"></label><br>
<label><b>Stocks:</b> <input type="text" id="stock_available" name="stock_available" maxlength="10" value="<?php echo htmlspecialchars($row7["stock_available"]) ?>"></label><br>

                </p>
                <div>
          <button class="button-like" type="submit" class="button-like" name="submit">Update</button>
          <a class="button-like" href="http://localhost/cenmerch/admin/merchandise.php" class="button-like">Cancel</a>
        </div>
      </form>

</div>
</div>
 <!-- Bootstrap -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>
