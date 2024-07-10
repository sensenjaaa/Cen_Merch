<?php
include "config/order.php";  // Include the necessary file (replace with actual file content)

session_start();

$servername = "127.0.0.1";
$username = "usera";
$password_db = "123098";
$database = "cen merch"; // Corrected the database name

$conn = new mysqli($servername, $username, $password_db, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = $_POST['username'];
    $admin_password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $query_admin_login = "SELECT * FROM admins WHERE username = ?";
    $stmt_admin_login = $conn->prepare($query_admin_login);
    $stmt_admin_login->bind_param("s", $admin_username);
    $stmt_admin_login->execute();
    $result_admin_login = $stmt_admin_login->get_result();

    if ($result_admin_login->num_rows == 1) {
        // Admin found, verify the password
        $row = $result_admin_login->fetch_assoc();
        if (password_verify($admin_password, $row['password'])) {
            // Admin login successful
            $_SESSION['admin_username'] = $admin_username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Invalid password
            echo "Invalid admin credentials";
        }
    } else {
        // Admin not found
        echo "Invalid admin credentials";
    }

    $stmt_admin_login->close();
}

$conn->close();
?>
