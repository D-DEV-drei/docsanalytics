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

// Check if the 'folder' parameter exists in the URL
if (isset($_GET['folder'])) {
    $folderId = $_GET['folder'];
    header("Location: integratedTable.php?folder=$folderId");
    exit();
}

// Prepare a SELECT statement to fetch all folders created by the current user along with the associated username
$sql = "SELECT f.id, f.file_name, f.created_at, u.username
        FROM fms_g14_folder as f
        INNER JOIN fms_g14_users as u ON f.user_id = u.id
        WHERE f.user_id = ? AND f.parent_id = 0 AND f.active = 0";
$stmt = mysqli_prepare($con, $sql);

// Bind the user_id parameter to the prepared statement
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $fileId, $file_name, $created_at, $username);

// Fetch the data and store it in an array
$folders = array();
while (mysqli_stmt_fetch($stmt)) {
    $folders[] = array(
        'id' => $fileId,
        'file_name' => $file_name,
        'created_at' => $created_at,
        'username' => $username,
    );
}
mysqli_stmt_close($stmt);

// Fetch file information for each folder
$files = array();
foreach ($folders as $folder) {
    $folder_name = $folder['file_name'];
    $files[$folder_name] = array();

    // Query to fetch files for the current folder
    $file_query = "SELECT name, date_updated FROM fms_g14_files WHERE folder_id = ?";
    $file_stmt = mysqli_prepare($con, $file_query);
    mysqli_stmt_bind_param($file_stmt, "s", $folder_name);
    mysqli_stmt_execute($file_stmt);
    mysqli_stmt_bind_result($file_stmt, $file_name, $file_created_at);

    // Fetch file data and store it in the $files array
    while (mysqli_stmt_fetch($file_stmt)) {
        $files[$folder_name][] = array(
            'name' => $file_name,
            'date_updated' => $file_created_at,
        );
    }
    mysqli_stmt_close($file_stmt);
}

