<?php
// delete.php
session_start(); // Start the session
include 'suppliers_db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $idToDelete = intval($_POST['id']);

    // Prepare and execute the delete statement
    $deleteSql = "DELETE FROM sif_table WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $idToDelete);

    if ($stmt->execute()) {
        // Set the success message
        $_SESSION['message'] = "Record deleted successfully!";
        // Redirect back to the list of records after deletion
        header("Location: records.php?page=1"); // Replace with your actual file name
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
