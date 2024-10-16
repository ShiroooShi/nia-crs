<?php
include 'fetch_data.php';
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
                    <?php foreach ($suppliers as $supplier): ?>
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
                            <td><?php echo $supplier['authletter']; ?></td>
                            <td><?php echo $supplier['id_presented']; ?></td>
                            <td><?php echo $supplier['spa']; ?></td>
                            <td>
                                <?php
                                $date = new DateTime($supplier['created_at']);
                                echo $date->format('F d, Y H:i:s');
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="<?php echo $supplier['id']; ?>" data-company-name="<?php echo $supplier['company_name']; ?>" data-company-owner="<?php echo $supplier['company_owner']; ?>" data-company-address="<?php echo $supplier['company_address']; ?>" data-tin="<?php echo $supplier['tin']; ?>" data-tax-type="<?php echo $supplier['tax_type']; ?>" data-mobile-number="<?php echo $supplier['mobile_number']; ?>" data-telephone-number="<?php echo $supplier['telephone_number']; ?>" data-email-address="<?php echo $supplier['email_address']; ?>" data-authorized-representative="<?php echo $supplier['authorized_representative']; ?>" data-authletter="<?php echo $supplier['authletter']; ?>" data-id-presented="<?php echo $supplier['id_presented']; ?>" data-spa="<?php echo $supplier['spa']; ?>">Edit</button>
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" action="update_supplier.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="supplierId">
                        <div class="form-group">
                            <label for="companyName">Company Name</label>
                            <input type="text" class="form-control" name="company_name" id="companyName" required>
                        </div>
                        <div class="form-group">
                            <label for="companyOwner">Company Owner</label>
                            <input type="text" class="form-control" name="company_owner" id="companyOwner" required>
                        </div>
                        <div class="form-group">
                            <label for="companyAddress">Company Address</label>
                            <input type="text" class="form-control" name="company_address" id="companyAddress" required>
                        </div>
                        <div class="form-group">
                            <label for="tin">TIN</label>
                            <input type="text" class="form-control" name="tin" id="tin" required>
                        </div>
                        <div class="form-group">
                            <label for="taxType">Tax Type</label>
                            <input type="text" class="form-control" name="tax_type" id="taxType" required>
                        </div>
                        <div class="form-group">
                            <label for="mobileNumber">Mobile Number</label>
                            <input type="text" class="form-control" name="mobile_number" id="mobileNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="telephoneNumber">Telephone Number</label>
                            <input type="text" class="form-control" name="telephone_number" id="telephoneNumber">
                        </div>
                        <div class="form-group">
                            <label for="emailAddress">Email Address</label>
                            <input type="email" class="form-control" name="email_address" id="emailAddress">
                        </div>
                        <div class="form-group">
                            <label for="authorizedRepresentative">Authorized Representative</label>
                            <input type="text" class="form-control" name="authorized_representative" id="authorizedRepresentative">
                        </div>
                        <div class="form-group">
                            <label for="authLetter">Auth Letter</label>
                            <input type="text" class="form-control" name="authletter" id="authLetter">
                        </div>
                        <div class="form-group">
                            <label for="idPresented">ID Presented</label>
                            <input type="text" class="form-control" name="id_presented" id="idPresented">
                        </div>
                        <div class="form-group">
                            <label for="spa">SPA</label>
                            <input type="text" class="form-control" name="spa" id="spa">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
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

        let originalRows = Array.from(document.querySelectorAll('#supplierTableBody tr'));
        let sortOrder = Array(14).fill(false); // Updated to 14 for tax_type

        function sortTable(columnIndex) {
            const rows = Array.from(document.querySelectorAll('#supplierTableBody tr'));
            const order = sortOrder[columnIndex];

            rows.sort((b, a) => {
                const cellA = a.cells[columnIndex].textContent.toLowerCase();
                const cellB = b.cells[columnIndex].textContent.toLowerCase();

                if (!isNaN(cellA) && !isNaN(cellB)) {
                    return order ? cellA - cellB : cellB - cellA;
                }
                return order ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
            });

            const tableBody = document.getElementById('supplierTableBody');
            tableBody.innerHTML = '';
            rows.forEach(row => tableBody.appendChild(row));
            sortOrder[columnIndex] = !order;
        }

        document.getElementById('sortID').addEventListener('click', function() {
            sortTable(0);
            this.textContent = sortOrder[0] ? '▴' : '▾';
        });

        document.getElementById('sortCompanyName').addEventListener('click', function() {
            sortTable(1);
            this.textContent = sortOrder[1] ? '▴' : '▾';
        });

        document.getElementById('sortCompanyOwner').addEventListener('click', function() {
            sortTable(2);
            this.textContent = sortOrder[2] ? '▴' : '▾';
        });

        document.getElementById('sortCompanyAddress').addEventListener('click', function() {
            sortTable(3);
            this.textContent = sortOrder[3] ? '▴' : '▾';
        });

        document.getElementById('sortTIN').addEventListener('click', function() {
            sortTable(4);
            this.textContent = sortOrder[4] ? '▴' : '▾';
        });

        document.getElementById('sortTaxType').addEventListener('click', function() {
            sortTable(5);
            this.textContent = sortOrder[5] ? '▴' : '▾';
        });

        document.getElementById('sortMobileNumber').addEventListener('click', function() {
            sortTable(6);
            this.textContent = sortOrder[6] ? '▴' : '▾';
        });

        document.getElementById('sortTelephoneNumber').addEventListener('click', function() {
            sortTable(7);
            this.textContent = sortOrder[7] ? '▴' : '▾';
        });

        document.getElementById('sortEmailAddress').addEventListener('click', function() {
            sortTable(8);
            this.textContent = sortOrder[8] ? '▴' : '▾';
        });

        document.getElementById('sortAuthorizedRepresentative').addEventListener('click', function() {
            sortTable(9);
            this.textContent = sortOrder[9] ? '▴' : '▾';
        });

        document.getElementById('sortIDPresented').addEventListener('click', function() {
            sortTable(10);
            this.textContent = sortOrder[10] ? '▴' : '▾';
        });

        document.getElementById('sortCreatedAt').addEventListener('click', function() {
            sortTable(11);
            this.textContent = sortOrder[11] ? '▴' : '▾';
        });

        // Handle the click event for the Edit buttons
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const companyName = button.getAttribute('data-company-name');
                const companyOwner = button.getAttribute('data-company-owner');
                const companyAddress = button.getAttribute('data-company-address');
                const tin = button.getAttribute('data-tin');
                const taxType = button.getAttribute('data-tax-type'); // New line
                const mobileNumber = button.getAttribute('data-mobile-number');
                const telephoneNumber = button.getAttribute('data-telephone-number');
                const emailAddress = button.getAttribute('data-email-address');
                const authorizedRepresentative = button.getAttribute('data-authorized-representative');
                const authLetter = button.getAttribute('data-authletter');
                const idPresented = button.getAttribute('data-id-presented');
                const spa = button.getAttribute('data-spa');

                document.getElementById('supplierId').value = id;
                document.getElementById('companyName').value = companyName;
                document.getElementById('companyOwner').value = companyOwner;
                document.getElementById('companyAddress').value = companyAddress;
                document.getElementById('tin').value = tin;
                document.getElementById('taxType').value = taxType; // New line
                document.getElementById('mobileNumber').value = mobileNumber;
                document.getElementById('telephoneNumber').value = telephoneNumber;
                document.getElementById('emailAddress').value = emailAddress;
                document.getElementById('authorizedRepresentative').value = authorizedRepresentative;
                document.getElementById('authLetter').value = authLetter;
                document.getElementById('idPresented').value = idPresented;
                document.getElementById('spa').value = spa;

                $('#editModal').modal('show');
            });
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>