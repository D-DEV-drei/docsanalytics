<?php
session_start();
include '../config/db.php';

// Check if user_id is provided in the URL
if (isset($_GET['user_id'])) {
    // Get user ID from the URL parameter
    $user_id = $_GET['user_id'];

    // Fetch the current activation status from the database
    $sql_select = "SELECT activate FROM fms_g14_users WHERE id = ?";
    $stmt_select = mysqli_prepare($con, $sql_select);
    mysqli_stmt_bind_param($stmt_select, "i", $user_id);
    mysqli_stmt_execute($stmt_select);
    mysqli_stmt_bind_result($stmt_select, $current_activation);
    mysqli_stmt_fetch($stmt_select);
    mysqli_stmt_close($stmt_select);

    // Toggle the activation status
    $new_activation = $current_activation == 1 ? 0 : 1;

    // Update the activation status in the database
    $sql_update = "UPDATE fms_g14_users SET activate = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($con, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "ii", $new_activation, $user_id);
    mysqli_stmt_execute($stmt_update);

    // Check if the update was successful
    if (mysqli_stmt_affected_rows($stmt_update) > 0) {
        $_SESSION['success_message'] = "Activation status updated successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to update activation status.";
    }

    // Close the statement
    mysqli_stmt_close($stmt_update);
}

// Close the database connection
mysqli_close($con);

// Redirect back to the user management page
header("Location: userManage.php");
exit();
?>
