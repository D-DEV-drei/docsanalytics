<?php
include '../config/db.php';

// Check if the user is logged in and if the user ID is set in the session
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php"); // Redirect to login when no user ID is detected
    exit(); // Stop executing the script further
}

// SQL query to retrieve the folder information along with file names
$sqlFolders = "SELECT id, file_name FROM fms_g14_folder WHERE active = 1";
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

<!-- Restore Folder Modal -->
<div class="modal fade" id="restoreFolderModal" tabindex="-1" role="dialog" aria-labelledby="restoreFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreFolderModalLabel">Restore Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="restoreFolderForm" method="post" action="restoreFolder.php">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Restore</button>
                    </div>
                    <input type="hidden" id="folderIdToRestore" name="folderIdToRestore">
                </form>
            </div>
        </div>
    </div>
</div>
