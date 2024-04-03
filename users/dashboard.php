<?php
session_start();
include '../config/db.php';

// Check if the user is logged in and if the user ID is set in the session
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
} else {
    // Redirect to login page or handle unauthorized access
    header("Location: ../login.php");
    exit(); // Stop further execution
}

// SQL query to fetch the count of inbound requests with status 'pending' for the current user
$sqlInboundPending = "SELECT COUNT(*) AS pending_count
FROM fms_g14_inbound as inbound
INNER JOIN fms_g14_files as files ON inbound.files_id = files.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
WHERE files.user_id = '$userId' AND inbound.status = 'Pending'";
$resultInboundPending = mysqli_query($con, $sqlInboundPending);
$inboundPendingCount = 0; // Default value
if ($resultInboundPending) {
    $rowInboundPending = mysqli_fetch_assoc($resultInboundPending);
    $inboundPendingCount = $rowInboundPending['pending_count']; // Get the count of pending inbound requests
}

// SQL query to fetch the count of outbound requests with status 'pending' for the current user
$sqlOutboundPending = "SELECT COUNT(*) AS pending_count
FROM fms_g14_outbound as o
INNER JOIN fms_g14_files as files ON o.files_id = files.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
WHERE files.user_id = '$userId' AND o.status = 'Pending'";
$resultOutboundPending = mysqli_query($con, $sqlOutboundPending);
$OutboundPendingCount = 0; // Default value
if ($resultOutboundPending) {
    $rowOutboundPending = mysqli_fetch_assoc($resultOutboundPending);
    $OutboundPendingCount = $rowOutboundPending['pending_count']; // Get the count of pending Outbound requests
}

// SQL query to fetch the count of accepted inbound requests for the current user
$sqlInboundAccepted = "SELECT COUNT(*) AS accepted_count
FROM fms_g14_inbound as inbound
INNER JOIN fms_g14_files as files ON inbound.files_id = files.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
WHERE files.user_id = '$userId' AND inbound.status = 'Accepted'";
$resultInboundAccepted = mysqli_query($con, $sqlInboundAccepted);
$inboundAcceptedCount = 0; // Default value
if ($resultInboundAccepted) {
    $rowInboundAccepted = mysqli_fetch_assoc($resultInboundAccepted);
    $inboundAcceptedCount = $rowInboundAccepted['accepted_count']; // Get the count of accepted inbound requests
}

// SQL query to fetch the count of accepted outbound requests for the current user
$sqlOutboundAccepted = "SELECT COUNT(*) AS accepted_count
FROM fms_g14_outbound as o
INNER JOIN fms_g14_files as files ON o.files_id = files.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
WHERE files.user_id = '$userId' AND o.status = 'Accepted'";
$resultOutboundAccepted = mysqli_query($con, $sqlOutboundAccepted);
$outboundAcceptedCount = 0; // Default value
if ($resultOutboundAccepted) {
    $rowOutboundAccepted = mysqli_fetch_assoc($resultOutboundAccepted);
    $outboundAcceptedCount = $rowOutboundAccepted['accepted_count']; // Get the count of accepted outbound requests
}

// SQL query to fetch the count of declined inbound requests for the current user
$sqlInboundDeclined = "SELECT COUNT(*) AS decline_count
FROM fms_g14_inbound as inbound
INNER JOIN fms_g14_files as files ON inbound.files_id = files.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
WHERE files.user_id = '$userId' AND inbound.status = 'Declined'";
$resultInboundDeclined = mysqli_query($con, $sqlInboundDeclined);
$inboundDeclinedCount = 0; // Default value
if ($resultInboundDeclined) {
    $rowInboundDeclined = mysqli_fetch_assoc($resultInboundDeclined);
    $inboundDeclinedCount = $rowInboundDeclined['decline_count']; // Get the count of declined inbound requests
}

// SQL query to fetch the count of declined outbound requests for the current user
$sqlOutboundDeclined = "SELECT COUNT(*) AS decline_count
FROM fms_g14_outbound as o
INNER JOIN fms_g14_files as files ON o.files_id = files.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
WHERE files.user_id = '$userId' AND o.status = 'Declined'";
$resultOutboundDeclined = mysqli_query($con, $sqlOutboundDeclined);
$outboundDeclinedCount = 0; // Default value
if ($resultOutboundDeclined) {
    $rowOutboundDeclined = mysqli_fetch_assoc($resultOutboundDeclined);
    $outboundDeclinedCount = $rowOutboundDeclined['decline_count']; // Get the count of Declined outbound requests
}

// Calculate total inbound and outbound requests
$totalInbound = $inboundPendingCount + $inboundAcceptedCount + $inboundDeclinedCount;
$totalOutbound = $OutboundPendingCount + $outboundAcceptedCount + $outboundDeclinedCount;

// SQL query to fetch the count of inbound requests per month and year based on date_updated
$sqlInboundMonthly = "SELECT MONTH(files.date_updated) AS month, YEAR(files.date_updated) AS year, COUNT(*) AS request_count
                     FROM fms_g14_inbound as inbound
                     INNER JOIN fms_g14_files as files ON inbound.files_id = files.id
                     INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
                     WHERE files.user_id = '$userId'
                     GROUP BY YEAR(files.date_updated), MONTH(files.date_updated)";

