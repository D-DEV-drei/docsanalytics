<?php
session_start();
include '../config/db.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the report ID is set in the POST data
    if (isset($_POST['id'])) {
        $reportId = $_POST['id'];

        // Prepare a DELETE statement to delete the report with the given ID
        $sql = "DELETE FROM fms_g14_shared_report WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);

        // Bind the report ID parameter to the prepared statement
        mysqli_stmt_bind_param($stmt, "i", $reportId);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Report deletion successful
            echo "Report deleted successfully";
        } else {
            // Report deletion failed
            echo "Error deleting report: " . mysqli_error($con);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // If report ID is not set in the POST data
        echo "Report ID not provided";
    }
} else {
    // If the request method is not POST
    echo "Invalid request method";
}

// Close the database connection
mysqli_close($con);
