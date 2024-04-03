<?php
session_start();
include '../config/db.php';

// Check if the user is logged in and get their ID
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
} else {
    // Redirect to login page or handle unauthorized access
    header("Location: ../login.php");
    exit(); // Stop further execution
}

// Check if the request ID is provided via POST method
if (isset($_POST['id'])) {
    $requestId = $_POST['id'];

    // Retrieve the file paths associated with the declined request from the database
    $sql = "SELECT file_path FROM fms_g14_files WHERE id IN (SELECT files_id FROM fms_g14_inbound WHERE id = ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $requestId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $fileName);

    // Store the file paths in an array
    $fileNames = array();
    while (mysqli_stmt_fetch($stmt)) {
        $fileNames[] = $fileName;
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Delete the files from the ../assets/uploads/ folder
    // foreach ($fileNames as $fileName) {
    //     $filePath = $fileName;
    //     if (file_exists($filePath)) {
    //         if (unlink($filePath)) {
    //             echo "File deleted: " . $fileName . "<br>";
    //         } else {
    //             echo "Error deleting file: " . $fileName . "<br>";
    //         }
    //     } else {
    //         echo "File not found: " . $fileName . "<br>";
    //     }
    // }

    // Return a success message or any relevant response to the JavaScript code
    echo "Files deleted successfully";
} else {
    // If request ID is not provided, return an error message or handle the situation accordingly
    echo "Error: Request ID not provided";
}

// Close the database connection
mysqli_close($con);
