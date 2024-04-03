<?php
// Include database connection
include '../config/db.php';

// Initialize session
session_start();

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Get the user ID

    // Check if the folderSelect parameter is set
    if (isset($_POST['folderSelect'])) {
        $selected_folder_id = $_POST['folderSelect'];

        // Fetch files based on folder ID and user ID
        $sql_files = "SELECT f.id, f.name FROM fms_g14_files as f
        inner join fms_g14_inbound as i on i.files_id = f.id
        WHERE folder_id = ? AND user_id = ? AND status = 'ACCEPTED' ";
        $stmt_files = mysqli_prepare($con, $sql_files);
        if ($stmt_files) {
            mysqli_stmt_bind_param($stmt_files, "ii", $selected_folder_id, $user_id);
            mysqli_stmt_execute($stmt_files);
            mysqli_stmt_bind_result($stmt_files, $file_id, $file_name);

            $files = array();
            while (mysqli_stmt_fetch($stmt_files)) {
                $files[] = array(
                    'id' => $file_id,
                    'name' => $file_name,
                );
            }
            mysqli_stmt_close($stmt_files);

            // Return files as JSON
            echo json_encode($files);
        } else {
            // Error handling
            echo json_encode(array('error' => 'Error preparing SQL statement: ' . mysqli_error($con)));
        }
    } else {
        // If folderSelect parameter is not set
        echo json_encode(array('error' => 'Folder ID not provided'));
    }
} else {
    // If user is not logged in, redirect to login page
    header("Location: ../login.php");
    exit(); // Stop executing the script further
}
