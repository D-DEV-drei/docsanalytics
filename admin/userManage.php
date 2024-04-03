    <?php
session_start();
include '../config/db.php';

// Prepare a SELECT statement to fetch all users
$sql = "SELECT * FROM fms_g14_users";
$stmt = mysqli_prepare($con, $sql);

// Execute the statement
mysqli_stmt_execute($stmt);

// Bind result variables
mysqli_stmt_bind_result($stmt, $id, $username, $email, $password, $verify_token, $created_at, $activate, $role, $image, $code, $expired);

// Fetch the data and store it in an array
$users = array();
while (mysqli_stmt_fetch($stmt)) {
    $users[] = array(
        'id' => $id,
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'verify_token' => $verify_token,
        'created_at' => $created_at,
        'activate' => $activate,
        'role' => $role,
        'image' => $image,
        'code' => $code,
        'expired' => $expired,

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
        <title>User Management</title>

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
                                <h1>User Management</h1>

                            </div>
                    </div>

                    <!-- table for all user to manage and monitor their permission -->
                <div class="bottom-data">
                    <div class="orders">
                        <div class="header">
                            <i class='bx bx-receipt'></i>
                            <h3>List of User</h3>
                            <div class="create-folder-button">
                                <button class="btn btn-primary" onclick="openAddUserModal()">+ Add User</button>
                            </div>
                        </div>
                        <table id='request-table'>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Created_at</th>
                                    <th>Role</th>
                                    <th>Status</th>
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
                                        <td><?php echo $user['created_at']; ?></td>
                                        <td><?php echo $user['role'] == 1 ? 'Admin' : 'User'; ?></td>
                                        <td>
                                        <a href="update_activation.php?user_id=<?php echo $user['id']; ?>">
                                            <?php if ($user['activate'] == 1): ?>
                                                <button class="status completed">Activated</button>
                                            <?php else: ?>
                                                <button class="status" style="background-color: gray">Disabled</button>
                                            <?php endif;?>
                                            </a>
                                        </td>
                                        <!-- <td>
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle dropdown-toggle-no-caret" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class='bx bx-dots-vertical-rounded'></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Edit</a>
                                                <a class="dropdown-item delete" href="#" data-user-id="<?php echo $user['id']; ?>">Delete</a>
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
        <?php include '../modal/addUserModal.php'?>

        <script>

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
    $(document).ready(function() {
        // Event listener for the "Delete" option in the dropdown menu
        $('.dropdown-item.delete').click(function(event) {
            event.preventDefault(); // Prevent default action (i.e., following the link)

            // Get the user ID from the data attribute or any other relevant method
            var userId = $(this).data('user-id');

            // Confirm with the user before deleting
            if (confirm("Are you sure you want to delete this user?")) {
                // Send an AJAX request to deleteUser.php
                $.ajax({
                    type: 'GET',
                    url: 'deleteUser.php',
                    data: { user_id: userId }, // Pass the user ID as a parameter
                    success: function(response) {
                        // Handle success response if needed
                        alert(response); // Display success message
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



        <!-- jquery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>

<!-- script for bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

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
            function openAddUserModal() {
                $('#addUserModal').modal('show');
            }
        </script>

        <!-- javascript dashboard -->
        <script src="../assets/js/dashboard.js"></script>
    </body>

    </html>
