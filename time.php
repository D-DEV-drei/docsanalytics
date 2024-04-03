<?php
session_start();
session_destroy();
setcookie('login_attempts', 'Try After 20 Seconds', time() + 20);

header("location: login.php");
