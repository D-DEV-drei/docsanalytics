<?php
session_start();
include '../config/db.php';

// Prepare a SELECT statement to fetch all users
$sql = "SELECT a.user_id, u.username, f.file_name, u.image FROM fms_g14_access as a
inner join fms_g14_users as u on u.id = a.user_id
inner join fms_g14_folder as f on f.id = a.folder_id";
$stmt = mysqli_prepare($con, $sql);

// Execute the statement
mysqli_stmt_execute($stmt);

// Bind result variables
mysqli_stmt_bind_result($stmt, $id, $username, $folder, $image);

// Fetch the data and store it in an array
$users = array();
while (mysqli_stmt_fetch($stmt)) {
    $users[] = array(
        'user_id' => $id,
        'username' => $username,
        'file_name' => $folder,
        'image' => $image,
    );
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the database connection
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
    <title>User Permission</title>

    <style>
        .dropdown-toggle-no-caret::after {
            display: none !important;
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
                    <h1>User Permission</h1>
                </div>
            </div>

            <!-- table for all user to manage and monitor their permission -->
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>List of User</h3>
                        <div class="create-folder-button">
                            <button class="btn btn-primary" onclick="openAddAccessModal()">+ Add User Access</button>
                        </div>
                    </div>
                    <!-- table for the list -->
                    <table id='request-table'>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Permission</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($user['image'])): ?>
                                    <img src="<?php echo $user['image']; ?>" alt="<?php echo $user['username']; ?>'s Profile Image" style="max-width: 50px;">
                                    <?php else: ?>
                                    <img src="../img/default-img.jpg" alt="Default Profile Image" style="max-width: 50px;">
                                    <?php endif;?>
                                    <?php echo $user['username']; ?>
                                </td>
                                <td><?php echo $user['file_name'] ?></td>
                                <!-- <td>
                                    <div class="dropdown">
                                        <span class="dropdown-toggle dropdown-toggle-no-caret" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class='bx bx-dots-vertical-rounded'></i>
                                        </span>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item delete" href="#" data-user-id="<?php echo $user['user_id']; ?>">Delete</a>
                                        </div>
                                    </div>
                                </td> -->
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Include addUserModal.php which is modal for adding new user-->
    <?php include '../modal/addAccessModal.php'?>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- script for bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>

    <!-- this is for interactive table: pagination, search bar and show entries -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#request-table').DataTable({
                "paging": true, // Enable pagination
                "pageLength": 5 // Set number of entries per page
            });
        });

        // Function to open the add user modal
        function openAddAccessModal() {
            $('#addAccessModal').modal('show');
        }

        $(document).ready(function() {
            // Event listener for the "Delete" option in the dropdown menu
            $('.dropdown-item.delete').click(function(event) {
                event.preventDefault(); // Prevent default action (i.e., following the link)

                // Get the user id from the data attribute of the clicked element
                var userId = $(this).data('user-id');

                // Confirm with the user before deleting
                if (confirm("Are you sure you want to delete the access" + "?")) {
                    // Send an AJAX request to deleteAccess.php
                    $.ajax({
                        type: 'POST',
                        url: 'deleteAccess.php',
                        data: { user_id: userId },
                        success: function(response) {
                            // Reload the page to reflect the changes
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle error response if needed
                            alert("Error: " + error); // Display error message
                        }
                    });
                }
            });
        });
    </script>

    <!-- javascript dashboard -->
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>
