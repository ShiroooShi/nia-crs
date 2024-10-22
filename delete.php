<?php

session_start(); 
include 'suppliers_db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $idToDelete = intval($_POST['id']);

    $deleteSql = "DELETE FROM sif_table WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $idToDelete);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Record deleted successfully!";
        header("Location: records.php?page=1");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
