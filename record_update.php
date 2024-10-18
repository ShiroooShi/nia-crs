<?php
// update.php
session_start(); // Start the session
include 'suppliers_db.php'; // Ensure this file connects to your MySQL database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $id = $_POST['id'];
    $company_name = $_POST['company_name'];
    $company_owner = $_POST['company_owner'];
    $company_address = $_POST['company_address'];
    $tin = $_POST['tin'];
    $tax_type = $_POST['tax_type'];
    $mobile_number = $_POST['mobile_number'];
    $telephone_number = $_POST['telephone_number'];
    $email_address = $_POST['email_address'];
    $authorized_representative = $_POST['authorized_representative'];
    $authLetter = isset($_POST['authletter']) ? $_POST['authletter'] : '';
    $id_presented = $_POST['id_presented'];
    $spa = isset($_POST['spa']) ? $_POST['spa'] : '';

    // Prepare the SQL statement
    $sql = "UPDATE sif_table SET 
        company_name = ?, 
        company_owner = ?, 
        company_address = ?, 
        tin = ?, 
        tax_type = ?, 
        mobile_number = ?, 
        telephone_number = ?, 
        email_address = ?, 
        authorized_representative = ?, 
        authletter = ?,
        id_presented = ?,
        spa = ?
        WHERE id = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param(
        "ssssssssssssi", // Update the type string to include two additional 's' for authletter and spa
        $company_name,
        $company_owner,
        $company_address,
        $tin,
        $tax_type,
        $mobile_number,
        $telephone_number,
        $email_address,
        $authorized_representative,
        $authLetter,
        $id_presented,
        $spa,
        $id
    );

    // Execute the statement
    if ($stmt->execute()) {
        // Set the success message
        $_SESSION['message'] = "Record updated successfully!";
        // Redirect to the list of records after successful update
        header("Location: records.php"); // Replace with your actual page
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
