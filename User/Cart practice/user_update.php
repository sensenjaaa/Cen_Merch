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

    // Close the statement after fetching data
    $stmt_customer_info->close();

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve updated information from the form
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $school_email = $_POST['school_email'];
        $street_address = $_POST['street_address'];
        $baranggay_address = $_POST['baranggay_address'];
        $city_address = $_POST['city_address'];
        $province_address = $_POST['province_address'];
        $zip_code = $_POST['zip_code'];
        $contact_no = $_POST['contact_no'];
        $password = $_POST['password'];

        // Update the customer information in the database
        $query_update_info = "UPDATE `customer's information` SET 
                            first_name = ?,
                            middle_name = ?,
                            last_name = ?,
                            school_email = ?,
                            street_address = ?,
                            baranggay_address = ?,
                            city_address = ?,
                            province_address = ?,
                            zip_code = ?,
                            contact_no = ?,
                            password = ?
                            WHERE student_id = ?";

        $stmt_update_info = $conn->prepare($query_update_info);
        $stmt_update_info->bind_param("ssssssssssss", $first_name, $middle_name, $last_name,
                                        $school_email, $street_address, $baranggay_address,
                                        $city_address, $province_address, $zip_code,
                                        $contact_no, $password, $student_id);

        if ($stmt_update_info->execute()) {
            // Redirect to the user's account page after successful update
            header("Location: user.php");
            exit();
        } else {
            die("Error updating customer information: " . $stmt_update_info->error);
        }
    }
}
// Close the database connection
$conn->close();
?>
