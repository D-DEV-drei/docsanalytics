<?php
session_start();
include '../config/db.php';

// Check if the user is logged in and get their ID
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
} else {
    // Redirect to login page or handle unauthorized access
    header("Location: ../login.php");
    exit(); // Stop further execution
}

// Retrieve data from the reports table
$sql = "SELECT sr.id as shared_id, r.id, r.report_name, r.report_description, r.created_at, r.include_access, r.include_users, r.include_downloads, r.include_uploads, u.username
FROM fms_g14_reports AS r
inner join fms_g14_shared_report AS sr on sr.report_id = r.id
inner join fms_g14_users as u on sr.user_id = u.id"; // Assuming you want to retrieve all reports
$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Bind result variables
    mysqli_stmt_bind_result($stmt, $sid, $id, $report_name, $description, $created_at, $include_access, $include_users, $include_downloads, $include_uploads, $username);

    // Initialize an empty array to store the fetched reports
    $reports = array();

    // Fetch data
    while (mysqli_stmt_fetch($stmt)) {
        // Store each report in the array
        $reports[] = array(
            'shared_id' => $sid,
            'id' => $id,
            'report_name' => $report_name,
            'report_description' => $description,
            'created_at' => $created_at,
            'include_access' => $include_access,
            'include_users' => $include_users,
            'include_downloads' => $include_downloads,
            'include_uploads' => $include_uploads,
            'username' => $username,
        );
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Handle errors
    echo "Error: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <title>Shared Report</title>
</head>

<style>
            .dropdown-toggle-no-caret::after {
                display: none !important;
                }
        </style>

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
                    <h1>Report</h1>
                </div>
            </div>

            <!-- table of archived document -->
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>List of Shared Report</h3>
                    </div>
                    <table id="report-table">
                        <thead>
                            <tr>
                                <th>Report Name</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Shared to</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reports as $report): ?>
                                <tr>
                                    <td><?php echo $report['report_name']; ?></td>
                                    <td><?php echo $report['report_description']; ?></td>
                                    <td><?php echo $report['created_at']; ?></td>
                                    <td><?php echo $report['username']; ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <span class="dropdown-toggle dropdown-toggle-no-caret" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class='bx bx-dots-vertical-rounded'></i>
                                            </span>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item delete-report" href="delete_report.php?id=<?php echo $report['shared_id']; ?>">Delete</a>
                                                <a class="dropdown-item" href="create_report.php?id=<?php echo $report['id']; ?>">View</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <?php include '../modal/createReportModal.php'?>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- this is for interactive table: pagination, search bar and show entries -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#report-table').DataTable({
                "paging": true, // Enable pagination
                "pageLength": 5 // Set number of entries per page
            });
        });

        function openCreateReportModal() {
            $('#addReportModal').modal('show');
        }

    </script>

<script>
    $(document).ready(function() {
    // Event listener for clicking the delete report option
    $('.delete-report').click(function(e) {
        e.preventDefault(); // Prevent the default action (i.e., following the link)

        // Get the report ID from the URL query parameter
        var reportId = $(this).attr('href').split('=')[1];
        console.log("reportId: ", reportId)
        // Confirm with the user before deleting the report
        if (confirm("Are you sure you want to delete this report?")) {
            // If the user confirms, perform the deletion via AJAX
            $.ajax({
                url: 'delete_report.php', // URL to the PHP script handling the deletion
                method: 'POST',
                data: { id: reportId }, // Send the report ID to the PHP script
                success: function(response) {
                    // Reload the page after successful deletion
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error("Error deleting report:", error);
                }
            });
        }
    });
});

</script>


    <!-- dashboard javascript -->
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>

