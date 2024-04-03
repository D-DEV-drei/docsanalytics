<?php
session_start();
include '../config/db.php';

// Check if user ID is provided
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Prepare SQL statement to delete the user
    $sql = "DELETE FROM fms_g14_users WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $userId);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // User deleted successfully
        $_SESSION['message'] = "User deleted successfully";
    } else {
        // Error occurred
        $_SESSION['error'] = "Error: Unable to delete user";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($con);

// Redirect back to the user management page
header("Location: userManage.php");
exit;
?>
