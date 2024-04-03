<?php
include '../config/db.php';

// Check if the user is logged in and if the user ID is set in the session
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Get the user ID
} else {
    header("Location: ../login.php"); // Redirect to login when no user ID is detected
    exit(); // Stop executing the script further
}

$sql = "SELECT a.folder_id, f.file_name FROM fms_g14_access as a
inner join fms_g14_folder as f on f.id = a.folder_id
where a.user_id = ?";

// Prepare the SQL statement
$stmt = mysqli_prepare($con, $sql);

// Check if the statement was prepared successfully
if ($stmt) {
    // Bind the user ID parameter
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Bind variables to prepared statement
    mysqli_stmt_bind_result($stmt, $id, $file_name);

    // Fetch the data and store it in an array
    $folders = array();
    while (mysqli_stmt_fetch($stmt)) {
        // Store each row's data in the $folders array
        $folders[] = array(
            'id' => $id, // Include the 'id' column in the array
            'file_name' => $file_name,
        );
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // If statement preparation fails, handle the error
    echo "Error: " . mysqli_error($con);
}

?>


<!-- Add File Modal -->
<div id="addFileModal" class="modal" tabindex="-1" style="z-index: 9999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addFileForm" method="post" action="addrequest.php" enctype="multipart/form-data">
                     <div class="form-group">
                        <label for="folderSelect">Select Folder</label>
                        <select class="form-control" id="folderSelect" name="folderSelect">
                            <?php
// Loop through the $folders array to generate options for the dropdown
foreach ($folders as $folder) {
    echo '<option value="' . $folder['id'] . '">' . $folder['file_name'] . '</option>';
}
?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file">Choose File</label>
                        <input type="file" class="form-control-file" id="file" name="file" required accept=".zip, .rar, .sql, .doc, .docx, .pdf, .xls, .txt, .csv, .jpg, .png">
                    </div>

                    <div class="form-group">
                        <label for="fileDescription">Description</label>
                        <textarea class="form-control" id="fileDescription" name="fileDescription" rows="4" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload File</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Your file was uploaded successfully.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Error message will be displayed here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


