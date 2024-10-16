<?php
include 'fetch_data.php';

// Pagination logic
$recordsPerPage = 10;
$totalRecords = count($suppliers);
$totalPages = ceil($totalRecords / $recordsPerPage);
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($currentPage < 1) {
    $currentPage = 1;
} elseif ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

$startRecord = ($currentPage - 1) * $recordsPerPage;
$suppliersToShow = array_slice($suppliers, $startRecord, $recordsPerPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="records.css">
</head>

<body>

    <div class="sidebar">
        <div style="display: flex; flex-direction: row; align-items: center;">
            <img src="images/crs-logo.png" alt="Logo">
            <h2 class="text-left">│CLAIMANTS │RECORD │SYSTEM</h2>
        </div>
        <br>
        <div class="list-group">
            <a href="home.php" class="list-group-item list-group-item-action">🏡&nbsp;&nbsp;&nbsp;Home</a>
            <a href="#" class="list-group-item list-group-item-action active">📋&nbsp;&nbsp;&nbsp;List of Records</a>
        </div>
        <a href="login.php" class="list-group-item list-group-item-action text-danger logout">Logout</a>
    </div>

    <div class="content">
        <br>
        <h1 class="header">SUPPLIER'S OVERALL RECORDS</h1>
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="search" class="col-sm-4 form-control" placeholder=" " aria-label="Search by Company Name...">&nbsp;&nbsp;
            <div class="input-group-append">
                <a href="form.php" class="btn btn-info btn-custom-add-record">✚&nbsp;Add Record</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered supplier-table">
                <thead>
                    <tr>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>ID</span>
                                <button class="btn btn-link btn-sort" id="sortID">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Company&nbsp;Name</span>
                                <button class="btn btn-link btn-sort" id="sortCompanyName">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Company&nbsp;Owner</span>
                                <button class="btn btn-link btn-sort" id="sortCompanyOwner">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Company&nbsp;Address</span>
                                <button class="btn btn-link btn-sort" id="sortCompanyAddress">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>TIN</span>
                                <button class="btn btn-link btn-sort" id="sortTIN">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Tax&nbsp;Type</span>
                                <button class="btn btn-link btn-sort" id="sortTax">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Mobile&nbsp;Number</span>
                                <button class="btn btn-link btn-sort" id="sortMobileNumber">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Telephone&nbsp;Number</span>
                                <button class="btn btn-link btn-sort" id="sortTelephoneNumber">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Email&nbsp;Address</span>
                                <button class="btn btn-link btn-sort" id="sortEmailAddress">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Authorized&nbsp;Representative</span>
                                <button class="btn btn-link btn-sort" id="sortAuthorizedRepresentative">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Auth&nbsp;Letter</span>
                                <button class="btn btn-link btn-sort" id="">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>ID&nbsp;Presented</span>
                                <button class="btn btn-link btn-sort" id="sortIDPresented">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>SPA</span>
                                <button class="btn btn-link btn-sort" id="">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Created&nbsp;At</span>
                                <button class="btn btn-link btn-sort" id="sortCreatedAt">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Actions</span>
                                <button class="btn btn-link btn-sort btn-action" id="">▾</button>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody id="supplierTableBody">
                    <?php foreach ($suppliersToShow as $supplier): ?>
                        <tr>
                            <td><?php echo $supplier['id']; ?></td>
                            <td><?php echo $supplier['company_name']; ?></td>
                            <td><?php echo $supplier['company_owner']; ?></td>
                            <td><?php echo $supplier['company_address']; ?></td>
                            <td><?php echo $supplier['tin']; ?></td>
                            <td><?php echo $supplier['tax_type']; ?></td>
                            <td><?php echo $supplier['mobile_number']; ?></td>
                            <td><?php echo $supplier['telephone_number']; ?></td>
                            <td><?php echo $supplier['email_address']; ?></td>
                            <td><?php echo $supplier['authorized_representative']; ?></td>
                            <td><?php echo $supplier['authletter'] === 'Yes' ? 'Yes' : ''; ?></td>
                            <td><?php echo $supplier['id_presented']; ?></td>
                            <td><?php echo $supplier['spa'] === 'Yes' ? 'Yes' : ''; ?></td>
                            <td><?php echo (new DateTime($supplier['created_at']))->format('F d, Y H:i:s'); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="<?php echo $supplier['id']; ?>">Edit</button>
                                <form action="delete.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $supplier['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo $i === $currentPage ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <script>
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
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>