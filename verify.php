<?php
session_start();
include './config/db.php';

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

// this is a function to send email on new registered user, to validate if email is valid and working.
// i used nodemailer here. I install it using vendor.
function verify_email($username, $email, $verify_token)
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com'; //this is the default host name, don`t change this
    $mail->Username = 'ccsched21@gmail.com'; //this is the email responsible for sending a message
    $mail->Password = 'meyj ahxv aiwi aroo';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('dummy@gmail.com', $username);
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Email verification';

    //this is the content of email that will be sent to the new registered user.
    $email_template = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Email Verification</title>
            </head>
            <body>
                <h2>Hello,</h2>
                <p>Thank you for signing up with our service. To complete your registration, please verify your email address by clicking the button below:</p>
                <br/>
                <a href="http://localhost/deyb/verify.php?verify_token=<?php echo $verify_token; ?>" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Verify Email</a>
                <br/>
                <br/>
                <p>If you didn\'t sign up for our service, you can safely ignore this email.</p>
                <p>Thank you,</p>
                <p>The KarGada Team</p>
            </body>
            </html>
        ';

    $mail->Body = $email_template; //set email template to the mail body.

    $mail->send(); //this is called to send the email once the user successfully login
    echo 'Message has been sent';
}

//for registration
if (isset($_POST['register_btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $verify_token = md5(uniqid(rand(), true)); // Generate unique token

    // Check if the email already exists
    $check_email_query = "SELECT * FROM fms_g14_users WHERE email=?";
    $stmt = $con->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result_email = $stmt->get_result();

    // Check if the username already exists
    $check_username_query = "SELECT * FROM fms_g14_users WHERE username=?";
    $stmt = $con->prepare($check_username_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result_username = $stmt->get_result();

    // If either email or username already exists, show error message
    if ($result_email->num_rows > 0) {
        $_SESSION['status'] = "Email already exists!";
        header("Location: login.php");
        exit();
    } elseif ($result_username->num_rows > 0) {
        $_SESSION['status'] = "Username already exists!";
        header("Location: login.php");
        exit();
    }

    // Proceed with user registration if email and username are unique
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security

    // Set default image path
    $default_image_path = '../img/default-img.jpg';

    // Insert into user table
    $query = "INSERT INTO fms_g14_users (username, email, password, verify_token, activate, role, image) VALUES (?, ?, ?, ?, 0, 0, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssss", $username, $email, $hashed_password, $verify_token, $default_image_path); // Default value of activate is 0, so no need to bind here
    $stmt->execute();

    // If saved in the database table, call the verify_email function to send verification email to the newly registered user
    if ($stmt->affected_rows > 0) {
        verify_email($username, $email, $verify_token);
        $_SESSION['status'] = "Registration Successful! Please verify your Email Address";
        $_SESSION['success'] = true; // Set success flag
        header("Location: login.php"); // Redirect to login.php
        exit();
    } else {
        $_SESSION['status'] = "Registration Failed";
        header("Location: login.php"); // If registration failed, redirect back to login.php
        exit();
    }
}

// check if user has token
if (isset($_GET['verify_token'])) {
    $token = $_GET['verify_token'];

    $query = "UPDATE users SET verify_token = NULL WHERE verify_token = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: login.php");
        exit();
    } else {
        echo "Invalid token or user not found.";
        exit();
    }
}
