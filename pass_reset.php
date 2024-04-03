<?php
session_start();
include './config/db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stored_email = $_SESSION['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify if new password and confirm password match
    if ($new_password === $confirm_password) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update user's password in the database
        $update_query = "UPDATE fms_g14_users SET password = '$hashed_password' WHERE email = '$stored_email'";
        if (mysqli_query($con, $update_query)) {
            // Password reset successful, redirect to login page
            $response['status'] = 'success';
            $response['message'] = 'Password reset successful. Redirecting to login page...';
            $response['redirect'] = 'login.php';
        } else {
            // Error updating password
            $response['status'] = 'error';
            $response['message'] = 'An error occurred while resetting the password. Please try again later.';
        }
    } else {
        // Passwords do not match
        $response['status'] = 'error';
        $response['message'] = 'New password and confirm password do not match.';
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>