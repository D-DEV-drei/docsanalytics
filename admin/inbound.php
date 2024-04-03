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
$sql = "SELECT inbound.id, inbound.status, files.name, files.file_type, files.description, DATE(files.date_updated) AS date_updated, users.username, folder.file_name
FROM fms_g14_inbound as inbound
INNER JOIN fms_g14_files as files ON inbound.files_id = files.id
INNER JOIN fms_g14_users as users ON files.user_id = users.id
INNER JOIN fms_g14_folder as folder ON files.folder_id = folder.id
WHERE inbound.status = 'Pending';

";

$stmt = mysqli_prepare($con, $sql);

// Execute the statement
mysqli_stmt_execute($stmt);

// Bind result variables
mysqli_stmt_bind_result($stmt, $fileid, $status, $name, $file_type, $description, $date_updated, $username, $folder);

// Fetch the data and store it in an array
$files = array();
while (mysqli_stmt_fetch($stmt)) {
    $files[] = array(
        'id' => $fileid,
        'status' => $status,
        'name' => $name,
        'file_type' => $file_type,
        'description' => $description,
        'date_updated' => $date_updated,
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
    <title>Inbound Request</title>
    <style>
        .dropdown-toggle-no-caret::after {
            display: none;
        }

        #file-viewer img {
            max-width: 100%;
            height: auto;
        }

        .modal {
            z-index: 9999 !important; /* Adjust the z-index value as needed */
        }


    </style>
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
                <!-- breadcrumb for request, user can navigate to pending, accepted and declined request -->
                <div class="left">
                            <h1>Inbound Request</h1>
                        </div>
                </div>

                <!-- table for request -->

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
                    </div>
                    </div>

                    <table id="request-table">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>Meta tags</th>
                                <th>File Type</th>
                                <th>Folder Name</th>
                                <th>Date</th>
                                <th>Requestor</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($files as $file): ?>
                                <tr>
                                    <td><?php echo $file['name']; ?></td>
                                    <td><?php echo $file['description']; ?></td>
                                    <td><?php echo $file['file_type']; ?></td>
                                    <td><?php echo $file['file_name']; ?></td>
                                    <td><?php echo $file['date_updated']; ?></td>
                                    <td><?php echo $file['username']; ?></td>
                                    <td>
                                        <button class="status" style="background-color: gray;"><?php echo $file['status']; ?></button>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item accept-btn" href="" data-id="<?php echo $file['id']; ?>">Accept</a>
                                                <a class="dropdown-item decline-btn" href="#" data-id="<?php echo $file['id']; ?>">Decline</a>
                                                <a class="dropdown-item view-btn" href="#" data-id="<?php echo $file['id']; ?>" data-name="<?php echo $file['name']; ?>" data-filetype="<?php echo $file['file_type']; ?>">View</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="fileViewerModal" tabindex="-1" role="dialog" aria-labelledby="fileViewerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fileViewerModalLabel">File Viewer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="file-viewer"></div>
                        </div>
                    </div>
                </div>
            </div>


        </main>

    </div>


    <?php include '../modal/addFileModal.php'?>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Include Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.4/mammoth.browser.min.js"></script>

    <!-- this is for interactive table: pagination, search bar and show entries -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
    $(document).ready(function() {
        $('#request-table').DataTable({
            "paging": true, // Enable pagination
            "pageLength": 5 // Set number of entries per page
        });

        function openAddFileModal() {
            $('#addFileModal').modal('show');
        }

    $('#folder-name-filter').on('change', function() {
        var folderNameFilter = $(this).val().toLowerCase();

        $('#request-table tbody tr').each(function() {
            var folderName = $(this).find('td:eq(3)').text().toLowerCase(); // Assuming folder name is in the third column (index 2)

            if (folderName.includes(folderNameFilter) || folderNameFilter === '') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    function removeActiveClass() {
        const sideLinks = document.querySelectorAll('.sidebar .side-menu li a:not(.logout)');
        sideLinks.forEach(item => {
            item.parentElement.classList.remove('active');
        });
    }
    $('.view-btn').click(function(e) {
                e.preventDefault();
                var fileId = $(this).data('id');
                var fileName = $(this).data('name');
                var fileExtension = $(this).data('filetype');
                var baseUrl = "http://localhost/kargada/";
                var fileUrl = baseUrl + 'assets/uploads/' + fileName + '.' + fileExtension;
                $('#file-viewer').html(''); // Clear previous content
                if (['pdf', 'doc', 'docx', 'txt', 'png', 'jpg', 'jpeg', 'gif'].includes(fileExtension)) {
                    displayFile(fileUrl, fileExtension);
                    $('#fileViewerModal').modal('show'); // Show modal
                    removeActiveClass(); // Remove active class from sidebar links
                }
            });

            // Function to display file content
            function displayFile(fileUrl, fileExtension) {
                if (['doc', 'docx', 'pdf', 'txt'].includes(fileExtension)) {
                    // Fetch the file content
                    $.ajax({
                        url: fileUrl,
                        method: 'GET',
                        xhrFields: {
                            responseType: 'arraybuffer'
                        },
                        success: function(data) {
                            if (fileExtension === 'pdf' || fileExtension === 'txt') {
                                // Embed PDF using an iframe
                                $('#file-viewer').html('<iframe src="' + fileUrl + '" width="100%" height="500px" frameborder="0"></iframe>');
                            } else {
                                // Use Mammoth.js for .docx and .txt files
                                mammoth.convertToHtml({
                                        arrayBuffer: data
                                    })
                                    .then(function(result) {
                                        $('#file-viewer').html(result.value);
                                    })
                                    .catch(function(err) {
                                        console.error('Error converting file:', err);
                                        $('#file-viewer').html('<p>Error loading file. Please try again later.</p>');
                                    });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching file:', error);
                            $('#file-viewer').html('<p>Error loading file. Please try again later.</p>');
                        }
                    });
                } else {
                    // Display images using an img tag
                    $('#file-viewer').html('<img src="' + fileUrl + '" alt="File Preview" style="max-width: 100%; height: auto;">');
                }
            }
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

        function updateStatus(requestId, newStatus) {
            console.log("Updating status for request ID:", requestId, "to:", newStatus);
            $.ajax({
                url: 'update_status.php',
                method: 'POST',
                data: { id: requestId, status: newStatus },
                success: function(response) {
                    console.log("Status updated successfully.");
                    // If the status update is successful, delete associated files if status is 'Declined'
                    location.reload();

                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error("Error updating status:", error);
                }
            });
        }

        // function updateStatus(requestId, newStatus) {
        //     console.log("Updating status for request ID:", requestId, "to:", newStatus);
        //     $.ajax({
        //         url: 'update_status.php',
        //         method: 'POST',
        //         data: { id: requestId, status: newStatus },
        //         success: function(response) {
        //             console.log("Status updated successfully.");
        //             // If the status update is successful, delete associated files if status is 'Declined'
        //             if (newStatus === 'Declined') {
        //                 deleteAssociatedFiles(requestId);
        //             } else {
        //                 // Reload the page or perform any other actions if needed
        //                 location.reload();
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle errors here
        //             console.error("Error updating status:", error);
        //         }
        //     });
        // }

        function deleteAssociatedFiles(requestId) {
            console.log("Deleting associated files for request ID:", requestId);
            $.ajax({
                url: 'delete_files.php', // PHP script to handle file deletion
                method: 'POST',
                data: { id: requestId },
                success: function(response) {
                    console.log("Files deleted successfully.");
                    // Reload the page after successful deletion
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error("Error deleting files:", error);
                }
            });
        }
    });
</script>

    <!-- dashboard javascript -->
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>
