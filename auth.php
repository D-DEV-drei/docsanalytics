<?php
session_start(); // Initialize session
include './config/db.php'; // Include database connection

// Ensure PHPMailer classes are loaded
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

if (isset($_SESSION['last_u_set_time']) && time() - $_SESSION['last_u_set_time'] > 20) {
    $_SESSION['u'] = 0; // Reset $_SESSION['u'] to 0
}
// Function to send login verification code
function send_login_verification_code($email, $verification_code)
{
    // Instantiate PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ccsched21@gmail.com'; //this is the email responsible for sending a message
        $mail->Password = 'meyj ahxv aiwi aroo';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('dummy@gmail.com', $email);
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Login Verification Code';
        $mail->Body = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Login Verification</title>
            </head>
            <body>
                <h2>Hello,</h2>
                <p>Here is your login verification code:</p>
                <p><strong>' . $verification_code . '</strong></p>
                <p>Please use this code to complete your login process.</p>
                <p>If you didn\'t request this code, you can safely ignore this email.</p>
                <p>Thank you,</p>
                <p>The KarGada Team</p>
            </body>
            </html>
        ';

        // Send email
        $mail->send();
    } catch (Exception $e) {
        // Handle exceptions
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch user data
    $query = "SELECT * FROM fms_g14_users WHERE username = ? AND verify_token IS NULL AND activate = 1";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, fetch user data
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];
        $role = $row['role'];

        if (password_verify($password, $stored_password)) {
            // Successful login
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['Active_Time'] = time();
            // Redirect based on role
            if ($role == 1) {
                $verificationCode = generateVerificationCode();
                $_SESSION['verification_code'] = $verificationCode;
                send_login_verification_code($_SESSION['email'], $verificationCode);

                echo json_encode(array("redirect" => "./admin/verify_login.php"));
            } else {
                echo json_encode(array("redirect" => "./users/inbound.php"));
            }
        } else {
            // Failed login attempt
            if ($role == 1) {
                // Check login attempts
                $_SESSION['u'] = isset($_SESSION['u']) ? $_SESSION['u'] + 1 : 1;
                if ($_SESSION['u'] >= 3) {
                    $_SESSION['last_u_set_time'] = time();
                    $_SESSION['status'] = "You've reached the limit. Please wait for 30 minutes to login.";
                    echo json_encode(array("status" => $_SESSION['status']));
                    exit();
                } else {
                    $_SESSION['status'] = "You entered incorrect username or password. Attempt: " . $_SESSION['u'] . " of 3";
                    echo json_encode(array("status" => $_SESSION['status']));
                    exit();
                }
            } else {
                $_SESSION['status'] = "You entered incorrect username or password.";
                echo json_encode(array("status" => $_SESSION['status']));
                exit();
            }
        }
    } else {
        $_SESSION['status'] = "You entered incorrect username or password.";
        echo json_encode(array("status" => $_SESSION['status']));
        exit();
    }
}

// Function to generate verification code
function generateVerificationCode()
{
    $characters = '0123456789';
    $verificationCode = '';
    $codeLength = 6;

    // Generate random code
    for ($i = 0; $i < $codeLength; $i++) {
        $verificationCode .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $verificationCode;
}

$status = isset($_SESSION['status']) ? $_SESSION['status'] : ''; // If there is a status, display it, otherwise, display an empty string.

unset($_SESSION['status']); // Unset the status to prevent repeated display
