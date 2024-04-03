<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Update view count for the given id
    $sql = "UPDATE fms_g14_outbound SET `view` = `view` + 1 WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Optionally, you can return a response if needed
    echo 'View count updated';
} else {
    // Handle invalid requests
    http_response_code(400);
    echo 'Invalid request';
}
