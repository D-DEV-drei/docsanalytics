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

// Prepare a SELECT statement with inner join and user ID condition
$sql = "SELECT inbound.status, files.name, files.description, files.date_updated, folder.file_name
FROM fms_g14_inbound as inbound
INNER JOIN fms_g14_files as files ON inbound.files_id = files.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id WHERE status = 'Declined' || status = 'Expired' || files.active = 1";

$stmt = mysqli_prepare($con, $sql);

// Execute the statement
mysqli_stmt_execute($stmt);

// Bind result variables
mysqli_stmt_bind_result($stmt, $status, $name, $description, $dateUpdated, $folder);

// Fetch the data and store it in an array
$records = array();
while (mysqli_stmt_fetch($stmt)) {
    $records[] = array(
        'status' => $status,
        'name' => $name,
        'description' => $description,
        'date_updated' => $dateUpdated,
        'file_name' => $folder,

    );
}

// Close the statement
mysqli_stmt_close($stmt);

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
    <title>Archive Management</title>
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
                            <h1>Archive Management</h1>

                        </div>
                </div>

                <!-- table of archived document -->
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>List of Archive</h3>
                    </div>
                    <table id="request-table">
                        <thead>
                            <tr>
                                <th>File name</th>
                                <th>Folder Name</th>
                                <th>Requested Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $record): ?>
                                <tr>
                                    <td><?php echo $record['name']; ?></td>
                                    <td><?php echo $record['file_name']; ?></td>
                                    <td><?php echo $record['date_updated']; ?></td>
                                    <td><?php echo $record['status']; ?></td>
                                    <td>
                                        <button class="btn btn-warning restore-btn" data-file="<?php echo $record['name']; ?>" data-status="<?php echo $record['status']; ?>">
                                            <i class='bx bxs-archive'></i>
                                        </button>
                                    </td>

                                </tr>
                            <?php endforeach;?>
                        </tbody>

                    </table>
                </div>
            </div>
        </main>

    </div>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


    <!-- this is for interactive table: pagination, search bar and show entries -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('.restore-btn').click(function() {
            var fileName = $(this).data('file');
            var currentStatus = $(this).data('status');
            var newStatus = '';

            // Determine the new status based on the current status
            switch (currentStatus) {
                case 'Declined':
                    newStatus = 'Pending';
                    break;
                case 'Expired':
                    newStatus = 'Accepted';
                    break;
                case 'Deleted':
                    newStatus = 'Accepted';
                    break;
                default:
                    break;
            }

            // Send an AJAX request to update the status
            $.ajax({
                url: 'restore.php', // Replace with the file handling the update
                type: 'POST',
                data: { fileName: fileName, newStatus: newStatus },
                success: function(response) {
                    // Handle the response if needed
                    alert('Status updated successfully!');
                    // Reload the page or update the UI as required
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle errors if any
                    console.error(error);
                    alert('Error updating status. Please try again later.');
                }
            });
        });

        $('#request-table').DataTable({
            "paging": true,
            "pageLength": 5
        });
    });

    </script>

    <!-- dashboard javascript -->
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>
