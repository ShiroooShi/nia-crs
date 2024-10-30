<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'fetch_data.php';

$query = "SELECT COUNT(*) AS total FROM crs_table";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$overallCount = $row['total'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            display: flex;
            margin: 0;
            padding: 0;
            height: 100vh;
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

        .sidebar h2 {
            color: black;
            text-align: center;
            font-family: "Cambria", sans-serif;
            font-weight: bold;
            padding: 20px 0;
            font-size: 27px;
        }

        .sidebar img {
            width: 100px;
            vertical-align: middle;
        }

        .separator {
            margin: 0 10px;
            font-size: 30px;
        }

        .sidebar a {
            color: black;
            text-decoration: none;
            font-family: "Cambria", sans-serif;
            font-size: 20px;
            background-color: transparent;
            border-color: transparent;
            border-radius: 5px;
        }

        .content {
            flex-grow: 1;
            margin-left: 280px;
            padding: 30px;
            overflow-y: auto;
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
            font-family: "Cambria", sans-serif;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .canvas {
            max-width: 100%;
            max-height: 300px;
            margin: auto;
        }

        .row {
            margin-bottom: 40px;
        }

        .card-title {
            font-size: 20px;
            font-family: "Cambria", sans-serif;
            font-weight: 500;
        }

        .cart-text {
            font-family: "Cambria", sans-serif;
            font-weight: bold;
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
            <a href="#" class="list-group-item list-group-item-action active">🏡&nbsp;&nbsp;&nbsp;Home</a>
            <a href="records.php" class="list-group-item list-group-item-action">📋&nbsp;&nbsp;&nbsp;List of Records</a>
        </div>
        <a href="logout.php" class="list-group-item list-group-item-action text-danger logout">Logout</a>
    </div>

    <div class="content"><br>
        <h1 class="header">DASHBOARD</h1>
        <br>
        <div class="row mb-20">
            <div class="col-md-4 d-flex justify-content-center">
                <div class="card border-default shadow" style="width: 80%;">
                    <br>
                    <div class="card-body text-center">
                        <h5 class="card-title">Overall Records</h5>
                        <h5 class="card-text" id="overallCount" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                            <?php echo $overallCount; ?><br><br>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <div class="card border-default shadow" style="width: 80%;">
                    <div class="card-body text-center">
                        <br>
                        <h5 class="card-title">With Authorized Letter</h5>
                        <h5 class="card-text" id="autletterCount" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                            <?php echo $autletterCount; ?><br><br>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <div class="card border-default shadow" style="width: 80%;">
                    <div class="card-body text-center">
                        <br>
                        <h5 class="card-title">With Notarized (SPA)</h5>
                        <h5 class="card-text" id="spaCount" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                            <?php echo $spaCount; ?><br><br>
                        </h5>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-6">
                <canvas id="overallCountChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="countAuthletterAndSPA"></canvas>
            </div>
        </div>

    </div>

    <script>
        const suppliers = <?php echo json_encode($suppliers); ?>;
        const monthlyCounts = <?php echo json_encode($monthlyCounts); ?>;

        const monthLabels = Object.keys(monthlyCounts).sort((a, b) => new Date(a) - new Date(b));
        const monthData = monthLabels.map(label => monthlyCounts[label]);

        // 1st Chart
        const ctx1 = document.getElementById('overallCountChart').getContext('2d');
        const overallCountChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Overall Records Added Per Month',
                    data: monthData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 2nd Chart
        const ctx2 = document.getElementById('countAuthletterAndSPA').getContext('2d');
        const countAuthletterAndSPAChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['With Authorization Letter', 'With Notarized SPA'],
                datasets: [{
                    label: 'Count',
                    data: [<?php echo $autletterCount; ?>, <?php echo $spaCount; ?>],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>