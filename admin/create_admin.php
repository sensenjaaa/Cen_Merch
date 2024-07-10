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

// Admin creation logic
$adminUsername = "usera";
$adminPassword = password_hash("123098", PASSWORD_DEFAULT);

$query = "INSERT INTO admins (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $adminUsername, $adminPassword);

if ($stmt->execute()) {
    echo "Admin added successfully!";
} else {
    echo "Error adding admin: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
