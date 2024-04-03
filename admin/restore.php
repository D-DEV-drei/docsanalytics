<?php
session_start();
include '../config/db.php';

// Check if the user is logged in and get their ID
if (!isset($_SESSION['id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: ../login.php");
    exit(); // Stop further execution
}

// Check if the required POST data is received
if (isset($_POST['fileName']) && isset($_POST['newStatus'])) {
    // Extract the file name and new status from the POST data
    $fileName = $_POST['fileName'];
    $newStatus = $_POST['newStatus'];

    // Prepare an UPDATE statement to change the status of the specified file
    $sql = "UPDATE fms_g14_inbound SET status = ? WHERE files_id IN (SELECT id FROM fms_g14_files WHERE name = ?)";

    // Prepare the statement
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        // Bind the parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "ss", $newStatus, $fileName);
        mysqli_stmt_execute($stmt);

        // Check if any rows were affected
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Status updated successfully
            echo "Status updated successfully!";
        } else {
            // No rows were affected, likely due to incorrect file name
            echo "No records found for the specified file name.";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Error preparing the statement
        echo "Error: " . mysqli_error($con);
    }
} else {
    // Required POST data is missing
    echo "Error: Missing required parameters.";
}

// Close the database connection
mysqli_close($con);
