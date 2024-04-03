<?php
session_start(); // always start the session

// Check if the user is logged in, if yes destroy it
if (isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['email'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session para totally forgot na ng website yung session/cookies
    session_destroy();
}

// Redirect to the login page
header("Location: login.php");
