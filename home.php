<?php
include 'fetch_data.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="home.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="sidebar">
        <div style="display: flex; flex-direction: row; align-items: center;">
            <img src="images/crs-logo.png" alt="Logo">
            <h2 class="text-left">│CLAIMANTS │RECORD │SYSTEM</h2>
        </div>
        <br>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action active">🏡&nbsp;&nbsp;&nbsp;Home</a>
            <a href="records.php" class="list-group-item list-group-item-action">📋&nbsp;&nbsp;&nbsp;List of Records</a>
        </div>
        <a href="login.php" class="list-group-item list-group-item-action text-danger logout">Logout</a>
    </div>

    <div class="content">
        <h1 class="header">DASHBOARD</h1>
        <div class="row">
            <div class="col-md-6">
                <canvas id="overallCountChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="companyNamesChart"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11">
                <canvas id="recordsOverTimeChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const suppliers = <?php echo json_encode($suppliers); ?>;
        const monthlyCounts = <?php echo json_encode($monthlyCounts); ?>;

        const monthLabels = Object.keys(monthlyCounts).sort((a, b) => new Date(a) - new Date(b));
        const monthData = monthLabels.map(label => monthlyCounts[label]);

        // First Chart
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

        // Second Chart
        const companyNames = suppliers.map(supplier => supplier.company_name);
        const companyCounts = {};
        companyNames.forEach(name => companyCounts[name] = (companyCounts[name] || 0) + 1);
        const companyLabels = Object.keys(companyCounts);
        const companyData = Object.values(companyCounts);

        const ctx2 = document.getElementById('companyNamesChart').getContext('2d');
        const companyNamesChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: companyLabels,
                datasets: [{
                    label: 'Total Suppliers for One Company',
                    data: companyData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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

        // Third Chart
        const createdAtCounts = {};
        suppliers.forEach(supplier => {
            const date = new Date(supplier.created_at);
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = date.toLocaleDateString('en-US', options);
            const label = `${supplier.company_name} - ${formattedDate}`;
            createdAtCounts[label] = (createdAtCounts[label] || 0) + 1;
        });

        const recordLabels = Object.keys(createdAtCounts);
        const recordData = Object.values(createdAtCounts);

        const ctx3 = document.getElementById('recordsOverTimeChart').getContext('2d');
        const recordsOverTimeChart = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: recordLabels,
                datasets: [{
                    label: 'Date of Added Records',
                    data: recordData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: true
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