<?php
include "config/order.php";
?>
<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <header>
        <h1 class="headingnav">CEN MERCH</h1>
        <div class="topnav">
            <a href="admin_dashboard.php" target="_parent">ADMIN</a>
            <a href="merchandise.php" target="_parent">INVENTORY</a>
            <a href="order_status.php" target="_parent">ORDER</a>
        </div>
    </header>
    <div class="dashboard">
    <h2>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h2>
    <p>This is the admin dashboard.</p>

    <form action="logout.php">
        <button class="logout-btn">Log out</button>
    </form>
</body>
</html>
