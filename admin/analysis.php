<?php

include '../config/db.php';
session_start();

// Check if the user is logged in and if the user ID is set in the session
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
} else {
    // Redirect to login page or handle unauthorized access
    header("Location: ../login.php");
    exit(); // Stop further execution
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <title>Analytics</title>
</head>

<body>
    <!-- Sidebar -->
    <?php include '../config/sidebar.php'?>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <?php include '../config/header.php'?>
        <main>
            <div class="header">
                    <div class="left">
                            <h1>Analytics</h1>
                        </div>
                </div>

                <!-- shows the bar graph -->
            <div class="bottom-data">
            <div class="orders">
                <div class="header">
                    <i class='bx bx-receipt'></i>
                    <h3>Data Report</h3>
                    <i class='bx bx-filter'></i>
                    <i class='bx bx-search'></i>
                </div>
                <!-- Bar Graph -->
                <div class="bar-graph">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

                <!-- shows the pue graph -->
                <div class="reminders">
                    <div class="header">
                        <i class='bx bx-note'></i>
                        <h3>Reminders</h3>
                        <i class='bx bx-filter'></i>
                        <i class='bx bx-plus'></i>
                    </div>
                     <!-- Pie Graph -->
                    <div class="pie-graph">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

        </main>

    </div>

    <!-- This is to use the chart.js library using CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- This is the dashboard.js, for changing theme -->
    <script src="../js/dashboard.js"></script>

    <!-- Configuration of chart to include data report. Plotting sa chart -->
    <script>
        // Bar Chart
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [{
                    label: 'Inbound Request',
                    data: [0, 0, 0, 0, 0],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
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

        // Pie Chart
        var ctx2 = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Completed', 'Pending', 'Processing'],
                datasets: [{
                    label: 'Orders Status',
                    data: [10, 20, 30],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
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
</body>

</html>
