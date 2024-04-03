<?php
// Include the database connection file
include '../config/db.php';

// Check if the user is logged in and get their ID
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

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

// Close the database connection
mysqli_close($con);
?>

<!-- Navbar/Header -->
<nav>
    <i class='bx bx-menu'></i>
    <form action="#">
        <!-- <div class="form-input">
            <input type="search" placeholder="Search...">
            <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
        </div> -->
    </form>
    <input type="checkbox" id="theme-toggle" hidden>
    <!-- <label for="theme-toggle" class="theme-toggle"></label> -->
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
