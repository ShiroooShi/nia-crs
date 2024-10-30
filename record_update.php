<?php

session_start(); 
include 'claimants_db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    $sql = "UPDATE crs_table SET 
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
        "ssssssssssssi",
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
        $_SESSION['message'] = "Record updated successfully!";
        header("Location: records.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}