mysqli_close($con);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <title>Folder Management</title>

    <style>
        .dropdown-toggle-no-caret::after {
            display: none;
        }

        .folder-container {
            display: flex;
            width: 100%;
            flex-wrap: wrap;
            justify-content: space-between;
            align-content: flex-start;
            max-height: 80vh;
        }

        .folder {
            width: calc(33.33% - 50px);
            margin-bottom: 50px;
            position: relative;
        }

        .ellipses-wrapper {
            position: absolute;
            top: 5px;
            right: 5px;
        }


        .menu-options {
            position: absolute;
            top: 10px;
            left: calc(60%);
            width:  300px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 10px;
            display: none;
            z-index: 100;
        }

        .menu-options ul {
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        .modal {
            z-index: 9999 !important; /* Adjust the z-index value as needed */
        }

        @media only screen and (max-width: 768px) {
    .folder-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .folder {
        width: 100%;
        margin-bottom: 20px;
    }
}

    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include '../config/sidebar.php'?>

    <!-- Main Content -->
<div class="content">
    <!-- Navbar -->
    <?php include '../config/header.php'?>
    <main>
        <div class="header">
            <div class="left">
                <h1>Folder Management</h1>
                <p id="current-directory">Current Directory: </p> <!-- Placeholder for current directory -->
            </div>
            <!-- Button for folder creation -->
            <div class="right">
                <button class="btn btn-primary" onclick="openAddFolderModal()">Create New Folder</button>
                <button class="btn btn-warning" onclick="openRestoreFolderModal()">Restore Folder</button>
            </div>
        </div>

       <!-- Grid view for created folders -->
       <div class="folder-filter">
            <select id="folder-name-filter">
                <option value="" selected disabled>Select folder</option>
                <?php foreach ($folders as $folder): ?>
                    <option value="<?php echo $folder['file_name']; ?>"><?php echo $folder['file_name']; ?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="bottom-data container-fluid folder-containers">

       <div class="orders"  style="background-color: white !important">
        <div class="header">
            <!-- Folder  -->
            <div class="folder-container" style="background-color: transparent">
                <?php
                    $folder_count = count($folders);
                    foreach ($folders as $index => $folder):
                        $folder_name = $folder['file_name'];
                        if (strlen($folder_name) > 20) {
                            $folder_name = substr($folder_name, 0, 20) . '...';
                        }
                        // Add a class to identify the last folder in each row
                        $class = ($index + 1) % 3 == 0 || $index == $folder_count - 1 ? 'last-in-row' : '';
                ?>
                    <div class="folder <?php echo $class; ?>" data-folder-id="<?php echo $folder['id']; ?>">
                        <i class='bx bx-folder'></i>
                        <span title="<?php echo $folder['file_name']; ?>"><?php echo $folder_name; ?></span>
                        <div class="ellipses-wrapper">
                            <div class="ellipses-icon">
                                <i class='bx bx-dots-vertical-rounded'></i>
                            </div>
                            <div class="menu-options">
                                <ul>
                                    <li><a href="#" class="renameOption"><i class='bx bx-rename'></i> Rename</a></li>
                                    <li><a href="#" class="downloadOption"><i class='bx bx-download'></i> Download</a></li>
                                    <li><a href="#" class="deleteOption"><i class='bx bx-trash'></i> Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        </div>
        </div>

        <!-- <h2>Files</h2> -->
        <!-- Files table -->
        <div class="bottom-data files-containers">
            <div class="orders">
                <div class="header">
                    <i class='bx bx-receipt'></i>
                    <h3>List of Files</h3>

                    <div class="right">
                    <a id="view-integrated-data" href="folderCreation.php?folder=">
                        <button class="btn btn-success">View Integrated Data</button>
                    </a>
                    </div>
                </div>
                <table id="request-table" class="files-table">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Folder</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="files-table-body">
                        <?php
                            foreach ($folders as $folder) {
                                $folderId = $folder['id'];

                                $file_query = "SELECT f.name, f.description, fl.file_name, f.date_updated, f.file_path FROM fms_g14_files as f
                                                                            JOIN fms_g14_inbound as i on i.files_id = f.id
                                                                            join fms_g14_folder as fl on fl.id = f.folder_id
                                                                            WHERE folder_id = ? AND i.status = 'Accepted'";
                                $file_stmt = mysqli_prepare($con, $file_query);
                                mysqli_stmt_bind_param($file_stmt, "i", $folderId);
                                mysqli_stmt_execute($file_stmt);
                                mysqli_stmt_bind_result($file_stmt, $file_name, $description, $folder_name, $date_updated, $file_path);

                                while (mysqli_stmt_fetch($file_stmt)) {
                                    echo "<tr>";
                                    echo "<td>" . $file_name . "</td>";
                                    echo "<td>" . $folder_name . "</td>";
                                    echo "<td>" . $description . "</td>";
                                    echo "<td>" . $date_updated . "</td>";
                                    echo "<td><a href='" . $file_path . "' target='_blank'><i class='bx bx-show'></i></a> <a href='" . $file_path . "' download><i class='bx bx-download'></i></a></td>";
                                    echo "</tr>";
                                }

                                mysqli_stmt_close($file_stmt);
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Environmental Sub Folder Table -->
        <!-- <div class="bottom-data files-containers">
            <div class="orders">
                <div class="header">
                    <i class='bx bx-receipt'></i>
                    <h3>Environmental Reports</h3>
                </div>
                <table id="request-table" class="files-table">
                    <thead>
                        <tr>
                            <th>Trip ID</th>
                            <th>Fuel Cost</th>
                            <th>Fuel Usage</th>
                            <th>Carbon Emission</th>
                            <th>Rainfall Rate</th>
                            <th>Current Weather</th>
                            <th>Air Quality</th>
                            <th>Wind Speed</th>
                            <th>Wind Direction</th>
                            <th>Wind Angle</th>
                            <th>Temperature</th>
                            <th>Humidity</th>
                            <th>Visibility</th>
                            <th>UV Index</th>
                            <th>Solar Radiation</th>
                            <th>Air Pressure</th>
                            <th>Sea Level Pressure</th>
                            <th>Alerts</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody id="files-table-body">
                    <?php
                        // $environmental_query = "SELECT sd_trip_id, sd_fuelcost, sd_fuelconsumption, sd_carbon_emission, sd_rainfall_rate, sd_current_weather, sd_air_quality, sd_wind_speed, sd_wind_direction, sd_wind_angle, sd_temperature, sd_humidity, sd_visibility, sd_uv_index, sd_solar_radiation, sd_pressure, sd_sealevel_pressure, alerts, sd_modified_date FROM fms_g11_sustainability_data";
                        // $environmental_result = mysqli_query($con, $environmental_query);

                        // while ($row = mysqli_fetch_assoc($environmental_result)) {
                        //     echo "<tr>";
                        //     echo "<td>" . $row['sd_trip_id'] . "</td>";
                        //     echo "<td>" . $row['sd_fuelcost'] . "</td>";
                        //     echo "<td>" . $row['sd_fuelconsumption'] . "</td>";
                        //     echo "<td>" . $row['sd_carbon_emission'] . "</td>";
                        //     echo "<td>" . $row['sd_rainfall_rate'] . "</td>";
                        //     echo "<td>" . $row['sd_current_weather'] . "</td>";
                        //     echo "<td>" . $row['sd_air_quality'] . "</td>";
                        //     echo "<td>" . $row['sd_wind_speed'] . "</td>";
                        //     echo "<td>" . $row['sd_wind_direction'] . "</td>";
                        //     echo "<td>" . $row['sd_wind_angle'] . "</td>";
                        //     echo "<td>" . $row['sd_temperature'] . "</td>";
                        //     echo "<td>" . $row['sd_humidity'] . "</td>";
                        //     echo "<td>" . $row['sd_visibility'] . "</td>";
                        //     echo "<td>" . $row['sd_uv_index'] . "</td>";
                        //     echo "<td>" . $row['sd_solar_radiation'] . "</td>";
                        //     echo "<td>" . $row['sd_pressure'] . "</td>";
                        //     echo "<td>" . $row['sd_sealevel_pressure'] . "</td>";
                        //     echo "<td>" . $row['alerts'] . "</td>";
                        //     echo "<td>" . $row['sd_modified_date'] . "</td>";
                        //     echo "</tr>";
                        // }

                        // mysqli_free_result($environmental_result);
                    ?>
                    </tbody>
                </table>
            </div>
        </div> -->

        <!-- Delivery Sub Folder Table -->
        <div class="bottom-data files-containers">
            <div class="orders">
                <div class="header">
                    <i class='bx bx-receipt'></i>
                    <h3>Delivery Reports</h3>
                </div>
                <table id="request-table" class="files-table">
                    <thead>
                        <tr>
                            <th>Trip ID</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Driver</th>
                            <th>Vehicle</th>
                            <th>Status</th>
                            <th>Trip Report</th>
                            <th>Tracking Code</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody id="files-table-body">
                        <?php
                        $delivery_query = "SELECT fms_g11_trips.*, fms_g12_drivers.d_first_name AS driver_name
                        FROM fms_g11_trips
                        JOIN fms_g12_drivers ON fms_g11_trips.t_driver = fms_g12_drivers.d_id";
                        
                        $delivery_result = mysqli_query($con, $delivery_query);

                        // Fetching and displaying data
                        while ($row = mysqli_fetch_assoc($delivery_result)) {
                            echo "<tr>";
                            echo "<td>" . $row['t_id'] . "</td>";
                            echo "<td>" . $row['t_start_date'] . "</td>";
                            echo "<td>" . $row['t_end_date'] . "</td>";
                            echo "<td>" . $row['t_trip_fromlocation'] . "</td>";
                            echo "<td>" . $row['t_trip_tolocation'] . "</td>";
                            echo "<td>" . $row['driver_name'] . "</td>";
                            echo "<td>" . $row['t_vehicle'] . "</td>";
                            echo "<td>" . $row['t_trip_status'] . "</td>";
                            echo "<td>" . $row['t_remarks'] . "</td>";
                            echo "<td>" . $row['t_trackingcode'] . "</td>";
                            echo "<td>" . $row['t_created_date'] . "</td>";
                            echo "</tr>";
                        }

                        // Free result set
                        mysqli_free_result($delivery_result);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <br>
        <br>
        <br>
    </main>
</div>



<!-- Rename Folder Modal -->
    <div class="modal fade" id="renameFolderModal" tabindex="-1" role="dialog" aria-labelledby="renameFolderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="renameFolderModalLabel">Rename Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="renameFolderForm">
                        <div class="form-group">
                            <label for="newFolderName">New Folder Name:</label>
                            <input type="text" class="form-control" id="newFolderName" name="newFolderName" required>
                        </div>
                        <input type="hidden" id="folderIdToUpdate" name="folderIdToUpdate">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="renameFolder()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include addFolderModal.php which is modal for adding new user-->
    <?php include '../modal/addFolderModal.php'?>
    <?php include '../modal/restoreFolderModal.php'?>

    <!-- Include your jQuery and other JavaScript files here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


    <!-- this is for interactive table: pagination, search bar and show entries -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
       $(document).ready(function() {
    $('#folder-name-filter').on('change', function() {
        var selectedFolder = $(this).val().trim().toLowerCase(); // Get the selected folder name

        $('.folder').each(function() {
            var folderName = $(this).find('span').attr('title').trim().toLowerCase(); // Get the full folder name from the title attribute
            if (selectedFolder === '' || folderName === selectedFolder) {
                $(this).show(); // Show the folder container if selected folder matches or if no folder is selected
            } else {
                $(this).hide(); // Hide the folder container if selected folder doesn't match
            }
        });
    });


            $('#request-table').DataTable({
                "paging": true, // Enable pagination
                "pageLength": 5 // Set number of entries per page
            });
        });

        function handleRenameClick(folderId, currentFolderName) {
            $('#folderIdToUpdate').val(folderId);
            $('#newFolderName').val(currentFolderName);
            $('#renameFolderModal').modal('show');
        }

        // Adjust menu options position based on folder position
        $('.folder').each(function(index) {
            // Check if the folder is the last in a row
            if ($(this).hasClass('last-in-row')) {
                // Position the menu options to the left
                $(this).find('.menu-options').css('left', '-290px');
            }
        });

        // Event listener for click on "Rename" option
            $('.renameOption').click(function(event) {
                event.preventDefault();
                var folderId = $(this).closest('.folder').data('folder-id'); // Get folder ID
                var currentFolderName = $(this).closest('.folder').find('span').attr('title'); // Get current folder name
                // Call function to handle rename click
                handleRenameClick(folderId, currentFolderName);
            });


    function renameFolder() {
    var newFolderName = document.getElementById('newFolderName').value;

    var folderIdToUpdate = document.getElementById('folderIdToUpdate').value;

    // AJAX request to update the folder name
    $.ajax({
        type: "POST",
        url: "renameFolder.php", // Update the URL accordingly
        data: { newFolderName: newFolderName, folderIdToUpdate: folderIdToUpdate },
        success: function(response) {
            // Handle success response
            console.log("Folder renamed successfully:", response);

            $('#renameFolderModal').modal('hide');
            location.reload();

        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error("Error renaming folder:", error);

        }
    });
    location.reload();


}

$('.downloadOption').click(function(event) {
    event.preventDefault();
    var folderId = $(this).closest('.folder').data('folder-id'); // Get folder ID

    // Prompt the user for the download path
    var downloadPath = prompt("Please enter the download path (e.g., C:\\Downloads):");

    if (downloadPath !== null) { // If the user didn't cancel the prompt
        // Send AJAX request to download folder
        $.ajax({
            type: "POST",
            url: "downloadFolder.php",
            data: { folder_id: folderId, download_path: downloadPath }, // Include the download path in the data
            success: function(response) {
                console.log("Folder downloaded successfully:", response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error downloading folder:", error);
            }
        });
    }
});

    </script>

    <!-- Delete Script -->
    <script>
        $(document).ready(function() {
        $('.deleteOption').click(function(event) {
            event.preventDefault();
            var folderId = $(this).closest('.folder').data('folder-id'); // Get folder ID
            var folderName = $(this).closest('.folder').find('span').attr('title'); // Get folder name
            if (confirm("Are you sure you want to delete the folder '" + folderName + "'?")) {
                // Send an AJAX request to delete the folder
                $.ajax({
                    type: "POST",
                    url: "deleteFolder.php",
                    data: { folderId: folderId },
                    success: function(response) {
                        console.log("Folder deleted successfully:", response);

                        $(this).closest('.folder').remove();
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error deleting folder:", error);
                    }
                });
            }
            location.reload();
        });
    });

    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select all ellipsis icons within folders
        var ellipsisMenus = document.querySelectorAll(".folder .ellipses-icon");

        // Iterate over each ellipsis icon
        ellipsisMenus.forEach(function(ellipsisMenu) {
            // Add click event listener to each ellipsis icon
            ellipsisMenu.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevent event from bubbling up

                // Log debugging message
                console.log("Ellipsis menu clicked");

                // Find the menu options relative to the clicked ellipsis icon
                var menuOptions = ellipsisMenu.parentElement.querySelector('.menu-options');

                // Check if menu options exist
                if (menuOptions) {
                    // Close all other menu options before opening this one
                    closeAllMenuOptions();

                    // Display the menu options
                    menuOptions.style.display = "block";

                    // Log debugging message
                    console.log("Menu options displayed");
                } else {
                    // Log error message if menu options not found
                    console.error("Menu options not found");
                    console.log("Ellipsis menu:", ellipsisMenu);
                }
            });
        });
    });

    // Function to close all menu options
    function closeAllMenuOptions() {
        // Select all menu options and hide them
        var allMenuOptions = document.querySelectorAll(".menu-options");
        allMenuOptions.forEach(function(menuOptions) {
            menuOptions.style.display = "none";
        });
    }

    var directoryPath = [];

    // Function to handle folder click event
    function handleFolderClick(folder) {
        var folderName = folder.querySelector("span").textContent;
        var folderId = folder.getAttribute("data-folder-id");

        console.log("Folder ID:", folderId); // Debugging

        // Update the href attribute of the anchor tag
        $("#view-integrated-data").attr("href", "folderCreation.php?folder=" + folderId);

        // Clear the existing content of the folders container
        document.querySelector(".bottom-data").innerHTML = "";

        // Check if the directory path is empty
        if (directoryPath.length > 0) {
            // If not empty, append the folder name to the directory path
            directoryPath.push(folderName);
        } else {
            // If empty, set the directory path to the folder name
            directoryPath = [folderName];
        }

        // Update the current directory
        updateCurrentDirectory();

        // AJAX request to fetch files and subfolders associated with the clicked folder
        $.ajax({
            type: "POST",
            url: "../assets/ajax/fetch_files_and_subfolders.php",
            data: { folderId: folderId },
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);

                console.log("data: ", data);

                if (data.files.length > 0) {
                    // If there are files, display them in the files table
                    var filesTableBody = document.getElementById("files-table-body");
                    filesTableBody.innerHTML = ""; // Clear existing content
                    data.files.forEach(function(file) {
                        var row = "<tr><td>" + file.name + "</td><td>" + file.folder + "</td><td>" + file.description + "</td><td>" + file.date_updated + "</td><td><a href='" + file.file_path + "' target='_blank'><i class='bx bx-show'></i></a> <a href='" + file.file_path + "' download><i class='bx bx-download'></i></a></td></tr>";
                        filesTableBody.innerHTML += row;
                    });
                } else {
                    // If no files, clear the files table
                    document.getElementById("files-table-body").innerHTML = "";
                }

                if (data.subfolders.length > 0) {
                    // Create containers for subfolders
                    var foldersContainer = $("<div class='bottom-data container-fluid'></div>");
                    var ordersContainer = $("<div class='orders' style='background-color: white !important'></div>");
                    var headerContainer = $("<div class='header'></div>");

                    // Append subfolders to the containers
                    ordersContainer.append(headerContainer);
                    foldersContainer.append(ordersContainer);

                    // Loop through subfolders to create folder elements
                    var subfolders = data.subfolders;
                    var subfoldersCount = subfolders.length;
                    var subfoldersInRow = 3;
                    var rowCount = Math.ceil(subfoldersCount / subfoldersInRow);

                    // Create rows of subfolders
                    for (var i = 0; i < rowCount; i++) {
                        var rowContainer = $("<div class='folder-container'></div>");
                        for (var j = i * subfoldersInRow; j < Math.min((i + 1) * subfoldersInRow, subfoldersCount); j++) {
                            var subfolder = subfolders[j];
                            var folderContainer = $("<div class='folder' data-folder-id='" + subfolder.id + "'></div>");
                            var folderIcon = $("<i class='bx bx-folder'></i>");
                            var folderName = $("<span></span>").attr('title', subfolder.file_name).text(subfolder.file_name.length > 20 ? subfolder.file_name.substring(0, 20) + '...' : subfolder.file_name);
                            var ellipsesWrapper = $("<div class='ellipses-wrapper'></div>");
                            var ellipsesIcon = $("<div class='ellipses-icon'><i class='bx bx-dots-vertical-rounded'></i></div>");
                            var menuOptions = $(`<div class='menu-options'>
                                <ul>
                                    <li><a href='#' class='renameOption'><i class='bx bx-rename'></i> Rename</a></li>
                                    <li><a href='#' class='downloadOption'><i class='bx bx-download'></i> Download</a></li>
                                    <li><a href='#' class='deleteOption'><i class='bx bx-trash'></i> Delete</a></li>
                                </ul>
                            </div>`);

                            folderContainer.append(folderIcon);
                            folderContainer.append(folderName);
                            ellipsesWrapper.append(ellipsesIcon);
                            folderContainer.append(ellipsesWrapper);
                            folderContainer.append(menuOptions);
                            rowContainer.append(folderContainer);
                        }
                        headerContainer.append(rowContainer);
                    }

                    // Replace the existing folder containers with the new ones
                    $(".folder-containers").replaceWith(foldersContainer);

                    // Event delegation for handling clicks on folders
                    $(document).on("click", ".folder[data-folder-id]", function() {
                        handleFolderClick(this);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log("Error fetching files and subfolders:", error);
            }
        });
    }

    // Function to position menu options relative to the ellipsis icon in subfolders
    function positionMenuOptions() {
        $('.folder').each(function() {
            var ellipsesWrapper = $(this).find('.ellipses-wrapper');
            var menuOptions = $(this).find('.menu-options');
            var ellipsesIcon = $(this).find('.ellipses-icon');

            // Position menu options to the right of ellipsis icon
            var iconWidth = ellipsesIcon.outerWidth();
            var optionsWidth = menuOptions.outerWidth();
            var wrapperWidth = ellipsesWrapper.outerWidth();
            var offset = (wrapperWidth - optionsWidth) / 2;
            menuOptions.css('right', -iconWidth - offset);
        });
    }

    // Call the positionMenuOptions function after rendering the subfolders
    positionMenuOptions();

    // Function to update the current directory
    function updateCurrentDirectory() {
        var currentDirectory = document.getElementById("current-directory");
        currentDirectory.innerHTML = "Current Directory: ";
        directoryPath.forEach(function(directory, index) {
            if (index > 0) {
                currentDirectory.innerHTML += " / ";
            }
            var directoryLink = document.createElement("a");
            directoryLink.textContent = directory;
            directoryLink.href = "folderCreation.php";

            directoryLink.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent default navigation behavior
                window.location.reload(); // Reload the page
            });
            currentDirectory.appendChild(directoryLink);
        });
    }

    // Get all folders and attach click event listeners
    var folders = document.querySelectorAll(".folder");
    folders.forEach(function(folder) {
        folder.addEventListener("click", function() {
            handleFolderClick(folder);
        });
    });

    // Call the updateCurrentDirectory function to display the initial current directory
    updateCurrentDirectory();

    function openAddFolderModal() {
        $('#addFolderModal').modal('show');
    }

    function openRestoreFolderModal() {
        $('#restoreFolderModal').modal('show');
    }

    $(document).ready(function() {
        // Check for success message in URL query parameters
        const urlParams = new URLSearchParams(window.location.search);
        const uploadSuccess = urlParams.get('upload_success');
        const uploadError = urlParams.get('upload_error');

        // If upload was successful, display success modal
        if (uploadSuccess) {
            $('#successModal').modal('show');
        }

        // If there was an error, display error modal with error message
        if (uploadError) {
            $('#errorModal').find('.modal-body').text(uploadError);
            $('#errorModal').modal('show');
        }
    });
