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
$sql = "SELECT inbound.id, inbound.status, files.name, files.description, files.date_updated, folder.file_name
FROM fms_g14_inbound as inbound
INNER JOIN fms_g14_files as files ON inbound.files_id = files.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
WHERE files.user_id = ?";

$stmt = mysqli_prepare($con, $sql);

// Bind parameters
mysqli_stmt_bind_param($stmt, "i", $userId);

// Execute the statement
mysqli_stmt_execute($stmt);

// Bind result variables
mysqli_stmt_bind_result($stmt, $id, $status, $name, $description, $dateUpdated, $folder);

// Fetch the data and store it in an array
$records = array();
while (mysqli_stmt_fetch($stmt)) {
    $records[] = array(
        'id' => $id,
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
    <title>Request Upload</title>
</head>

<body>
    <!-- Sidebar -->
    <?php include '../config/userSidebar.php'?>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <?php include '../config/userHeader.php'?>
        <main>
            <div class="header">
                <div class="left">
                    <h1>Request Upload</h1>
                </div>
                <!-- <a href="#" class="report">
                    <i class='bx bx-cloud-download'></i>
                    <span>Download CSV</span>
                </a> -->
            </div>

            <!-- table for all request either accepted or declined -->
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>List of Request</h3>
                        <button class="btn btn-primary" onclick="openAddFileModal()">Upload New File</button>
                    </div>
                    <table id="request-table">
                        <thead>
                            <tr>
                                <th>File name</th>
                                <th>Folder Name</th>
                                <th>Requested Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $record): ?>
                                <tr>
                                    <td><?php echo pathinfo($record['name'], PATHINFO_FILENAME); ?></td>
                                    <td><?php echo $record['file_name']; ?></td>
                                    <td><?php echo $record['date_updated']; ?></td>
                                    <td><?php echo $record['status']; ?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>

                    </table>
                </div>
            </div>

        </main>

    </div>

    <!-- Include addFolderModal.php which is modal for adding new user-->
    <?php include '../modal/addFileModal.php'?>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- this is for interactive table: pagination, search bar and show entries -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#request-table').DataTable({
                "paging": true, // Enable pagination
                "pageLength": 5 // Set number of entries per page
            });
        });

        function openAddFileModal() {
            $('#addFileModal').modal('show');
        }

        $(document).ready(function() {
    // Check for success message in URL query parameters
    const urlParams = new URLSearchParams(window.location.search);
    const uploadSuccess = urlParams.get('upload_success');
    const uploadError = urlParams.get('upload_error');

    // If upload was successful, display success modal
    if (uploadSuccess) {
        $('#successModal').modal('show');
    }

    // If there was an error, display error modal with error message
    if (uploadError) {
        $('#errorModal').find('.modal-body').text(uploadError);
        $('#errorModal').modal('show');
    }
});

    </script>

    <!-- dashboard javascript -->
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>