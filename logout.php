<?php
session_start();
$_SESSION['notification'] = ['type' => 'success', 'message' => 'You have successfully logged out.'];
session_destroy();
header('Location: login.php');
exit();
?>