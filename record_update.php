<?php
// update.php
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
    $id_presented = $_POST['id_presented'];

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
            id_presented = ? 
            WHERE id = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param(
        "ssssssssssi",
        $company_name,
        $company_owner,
        $company_address,
        $tin,
        $tax_type,
        $mobile_number,
        $telephone_number,
        $email_address,
        $authorized_representative,
        $id_presented,
        $id
    );

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the list of records after successful update
        header("Location: records.php");
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
