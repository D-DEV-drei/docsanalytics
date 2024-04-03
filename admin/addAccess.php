<?php
session_start();
include '../config/db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if folderSelect and userSelect are set in the POST data
    if (isset($_POST["folderSelect"]) && isset($_POST["userSelect"])) {
        // Sanitize and validate input
        $folderId = $_POST["folderSelect"];
        $userId = $_POST["userSelect"];

        // Prepare INSERT statement
        $sql = "INSERT INTO fms_g14_access (user_id, folder_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($con, $sql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ii", $userId, $folderId);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Access added successfully
            echo "Access added successfully.";
            header("Location: access.php");
        } else {
            // Error in execution
            echo "Error: " . mysqli_error($con);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Parameters not set
        echo "Error: Folder and user parameters are required.";
    }
}

// Close the database connection
mysqli_close($con);
