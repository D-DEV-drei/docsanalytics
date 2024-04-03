<?php
session_start();
include '../config/db.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php"); // Redirect to login if the user is not logged in
    exit(); // Stop executing the script further
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if folder ID to restore is set
    if (isset($_POST['folderSelect'])) {
        $folderIdToRestore = $_POST['folderSelect'];

        // SQL query to update the active status of the folder
        $sql = "UPDATE fms_g14_folder SET active = 0 WHERE id = ?";

        // Prepare the SQL statement
        $stmt = mysqli_prepare($con, $sql);

        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "i", $folderIdToRestore);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Folder successfully restored
            header("Location: folderCreation.php");
            exit();
        } else {
            // Error occurred while restoring folder
            echo "Error: " . mysqli_error($con);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Folder ID to restore not set
        echo "Folder ID to restore is not set!";
    }
} else {
    // Method is not POST
    echo "Invalid request method!";
}

// Close the database connection
mysqli_close($con);
