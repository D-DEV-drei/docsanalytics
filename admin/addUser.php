<?php
include '../config/db.php'; 

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $userType = $_POST['userType']; // Get the selected user type

    // Check if an image is uploaded
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
        $targetDir = "../assets/uploads/"; // Directory where images will be stored
        $targetFile = $targetDir . basename($_FILES['profileImage']['name']);
        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFile)) {
            $image = $targetFile; // Set image path if uploaded successfully
        }
    } else {
        // Use default image path if no image is uploaded
        $image = "../img/default-img.jpg"; // Default image path
    }

    // Check if email or username already exists
    $checkQuery = "SELECT * FROM fms_g14_users WHERE email = '$email' OR username = '$username'";
    $checkResult = mysqli_query($con, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        header("Location: userManage.php?upload_error=" . urlencode("User with the provided email or username already exists"));

        mysqli_close($con); // Close database connection
        exit; // Stop further execution
    }

    // Insert data into database
    $sql = "INSERT INTO fms_g14_users (username, email, password, created_at, role, image)
            VALUES ('$username', '$email', '$password', NOW(), $userType, '$image')";
    if (mysqli_query($con, $sql)) {
        echo "User added successfully";
        header("Location: userManage.php?upload_success=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
    // Close database connection
    mysqli_close($con);
}
