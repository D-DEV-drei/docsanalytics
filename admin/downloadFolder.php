<?php
// Include necessary files and start the session
session_start();
include '../config/db.php';

if (isset($_POST['folder_id']) && isset($_POST['download_path'])) {
    $folderId = $_POST['folder_id'];
    $downloadPath = $_POST['download_path']; // Get the download path from the AJAX request

    // Fetch folder name from the database
    $folderNameQuery = "SELECT file_name, parent_id FROM fms_g14_folder WHERE id = ?";
    $folderNameStmt = mysqli_prepare($con, $folderNameQuery);
    mysqli_stmt_bind_param($folderNameStmt, "i", $folderId);
    mysqli_stmt_execute($folderNameStmt);
    mysqli_stmt_bind_result($folderNameStmt, $folderName, $parentId);
    mysqli_stmt_fetch($folderNameStmt);
    mysqli_stmt_close($folderNameStmt);

    // Replace spaces in folder name with underscores and append .zip extension
    $zipFileName = str_replace(' ', '_', $folderName) . '.zip';

    // Function to recursively add files and subdirectories to the zip archive
    function addFolderToZip($folderId, $zip, $basePath, $con)
    {
        // Query to fetch subfolders in the folder
        $subfoldersQuery = "SELECT id, file_name FROM fms_g14_folder WHERE parent_id = ?";
        $subfoldersStmt = mysqli_prepare($con, $subfoldersQuery);
        mysqli_stmt_bind_param($subfoldersStmt, "i", $folderId);
        mysqli_stmt_execute($subfoldersStmt);
        mysqli_stmt_bind_result($subfoldersStmt, $subfolderId, $subfolderName);

        // Store the results in an array
        $subfolders = array();
        while (mysqli_stmt_fetch($subfoldersStmt)) {
            $subfolders[] = array('id' => $subfolderId, 'name' => $subfolderName);
        }

        // Close the statement
        mysqli_stmt_close($subfoldersStmt);

        // Add subfolders and their contents to the zip archive
        foreach ($subfolders as $subfolder) {
            $subfolderPath = $basePath . '/' . $subfolder['name'];
            $zip->addEmptyDir($subfolderPath);
            // Recursively add files and subfolders in the subfolder
            addFolderToZip($subfolder['id'], $zip, $subfolderPath, $con);
        }

        // Query to fetch files in the folder
        $filesQuery = "SELECT file_path FROM fms_g14_files WHERE folder_id = ?";
        $filesStmt = mysqli_prepare($con, $filesQuery);
        mysqli_stmt_bind_param($filesStmt, "i", $folderId);
        mysqli_stmt_execute($filesStmt);
        mysqli_stmt_bind_result($filesStmt, $fileName);

        // Add files to the zip archive
        while (mysqli_stmt_fetch($filesStmt)) {
            // Check if the file exists in the laptop's directory
            $localFilePath = 'C:\\xampp\\htdocs\\kargada\\assets\\uploads\\' . basename($fileName);
            if (file_exists($localFilePath)) {
                // Add the file to the zip archive
                $zip->addFile($localFilePath, $basePath . '/' . basename($fileName));
            }
        }

        // Close the statement
        mysqli_stmt_close($filesStmt);
    }

    // Create a new zip archive
    $zip = new ZipArchive();

    if ($zip->open($downloadPath . '/' . $zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        // Add folder and its contents to the zip archive
        addFolderToZip($folderId, $zip, ($parentId == 0) ? '' : $folderName, $con);
        $zip->close();

        // Provide the zip file for download
        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$zipFileName");
        readfile($downloadPath . '/' . $zipFileName);
        exit;
    } else {
        echo "Failed to create zip archive: " . $zip->getStatusString();
    }
}

mysqli_close($con);
