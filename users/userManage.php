    <?php
// Include database connection and ensure user is logged in
include '../config/db.php';
session_start();

// Check if the user is logged in and if the user ID is set in the session
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
} else {
    // Redirect to login page or handle unauthorized access
    header("Location: ../login.php");
    exit(); // Stop further execution
}

// Function to update password
function updatePassword($username, $currentPassword, $newPassword, $con)
{
    // Check if the username exists
    $query = "SELECT password FROM fms_g14_users WHERE username = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        // Username exists, fetch the password
        mysqli_stmt_bind_result($stmt, $storedPassword);
        mysqli_stmt_fetch($stmt);

        // Verify if the current password matches the stored password
        if (password_verify($currentPassword, $storedPassword)) {
            // Update the password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE fms_g14_users SET password = ? WHERE username = ?";
            $updateStmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "ss", $hashedNewPassword, $username);
            $success = mysqli_stmt_execute($updateStmt);

            if ($success) {
                return true; // Password updated successfully
            } 
        } 
    }
}

// Check if the form is submitted for changing the password
if (isset($_POST['changePasswordBtn'])) {
    $username = $_SESSION['username'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Check if the new password and confirm password match
    if ($newPassword !== $confirmNewPassword) {
        $_SESSION['change_password_status'] = "New password and confirm password do not match.";
        header("Location: ./userManagement.php");
        exit();
    }

    // Update the password
    $passwordUpdated = updatePassword($username, $currentPassword, $newPassword, $con);
    if ($passwordUpdated) {
        $_SESSION['change_password_status'] = "Password updated successfully.";
    } else {
        $_SESSION['change_password_status'] = "Failed to update password. Please check your current password.";
    }
    header("Location: ./userManagement.php");
    exit();
}

// Fetch user details based on user ID
$sql_user = "SELECT * FROM fms_g14_users WHERE id = ?";
$stmt_user = mysqli_prepare($con, $sql_user);
if ($stmt_user) {
    mysqli_stmt_bind_param($stmt_user, "i", $userId); // Corrected variable name
    mysqli_stmt_execute($stmt_user);
    mysqli_stmt_bind_result($stmt_user, $user_id, $user, $email, $password, $verify_token, $created_at, $activate, $role, $image, $code, $expired);
    mysqli_stmt_fetch($stmt_user);
    mysqli_stmt_close($stmt_user);
} else {
    echo "Error fetching user details: " . mysqli_error($con);
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Management</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="../assets/css/dashboard.css">
    </head>
    <body>
        <!-- Sidebar -->
        <?php include '../config/userSidebar.php'?>

        <!-- Main Content -->
        <div class="content">
            <!-- Navbar -->
            <?php include '../config/userHeader.php'?>
            <main>
                <div class="header">
                    <div class="left">
                        <h1>Personal Information</h1>
                    </div>
                    <!-- <div class="row">
                        <div class="col-lg-6 mb-3">
                            <button id="editProfileBtn" class="btn btn-primary btn-block">Edit Profile</button>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <button id="changePasswordBtn" class="btn btn-secondary btn-block">Change Password</button>
                        </div>
                    </div> -->

                </div>
                <!-- Profile container -->
                <div class="bottom-data">
                    <div class="orders">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-md-8 col-sm-10">
                                    <div class="order-card">
                                        <div class="user-profile">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <img src="<?php echo $image; ?>" alt="Profile Image" style="width:250px; height: 300px;">
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="user-info">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <p><strong>User:</strong></p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p><?php echo $user; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <p><strong>Email:</strong></p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p><?php echo $email; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <p><strong>Role:</strong></p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p><?php echo ($role == 1) ? 'Admin' : 'User'; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <p><strong>Status:</strong></p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p><?php echo ($role == 0) ? 'Active' : 'Disabled'; ?></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit profile modal -->
                <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editProfileForm" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="name">Username:</label>
                                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $user; ?>" required>
                                    </div>
                                    <!-- Email -->
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                                    </div>

                                    <!-- Profile Image -->
                                    <div class="form-group">
                                    <label for="image">Profile Image:</label>
                                        <input type="file" id="image" name="image" class="form-control-file" multiple accept="image/*">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Change password modal -->
                <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="changePasswordForm" method="post">
                                <div class="modal-body">
                                    <!-- Current Password -->
                                    <div class="form-group">
                                        <label for="currentPassword">Current Password:</label>
                                        <input type="password" id="currentPassword" name="currentPassword" class="form-control" required>
                                    </div>
                                    <!-- New Password -->
                                    <div class="form-group">
                                        <label for="newPassword">New Password:</label>
                                        <input type="password" id="newPassword" name="newPassword" class="form-control" required>
                                    </div>
                                    <!-- Confirm New Password -->
                                    <div class="form-group">
                                        <label for="confirmNewPassword">Confirm New Password:</label>
                                        <input type="password" id="confirmNewPassword" name="confirmNewPassword" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </main>
        </div>

        <!-- JavaScript and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- JavaScript for showing and hiding the modal -->
    <script>
    $(document).ready(function() {
        $('#editProfileBtn').click(function() {
            $('#editProfileModal').modal('show');
        });

        $('#changePasswordBtn').click(function() {
            $('#changePasswordModal').modal('show');
        });

        $('#editProfileForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to save changes to your profile.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save changes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, submit the form
                    this.submit();
                }
            });
        });

        $('#changePasswordForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            var newPassword = $('#newPassword').val();
            var confirmNewPassword = $('#confirmNewPassword').val();

            // Check if the new password matches the confirmed new password
            if (newPassword !== confirmNewPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'New password and confirm password do not match!',
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to change your password.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change password!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, submit the form
                    this.submit();
                }
            });
        });
    });
    </script>

    </body>
    </html>