$resultInboundMonthly = mysqli_query($con, $sqlInboundMonthly);

// Initialize array to store inbound request data
$inboundMonthlyData = array_fill(1, 12, 0); // Assuming data is for 12 months

// Fetch and store data in the array
// Fetch and store data in the array
while ($row = mysqli_fetch_assoc($resultInboundMonthly)) {
    $month = $row['month'];
    $year = $row['year'];
    $requestCount = $row['request_count'];
    $index = $month; // Adjust index to represent months from 0 to 11

    $inboundMonthlyData[$index] = $requestCount;
}

// SQL query to fetch the count of outbound requests per month and year based on created_at
$sqlOutboundMonthly = "SELECT MONTH(o.created_at) AS month, YEAR(o.created_at) AS year, COUNT(*) AS request_count
FROM fms_g14_outbound AS o
INNER JOIN fms_g14_files as files ON o.files_id = files.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
WHERE files.user_id = '$userId'
GROUP BY YEAR(o.created_at), MONTH(o.created_at)";

$resultOutboundMonthly = mysqli_query($con, $sqlOutboundMonthly);

// Initialize array to store outbound request data
$outboundMonthlyData = array_fill(1, 12, 0); // Assuming data is for 12 months

// Fetch and store data in the array
while ($row = mysqli_fetch_assoc($resultOutboundMonthly)) {
    $month = $row['month'];
    $year = $row['year'];
    $requestCount = $row['request_count'];
    $index = $month; // Adjust index to represent months from 0 to 11
    $outboundMonthlyData[$index] = $requestCount;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <title>Dashboard</title>
</head>

<body>

    <!-- Sidebar -->
    <?php include '../config/userSidebar.php'?>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <?php include '../config/userHeader.php'?>

        <!-- content -->
        <main>
            <div class="header">
                <div class="left">
                        <h1>Dashboard</h1>
                    </div>
            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                    <i class='bx bx-time'></i>
                    <span class="info">
                        <h3>
                        <?php echo $inboundPendingCount > 0 ? $inboundPendingCount : 0; ?>
                        </h3>
                        <p>Pending Request</p>
                    </span>
                </li>
                <li><i class='bx bx-key'></i>
                    <span class="info">
                        <h3>
                        <?php echo ($outboundAcceptedCount == 0) ? '0' : $outboundAcceptedCount; ?>
                        </h3>
                        <p>Access Files</p>
                    </span>
                </li>
                <li><i class='bx bx-check'></i>
                    <span class="info">
                        <h3>
                        <?php echo ($inboundAcceptedCount + $outboundAcceptedCount) > 0 ? $inboundAcceptedCount + $outboundAcceptedCount : 0; ?>
                        </h3>
                        <p>Accepted</p>
                    </span>
                </li>
                <li><i class='bx bx-x'></i>
                    <span class="info">
                        <h3>
                        <?php echo ($inboundDeclinedCount + $outboundDeclinedCount) > 0 ? $inboundDeclinedCount + $outboundDeclinedCount : 0; ?>
                        </h3>
                        <p>Declined</p>
                    </span>
                </li>
            </ul>

            <!-- Data Report -->
            <div class="bottom-data">
            <div class="orders">
                <div class="header">
                    <i class='bx bx-receipt'></i>
                    <h3>Data Report</h3>
                </div>
                <!-- Bar Graph -->
                <div class="bar-graph">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

                <div class="reminders">
                    <div class="header">
                        <i class='bx bx-note'></i>
                        <h3>Reminders</h3>
                    </div>
                     <!-- Pie Graph -->
                    <div class="pie-graph">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
                <!-- End of Reminders-->
            </div>

        </main>

    </div>

    <!-- This is to use the chart.js library using CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- This is the dashboard.js, for changing theme -->
    <script src="../assets/js/dashboard.js"></script>
    <!-- Configuration of chart to include data -->
    <script>
        // Bar Chart
        var ctx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ],
            datasets: [{
                label: 'Inbound Requests',
                data: <?php echo json_encode(array_values($inboundMonthlyData)); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Outbound Requests',
                data: <?php echo json_encode(array_values($outboundMonthlyData)); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
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
        labels: ['Pending', 'Accepted', 'Declined'], // Labels for different request statuses
        datasets: [{
            label: 'Request',
            data: [
                <?php echo $inboundPendingCount; ?>, // Total pending inbound requests
                <?php echo $inboundAcceptedCount; ?> + <?php echo $outboundAcceptedCount; ?>, // Total accepted requests (inbound + outbound)
                <?php echo $inboundDeclinedCount; ?> + <?php echo $outboundDeclinedCount; ?> // Total declined requests (inbound + outbound)
            ],
            backgroundColor: [
                'rgba(255, 206, 86, 0.2)', // Color for pending requests
                'rgba(75, 192, 192, 0.2)', // Color for accepted requests
                'rgba(255, 99, 132, 0.2)' // Color for declined requests
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)', // Border color for pending requests
                'rgba(75, 192, 192, 1)', // Border color for accepted requests
                'rgba(255, 99, 132, 1)' // Border color for declined requests
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
