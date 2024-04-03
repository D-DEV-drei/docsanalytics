<?php
session_start();
include '../config/db.php';

// Check if the user is logged in and if the user ID is set in the session
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Get the user ID
} else {
    header("Location: ../login.php"); // Redirect to login when no user ID detected
    exit; // Stop further execution
}

// Handle the form submission to add a new folder
if (isset($_POST['folder_name'])) {

    // Get the folder name and parent folder ID from the form
    $folder_name = $_POST['folder_name'];
    $parent_folder_id = $_POST['parent_folder_id'];

    // Validate folder name
    if (empty($folder_name)) {
        header("Location: folderCreation.php?upload_error=" . urlencode("Folder name cannot be empty."));
        exit();
    } else {
        // Check for duplicate folder name
        $sql_check_duplicate = "SELECT * FROM fms_g14_folder WHERE file_name = '$folder_name' AND user_id = '$user_id' AND parent_id = '$parent_folder_id'";
        $result_check_duplicate = mysqli_query($con, $sql_check_duplicate);
        if (mysqli_num_rows($result_check_duplicate) > 0) {
            header("Location: folderCreation.php?upload_error=" . urlencode("Folder name already exists. Please choose a different name."));
            exit();
        } else {
            // Insert the new folder into the database
            $sql = "INSERT INTO fms_g14_folder (user_id, file_name, parent_id) VALUES ('$user_id', '$folder_name', '$parent_folder_id')";

            if (mysqli_query($con, $sql)) {
                // Folder added successfully
                header("Location: folderCreation.php");
                exit;
            } else {
                // Error adding folder
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
        }
    }

    // Close the database connection
    mysqli_close($con);
}