</script>


    <script>
$(document).ready(function() {

    $(document).on("click", ".menu-options .renameOption", function(event) {
    event.preventDefault();
    var folderId = $(this).closest('.folder').data('folder-id'); // Get folder ID
    var currentFolderName = $(this).closest('.folder').find('span').attr('title'); // Get current folder name
    // Call function to handle rename click
    handleRenameClick(folderId, currentFolderName);
});

// Event delegation for handling clicks on subfolder menu options
$(document).on("click", ".menu-options .deleteOption", function(event) {
    event.preventDefault();
    var folderId = $(this).closest('.folder').data('folder-id'); // Get folder ID
    var folderName = $(this).closest('.folder').find('span').attr('title'); // Get folder name
    console.log("folder id: ", folderId);
    console.log("folderName: ", folderName);
    if (confirm("Are you sure you want to delete the folder '" + folderName + "'?")) {
        // Send an AJAX request to delete the folder
        $.ajax({
            type: "POST",
            url: "deleteFolder.php",
            data: { folderId: folderId },
            success: function(response) {
                console.log("Folder deleted successfully:", response);
                // Optionally, you can remove the folder from the UI
                $(this).closest('.folder').remove();
                // Instead of removing the folder immediately, you can reload the page after successful deletion
                location.reload(); // Reload the page or update the UI as needed
            },
            error: function(xhr, status, error) {
                console.error("Error deleting folder:", error);
                // You can display an error message to the user if the deletion fails
                alert("Failed to delete folder: " + error);
            }
        });
    }
});


// Event delegation for handling clicks on subfolder menu options
$(document).on("click", ".menu-options .downloadOption", function(event) {
    event.preventDefault();
    var folderId = $(this).closest('.folder').data('folder-id'); // Get folder ID

    // Prompt the user to choose whether to download from this subfolder or from the parent folder
    
        var downloadPath = prompt("Please enter the download path (e.g., C:\\Downloads):");

        if (downloadPath !== null) { // If the user didn't cancel the prompt
            // Send AJAX request to download subfolder
            $.ajax({
                type: "POST",
                url: "downloadFolder.php",
                data: { folder_id: folderId, download_path: downloadPath }, // Include the download path in the data
                success: function(response) {
                    console.log("Folder downloaded successfully:", response);
                    // Optionally, you can reload the page or update the UI as needed
                },
                error: function(xhr, status, error) {
                    console.error("Error downloading folder:", error);
                }
            });
        }

});

});


    </script>
    <!-- dashboard javascript -->
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>