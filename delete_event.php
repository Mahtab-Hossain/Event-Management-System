<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Event deleted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header('Location: dashboard.php');
exit();
?>