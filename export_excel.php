<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Database connection details
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

if (isset($_POST['export_excel'])) {
    $sql = "SELECT id, company_name, company_owner, company_address, tin, tax_type, mobile_number, telephone_number, email_address, authorized_representative, authletter, id_presented, spa, created_at FROM crs_table";
    $result = $conn->query($sql);
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
        'id',
        'company_name',
        'company_owner',
        'company_address',
        'tin',
        'tax_type',
        'mobile_number',
        'telephone_number',
        'email_address',
        'authorized_representative',
        'authletter',
        'id_presented',
        'spa',
        'created_at'
    ];

    foreach ($headers as $columnIndex => $header) {
        $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex + 1) . '1';
        $sheet->setCellValue($cell, strtoupper(ucfirst(str_replace('_', ' ', $header))));

        $sheet->getStyle($cell)->getFont()->setBold(true);
        $sheet->getStyle($cell)->getFont()->setName('Cambria');
        $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle($cell)->getFill()->getStartColor()->setARGB('71f79f'); 
    }

    // Populate data
    $rowIndex = 2; // Start from the second row
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            foreach ($headers as $columnIndex => $header) {
                $cellAddress = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex + 1) . $rowIndex;
                $sheet->setCellValue($cellAddress, $row[$header]);

                if ($rowIndex % 2 == 0) {
                    $sheet->getStyle($cellAddress)->getFill()->setFillType(Fill::FILL_SOLID);
                    $sheet->getStyle($cellAddress)->getFill()->getStartColor()->setARGB(Color::COLOR_WHITE);
                } else {
                    $sheet->getStyle($cellAddress)->getFill()->setFillType(Fill::FILL_SOLID);
                    $sheet->getStyle($cellAddress)->getFill()->getStartColor()->setARGB('e0e0e0');
                }
            }
            $rowIndex++;
        }
    }

    // Set column widths
    foreach (range('A', 'N') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Add borders
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => Color::COLOR_BLACK],
            ],
        ],
    ];
    $sheet->getStyle('A1:N' . ($rowIndex - 1))->applyFromArray($styleArray);
    $sheet->getStyle('A1:N' . ($rowIndex - 1))->getFont()->setName('Cambria');

    $conn->close();

    // Save the Excel file
    $writer = new Xlsx($spreadsheet);
    $filename = 'exported_data.xlsx';
    $writer->save($filename);

    // Force download the Excel file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    readfile($filename);
    unlink($filename);
    exit();
}
