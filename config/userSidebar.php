<!-- Sidebar for user -->

<?php
ob_start(); // Start output buffering

?>
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
            <!-- <li><a href="dashboard.php"><i class='bx bxs-dashboard'></i>Dashboard</a></li> -->
            <li><a href="inbound.php"><i class='bx bx-upload'></i>Request Upload</a></li>
            <li><a href="documentManage.php"><i class='bx bx-file'></i>View/Download</a></li>
            <li><a href="report.php"><i class='bx bx-bar-chart'></i>Reports</a></li>
            <li><a href="userManage.php"><i class='bx bx-group'></i>Account</a></li>
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

<?php

//modify here yung difference between current time and active time
//so if > 60 (seconds) its auto logout, if want niyo in minutes then convert the minutes to seconds
if ((time() - $_SESSION['Active_Time']) > 60) {
    // Redirect to logout page
    header('Location: ../logout.php');
    exit;
}
$_SESSION['Active_Time'] = time(); //update session active time

?>

<?php
// End output buffering and send content to browser
ob_end_flush();
?>