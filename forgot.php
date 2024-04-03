<?php
session_start();
include './config/db.php';

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

// Function to send the password reset code via email
function send_reset_code($email, $reset_code)
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'ccsched21@gmail.com'; // Replace with your email
    $mail->Password = 'meyj ahxv aiwi aroo'; // Replace with your password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('dummy@gmail.com', $email);

    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Code';

    // Email template for password reset code
    $email_template = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Password Reset Code</title>
            </head>
            <body>
                <h2>Hello,</h2>
                <p>You have requested to reset your password. Below is your reset code:</p>
                <h3>' . $reset_code . '</h3>
                <p>This code will expire in 1 hour.</p>
                <p>If you didn\'t request a password reset, you can safely ignore this email.</p>
                <p>Thank you,</p>
                <p>Your KarGada Team</p>
            </body>
            </html>
        ';

    $mail->Body = $email_template;

    $mail->send();
    echo 'Message has been sent';
}

// Check if the email exists in the database
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Perform database query to check if the email exists
    $query = "SELECT * FROM fms_g14_users WHERE email = '$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Email exists, generate a 6-digit random code
        $reset_code = mt_rand(100000, 999999);

        // Set expiration time (1 hour from now)
        $expiration_time = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Update the user's record with the reset code and expiration time
        $update_query = "UPDATE fms_g14_users SET code = '$reset_code', expired = '$expiration_time' WHERE email = '$email'";
        mysqli_query($con, $update_query);

        // Send the reset code to the user's email
        send_reset_code($email, $reset_code);
        header("Location: code.php");
        exit();
    } else {
        echo 'Email does not exist in the database';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="./assets/css/login.css">
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Forgot Password form -->
                <form action="forgot.php" class="sign-in-form" method="post">
                    <h2 class="title">Forgot Password</h2>
                    <div class="contains">
                        <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input type="email" placeholder="Email" id="email" name="email" required>
                        </div>
                    </div>
                    <button type="submit" class="btn">Submit</button>
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here ?</h3>
                    <p>Ready to ship with ease? Sign up now and experience seamless freight management!</p>
                    <button class="btn transparent" id="sign-in-btn" onclick="window.location.href='login.php';">Sign in</button>
                </div>
                <img src="img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>
</body>
</html>
