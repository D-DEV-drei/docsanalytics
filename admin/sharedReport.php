<?php
session_start();
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if userId and reportId are set and not empty
    if (isset($_POST['userId']) && isset($_POST['reportId']) && !empty($_POST['userId']) && !empty($_POST['reportId'])) {
        // Sanitize input to prevent SQL injection
        $userId = mysqli_real_escape_string($con, $_POST['userId']);
        $reportId = mysqli_real_escape_string($con, $_POST['reportId']);

        // Prepare and bind the insert statement
        $stmt = mysqli_prepare($con, "INSERT INTO fms_g14_shared_report (report_id, user_id) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ii", $reportId, $userId);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Report shared successfully
            echo "Report shared successfully";
            header("Location: share_report.php");
        } else {
            // Error in sharing report
            echo "Error sharing report: " . mysqli_error($con);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // userId or reportId is missing or empty
        echo "userId or reportId is missing or empty";
    }
} else {
    // Redirect if accessed directly
    header("Location: ../login.php");
    exit();
}
