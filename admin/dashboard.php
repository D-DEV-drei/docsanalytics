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

// SQL query to fetch the count of inbound requests with status 'pending'
$sqlInboundPending = "SELECT COUNT(*) AS pending_count FROM fms_g14_inbound WHERE status = 'pending'";
$resultInboundPending = mysqli_query($con, $sqlInboundPending);
$inboundPendingCount = 0; // Default value
if ($resultInboundPending) {
    $rowInboundPending = mysqli_fetch_assoc($resultInboundPending);
    $inboundPendingCount = $rowInboundPending['pending_count']; // Get the count of pending inbound requests
}

// SQL query to fetch the count of outbound requests with status 'pending'
$sqlOutboundPending = "SELECT COUNT(*) AS pending_count FROM fms_g14_outbound WHERE status = 'pending'";
$resultOutboundPending = mysqli_query($con, $sqlOutboundPending);
$outboundPendingCount = 0; // Default value
if ($resultOutboundPending) {
    $rowOutboundPending = mysqli_fetch_assoc($resultOutboundPending);
    $outboundPendingCount = $rowOutboundPending['pending_count']; // Get the count of pending outbound requests
}

// SQL query to fetch the count of inbound requests with status 'accepted'
$sqlInboundAccepted = "SELECT COUNT(*) AS accepted_count FROM fms_g14_inbound WHERE status = 'accepted'";
$resultInboundAccepted = mysqli_query($con, $sqlInboundAccepted);
$inboundAcceptedCount = 0; // Default value
if ($resultInboundAccepted) {
    $rowInboundAccepted = mysqli_fetch_assoc($resultInboundAccepted);
    $inboundAcceptedCount = $rowInboundAccepted['accepted_count']; // Get the count of accepted inbound requests
}

// SQL query to fetch the count of outbound requests with status 'accepted'
$sqlOutboundAccepted = "SELECT COUNT(*) AS accepted_count FROM fms_g14_outbound WHERE status = 'accepted'";
$resultOutboundAccepted = mysqli_query($con, $sqlOutboundAccepted);
$outboundAcceptedCount = 0; // Default value
if ($resultOutboundAccepted) {
    $rowOutboundAccepted = mysqli_fetch_assoc($resultOutboundAccepted);
    $outboundAcceptedCount = $rowOutboundAccepted['accepted_count']; // Get the count of accepted outbound requests
}

// SQL query to fetch the count of inbound requests with status 'declined'
$sqlInboundDeclined = "SELECT COUNT(*) AS declined_count FROM fms_g14_inbound WHERE status = 'declined'";
$resultInboundDeclined = mysqli_query($con, $sqlInboundDeclined);
$inboundDeclinedCount = 0; // Default value
if ($resultInboundDeclined) {
    $rowInboundDeclined = mysqli_fetch_assoc($resultInboundDeclined);
    $inboundDeclinedCount = $rowInboundDeclined['declined_count']; // Get the count of declined inbound requests
}

// SQL query to fetch the count of outbound requests with status 'declined'
$sqlOutboundDeclined = "SELECT COUNT(*) AS declined_count FROM fms_g14_outbound WHERE status = 'declined'";
$resultOutboundDeclined = mysqli_query($con, $sqlOutboundDeclined);
$outboundDeclinedCount = 0; // Default value
if ($resultOutboundDeclined) {
    $rowOutboundDeclined = mysqli_fetch_assoc($resultOutboundDeclined);
    $outboundDeclinedCount = $rowOutboundDeclined['declined_count']; // Get the count of declined outbound requests
}

$sqlInboundMonthly = "SELECT folder.file_name, COUNT(*) AS request_count
FROM fms_g14_inbound AS inbound
JOIN fms_g14_files AS files ON inbound.files_id = files.id
JOIN fms_g14_folder AS folder ON files.folder_id = folder.id
where folder.active = 0
GROUP BY folder.file_name;
";

$resultInboundMonthly = mysqli_query($con, $sqlInboundMonthly);

// Initialize array to store inbound request data
$inboundMonthlyData = array();

