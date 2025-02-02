<?php
session_start();
// Set a notification message for successful logout
$_SESSION['notification'] = ['type' => 'success', 'message' => 'You have successfully logged out.'];
// Destroy the session
session_destroy();
// Redirect to login page
header('Location: login.php');
exit();
?>