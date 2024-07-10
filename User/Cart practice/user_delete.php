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

    // Delete the customer's information from the database
    $query_delete_user = "DELETE FROM `customer's information` WHERE student_id = ?";
    $stmt_delete_user = $conn->prepare($query_delete_user);
    $stmt_delete_user->bind_param("s", $student_id);

    if ($stmt_delete_user->execute()) {
        // Clear the session and redirect to register.html after successful deletion
        session_unset();
        session_destroy();
        header("Location: register.html");
        exit();
    } else {
        die("Error deleting customer information: " . $stmt_delete_user->error);
    }
}

// Close the database connection
$conn->close();
?>
