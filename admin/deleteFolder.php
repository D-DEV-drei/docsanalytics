<?php
session_start();
include '../config/db.php';

// Check if the user is logged in and if the user ID is set in the session
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Get the user ID
} else {
    // Redirect to login when no user ID detected
    header("Location: ../login.php");
    exit; // Stop further execution
}

// Check if folder ID is provided via POST request
if (isset($_POST['folderId'])) {
    $folderId = $_POST['folderId'];
    
    // Prepare a UPDATE statement to update the active status of the folder
    $sql = "UPDATE fms_g14_folder SET active = 1 WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ii", $folderId, $user_id);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Folder active status updated successfully
        echo "Folder hidden successfully.";
    } else {
        // Error updating folder active status
        echo "Error updating folder active status.";
    }
    
    mysqli_stmt_close($stmt);
} else {
    // Folder ID not provided
    echo "Folder ID not provided.";
}

mysqli_close($con);
?>
