<?php
include '../config/db.php';

// Function to fetch folders
function fetchFolders($con): array
{
    $sql = "SELECT id, file_name FROM fms_g14_folder";
    $stmt = mysqli_prepare($con, $sql);
    if ($stmt) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $fileName); // Changed $file_name to $fileName
        $folders = [];
        while (mysqli_stmt_fetch($stmt)) {
            $folders[] = [
                'id' => $id,
                'file_name' => $fileName,
            ];
        }
        mysqli_stmt_close($stmt);
        return $folders;
    }
    echo "Error: " . mysqli_error($con);
    return [];
}

// Function to fetch users
function fetchUsers($con): array
{
    $sql = "SELECT id, username FROM fms_g14_users";
    $stmt = mysqli_prepare($con, $sql);
    if ($stmt) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $username);
        $users = [];
        while (mysqli_stmt_fetch($stmt)) {
            $users[] = [
                'id' => $id,
                'username' => $username,
            ];
        }
        mysqli_stmt_close($stmt);
        return $users;
    }
    echo "Error: " . mysqli_error($con);
    return [];
}

// Fetch folders
$folders = fetchFolders($con);

// Fetch users
$users = fetchUsers($con);

?>



<!-- Add File Modal -->
<div id="addAccessModal" class="modal" tabindex="-1" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Access</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addFileForm" method="post" action="addAccess.php" enctype="multipart/form-data">
                <div class="form-group">
        <label for="folderSelect">Select Folder</label>
        <select class="form-control" id="folderSelect" name="folderSelect">
            <?php foreach ($folders as $folder): ?>
                <option value="<?php echo $folder['id']; ?>"><?php echo $folder['file_name']; ?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="form-group">
        <label for="userSelect">Select User</label>
        <select class="form-control" id="userSelect" name="userSelect">
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Access</button>
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
            Access Control was successfully Deleted.
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

