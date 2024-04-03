<?php
include '../config/db.php';

// Check if the request method is POST and if the file ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Sanitize the input
    $id = mysqli_real_escape_string($con, $_POST['id']);

    // Update the download count for the given file ID
    $sql = "UPDATE fms_g14_outbound SET `download` = `download` + 1 WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Return a success message
        echo 'Download count updated';
    } else {
        // Return an error message
        echo 'Failed to update download count';
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Return an error message for invalid requests
    http_response_code(400);
    echo 'Invalid request';
}
?>
