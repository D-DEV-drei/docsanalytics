<?php
session_start();

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user input verification code
    $userVerificationCode = $_POST['reset_code'];

    // Get the session verification code
    $sessionVerificationCode = isset($_SESSION['verification_code']) ? $_SESSION['verification_code'] : '';

    // Compare user input with session verification code
    if ($userVerificationCode === $sessionVerificationCode) {
        // Verification code matches
        $_SESSION['status'] = 'Authentication successful';
        $_SESSION['redirect'] = 'dashboard.php';
        echo json_encode(array(
            "status" => "success",
            "message" => $_SESSION['status'],
            "redirect" => $_SESSION['redirect'],
        ));
    } else {
        // Verification code doesn't match
        $_SESSION['status'] = "Invalid verification code. Please try again.";
        echo json_encode(array(
            "status" => "error",
            "message" => $_SESSION['status'],
        ));
    }
} else {
    // If the script reaches here, it means it's not a POST request, so return a 404 error
    http_response_code(404);
    exit();
}
