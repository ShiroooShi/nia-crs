<?php
include 'fetch_data.php';

// Pagination logic
$recordsPerPage = 10;
$totalRecords = count($suppliers);
$totalPages = ceil($totalRecords / $recordsPerPage);
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$currentPage = max(1, min($currentPage, $totalPages)); // Ensure current page is within bounds

$startRecord = ($currentPage - 1) * $recordsPerPage;
$suppliersToShow = array_slice($suppliers, $startRecord, $recordsPerPage);

// Function to escape output
function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
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

        <div id="message" class="alert" style="display:none; position: absolute; left: 50%; transform: translateX(-50%); top: 20%; z-index: 1000; width: 300px; text-align: center;"></div>

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
                                <button class="btn btn-link btn-sort" id="">▾</button>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>ID&nbsp;Presented</span>
                                <button class="btn btn-link btn-sort" onclick="sortTable(10)">▾</button>
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
                                <button class="btn btn-link btn-sort" onclick="sortTable(11)">▾</button>
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
                            <td><?php echo escape($supplier['id']); ?></td>
                            <td><?php echo escape($supplier['company_name']); ?></td>
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
                            <input type="text" class="form-control" id="editTIN" name="tin">
                        </div>
                        <div class="form-group">
                            <label for="editTaxType">Tax Type</label>
                            <select class="form-control" id="editTaxType" name="tax_type">
                                <option value="">Select Tax Type</option>
                                <option value="VAT Registered">VAT Registered</option>
                                <option value="Non-VAT Registered">Non-VAT Registered</option>
                                <option value="Zero Rated">Zero Rated</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editMobileNumber">Mobile Number</label>
                            <input type="text" class="form-control" id="editMobileNumber" name="mobile_number">
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
                        <button type="submit" class="btn btn-primary">Update Record</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Show message function
        function showMessage(text, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = text;
            messageDiv.className = 'alert alert-' + type; // Add appropriate Bootstrap class
            messageDiv.style.display = 'block'; // Show the message

            // Hide the message after 3 seconds
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 3000);
        }

        // Handle Edit button clicks
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
    </script>

</body>

</html>