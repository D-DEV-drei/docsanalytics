<?php
// Include the database connection
include '../../config/db.php';

// Check if the folderId parameter is set
if (isset($_POST['folderId'])) {
    // Get the folder ID from the POST data
    $folderId = $_POST['folderId'];

    // Prepare a SELECT statement to fetch files for the specified folder
    $file_query = "SELECT name, description, file_path, date_updated FROM fms_g14_files as f
    inner join fms_g14_inbound as i on i.files_id = f.id
    WHERE folder_id = ? AND status = 'ACCEPTED'";
    $file_stmt = mysqli_prepare($con, $file_query);
    if (!$file_stmt) {
        echo "Error: " . mysqli_error($con);
    } else {
        mysqli_stmt_bind_param($file_stmt, "s", $folderId);
        mysqli_stmt_execute($file_stmt);

        // Check for errors during execution
        if (mysqli_stmt_error($file_stmt)) {
            echo "Error: " . mysqli_stmt_error($file_stmt);
        } else {
            mysqli_stmt_bind_result($file_stmt, $file_name, $file_description, $file_path, $file_created_at);

            // Fetch the data and store it in an array
            $files = array();
            while (mysqli_stmt_fetch($file_stmt)) {
                $files[] = array(
                    'name' => $file_name,
                    'description' => $file_description,
                    'file_path' => $file_path,
                    'date_updated' => $file_created_at,
                );
            }

            // Close the statement
            mysqli_stmt_close($file_stmt);

            // Close the database connection
            mysqli_close($con);

            // Return the files data as JSON
            echo json_encode($files);
        }
    }
} else {
    // If folderId parameter is not set, return an error message
    echo "Error: folderId parameter is not set";
}
