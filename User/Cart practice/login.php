<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $student_id = $_POST["student_id"];
    $password = $_POST["password"];

    // Your database connection and query logic here
    $servername = "127.0.0.1";
    $username = "usera";
    $password_db = "123098";
    $database = "cen merch";

    $conn = new mysqli($servername, $username, $password_db, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM `customer's information` WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists and verify the password
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Start the session before setting session variables
            session_start();

            // Set the student_id as a session variable
            $_SESSION['student_id'] = $student_id;

            // Successful login, redirect to home page or user dashboard
            header("Location: home.html");
            exit();
        } else {
            // Invalid password
            echo '<script>alert("Invalid Password");</script>';
        }
    } else {
        // User not found
        echo '<script>alert("User not found");</script>';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>



