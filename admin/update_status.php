<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary data is provided
    if (isset($_POST['id']) && isset($_POST['status'])) {
        // Include the database connection file
        include '../config/db.php';

        // Sanitize the input data to prevent SQL injection
        $requestId = mysqli_real_escape_string($con, $_POST['id']);
        $newStatus = mysqli_real_escape_string($con, $_POST['status']);

        // Prepare an UPDATE statement
        $sql = "UPDATE fms_g14_inbound SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "si", $newStatus, $requestId);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // If the update was successful, return a success message
            echo "Status updated successfully!";
        } else {
            // If there was an error, return an error message
            echo "Error updating status: " . mysqli_error($con);
        }

        // Close the statement
        mysqli_stmt_close($stmt);

        // Close the database connection
        mysqli_close($con);
    } else {
        // If the necessary data is not provided, return an error message
        echo "Error: Missing required data!";
    }
} else {
    // If the request method is not POST, return an error message
    echo "Error: Invalid request method!";
}
?>
