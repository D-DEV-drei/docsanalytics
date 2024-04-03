<?php
session_start();
include '../config/db.php';

$sql = "SELECT id, file_name FROM fms_g14_folder";

// Prepare the SQL statement
$stmt = mysqli_prepare($con, $sql);

// Check if the statement was prepared successfully
if ($stmt) {
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Bind variables to prepared statement
    mysqli_stmt_bind_result($stmt, $id, $file_name);

    // Fetch the data and store it in an array
    $folders = array();
    while (mysqli_stmt_fetch($stmt)) {
        // Store each row's data in the $folders array
        $folders[] = array(
            'id' => $id,
            'file_name' => $file_name,
        );
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // If statement preparation fails, handle the error
    echo "Error: " . mysqli_error($con);
}

// Check if the user is logged in and if the user ID is set in the session
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Get the user ID
} else {
    header("Location: ../login.php"); // Redirect to login when no user id detected
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fileName = pathinfo(basename($_FILES["file"]["name"]), PATHINFO_FILENAME);
    $folderId = $_POST['folderSelect'];
    $fileDescription = $_POST['fileDescription'];
    $userId = $_SESSION['id'];

    // File upload handling
    $targetDirectory = "../assets/uploads/"; // Directory where files will be uploaded
    $fileExtension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION)); // Get file extension
    $targetFileName = $targetDirectory . $fileName . '.' . $fileExtension; // Construct target file path
    $uploadOk = 1; // Flag to check if file upload is successful

    // Check file type
    $allowedFileTypes = array('zip', 'rar', 'sql', 'doc', 'docx', 'pdf', 'xls', 'txt', 'csv', 'jpg', 'png');
    if (!in_array($fileExtension, $allowedFileTypes)) {
        echo "Sorry, only ZIP, RAR, SQL, DOC, PDF, and XLS files are allowed.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFileName)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // Redirect with error message
        header("Location: inbound.php?upload_error=" . urlencode("Sorry, your file was not uploaded."));
        exit();
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFileName)) {
            // File uploaded successfully, proceed to insert data into database
            $sql = "INSERT INTO fms_g14_files (name, description, user_id,  folder_id,  file_type, file_path) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssiiss", $fileName, $fileDescription, $userId, $folderId, $fileExtension, $targetFileName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "The file " . htmlspecialchars($_FILES["file"]["name"]) . " has been uploaded.";
            header("Location: inbound.php?upload_success=1");
            exit();
        } else {
            $error_message = "Sorry, there was an error uploading your file.";
            // Redirect with error message
            header("Location: inbound.php?upload_error=" . urlencode($error_message));
            exit();
        }
    }
}

// Close the database connection
mysqli_close($con);
