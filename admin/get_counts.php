    <?php
    // Include database connection
    include '../config/db.php';

    // Initialize session
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id']; // Get the user ID

        // Check if the folder_id parameter is set
        if (isset($_POST['folder_id'])) {
            $selected_folder_id = $_POST['folder_id'];

            // SQL query to retrieve the count of accesses for the selected folder
            $sqlAccessCount = "SELECT COUNT(*) AS access_count FROM fms_g14_access WHERE folder_id = ?";
            $stmtAccessCount = mysqli_prepare($con, $sqlAccessCount);
            mysqli_stmt_bind_param($stmtAccessCount, "i", $selected_folder_id);
            mysqli_stmt_execute($stmtAccessCount);
            mysqli_stmt_bind_result($stmtAccessCount, $access_count);
            mysqli_stmt_fetch($stmtAccessCount);
            mysqli_stmt_close($stmtAccessCount);

            // SQL query to sum the views for files in the selected folder
            $sqlSumViews = "SELECT SUM(view) AS total_views FROM fms_g14_outbound AS o INNER JOIN fms_g14_files AS f ON o.files_id = f.id WHERE f.folder_id = ?";
            $stmtSumViews = mysqli_prepare($con, $sqlSumViews);
            mysqli_stmt_bind_param($stmtSumViews, "i", $selected_folder_id);
            mysqli_stmt_execute($stmtSumViews);
            mysqli_stmt_bind_result($stmtSumViews, $total_views);
            mysqli_stmt_fetch($stmtSumViews);
            mysqli_stmt_close($stmtSumViews);

            // SQL query to sum the downloads for files in the selected folder
            $sqlSumDownloads = "SELECT SUM(download) AS total_downloads FROM fms_g14_outbound AS o INNER JOIN fms_g14_files AS f ON o.files_id = f.id WHERE f.folder_id = ?";
            $stmtSumDownloads = mysqli_prepare($con, $sqlSumDownloads);
            mysqli_stmt_bind_param($stmtSumDownloads, "i", $selected_folder_id);
            mysqli_stmt_execute($stmtSumDownloads);
            mysqli_stmt_bind_result($stmtSumDownloads, $total_downloads);
            mysqli_stmt_fetch($stmtSumDownloads);
            mysqli_stmt_close($stmtSumDownloads);

            // SQL query to count the files in the selected folder
            $sqlFileCount = "SELECT COUNT(*) AS file_count FROM fms_g14_files WHERE folder_id = ?";
            $stmtFileCount = mysqli_prepare($con, $sqlFileCount);
            mysqli_stmt_bind_param($stmtFileCount, "i", $selected_folder_id);
            mysqli_stmt_execute($stmtFileCount);
            mysqli_stmt_bind_result($stmtFileCount, $file_count);
            mysqli_stmt_fetch($stmtFileCount);
            mysqli_stmt_close($stmtFileCount);

            // Return the counts as JSON
            echo json_encode(array(
                'access_count' => $access_count,
                'total_views' => $total_views,
                'total_downloads' => $total_downloads,
                'file_count' => $file_count,
            ));

        } else {
            // If folder_id parameter is not set
            echo json_encode(array('error' => 'Folder ID not provided'));
        }
    } else {
        // If user is not logged in, redirect to login page
        header("Location: ../login.php");
        exit(); // Stop executing the script further
    }

