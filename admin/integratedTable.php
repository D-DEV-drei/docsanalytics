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

$folder = $_GET['folder'] ?? '';

// if the selected folder is not subfolder, redirect the user on folderCreation page
$query = "SELECT parent_id FROM fms_g14_folder WHERE id = $folder";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $parent_id = $row['parent_id'];

    if ($parent_id == 0) {
        header("Location: folderCreation.php");
        exit(); 
    }
} else {
    // Handle query error
    echo "Error: " . mysqli_error($con);
}

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
                </div>
                <!-- Button for folder creation -->
                <div class="right">
                    <a id="view-integrated-data" href="folderCreation.php">
                        <button class="btn btn-primary">Back</button>
                    </a>
                </div>
            </div>

            <!-- Sustainable Main Folder -->
            <!-- Environmental Sub Folder Table -->
            <?php
                // change this according to folder_id
                if ($folder == 29) {
            ?>
            <div class="bottom-data files-containers">
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
                            $environmental_query = "SELECT sd_trip_id, sd_fuelcost, sd_fuelconsumption, sd_carbon_emission, sd_rainfall_rate, sd_current_weather, sd_air_quality, sd_wind_speed, sd_wind_direction, sd_wind_angle, sd_temperature, sd_humidity, sd_visibility, sd_uv_index, sd_solar_radiation, sd_pressure, sd_sealevel_pressure, alerts, sd_modified_date FROM fms_g11_sustainability_data";
                            $environmental_result = mysqli_query($con, $environmental_query);

                            while ($row = mysqli_fetch_assoc($environmental_result)) {
                                echo "<tr>";
                                echo "<td>" . $row['sd_trip_id'] . "</td>";
                                echo "<td>" . $row['sd_fuelcost'] . "</td>";
                                echo "<td>" . $row['sd_fuelconsumption'] . "</td>";
                                echo "<td>" . $row['sd_carbon_emission'] . "</td>";
                                echo "<td>" . $row['sd_rainfall_rate'] . "</td>";
                                echo "<td>" . $row['sd_current_weather'] . "</td>";
                                echo "<td>" . $row['sd_air_quality'] . "</td>";
                                echo "<td>" . $row['sd_wind_speed'] . "</td>";
                                echo "<td>" . $row['sd_wind_direction'] . "</td>";
                                echo "<td>" . $row['sd_wind_angle'] . "</td>";
                                echo "<td>" . $row['sd_temperature'] . "</td>";
                                echo "<td>" . $row['sd_humidity'] . "</td>";
                                echo "<td>" . $row['sd_visibility'] . "</td>";
                                echo "<td>" . $row['sd_uv_index'] . "</td>";
                                echo "<td>" . $row['sd_solar_radiation'] . "</td>";
                                echo "<td>" . $row['sd_pressure'] . "</td>";
                                echo "<td>" . $row['sd_sealevel_pressure'] . "</td>";
                                echo "<td>" . $row['alerts'] . "</td>";
                                echo "<td>" . $row['sd_modified_date'] . "</td>";
                                echo "</tr>";
                            }

                            mysqli_free_result($environmental_result);
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
                } // End of if statement
            ?>

            <!-- Delivery Sub Folder Table -->
            <?php
                // change this according to folder_id
                if ($folder == 30) {
            ?>
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
            <?php
                } // End of if statement
            ?>

            <!-- Drivers Management Main Folder -->
            <!-- Drivers Information Sub Folder Table -->
             <?php
                // change this according to folder_id
                if ($folder == 31) {
            ?>
                <div class="bottom-data files-containers">
                    <div class="orders">
                        <div class="header">
                            <i class='bx bx-receipt'></i>
                            <h3>Drivers Reports</h3>
                        </div>
                        <table id="request-table" class="files-table">
                            <thead>
                                <tr>
                                    <th>Driver ID</th>
                                    <th>Email</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Mobile Number</th>
                                    <th>Address</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>License No.</th>
                                    <th>License Expiration Date</th>
                                    <th>Total Experience</th>
                                    <th>DOJ</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="files-table-body">
                                <?php
                                $driver_query = "SELECT *
                                FROM fms_g12_drivers";
                                
                                $driver_result = mysqli_query($con, $driver_query);

                                // Fetching and displaying data
                                while ($row = mysqli_fetch_assoc($driver_result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['d_id'] . "</td>";
                                    echo "<td>" . $row['d_email'] . "</td>";
                                    echo "<td>" . $row['d_first_name'] . "</td>";
                                    echo "<td>" . $row['d_last_name'] . "</td>";
                                    echo "<td>" . $row['d_mobile'] . "</td>";
                                    echo "<td>" . $row['d_address'] . "</td>";
                                    echo "<td>" . $row['d_age'] . "</td>";
                                    echo "<td>" . $row['d_gender'] . "</td>";
                                    echo "<td>" . $row['d_licenseno'] . "</td>";
                                    echo "<td>" . $row['d_license_expdate'] . "</td>";
                                    echo "<td>" . $row['d_total_exp'] . "</td>";
                                    echo "<td>" . $row['d_doj'] . "</td>";
                                    echo "<td>" . $row['d_created_date'] . "</td>";
                                    echo "</tr>";
                                }

                                // Free result set
                                mysqli_free_result($driver_result);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
                } // End of if statement
            ?>

            <!-- Drivers Management Main Folder -->
            <!-- Drivers Information Sub Folder Table -->
            <?php
                // change this according to folder_id
                if ($folder == 32) {
            ?>
                <div class="bottom-data files-containers">
                    <div class="orders">
                        <div class="header">
                            <i class='bx bx-receipt'></i>
                            <h3>Invoice Reports</h3>
                        </div>
                        <table id="request-table" class="files-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice Number</th>
                                    <th>Payment Method</th>
                                    <th>Customer Name</th>
                                    <th>Company Name</th>
                                    <th>Carrier</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                </tr>
                            </thead>
                            <tbody id="files-table-body">
                                <?php
                                $invoice_query = "SELECT *
                                FROM fms_g15_invoices";
                                
                                $invoice_result = mysqli_query($con, $invoice_query);

                                // Fetching and displaying data
                                while ($row = mysqli_fetch_assoc($invoice_result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['invoice_number'] . "</td>";
                                    echo "<td>" . $row['payment_method'] . "</td>";
                                    echo "<td>" . $row['customer_name'] . "</td>";
                                    echo "<td>" . $row['company_name'] . "</td>";
                                    echo "<td>" . $row['carrier'] . "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "<td>" . $row['updated_at'] . "</td>";
                                    echo "</tr>";
                                }

                                // Free result set
                                mysqli_free_result($invoice_result);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
                } // End of if statement
            ?>

            <!-- Order Management Main Folder -->
            <!--  Order Form Sub Folder Table -->
            <?php
                // change this according to folder_id
                if ($folder == 36) {
            ?>
                <div class="bottom-data files-containers">
                    <div class="orders">
                        <div class="header">
                            <i class='bx bx-receipt'></i>
                            <h3>Order Reports</h3>
                        </div>
                        <table id="request-table" class="files-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order ID</th>
                                    <!-- <th>User ID</th> -->
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Item</th>
                                    <th>Dimensions</th>
                                    <th>Location From</th>
                                    <!-- <th>Location To</th> -->
                                    <th>DropOffWarehouse</th>
                                    <th>Consignee Name</th>
                                    <th>Receiver Contact</th>
                                    <th>Receiver Address</th>
                                    <th>Mode Selection</th>
                                    <th>Delivery Date</th>
                                    <th>Price</th>
                                    <th>Fee</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Order Expiration Date</th>
                                    <th>Load ID</th>
                                </tr>
                            </thead>
                            <tbody id="files-table-body">
                                <?php
                                $order_form_query = "SELECT *
                                FROM fms_g18_formdetails";
                                
                                $order_form_result = mysqli_query($con, $order_form_query);

                                // Fetching and displaying data
                                while ($row = mysqli_fetch_assoc($order_form_result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['order_id'] . "</td>";
                                    echo "<td>" . $row['firstname'] . "</td>";
                                    echo "<td>" . $row['lastname'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['contact'] . "</td>";
                                    echo "<td>" . $row['item'] . "</td>";
                                    echo "<td>" . $row['dimensions'] . "</td>";
                                    echo "<td>" . $row['LocationFrom'] . "</td>";
                                    echo "<td>" . $row['DropOffWarehouse'] . "</td>";
                                    echo "<td>" . $row['consigneeName'] . "</td>";
                                    echo "<td>" . $row['receiverContact'] . "</td>";
                                    echo "<td>" . $row['receiveraddress'] . "</td>";
                                    echo "<td>" . $row['modeSelection'] . "</td>";
                                    echo "<td>" . $row['deliveryDate'] . "</td>";
                                    echo "<td>" . $row['price'] . "</td>";
                                    echo "<td>" . $row['totalAmount'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    echo "<td>" . $row['order_expirationDate'] . "</td>";
                                    echo "<td>" . $row['load_id'] . "</td>";
                                    echo "</tr>";
                                }

                                // Free result set
                                mysqli_free_result($order_form_result);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
                } // End of if statement
            ?>

            <br>
        </main>
    </div>

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