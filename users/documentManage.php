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
$sql = "SELECT o.id, o.status, o.created_at, files.name, files.description, files.file_path, folder.file_name
FROM fms_g14_outbound as o
INNER JOIN fms_g14_files as files ON o.files_id = files.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
WHERE files.user_id = ?";

$stmt = mysqli_prepare($con, $sql);

// Bind parameters
mysqli_stmt_bind_param($stmt, "i", $userId);

// Execute the statement
mysqli_stmt_execute($stmt);

// Bind result variables
mysqli_stmt_bind_result($stmt, $id, $status, $dateUpdated, $name, $description, $path, $folder);

// Fetch the data and store it in an array
$records = array();
while (mysqli_stmt_fetch($stmt)) {
    $records[] = array(
        'id' => $id,
        'status' => $status,
        'name' => $name,
        'description' => $description,
        'file_path' => $path,
        'created_at' => $dateUpdated,
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
    <title>Document Management</title>

    <style>
        .disabled-link {
            pointer-events: none !important; /* Disable pointer events */
            opacity: 0.5 !important; /* Reduce opacity to visually indicate disabled state */
        }

    </style>
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
                            <h1>Document Management</h1>

                        </div>
                </div>

                <!-- table for all files that are permitted to access -->
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>List of Access Files</h3>
                        <button class="btn btn-primary" onclick="openRequestModal()">Request Access</button>
                    </div>
                    <table id='request-table'>
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Folder Name</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($records as $record): ?>
    <tr>
        <td><?php echo $record['name']; ?></td>
        <td><?php echo $record['description']; ?></td>
        <td><?php echo $record['created_at']; ?></td>
        <td>
            <button class="status" style="background-color: <?php echo $record['status'] === 'Accepted' ? 'green' : ($record['status'] === 'Pending' ? 'gray' : 'red'); ?>;"><?php echo $record['status']; ?></button>
        </td>
        <td>
    <!-- Icon for view -->
    <?php if ($record['status'] !== 'Pending' && $record['status'] !== 'Declined'): ?>
        <a href="<?php echo $record['file_path']; ?>" target="_blank" onclick="updateViewCount(<?php echo $record['id']; ?>)">
            <i class='bx bx-show'></i>
        </a>
    <?php else: ?>
        <i class='bx bx-show disabled-link'></i>
    <?php endif;?>

    <!-- Icon for download -->
    <?php if ($record['status'] !== 'Pending' && $record['status'] !== 'Declined'): ?>
        <a href="<?php echo $record['file_path']; ?>" onclick="updateDownloadCount(<?php echo $record['id']; ?>)">
            <i class='bx bx-download'></i>
        </a>
    <?php else: ?>
        <i class='bx bx-download disabled-link'></i>
    <?php endif;?>
</td>

    </tr>
<?php endforeach;?>


                        </tbody>
                    </table>
                </div>
            </div>
        </main>

    </div>

    <?php include '../modal/addRequestModal.php'?>

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

        function openRequestModal() {
            $('#addRequestModal').modal('show');
        }
    </script>

<script>
    function updateViewCount(id) {
        $.ajax({
            url: 'updateViewCount.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                // Optionally, you can update the view count display on the page
                console.log('View count updated');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function updateDownloadCount(id) {
        $.ajax({
            url: 'updateDownloadCount.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                // Optionally, you can update the download count display on the page
                console.log('Download count updated');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>


    <!-- dashboard javascript -->
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>
