<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirect kung hindi naka-login
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claimants Information Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            text-align: center;
            margin: 50px;
            background-color: #f8f8f8;
            color: #333;
            font-family: 'Cambria', serif;
        }

        h1 {
            color: #4caf50;
        }

        h2 {
            font-size: 55px;
            font-weight: bold;
        }

        h3 {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: 10px auto;
        }

        th,
        td {
            padding: 10px;
            border: 2px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #71f79f;
            color: white;
        }

        .headinput {
            width: 34%;
        }

        .tabhead {
            color: black;
        }

        .tabheader {
            height: 70px;
        }

        .rbutton {
            width: 15px;
        }

        .invalid-feedback {
            display: none;
        }

        .is-invalid+.invalid-feedback {
            display: block;
        }

        .btn-custom-add-record,
        .btn-custom-exit {
            width: 250px;
            height: 40px;
            border-radius: 10px;
            background-color: transparent;
            color: black;
            border-color: black;
        }

        .text-right {
            text-align: right;
        }

        .tborder {
            border: 0px;
        }

    </style>
</head>
<h2 class="mb-4" style="text-align: center;">CLAIMANT'S INFORMATION FORM</h2><br>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
    <table class="tborder">
        <tr class="tabheader">
            <th class="tabhead">Company Name / Irrigator's Association *</th>
            <th class="tabhead">Company Owner / IA President / Treasurer *</th>
            <th class="tabhead">Company Address *</th>
        </tr>
        <tr>
            <td class="headinput">
                <input type="text" class="form-control" name="company_name" required>
            </td>
            <td class="headinput">
                <input type="text" class="form-control" name="company_owner" required>
            </td>
            <td class="headinput">
                <input type="text" class="form-control" name="company_address" required>
            </td>
        </tr>
    </table>

    <table class="tborder">
        <tr class="tabheader">
            <th class="tabhead">Tax Identification Number(TIN)</th>
            <th class="tabhead">Mobile Number</th>
            <th class="tabhead">Tax Type</th>
        </tr>
        <tr>
            <td class="headinput">
                <input type="text" class="form-control" name="tin" maxlength="17" oninput="formatTIN(this)">
            </td>
            <td class="headinput">
                <input type="text" class="form-control" name="mobile_number" maxlength="14" oninput="formatMobileNumber(this)">
            </td>
            <td class="headinput">
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input rbutton" type="radio" name="tax_type" value="VAT Registered">
                        <label class="form-check-label ftype">VAT Registered</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input rbutton" type="radio" name="tax_type" value="Non-VAT Registered">
                        <label class="form-check-label ftype">Non-VAT Registered</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input rbutton" type="radio" name="tax_type" value="VAT Exempted">
                        <label class="form-check-label ftype">VAT Exempted</label>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="tborder">
        <tr class="tabheader">
            <th class="tabhead">E-mail Address</th>
            <th class="tabhead">Telephone Number</th>
            <th class="tabhead">ID Presented</th>
        </tr>
        <tr>
            <td class="headinput">
                <input type="email" class="form-control" name="email_address">
            </td>
            <td class="headinput">
                <input type="text" class="form-control" name="telephone_number">
            </td>
            <td>
                <div class="form-group row">&nbsp;&nbsp;&nbsp;&nbsp;
                    <select class="form-control col-sm-5" id="idSelect" name="id_presented" onchange="toggleOtherInput()">
                        <option value="">Select ID...</option>
                        <option value="Barangay Clearance">Barangay Clearance</option>
                        <option value="Company ID">Company ID</option>
                        <option value="Driver`s License">Driver`s License</option>
                        <option value="Government Employee`s ID">Government Employee`s ID</option>
                        <option value="GSIS ID">GSIS ID</option>
                        <option value="NBI Clearance">NBI Clearance</option>
                        <option value="PhilHealth ID">PhilHealth ID</option>
                        <option value="Philippine Identification Card">Philippine Identification Card</option>
                        <option value="Philippine Passport">Philippine Passport</option>
                        <option value="PRC ID">PRC ID</option>
                        <option value="Police Clearance">Police Clearance</option>
                        <option value="Postal ID">Postal ID</option>
                        <option value="PWD ID">PWD ID</option>
                        <option value="School ID">School ID</option>
                        <option value="Senior Citizen ID">Senior Citizen ID</option>
                        <option value="SSS ID">SSS ID</option>
                        <option value="Tax Identification Number (TIN) ID">Tax Identification Number (TIN) ID</option>
                        <option value="Unified Multi-Purpose ID (UMID)">Unified Multi-Purpose ID (UMID)</option>
                        <option value="Voter`s ID">Voter`s ID</option>
                        <option value="others">Others (please specify)</option>
                    </select>
                    <input type="text" class="col-sm-5 form-control mt" id="otherIdInput" name="other_id_presented" style="display:none;" placeholder="Specify ID">
                    <div class="col-sm-8 form-group row" id="idNumberField" style="display:none;">
                        <label class="col-sm-8 col-form-label form-label">ID Number</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="idNumberInput" name="id_number" placeholder="Enter ID Number">
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="tborder">
        <tr class="tabheader">
            <th class="tabhead">Company Authorized Representative</th>
            <th class="tabhead">For Company Authorized Representative :</th>
        </tr>
        <tr>
            <td class="headinput">
                <input type="text" class="form-control" name="authorized_representative">
            </td>
            <td class="headinput">
                <div class="form-group row align-items-center">
                    <div class="col-sm-8">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="authletter" value="Yes">
                            <label class="form-check-label form-label">With Authorization Letter</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="spa" value="Yes">
                            <label class="form-check-label form-label">With Notarized Special Power of Attorney (SPA)</label>
                            <small class="form-text form-label text-muted">Suppliers with transaction above Php 50,000.00</small>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="text-center">
        <button type="submit" class="btn btn-info btn-custom-add-record">✚&nbsp;Add Record</button>
    </div>
</form><br>
<form action="records.php" class="text-right" method="get">
    <button type="submit" class="btn btn-danger btn-custom-exit">▶&nbsp;EXIT</button>
</form><br><br>

<!-- Modal -->
<div class="modal fade" id="submissionModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Submitted Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody"></div>
        </div>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'claimants_db.php';

    $company_name = htmlspecialchars($_POST['company_name']);
    $company_owner = htmlspecialchars($_POST['company_owner']);
    $company_address = htmlspecialchars($_POST['company_address']);
    $tin = htmlspecialchars($_POST['tin']);
    $mobile_number = htmlspecialchars($_POST['mobile_number']);
    $telephone_number = htmlspecialchars($_POST['telephone_number']);
    $email_address = htmlspecialchars($_POST['email_address']);
    $authorized_representative = htmlspecialchars($_POST['authorized_representative']);
    $tax_type = isset($_POST['tax_type']) ? htmlspecialchars($_POST['tax_type']) : '';
    $authletter = isset($_POST['authletter']) ? 'Yes' : NULL;
    $spa = isset($_POST['spa']) ? 'Yes' : NULL;

    // Get ID Type
    $id_presented = htmlspecialchars($_POST['id_presented']);
    if ($id_presented === 'others') {
        $id_presented = htmlspecialchars($_POST['other_id_presented']);
    }
    $id_number = htmlspecialchars($_POST['id_number']);
    $id_presented_full = $id_presented . ' ' . $id_number;

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO crs_table (company_name, company_owner, company_address, tin, tax_type, mobile_number, telephone_number, email_address, authorized_representative, authletter, id_presented, spa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "ssssssssssss",
        $company_name,
        $company_owner,
        $company_address,
        $tin,
        $tax_type,
        $mobile_number,
        $telephone_number,
        $email_address,
        $authorized_representative,
        $authletter,
        $id_presented_full,
        $spa
    );

    if ($stmt->execute()) {
        $modalContent = "<p>Company Name: $company_name</p><p>ID Presented: $id_presented_full</p><p>Tax Type: $tax_type</p>";

        echo "<script>
                alert('Record added successfully!');
                document.getElementById('modalBody').innerHTML = '$modalContent';
                $('#submissionModal').modal('show');
                setTimeout(function() {
                    $('#submissionModal').modal('hide');
                }, 2000);
            </script>";
    } else {
        echo "<script>alert('Error adding record: " . $stmt->error . "');</script>";
    }
}
?>

<script>
    function toggleOtherInput() {
        const select = document.getElementById('idSelect');
        const otherInput = document.getElementById('otherIdInput');
        const idNumberField = document.getElementById('idNumberField');

        if (select.value === 'others') {
            otherInput.style.display = 'block';
            otherInput.focus();
            idNumberField.style.display = 'block';
        } else if (select.value) {
            otherInput.style.display = 'none';
            idNumberField.style.display = 'block';
        } else {
            otherInput.style.display = 'none';
            idNumberField.style.display = 'none';
        }
    }

    function formatTIN(input) {
        let value = input.value.replace(/\D/g, '').slice(0, 15);

        let formattedValue = '';
        if (value.length > 0) formattedValue += value.substring(0, 3);
        if (value.length > 3) formattedValue += '-' + value.substring(3, 6);
        if (value.length > 6) formattedValue += '-' + value.substring(6, 9);
        if (value.length > 9) formattedValue += '-' + value.substring(9, 14);

        input.value = formattedValue.trim();

        if (value.length < 9) {
            input.setCustomValidity('Please enter at least 9 digits.');
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
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>