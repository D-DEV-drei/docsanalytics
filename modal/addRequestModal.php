<?php
// Include database connection and ensure user is logged in
include '../config/db.php';

// Check if the user is logged in and if the user ID is set in the session
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Get the user ID
} else {
    header("Location: ../login.php"); // Redirect to login when no user ID is detected
    exit(); // Stop executing the script further
}

// Fetch folders accessible by the user
$sql_folders = "SELECT a.folder_id, f.file_name FROM fms_g14_access AS a
                INNER JOIN fms_g14_folder AS f ON f.id = a.folder_id
                WHERE a.user_id = ?";
$stmt_folders = mysqli_prepare($con, $sql_folders);
if ($stmt_folders) {
    mysqli_stmt_bind_param($stmt_folders, "i", $user_id);
    mysqli_stmt_execute($stmt_folders);
    mysqli_stmt_bind_result($stmt_folders, $folder_id, $folder_name);

    $folders = array();
    while (mysqli_stmt_fetch($stmt_folders)) {
        $folders[] = array(
            'id' => $folder_id,
            'name' => $folder_name,
        );
    }
    mysqli_stmt_close($stmt_folders);
} else {
    echo "Error fetching folders: " . mysqli_error($con);
}
?>

<!-- Add File Modal -->
<div id="addRequestModal" class="modal" tabindex="-1" style="z-index: 9999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request View/Download File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addRequestForm" method="post" action="askPermission.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="folderSelect">Select Folder</label>
                    <select class="form-control" id="folderSelect" name="folderSelect">
                        <option value="" disabled selected>Select Folder</option> <!-- Disabled by default -->
                        <?php foreach ($folders as $folder): ?>
                            <option value="<?php echo $folder['id']; ?>"><?php echo $folder['name']; ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                    <div class="form-group">
                        <label for="fileSelect">Select Files</label>
                        <select class="form-control" id="fileSelect" name="fileSelect">
                            <!-- Files will be populated dynamically using JavaScript -->
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ask Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#folderSelect').change(function() {
        // Get the selected folder ID
        var folderId = $(this).val();

        // Perform AJAX request to fetch files based on the selected folder ID
        $.ajax({
            type: 'POST',
            url: '../modal/fetch_files.php',
            data: { folderSelect: folderId }, // Send selected folder ID to fetch_files.php
            dataType: 'json',
            success: function(response) {
                $('#fileSelect').empty(); // Clear previous options
                $.each(response, function(index, file) {
                    $('#fileSelect').append('<option value="' + file.id + '">' + file.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Optionally handle errors here, e.g., display a message to the user
            }
        });
    });

    // Trigger change event on page load to populate files for the default selected folder
    $('#folderSelect').trigger('change');
});

</script>
