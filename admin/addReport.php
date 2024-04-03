<?php
session_start();
include '../config/db.php';

// Check if the user is logged in and if the user ID is set in the session
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Get the user ID
} else {
    header("Location: ../login.php"); // Redirect to login when no user ID is detected
    exit(); // Stop executing the script further
}

// Check if the form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $folderId = $_POST['folderSelect'];
    $reportName = $_POST['reportName'];
    $reportDescription = $_POST['reportDescription'];
    $Access = isset($_POST['includeAccess']) ? 1 : 0;
    $Users = isset($_POST['includeUsers']) ? 1 : 0;
    $Downloads = isset($_POST['includeDownloads']) ? 1 : 0;
    $Uploads = isset($_POST['includeUploads']) ? 1 : 0;
    $includeAccess = $_POST['hiddenAccessCount'];
    $includeUsers = $_POST['hiddenViewCount'];
    $includeDownloads = $_POST['hiddenDownloadCount'];
    $includeUploads = $_POST['hiddenUploadCount'];

    // Prepare and execute SQL statement to insert data into `reports` table
    $sql = "INSERT INTO fms_g14_reports (folder_id, report_name, report_description, access, user, download, upload, include_access, include_users, include_downloads, include_uploads) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "issssssssss", $folderId, $reportName, $reportDescription, $Access, $Users, $Downloads, $Uploads, $includeAccess, $includeUsers, $includeDownloads, $includeUploads);
    mysqli_stmt_execute($stmt);

    // Check if the insertion was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Report created successfully.";
        header("Location: report.php");
        exit();
    } else {
        echo "Error creating report: " . mysqli_error($con);
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {

}

// Close database connection
mysqli_close($con);
