        <?php
ob_start(); // Start output buffering

?>
        <!-- this is a sidebar for admin -->

        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Bootstrap JavaScript -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <div class="sidebar">
                <a href="#" class="logo">
                <img src="../img/kargada.png" alt="Kar Gada" width="100" height="100" style="margin-left: -20px; margin-top: 20px">
                    <div class="logo-name" style="margin-left: -20px;"><span>Kar</span>Gada</div>
                </a>
                <ul class="side-menu">
                    <li class="dashboard"><a href="dashboard.php"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
                    <li><a href="inbound.php"><i class='bx bx-upload'></i>Inbound</a></li>
                    <li><a href="outbound.php"><i class='bx bx-download'></i>Outbound</a></li>
                    <li><a href="documentManage.php"><i class='bx bx-file'></i>Archive Management</a></li>
                    <li><a href="folderCreation.php"><i class='bx bx-folder-plus'></i>Folder Management</a></li>
                    <li><a href="report.php"><i class='bx bx-bar-chart-alt'></i>Reports</a></li>
                    <li><a href="share_report.php"><i class='bx bx-share-alt'></i>Shared Reports</a></li>
                    <li><a href="userManage.php"><i class='bx bx-group'></i>User Management</a></li>
                    <li><a href="access.php"><i class='bx bx-lock'></i>Access Control</a></li>
                    <li><a href="#" onclick="openPasswordResetModal()"><i class='bx bxs-key'></i>Password Reset</a></li>

                </ul>
                <ul class="side-menu">
                <li>
                <a href="#" class="logout" id="logoutButton" data-toggle="modal" data-target="#logoutConfirmationModal">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>

                </ul>
            </div>

        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutConfirmationModalLabel">Logout Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to logout?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a href="../logout.php" class="btn btn-primary">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Reset Modal -->
        <div id="passwordResetModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Password Reset</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="passwordResetForm" method="post">
                            <div class="form-group">
                                <label for="new_password">New Password:</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password:</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="resetPasswordBtn" class="btn btn-primary">Reset Password</button>
                    </div>
                </div>
            </div>
        </div>

        <?php

//modify here yung difference between current time and active time
//so if > 3600 (seconds) OR 1 HOUR its auto logout, if want niyo in minutes then convert the minutes to seconds
if ((time() - $_SESSION['Active_Time']) > 3600) {
    // Redirect to logout page
    header('Location: ../logout.php');
    exit;
}
$_SESSION['Active_Time'] = time(); //update session active time

?>

<script>
function openPasswordResetModal() {
    $('#passwordResetModal').modal('show');
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
$(document).ready(function() {
    $('#resetPasswordBtn').click(function() {
        var newPassword = $('#new_password').val();
        var confirmPassword = $('#confirm_password').val();

        // Check if passwords match
        if (newPassword !== confirmPassword) {
            alert('Passwords do not match.');
            return;
        }

        // Send AJAX request to password_reset.php
        $.ajax({
            type: 'POST',
            url: '../pass_reset.php',
            data: {
                new_password: newPassword,
                confirm_password: confirmPassword
            },
            success: function(response) {
// Handle response from password_reset.php
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Password reset successful.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#passwordResetModal').modal('hide'); // Close the modal
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Password reset failed: ' + response.message,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#passwordResetModal').modal('hide'); // Close the modal
                    }
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while resetting the password.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#passwordResetModal').modal('hide'); // Close the modal
                }
            });
        }

        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sideMenuItems = document.querySelectorAll('.sidebar .side-menu li');

        sideMenuItems.forEach(item => {
            item.addEventListener('click', function(event) {
                // Close the sidebar when a menu item is clicked
                document.querySelector('.sidebar').classList.add('close');
            });
        });

        const menuBar = document.querySelector('.sidebar .logo');

        menuBar.addEventListener('click', function() {
            // Toggle the sidebar when the menu bar is clicked
            document.querySelector('.sidebar').classList.toggle('close');
        });
    });
</script>

<?php
// End output buffering and send content to browser
ob_end_flush();
?>