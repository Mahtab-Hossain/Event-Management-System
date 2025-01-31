<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Check if the user is the owner of the event
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM events WHERE id = ? AND user_id = ?");
$checkStmt->bind_param("ii", $id, $user_id);
$checkStmt->execute();
$checkStmt->bind_result($count);
$checkStmt->fetch();
$checkStmt->close();

if ($count > 0) {
    // Delete attendees
    $deleteAttendeesStmt = $conn->prepare("DELETE FROM attendees WHERE event_id = ?");
    $deleteAttendeesStmt->bind_param("i", $id);
    $deleteAttendeesStmt->execute();
    $deleteAttendeesStmt->close();

    // Delete event
    $deleteEventStmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $deleteEventStmt->bind_param("i", $id);
    if ($deleteEventStmt->execute()) {
        $_SESSION['notification'] = ['type' => 'success', 'message' => 'Event deleted successfully!'];
    } else {
        $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error deleting event: ' . $deleteEventStmt->error];
    }
    $deleteEventStmt->close();
} else {
    $_SESSION['notification'] = ['type' => 'error', 'message' => 'You do not have permission to delete this event.'];
}

$conn->close();
header('Location: manage_events.php');
exit();
?>