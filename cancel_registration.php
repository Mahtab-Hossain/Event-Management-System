<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

$event_id = $_GET['event_id'];
$user_id = $_SESSION['user_id'];

// Check if the user is registered for the event
$stmt = $conn->prepare("SELECT COUNT(*) FROM attendees WHERE event_id = ? AND user_id = ?");
$stmt->bind_param("ii", $event_id, $user_id);
$stmt->execute();
$stmt->bind_result($registration_count);
$stmt->fetch();
$stmt->close();

if ($registration_count > 0) {
    // Cancel the registration
    $stmt = $conn->prepare("DELETE FROM attendees WHERE event_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $event_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['notification'] = ['type' => 'success', 'message' => 'Your registration has been cancelled.'];
    } else {
        $_SESSION['notification'] = ['type' => 'error', 'message' => 'Error cancelling registration: ' . $stmt->error];
    }

    $stmt->close();
} else {
    $_SESSION['notification'] = ['type' => 'error', 'message' => 'You are not registered for this event.'];
}

$conn->close();
header('Location: view_event.php?id=' . $event_id);
exit();
?>