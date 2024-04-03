<style>
.notification-overlay {
    position: absolute;
    top: calc(100% + 10px); /* Position it below the notification bell icon */
    right: 0;
    width: 800px; /* Adjust as needed */
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow for better visibility */
    display: none;
}

.notification-content {
    padding: 10px;
}

.notification-item {
    margin-bottom: 5px;
}

.show {
    display: block !important; /* Ensure it overrides display:none */
}

.notification-item p.message,
.notification-item p.date {
    text-decoration: none; /* Prevent underlining */
}

</style>

<?php
// Include the database connection file
include '../config/db.php';

// Check if the user is logged in and get their ID
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // Query to count unseen notifications
    $sqlCountUnseen = "SELECT COUNT(*) AS unseen_count FROM fms_g14_notifications WHERE status = 'unread' Limit 10";
    $resultCountUnseen = mysqli_query($con, $sqlCountUnseen);
    $rowUnseen = mysqli_fetch_assoc($resultCountUnseen);
    $unseenCount = $rowUnseen['unseen_count'];

    // Query to fetch user image from the users table
    $sql = "SELECT image FROM fms_g14_users WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $userId);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind result variables
    mysqli_stmt_bind_result($stmt, $userImage);

    // Fetch the user image
    mysqli_stmt_fetch($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);
}

?>


<!-- This is a navbar/header. Include this in every file para mas shorter yung code  -->
<nav>
    <i class='bx bx-menu'></i>
    <form action="#">

    </form>
    <input type="checkbox" id="theme-toggle" hidden>
    <!-- Notification bell icon -->
    <a href="#" class="notif">
        <i class='bx bx-bell'></i>
        <span class="count"><?php echo $unseenCount; ?></span>
        <!-- Notification Overlay -->
        <div id="notification-overlay" class="notification-overlay">
            <div class="notification-content">
            <?php
// Query to fetch notifications
$sqlFetchNotifications = "SELECT * FROM fms_g14_notifications WHERE status = 'unread' ORDER BY created_at DESC LIMIT 5";
$resultFetchNotifications = mysqli_query($con, $sqlFetchNotifications);
while ($rowNotification = mysqli_fetch_assoc($resultFetchNotifications)) {
    echo "<div class='notification-item'>";
    echo "<p class='message'>" . $rowNotification['message'] . "</p>";
    echo "<p class='date'>" . $rowNotification['created_at'] . "</p>";
    // Check if the type is outbound
    if ($rowNotification['type'] === 'outbound') {
        echo "<p><a href='outbound.php' data-notification-id='" . $rowNotification['id'] . "'>View Details</a></p>";
    } else {
        echo "<p><a href='inbound.php' data-notification-id='" . $rowNotification['id'] . "'>View Details</a></p>";
    }
    echo "<hr>";
    echo "</div>";
}
?>
            </div>
        </div>
    </a>

    <a href="#" class="profile">
        <!-- Check if user image exists -->
        <?php if (isset($userImage)): ?>
            <img src="<?php echo $userImage; ?>" alt="Profile Image">
        <?php else: ?>
            <!-- Provide a default profile image -->
            <img src="../img/default-img.jpg" alt="Default Profile Image">
        <?php endif;?>
    </a>
</nav>

<!-- JavaScript to toggle the visibility of the notification overlay -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const notificationIcon = document.querySelector('.notif');
    const notificationOverlay = document.getElementById('notification-overlay');

    notificationIcon.addEventListener('click', function () {
        notificationOverlay.classList.toggle('show');
    });

    // Add event listener to "View Details" links
    const viewDetailsLinks = document.querySelectorAll('.notification-item a');
    viewDetailsLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default link behavior
            const notificationId = this.dataset.notificationId; // Get the notification ID from data attribute

            // Send AJAX request to update notification status
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // If you want to redirect after updating the status
                    window.location.href = link.getAttribute('href');
                }
            };
            xhr.open('GET', 'update_notification_status.php?id=' + notificationId, true);
            xhr.send();
        });
    });
});

</script>


