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

// Fetch folder names from the database
$sqlFolders = "SELECT file_name FROM fms_g14_folder";
$resultFolders = mysqli_query($con, $sqlFolders);

// Check if the query was successful
if (!$resultFolders) {
    // Handle the error (e.g., display an error message or log the error)
    echo "Error: " . mysqli_error($con);
} else {
    // Fetch folder names and store them in an array
    $folders = array();
    while ($row = mysqli_fetch_assoc($resultFolders)) {
        $folders[] = $row['file_name'];
    }
}

// Prepare a SELECT statement to fetch the required columns
$sql = "SELECT o.id, o.status, o.created_at, fl.name, fl.description, u.username, folder.file_name
FROM fms_g14_outbound as o
INNER JOIN fms_g14_files as fl ON o.files_id = fl.id
INNER JOIN fms_g14_users as u ON fl.user_id = u.id
INNER JOIN fms_g14_folder as folder ON fl.folder_id = folder.id";

$stmt = mysqli_prepare($con, $sql);

// Execute the statement
mysqli_stmt_execute($stmt);

// Bind result variables
mysqli_stmt_bind_result($stmt, $fileid, $status, $date_updated, $name, $description, $username, $folder);

// Fetch the data and store it in an array
$files = array();
while (mysqli_stmt_fetch($stmt)) {
    $files[] = array(
        'id' => $fileid,
        'status' => $status,
        'created_at' => $date_updated,
        'name' => $name,
        'description' => $description,
        'username' => $username,
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
    <title>Outbound Request</title>
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
                    <h1>Outbound Request</h1>
                </div>
            </div>

            <!-- table for outbound request -->
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>List of Request</h3>
                        <div class="filters">
                        <select id="folder-name-filter">
                            <option value="" selected disabled>Select folder</option>
                            <?php foreach ($folders as $folder): ?>
                                <?php $selected = ($folder === $defaultFolder) ? 'selected' : '';?>
                                <option value="<?php echo $folder; ?>" <?php echo $selected; ?>><?php echo $folder; ?></option>
                            <?php endforeach;?>
                        </select>

                        <!-- <select id="status-filter">
                            <option value="" disabled>Filter by Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Accepted">Accepted</option>
                            <option value="Declined">Declined</option>
                        </select> -->
                    </div>
                    </div>
                    <table id="request-table">
                        <thead>
                            <tr>
                                <th>File name</th>
                                <th>Description</th>
                                <th>Folder</th>
                                <th>Requested Date</th>
                                <th>Requester</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($files as $file): ?>
                                <tr>
                                    <td><?php echo $file['name']; ?></td>
                                    <td><?php echo $file['description']; ?></td>
                                    <td><?php echo $file['file_name']; ?></td>
                                    <td><?php echo $file['created_at']; ?></td>
                                    <td><?php echo $file['username']; ?></td>
                                    <td>
    <button class="status" style="background-color: <?php echo $file['status'] === 'Accepted' ? 'green' : ($file['status'] === 'Declined' ? 'red' : 'gray'); ?>;"><?php echo $file['status']; ?></button>
</td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item accept-btn btn btn-success" href="" data-id="<?php echo $file['id']; ?>">Accept</a>
                                                <a class="dropdown-item decline-btn" href="#" data-id="<?php echo $file['id']; ?>">Decline</a>
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

    </script>

    <!-- ajax for changing status -->
<script>
    $(document).ready(function() {
        $('.accept-btn').click(function(e) {
            e.preventDefault();
            var requestId = $(this).data('id');
            updateStatus(requestId, 'Accepted');
        });

        $('.decline-btn').click(function(e) {
            e.preventDefault();
            var requestId = $(this).data('id');
            updateStatus(requestId, 'Declined');
        });

        $('#folder-name-filter').on('change', function() {
        var folderNameFilter = $(this).val().toLowerCase();

        $('#request-table tbody tr').each(function() {
            var folderName = $(this).find('td:eq(2)').text().toLowerCase(); // Assuming folder name is in the third column (index 2)

            if (folderName.includes(folderNameFilter) || folderNameFilter === '') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

        function updateStatus(requestId, newStatus) {
            $.ajax({
                url: 'update_outbound_status.php',
                method: 'POST',
                data: { id: requestId, status: newStatus },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    location.reload();
                }
            });
        }
    });
</script>

    <!-- dashboard javascript -->
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>
