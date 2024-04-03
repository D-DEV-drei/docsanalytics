<?php
// Include database connection and ensure user is logged in
include '../config/db.php';

// Initialize session
session_start();

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Get the user ID

    // Fetch username based on user ID
    $username = "";
    $username_query = "SELECT username FROM fms_g14_users WHERE id = ?";
    $username_stmt = mysqli_prepare($con, $username_query);
    mysqli_stmt_bind_param($username_stmt, "i", $user_id);
    mysqli_stmt_execute($username_stmt);
    mysqli_stmt_bind_result($username_stmt, $username);
    mysqli_stmt_fetch($username_stmt);
    mysqli_stmt_close($username_stmt);

    // Check if the folderSelect and fileSelect parameters are set
    if (isset($_POST['folderSelect']) && isset($_POST['fileSelect'])) {
        $selected_folder_id = $_POST['folderSelect'];
        $selected_file_id = $_POST['fileSelect'];
        $reason = "View/Download"; // Default reason

        // Fetch filename based on file ID
        $filename = "";
        $filename_query = "SELECT name FROM fms_g14_files WHERE id = ?";
        $filename_stmt = mysqli_prepare($con, $filename_query);
        mysqli_stmt_bind_param($filename_stmt, "i", $selected_file_id);
        mysqli_stmt_execute($filename_stmt);
        mysqli_stmt_bind_result($filename_stmt, $filename);
        mysqli_stmt_fetch($filename_stmt);
        mysqli_stmt_close($filename_stmt);

        // Insert into outbound table
        $sql_insert = "INSERT INTO fms_g14_outbound (user_id, files_id, reason, status) VALUES (?, ?, ?, 'Pending')";
        $stmt_insert = mysqli_prepare($con, $sql_insert);
        if ($stmt_insert) {
            mysqli_stmt_bind_param($stmt_insert, "iis", $user_id, $selected_file_id, $reason);
            mysqli_stmt_execute($stmt_insert);
            mysqli_stmt_close($stmt_insert);

            // Add notification
            $notification_message = "$username is requesting to access the $filename"; // Notification message
            $notification_status = "unread"; // Notification status
            $sql_notification = "INSERT INTO fms_g14_notifications (message, type, status) VALUES (?, 'outbound', ?)";
            $stmt_notification = mysqli_prepare($con, $sql_notification);
            if ($stmt_notification) {
                mysqli_stmt_bind_param($stmt_notification, "ss", $notification_message, $notification_status);
                mysqli_stmt_execute($stmt_notification);
                mysqli_stmt_close($stmt_notification);
            } else {
                // Error handling
                echo json_encode(array('error' => 'Error preparing notification SQL statement: ' . mysqli_error($con)));
            }

            // Return success message
            echo json_encode(array('success' => 'Permission requested successfully'));
            header("Location: documentManage.php");
        } else {
            // Error handling
            echo json_encode(array('error' => 'Error preparing SQL statement: ' . mysqli_error($con)));
        }
    } else {
        // If folderSelect or fileSelect parameter is not set
        echo json_encode(array('error' => 'Folder ID or File ID not provided'));
    }
} else {
    // If user is not logged in, redirect to login page
    header("Location: ../login.php");
    exit(); // Stop executing the script further
}
