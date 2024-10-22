<?php
include 'claimants_db.php';

// Handle Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $idToDelete = intval($_POST['id']);
    $deleteSql = "DELETE FROM crs_table WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $idToDelete);
    $stmt->execute();
    $stmt->close();
}

// Fetch Data
$sql = "SELECT id, company_name, company_owner, company_address, tin, tax_type, mobile_number, telephone_number, email_address, authorized_representative, authletter, id_presented, spa, created_at FROM crs_table";
$result = $conn->query($sql);
$suppliers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suppliers[] = $row;
    }
}

// Fetch overall count of records
$countSql = "SELECT COUNT(*) AS total FROM crs_table"; // Adjust table name if necessary
$countResult = $conn->query($countSql);
$countRow = $countResult->fetch_assoc();
$overallCount = $countRow['total'];

// Count records with Authorization Letter
$autLetterSql = "SELECT COUNT(*) AS total FROM crs_table WHERE authletter = 'yes'"; // Adjust condition as needed
$autLetterResult = $conn->query($autLetterSql);
$autLetterRow = $autLetterResult->fetch_assoc();
$autletterCount = $autLetterRow['total'];

// Count records with Notarized SPA
$spaSql = "SELECT COUNT(*) AS total FROM crs_table WHERE spa = 'yes'"; // Adjust condition as needed
$spaResult = $conn->query($spaSql);
$spaRow = $spaResult->fetch_assoc();
$spaCount = $spaRow['total'];

// Prepare Data for Monthly Records
$monthlyCounts = [];
foreach ($suppliers as $supplier) {
    $date = new DateTime($supplier['created_at']);
    $monthYear = $date->format('F Y');
    if (!isset($monthlyCounts[$monthYear])) {
        $monthlyCounts[$monthYear] = 0;
    }
    $monthlyCounts[$monthYear]++;
}

$startDate = new DateTime('first day of January this year');
$endDate = new DateTime('last day of December this year');
$interval = new DateInterval('P1M');
$period = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

foreach ($period as $dt) {
    $monthYear = $dt->format('F Y');
    if (!isset($monthlyCounts[$monthYear])) {
        $monthlyCounts[$monthYear] = 0;
    }
}
