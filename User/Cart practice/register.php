<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $student_id = $_POST["student_id"];
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];
    $school_email = $_POST["school_email"];
    $street_address = $_POST["street_address"];
    $baranggay_address = $_POST["baranggay_address"];
    $city_address = $_POST["city_address"];
    $province_address = $_POST["province_address"];
    $zip_code = $_POST["zip_code"];
    $contact_no = $_POST["contact_no"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password for security

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
    $stmt = $conn->prepare("INSERT INTO `customer's information` (student_id, first_name, middle_name, last_name, school_email, street_address, baranggay_address, city_address, province_address, zip_code, contact_no, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssss", $student_id, $first_name, $middle_name, $last_name, $school_email, $street_address, $baranggay_address, $city_address, $province_address, $zip_code, $contact_no, $password);

    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Start the session
    session_start();

    // Set the student_id as a session variable
    $_SESSION['student_id'] = $student_id;

    // Redirect to a thank you or login page
    header("Location: thankyou.html");
    exit();
}
?>
