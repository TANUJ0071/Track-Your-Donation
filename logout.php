<?php
// Start the session
session_start();

// Destroy all session variables
session_destroy();

// Redirect to the login page after logout
header("Location: login.php");
exit();
?>
