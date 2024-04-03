
<?php
include '../config/db.php';

// Check if the user is logged in and if the user ID is set in the session
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Get the user ID
} else {
    header("Location: ../login.php"); // Redirect to login when no user ID is detected
    exit(); // Stop executing the script further
}

// SQL query to retrieve the folder information along with file names
$sqlFolders = "SELECT a.folder_id, f.file_name
            FROM fms_g14_access AS a
            INNER JOIN fms_g14_folder AS f ON f.id = a.folder_id
            GROUP BY a.folder_id;
            ";
$stmtFolders = mysqli_prepare($con, $sqlFolders);

// Check if the statement was prepared successfully
if ($stmtFolders) {
    // Execute the prepared statement
    mysqli_stmt_execute($stmtFolders);

    // Bind variables to prepared statement
    mysqli_stmt_bind_result($stmtFolders, $folder_id, $file_name);

    // Fetch the data and store it in an array
    $folders = array();
    while (mysqli_stmt_fetch($stmtFolders)) {
        // Store each row's data in the $folders array
        $folders[] = array(
            'folder_id' => $folder_id,
            'file_name' => $file_name,
        );
    }

    // Close the statement
    mysqli_stmt_close($stmtFolders);

} else {
    // If statement preparation fails, handle the error
    echo "Error: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>

<script>
function selectAllCheckboxes() {
    var includeAllCheckbox = document.getElementById('includeAll');
    var checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#includeAll):not(#shareToAllFolders)');

    checkboxes.forEach(function(checkbox) {
        checkbox.checked = includeAllCheckbox.checked;
    });
}

function getCounts() {
    var folderSelect = document.getElementById('folderSelect');
    var folderId = folderSelect.value;

    // Send an AJAX request to the server
    $.ajax({
        type: 'POST',
        url: 'get_counts.php',
        data: { folder_id: folderId },
        dataType: 'json',
        success: function(response) {
            // Handle the response
            console.log(response);

            // Store the counts in hidden input fields
            $('#hiddenAccessCount').val(response.access_count);
            $('#hiddenDownloadCount').val(response.total_downloads);
            $('#hiddenUploadCount').val(response.file_count);
            $('#hiddenViewCount').val(response.total_views);

            // Submit the form after setting the counts
            $('#createReportForm').submit();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

</script>


<!-- Create Report Modal -->
<div class="modal fade" id="addReportModal" tabindex="-1" role="dialog" aria-labelledby="addReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Shared Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <!-- Form for creating a shared report -->
                <form id="createReportForm" method="POST" action="addReport.php">
                    <div class="form-group">
                        <label for="folderSelect">Select Folder</label>
                        <select class="form-control" id="folderSelect" name="folderSelect">
                            <?php
// Loop through the $folders array to generate options for the dropdown
foreach ($folders as $folder) {
    echo '<option value="' . $folder['folder_id'] . '">' . $folder['file_name'] . '</option>';
}
?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="includeAll" name="includeAll" onclick="selectAllCheckboxes()">
                                <label class="form-check-label" for="includeAll">Include All</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="includeAccess" name="includeAccess">
                                <label class="form-check-label" for="includeAccess">Files</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="includeDownloads" name="includeDownloads">
                                <label class="form-check-label" for="includeDownloads">Downloads</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="includeUploads" name="includeUploads">
                                <label class="form-check-label" for="includeUploads">Uploads</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="includeUsers" name="includeUsers">
                                <label class="form-check-label" for="includeUsers">Users</label>
                            </div>
                        </div>
                    </diV>
                    <div class="form-group">
                        <label for="reportName">Report Name</label>
                        <input type="text" class="form-control" id="reportName" name="reportName" required>
                    </div>
                    <div class="form-group">
                        <label for="reportDescription">Report Description</label>
                        <textarea class="form-control" id="reportDescription" name="reportDescription" rows="3"></textarea>
                    </div>
                    <input type="hidden" id="hiddenAccessCount" name="hiddenAccessCount">
                    <input type="hidden" id="hiddenDownloadCount" name="hiddenDownloadCount">
                    <input type="hidden" id="hiddenUploadCount" name="hiddenUploadCount">
                    <input type="hidden" id="hiddenViewCount" name="hiddenViewCount">

                    <button type="button" class="btn btn-primary" onclick="getCounts()">Create Report</button>
                </form>
            </div>
        </div>
    </div>
</div>

