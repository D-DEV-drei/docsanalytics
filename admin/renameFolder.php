<?php
session_start();
include '../config/db.php';

// PHP code to handle folder renaming
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['newFolderName']) && isset($_POST['folderIdToUpdate'])) {
    $newFolderName = $_POST['newFolderName'];
    $folderIdToUpdate = $_POST['folderIdToUpdate'];

    // Prepare and execute SQL query to update folder name
    $updateQuery = "UPDATE fms_g14_folder SET file_name = ? WHERE id = ?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "si", $newFolderName, $folderIdToUpdate);
    mysqli_stmt_execute($updateStmt);

    // Check if update was successful
    if (mysqli_stmt_affected_rows($updateStmt) > 0) {
        echo "<script>window.location.reload();</script>";
        exit;
    } else {
        // Folder name update failed
        // Handle error as needed
    }

    mysqli_stmt_close($updateStmt);
}
