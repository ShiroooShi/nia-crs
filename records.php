<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'fetch_data.php';

$recordsPerPage = isset($_GET['recordsPerPage']) ? (int)$_GET['recordsPerPage'] : 10;
$totalRecords = count($suppliers);
$totalPages = ceil($totalRecords / $recordsPerPage);
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$currentPage = max(1, min($currentPage, $totalPages));

$startRecord = ($currentPage - 1) * $recordsPerPage;
$suppliersToShow = array_slice($suppliers, $startRecord, $recordsPerPage);

function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

$data = fetchData();

if ($data === null) {
    $data = []; // Handle the case where no data is returned
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 300px;
            background-color: #71f79f;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 15px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar img {
            width: 100px;
            vertical-align: middle;
        }

        .sidebar h2,
        .sidebar a,
        .header,
        thead th,
        .table,
        .table td,
        .btn-custom-add-record {
            font-family: "Cambria", serif;
        }

        .sidebar h2 {
            color: black;
            text-align: left;
            font-weight: bold;
            padding: 20px 0;
            font-size: 27px;
        }

        .sidebar a {
            color: black;
            text-decoration: none;
            font-size: 20px;
            background-color: transparent;
            border-color: transparent;
            border-radius: 5px;
        }

        .content {
            flex-grow: 1;
            margin-left: 300px;
            overflow-y: auto;
            padding: 10px;
        }

        .logout {
            margin-top: auto;
            background-color: transparent;
            border: none;
            border-radius: 20px;
            align-items: center;
            font-family: "Poppins", sans-serif;
            font-size: 20px;
            transition: background-color 0.3s ease;
        }

        .logout:hover {
            background-color: transparent;
        }

        .header {
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .supplier-table {
            width: 100%;
            table-layout: auto;
        }

        .supplier-table tbody tr:nth-child(odd) {
            background-color: white;
        }

        .supplier-table tbody tr:nth-child(even) {
            background-color: #e0e0e0;
        }

        .table-responsive {
            overflow-x: auto;
        }

        thead th {
            background-color: #71f79f;
            color: black;
            position: relative;
            padding: 20px;
            text-transform: capitalize;
        }

        .table,
        .table td {
            border: none;
        }

        .btn-sort {
            color: black;
            font-weight: bold;
            margin-left: 10px;
        }

        .btn-action {
            color: #71f79f;
        }

        .btn-custom-add-record {
            width: 200px;
            height: 40px;
            border-radius: 10px;
        }

        #editModal,
        #editModal * {
            font-family: "Cambria", serif !important;
        }

        #message {
            border-radius: 5px;
            padding: 15px;
            transition: opacity 0.5s;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div style="display: flex; flex-direction: row; align-items: center;">
            <img src="images/crs-logo.png" alt="Logo">
            <h2 class="text-left">│CLAIMANT`S │RECORD │SYSTEM</h2>
        </div>
        <br>
        <div class="list-group">
            <a href="home.php" class="list-group-item list-group-item-action">🏡&nbsp;&nbsp;&nbsp;Home</a>
            <a href="#" class="list-group-item list-group-item-action active">📋&nbsp;&nbsp;&nbsp;List of Records</a>
        </div>
        <a href="logout.php" class="list-group-item list-group-item-action text-danger logout">Logout</a>
    </div>
    <div class="content">
        <br><br>
        <h1 class="header">CLAIMANT'S OVERALL RECORDS</h1>
        <br><br>
        <div id="message" class="alert" style="display:none; position: absolute; left: 50%; transform: translateX(-50%); top: 20%; z-index: 1000; width: 300px; text-align: center;"></div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text form-control"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="search" class="col-sm-3 form-control" placeholder=" " aria-label="Search by Company Name...">&nbsp;&nbsp;
            <div class="input-group-append">
                <a href="form.php" class="btn btn-info btn-custom-add-record">✚&nbsp;Add Record</a>
            </div>
        </div>
        <div class="input-group" style="display: flex; align-items: center; width: 100%;">
            <label for="recordsPerPage" class="form-control col-sm-1" style="margin: 0; width: 100px;">Show:</label>
            <select id="recordsPerPage" class="form-control col-sm-1" style="width: 100px;" onchange="changeRecordsPerPage()">
                <?php for ($value = 5; $value <= 100; $value += 5): ?>
                    <option value="<?php echo $value; ?>" <?php echo $recordsPerPage == $value ? 'selected' : ''; ?>><?php echo $value; ?></option>
                <?php endfor; ?>
            </select>
            <nav aria-label="Page navigation" style="margin-left: 20px;">
                <ul class="pagination justify-content-center" style="margin: 0;">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&recordsPerPage=<?php echo $recordsPerPage; ?>">↞</a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $maxPagesToShow = 5;
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($totalPages, $startPage + $maxPagesToShow - 1);

                    if ($endPage - $startPage < $maxPagesToShow - 1) {
                        $startPage = max(1, $endPage - $maxPagesToShow + 1);
                    }

                    for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?php echo $i === $currentPage ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&recordsPerPage=<?php echo $recordsPerPage; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($endPage < $totalPages): ?>
                        <li class="page-item">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $totalPages; ?>&recordsPerPage=<?php echo $recordsPerPage; ?>"><?php echo $totalPages; ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&recordsPerPage=<?php echo $recordsPerPage; ?>">↠</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="input-group-append ml-auto" style="margin-left: auto;">
                <button class="btn btn-primary" data-toggle="modal" data-target="#idRangeModal" style="border-radius: 2px;">Select Export</button>
                <form action="export.php" method="POST">
                    <button class="btn btn-danger" name="export_all" value="1" type="submit" style="border-radius: 2px;">Export All to PDF</button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered supplier-table">
                <thead>
                    <tr>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>ID</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(0)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Company&nbsp;Name&nbsp;/&nbsp;</span>
                                <span>Irrigator's&nbsp;Association </span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(1)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Company&nbsp;Owner&nbsp;/&nbsp;</span>
                                <span>IA&nbsp;President&nbsp;/&nbsp;</span>
                                <span>Treasurer</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(2)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Company&nbsp;Address</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(3)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>TIN</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(4)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Tax&nbsp;Type</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(5)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Mobile&nbsp;Number</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(6)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Telephone&nbsp;Number</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(7)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Email&nbsp;Address</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(8)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Authorized&nbsp;Representative</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(9)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Auth&nbsp;Letter</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(10)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>ID&nbsp;Presented</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(11)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>SPA</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(12)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Created&nbsp;At</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(13)">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Actions</span>
                                <button class="btn btn-link btn-sort btn-action">▾</button>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody id="supplierTableBody">
                    <?php foreach ($suppliersToShow as $supplier): ?>
                        <tr>
                            <td><?php echo escape($supplier['id']); ?></td>
                            <td class="edit-btn"
                                data-id="<?php echo escape($supplier['id']); ?>"
                                data-name="<?php echo escape($supplier['company_name']); ?>"
                                data-owner="<?php echo escape($supplier['company_owner']); ?>"
                                data-address="<?php echo escape($supplier['company_address']); ?>"
                                data-tin="<?php echo escape($supplier['tin']); ?>"
                                data-tax-type="<?php echo escape($supplier['tax_type']); ?>"
                                data-mobile="<?php echo escape($supplier['mobile_number']); ?>"
                                data-telephone="<?php echo escape($supplier['telephone_number']); ?>"
                                data-email="<?php echo escape($supplier['email_address']); ?>"
                                data-representative="<?php echo escape($supplier['authorized_representative']); ?>"
                                data-authletter="<?php echo $supplier['authletter']; ?>"
                                data-id-presented="<?php echo escape($supplier['id_presented']); ?>"
                                data-spa="<?php echo $supplier['spa']; ?>" style="cursor: pointer; text-decoration: underline; color: blue;">
                                <?php echo escape($supplier['company_name']); ?>
                            </td>
                            <td><?php echo escape($supplier['company_owner']); ?></td>
                            <td><?php echo escape($supplier['company_address']); ?></td>
                            <td><?php echo escape($supplier['tin']); ?></td>
                            <td><?php echo escape($supplier['tax_type']); ?></td>
                            <td><?php echo escape($supplier['mobile_number']); ?></td>
                            <td><?php echo escape($supplier['telephone_number']); ?></td>
                            <td><?php echo escape($supplier['email_address']); ?></td>
                            <td><?php echo escape($supplier['authorized_representative']); ?></td>
                            <td><?php echo $supplier['authletter'] === 'Yes' ? 'Yes' : ''; ?></td>
                            <td><?php echo escape($supplier['id_presented']); ?></td>
                            <td><?php echo $supplier['spa'] === 'Yes' ? 'Yes' : ''; ?></td>
                            <td><?php echo (new DateTime($supplier['created_at']))->format('F d, Y H:i:s'); ?></td>
                            <td>
                                <button class="btn btn-secondary btn-sm edit-btn"
                                    data-id="<?php echo escape($supplier['id']); ?>"
                                    data-name="<?php echo escape($supplier['company_name']); ?>"
                                    data-owner="<?php echo escape($supplier['company_owner']); ?>"
                                    data-address="<?php echo escape($supplier['company_address']); ?>"
                                    data-tin="<?php echo escape($supplier['tin']); ?>"
                                    data-tax-type="<?php echo escape($supplier['tax_type']); ?>"
                                    data-mobile="<?php echo escape($supplier['mobile_number']); ?>"
                                    data-telephone="<?php echo escape($supplier['telephone_number']); ?>"
                                    data-email="<?php echo escape($supplier['email_address']); ?>"
                                    data-representative="<?php echo escape($supplier['authorized_representative']); ?>"
                                    data-authletter="<?php echo $supplier['authletter']; ?>"
                                    data-id-presented="<?php echo escape($supplier['id_presented']); ?>"
                                    data-spa="<?php echo $supplier['spa']; ?>">Edit</button>

                                <form action="delete.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                    <input type="hidden" name="id" value="<?php echo escape($supplier['id']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="showMessage('Record deleted successfully!', 'danger');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br>
        <nav aria-label="Page navigation" style="margin-left: 20px;">
            <ul class="pagination justify-content-center" style="margin: 0;">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&recordsPerPage=<?php echo $recordsPerPage; ?>">↞</a>
                    </li>
                <?php endif; ?>

                <?php
                $maxPagesToShow = 5;
                $startPage = max(1, $currentPage - 2);
                $endPage = min($totalPages, $startPage + $maxPagesToShow - 1);

                if ($endPage - $startPage < $maxPagesToShow - 1) {
                    $startPage = max(1, $endPage - $maxPagesToShow + 1);
                }

                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?php echo $i === $currentPage ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&recordsPerPage=<?php echo $recordsPerPage; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($endPage < $totalPages): ?>
                    <li class="page-item">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $totalPages; ?>&recordsPerPage=<?php echo $recordsPerPage; ?>"><?php echo $totalPages; ?></a>
                    </li>
                <?php endif; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&recordsPerPage=<?php echo $recordsPerPage; ?>">↠</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <!-- Export Modal -->
    <form action="export.php" method="POST">
        <div class="modal fade" id="idRangeModal" tabindex="-1" role="dialog" aria-labelledby="idRangeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="idRangeModalLabel">Enter ID Range</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="idRangeForm" action="export.php" method="POST">
                            <div class="form-group">
                                <label for="startId">Start ID</label>
                                <input type="number" class="form-control" id="startId" name="start_id" required>
                            </div>
                            <div class="form-group">
                                <label for="endId">End ID</label>
                                <input type="number" class="form-control" id="endId" name="end_id" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Export</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">EDITING ID <span id="editingId"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="record_update.php" method="POST">
                        <input type="hidden" name="id" id="editId">
                        <div class="form-group">
                            <label for="editCompanyName">Company Name</label>
                            <input type="text" class="form-control" id="editCompanyName" name="company_name" required>
                        </div>
                        <div class="form-group">
                            <label for="editCompanyOwner">Company Owner</label>
                            <input type="text" class="form-control" id="editCompanyOwner" name="company_owner" required>
                        </div>
                        <div class="form-group">
                            <label for="editCompanyAddress">Company Address</label>
                            <input type="text" class="form-control" id="editCompanyAddress" name="company_address" required>
                        </div>
                        <div class="form-group">
                            <label for="editTIN">TIN</label>
                            <input type="text" id="editTIN" class="form-control" name="tin" maxlength="17" oninput="formatTIN(this)">
                        </div>
                        <div class="form-group">
                            <label for="editTaxType">Tax Type</label>
                            <select class="form-control" id="editTaxType" name="tax_type">
                                <option value="">Select Tax Type</option>
                                <option value="VAT Registered">VAT Registered</option>
                                <option value="Non-VAT Registered">Non-VAT Registered</option>
                                <option value="Vat Exempted">Vat Exempted</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editMobileNumber">Mobile Number</label>
                            <input type="text" id="editMobileNumber" class="form-control" name="mobile_number" maxlength="14" oninput="formatMobileNumber(this)">
                        </div>
                        <div class="form-group">
                            <label for="editTelephoneNumber">Telephone Number</label>
                            <input type="text" class="form-control" id="editTelephoneNumber" name="telephone_number">
                        </div>
                        <div class="form-group">
                            <label for="editEmailAddress">Email Address</label>
                            <input type="email" class="form-control" id="editEmailAddress" name="email_address">
                        </div>
                        <div class="form-group">
                            <label for="editAuthorizedRepresentative">Authorized Representative</label>
                            <input type="text" class="form-control" id="editAuthorizedRepresentative" name="authorized_representative">
                        </div>
                        <div class="form-group">
                            <label for="editAuthLetter">Auth Letter</label>
                            <select class="form-control" id="editAuthLetter" name="authletter">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editIdPresented">ID Presented</label>
                            <input type="text" class="form-control" id="editIdPresented" name="id_presented">
                        </div>
                        <div class="form-group">
                            <label for="editSPA">SPA</label>
                            <select class="form-control" id="editSPA" name="spa">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Edit Button
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const supplierId = this.getAttribute('data-id');
                const supplierName = this.getAttribute('data-name');
                const supplierOwner = this.getAttribute('data-owner');
                const supplierAddress = this.getAttribute('data-address');
                const supplierTin = this.getAttribute('data-tin');
                const supplierTaxType = this.getAttribute('data-tax-type');
                const supplierMobile = this.getAttribute('data-mobile');
                const supplierTelephone = this.getAttribute('data-telephone');
                const supplierEmail = this.getAttribute('data-email');
                const supplierRepresentative = this.getAttribute('data-representative');
                const supplierAuthLetter = this.getAttribute('data-authletter');
                const supplierIdPresented = this.getAttribute('data-id-presented');
                const supplierSPA = this.getAttribute('data-spa');

                document.getElementById('editId').value = supplierId;
                document.getElementById('editingId').textContent = supplierId;
                document.getElementById('editCompanyName').value = supplierName;
                document.getElementById('editCompanyOwner').value = supplierOwner;
                document.getElementById('editCompanyAddress').value = supplierAddress;
                document.getElementById('editTIN').value = supplierTin;
                document.getElementById('editTaxType').value = supplierTaxType;
                document.getElementById('editMobileNumber').value = supplierMobile;
                document.getElementById('editTelephoneNumber').value = supplierTelephone;
                document.getElementById('editEmailAddress').value = supplierEmail;
                document.getElementById('editAuthorizedRepresentative').value = supplierRepresentative;
                document.getElementById('editAuthLetter').value = supplierAuthLetter;
                document.getElementById('editIdPresented').value = supplierIdPresented;
                document.getElementById('editSPA').value = supplierSPA;

                $('#editModal').modal('show');
            });
        });

        // Validation for TIN and Mobile Number
        function validateForm() {
            const tinInput = document.querySelector('input[name="tin"]');
            const mobileInput = document.querySelector('input[name="mobile_number"]');

            let isValid = true;

            // TIN validation
            if (tinInput.value && tinInput.value.replace(/-/g, '').length !== 12) {
                tinInput.classList.add('is-invalid');
                isValid = false;
            } else {
                tinInput.classList.remove('is-invalid');
            }

            // Mobile Number
            const mobileValue = mobileInput.value.replace(/\s/g, ''); // Remove spaces for length check
            if (mobileValue && (mobileValue.length !== 11 || isNaN(mobileValue))) {
                mobileInput.classList.add('is-invalid');
                isValid = false;
            } else {
                mobileInput.classList.remove('is-invalid');
            }

            return isValid;
        }

        // Format for TIN and Mobile Number
        function formatTIN(input) {
            let value = input.value.replace(/\D/g, '').slice(0, 15);

            let formattedValue = '';
            if (value.length > 0) formattedValue += value.substring(0, 3);
            if (value.length > 3) formattedValue += '-' + value.substring(3, 6);
            if (value.length > 6) formattedValue += '-' + value.substring(6, 9);
            if (value.length > 9) formattedValue += '-' + value.substring(9, 14);

            input.value = formattedValue.trim();

            if (value.length < 9) {
                input.setCustomValidity('Please enter eat least 9 digits.');
            } else {
                input.setCustomValidity('');
            }
        }

        function formatMobileNumber(input) {
            let value = input.value.replace(/\D/g, '').slice(0, 11);

            let formattedValue = '';
            if (value.length > 0) formattedValue += value.substring(0, 4);
            if (value.length > 4) formattedValue += ' ' + value.substring(4, 7);
            if (value.length > 7) formattedValue += ' ' + value.substring(7, 11);

            input.value = formattedValue.trim();
        }

        // Searching
        document.getElementById('search').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#supplierTableBody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let rowContainsFilter = false;

                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(filter)) {
                        rowContainsFilter = true;
                    }
                });

                row.style.display = rowContainsFilter ? '' : 'none';
            });
        });

        // Sorting
        function sortTable(columnIndex) {
            const table = document.querySelector('.supplier-table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            const isAscending = tbody.dataset.sortDirection === 'asc';
            tbody.dataset.sortDirection = isAscending ? 'desc' : 'asc';

            rows.sort((rowA, rowB) => {
                const cellB = rowA.children[columnIndex].innerText.trim();
                const cellA = rowB.children[columnIndex].innerText.trim();

                const numA = parseFloat(cellA);
                const numB = parseFloat(cellB);

                if (cellA === '' && cellB === '') return 0;
                if (cellA === '') return isAscending ? 1 : -1;
                if (cellB === '') return isAscending ? -1 : 1;

                if (!isNaN(numA) && !isNaN(numB)) {
                    return isAscending ? numA - numB : numB - numA;
                }

                if (cellA < cellB) return isAscending ? -1 : 1;
                if (cellA > cellB) return isAscending ? 1 : -1;
                return 0;
            });

            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));

            updateSortButtons(columnIndex, isAscending);
        }

        function updateSortButtons(activeIndex, isAscending) {
            const sortButtons = document.querySelectorAll('.btn-sort');
            sortButtons.forEach((button, index) => {
                if (index === activeIndex) {
                    button.innerHTML = isAscending ? '▾' : '▴';
                } else {
                    button.innerHTML = '▾';
                }
            });
        }

        function changeRecordsPerPage() {
            const recordsPerPage = document.getElementById('recordsPerPage').value;
            const currentPage = <?php echo $currentPage; ?>;
            window.location.href = `?page=${currentPage}&recordsPerPage=${recordsPerPage}`;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>