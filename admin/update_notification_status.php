<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $notificationId = $_GET['id'];
    // Update notification status to 'read' in the database
    $sqlUpdateStatus = "UPDATE fms_g14_notifications SET status = 'read' WHERE id = ?";
    $stmt = mysqli_prepare($con, $sqlUpdateStatus);
    mysqli_stmt_bind_param($stmt, "i", $notificationId);
    if (mysqli_stmt_execute($stmt)) {
        echo "Notification status updated successfully.";
    } else {
        echo "Error updating notification status: " . mysqli_error($con);
    }
    mysqli_stmt_close($stmt);
}
?>