// Fetch and store data in the array
while ($row = mysqli_fetch_assoc($resultInboundMonthly)) {
    $folderName = $row['file_name'];
    $requestCount = $row['request_count'];
    $inboundMonthlyData[$folderName] = $requestCount;
}

$sqlOutboundMonthly = "SELECT folder.file_name, COUNT(*) AS request_count
FROM fms_g14_outbound AS o
INNER JOIN fms_g14_files as files ON o.files_id = files.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
GROUP BY folder.file_name";

$resultOutboundMonthly = mysqli_query($con, $sqlOutboundMonthly);

// Initialize array to store outbound request data
$outboundMonthlyData = array();

while ($row = mysqli_fetch_assoc($resultOutboundMonthly)) {
    $folderName = $row['file_name'];
    $requestCount = $row['request_count'];
    $outboundMonthlyData[$folderName] = $requestCount;
}
$totalRequests = $inboundAcceptedCount + $inboundPendingCount + $outboundPendingCount + $outboundAcceptedCount + $inboundDeclinedCount + $outboundDeclinedCount;
// Check if $totalRequests is zero
if ($totalRequests != 0) {
    $pendingPercentage = ($inboundPendingCount + $outboundPendingCount) / ($totalRequests) * 100;
    $acceptedPercentage = ($inboundAcceptedCount + $outboundAcceptedCount) / ($totalRequests) * 100;
    $declinedPercentage = ($inboundDeclinedCount + $outboundDeclinedCount) / ($totalRequests) * 100;
} else {
    // Set percentages to zero if no data is available
    $pendingPercentage = 0;
    $acceptedPercentage = 0;
    $declinedPercentage = 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="icon" type="image/png" href="kargada.png">
    <title>Dashboard</title>
</head>

<body>

    <!-- Sidebar -->
    <?php include '../config/sidebar.php'?>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <?php include '../config/header.php'?>

        <!-- main content -->
        <main>
            <div class="header">
                <div class="left">
                        <h1>Dashboard</h1>
                    </div>
            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                    <i class='bx bx-upload'></i>
                    <span class="info">
                        <h3>
                        <?php echo $inboundPendingCount; ?> <!-- Print the count of pending inbound requests here -->
                        </h3>
                        <p>Inbound Request</p>
                    </span>
                </li>
                <li><i class='bx bx-download'></i>
                    <span class="info">
                        <h3>
                        <?php echo $outboundPendingCount; ?> <!-- Print the count of pending outbound requests here -->
                        </h3>
                        <p>Outbound Request</p>
                    </span>
                </li>
                <li><i class='bx bx-check'></i>
                    <span class="info">
                        <h3><?php echo $inboundAcceptedCount + $outboundAcceptedCount; ?></h3>
                        <p>Accepted</p>
                    </span>
                </li>
                <li><i class='bx bx-x'></i>
                    <span class="info">
                        <h3><?php echo $inboundDeclinedCount + $outboundDeclinedCount; ?></h3>
                        <p>Declined</p>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->

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
                        <h3>Request</h3>
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
    <!-- Configuration of chart to include data report. Plotting sa chart -->
    <script>
        // Bar Chart
        var ctx = document.getElementById('barChart').getContext('2d');
var barChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_keys($inboundMonthlyData)); ?>, // Use file names as labels

        datasets: [{
            label: 'Inbound',
            data: <?php echo json_encode(array_values($inboundMonthlyData)); ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.2)', // Pink color for inbound
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        },
        {
            label: 'Outbound',
            data: <?php echo json_encode(array_values($outboundMonthlyData)); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Blue color for outbound
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 10 // Set the step size to 10
                }
            }
        },
        plugins: {
            legend: {
                display: true, // Display the legend
                labels: {
                    fontColor: 'black' // Set legend label color to black
                }
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
                    <?php echo $pendingPercentage; ?>, // Total pending requests percentage
                    <?php echo $acceptedPercentage; ?>, // Total accepted requests percentage
                    <?php echo $declinedPercentage; ?> // Total declined requests percentage
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
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        var label = context.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += context.parsed.toFixed(2) + '%';
                        return label;
                    }
                }
            }
        }
    }
});

    </script>

</body>

</html>
