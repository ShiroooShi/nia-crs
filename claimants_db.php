<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "claimants_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchData()
{
    global $conn;
    $sql = "SELECT * FROM crs_table";
    $result = $conn->query($sql);

    $data = [];
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }

    return $data;
}
