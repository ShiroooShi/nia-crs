<?php
include('claimants_db.php');
require 'vendor/autoload.php';

use Mpdf\Mpdf;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mpdf = new Mpdf();
    $data = fetchData();

    // Initialize selected data
    $selected_data = [];

    // Check if ID range is provided
    if (isset($_POST['start_id']) && isset($_POST['end_id'])) {
        $startId = (int)$_POST['start_id'];
        $endId = (int)$_POST['end_id'];

        // Filter data based on the provided ID range
        $selected_data = array_filter($data, function ($row) use ($startId, $endId) {
            return $row['id'] >= $startId && $row['id'] <= $endId;
        });
    } elseif (isset($_POST['export_all'])) {
        $selected_data = $data;
    }

    // PDF Content
    $mpdf->WriteHTML(
        '<style>
        h2 {
            font-family: "Cambria", serif;
        }            
        </style>'
    );
    $mpdf->WriteHTML('<h2>Claimant`s Data</h2>');
    $mpdf->WriteHTML(
        '<style>
        body {
            font-family: "Cambria", serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-family: "Cambria", serif;
        }

        th {
            background-color: #71f79f;
            color: #000;
            font-family: "Cambria", serif;
        }

        tr:nth-child(even) {
            background-color: #ffffff;
        }

        tr:nth-child(odd) {
            background-color: #e0e0e0;
        }
    </style>'
    );

    $mpdf->WriteHTML('<table><tr><th>ID</th><th>Company Name</th><th>Company Owner</th><th>Company Address</th></tr>');

    if (!empty($selected_data)) {
        foreach ($selected_data as $row) {
            $mpdf->WriteHTML('<tr>
                <td>' . htmlspecialchars($row['id']) . '</td>
                <td>' . htmlspecialchars($row['company_name']) . '</td>
                <td>' . htmlspecialchars($row['company_owner']) . '</td>
                <td>' . htmlspecialchars($row['company_address']) . '</td>
            </tr>');
        }
    } else {
        $mpdf->WriteHTML('<tr><td colspan="4">No records found for the given criteria.</td></tr>');
    }

    $mpdf->WriteHTML('</table>');
    $mpdf->Output('claimants_data.pdf', 'D');
}
