<?php
session_start();
include './config/db.php';

// Check if the reset code form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reset_code = $_POST['reset_code'];

    // Limit the length of the reset code to 6 characters
    if (strlen($reset_code) !== 6) {
        $response['status'] = 'error';
        $response['message'] = 'Reset code should be exactly 6 characters long.';
        echo json_encode($response); // Send JSON response
        exit();
    }

    // Query the database to retrieve the stored reset code associated with the user's email
    $query = "SELECT email, expired, code FROM fms_g14_users WHERE code = '$reset_code'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);
        $stored_code = $row['code'];
        $expiration_time = $row['expired'];
        $email = $row['email'];

        // Check if the entered reset code matches the stored code
        if ($reset_code == $stored_code) {
            $_SESSION['email'] = $email;
            $response['status'] = 'success';
            $response['message'] = 'Redirecting to password reset page...';
            $response['redirect'] = 'password_reset.php';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid reset code.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'User not found or multiple users found with the same email.';
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            height: 400px; /* Set the height of the container */
        }

        form {
            width: 100%; /* Set initial width */
            max-width: 1200px; /* Set maximum width */
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 15px;
            font-size: 18px;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 12px 24px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            form {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter Reset Code</h2>
        <form action="code.php" method="post">
            <label for="reset_code">Reset Code:</label>
            <input type="text" id="reset_code" name="reset_code" required maxlength="6">
            <button type="submit">Submit Code</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // Function to display SweetAlert with the provided message and type
        function showAlert(message, type) {
            Swal.fire({
                icon: type,
                text: message,
                confirmButtonText: 'OK'
            });
        }

        // Submit form and handle response
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Send AJAX request to PHP script
            fetch('code.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                // Display SweetAlert based on response
                if (data.status === 'success') {

                showAlert(data.message, 'success').then((result) => {
                // Redirect to login page only if user clicks "OK"
                if (result.isConfirmed) {
                    window.location.href = data.redirect;
                }
            });
        } else {
                    // Show error message
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.', 'error');
            });
        });
        function showAlert(message, type) {
    return Swal.fire({
        icon: type,
        text: message,
        confirmButtonText: 'OK'
    });
}
    </script>
</body>
</html>
