<?php
session_start();
include '../../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the folderId is set in the POST request
    if (isset($_POST["folderId"])) {
        // Get the folder ID from the POST data
        $folderId = $_POST["folderId"];

        // Initialize arrays to store files and subfolders data
        $files = array();
        $subfolders = array();

        // Prepare a SELECT statement to fetch files for the current folder
        $file_query = "SELECT f.name, fl.file_name,  f.description, f.date_updated, f.file_path FROM fms_g14_files as f
            inner join fms_g14_inbound as i on i.files_id = f.id
            JOIN fms_g14_folder as fl ON fl.id = folder_id
            WHERE folder_id = ? and i.status = 'Accepted' ";
        $file_stmt = mysqli_prepare($con, $file_query);
        mysqli_stmt_bind_param($file_stmt, "i", $folderId);
        mysqli_stmt_execute($file_stmt);
        mysqli_stmt_bind_result($file_stmt, $file_name, $folder, $description, $date_updated, $file_path);

        // Fetch file data and store it in the $files array
        while (mysqli_stmt_fetch($file_stmt)) {
            $files[] = array(
                'name' => $file_name,
                'folder' => $folder,
                'description' => $description,
                'date_updated' => $date_updated,
                'file_path' => $file_path,
            );
        }
        mysqli_stmt_close($file_stmt);

        // Prepare a SELECT statement to fetch subfolders for the current folder
        $subfolder_query = "SELECT id, file_name FROM fms_g14_folder WHERE parent_id = ? and active = 0";
        $subfolder_stmt = mysqli_prepare($con, $subfolder_query);
        mysqli_stmt_bind_param($subfolder_stmt, "i", $folderId);
        mysqli_stmt_execute($subfolder_stmt);
        mysqli_stmt_bind_result($subfolder_stmt, $subfolder_id, $subfolder_name);

        // Fetch subfolder data and store it in the $subfolders array
        while (mysqli_stmt_fetch($subfolder_stmt)) {
            $subfolders[] = array(
                'id' => $subfolder_id,
                'file_name' => $subfolder_name,
            );
        }
        mysqli_stmt_close($subfolder_stmt);

        // Close database connection
        mysqli_close($con);

        // Combine files and subfolders data into a single associative array
        $data = array(
            'files' => $files,
            'subfolders' => $subfolders,
        );

        // Send the JSON response
        echo json_encode($data);
    } else {
        // If folderId is not set in the POST data, send a 400 Bad Request response
        http_response_code(400);
        echo json_encode(array("message" => "Folder ID is required."));
    }
} else {
    // If the request method is not POST, send a 405 Method Not Allowed response
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
}
