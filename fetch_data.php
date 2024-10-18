<?php
// fetch_data.php
include 'suppliers_db.php'; // Include your database connection

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $idToDelete = intval($_POST['id']);
    $deleteSql = "DELETE FROM sif_table WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $idToDelete);
    $stmt->execute();
    $stmt->close();
}

// Fetch data
$sql = "SELECT id, company_name, company_owner, company_address, tin, tax_type, mobile_number, telephone_number, email_address, authorized_representative, authletter, id_presented, spa, created_at FROM sif_table";
$result = $conn->query($sql);
$suppliers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suppliers[] = $row;
    }
}

// Prepare data for monthly records
$monthlyCounts = [];
foreach ($suppliers as $supplier) {
    $date = new DateTime($supplier['created_at']);
    $monthYear = $date->format('F Y'); // Format as "Month Year"
    if (!isset($monthlyCounts[$monthYear])) {
        $monthlyCounts[$monthYear] = 0;
    }
    $monthlyCounts[$monthYear]++;
}

// Include remaining months until December 2024
$currentDate = new DateTime();
$endDate = new DateTime('2024-12-31');
$interval = new DateInterval('P1M');
$period = new DatePeriod($currentDate, $interval, $endDate);

foreach ($period as $dt) {
    $monthYear = $dt->format('F Y');
    if (!isset($monthlyCounts[$monthYear])) {
        $monthlyCounts[$monthYear] = 0; // Set zero for months with no records
    }
}

$conn->close();
