<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

$event_id = $_GET['event_id'];
$user_id = $_SESSION['user_id'];

// Check if the user is the owner of the event
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM events WHERE id = ? AND user_id = ?");
$checkStmt->bind_param("ii", $event_id, $user_id);
$checkStmt->execute();
$checkStmt->bind_result($count);
$checkStmt->fetch();
$checkStmt->close();

if ($count > 0) {
    // Fetch attendees for the event
    $attendeesQuery = "SELECT u.username, u.email, a.registration_time 
                       FROM attendees a 
                       JOIN users u ON a.user_id = u.id 
                       WHERE a.event_id = ?";
    $stmt = $conn->prepare($attendeesQuery);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $attendeesResult = $stmt->get_result();
    $stmt->close();

    // Generate CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=attendees_list.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Username', 'Email', 'Registration Time']);

    while ($row = $attendeesResult->fetch_assoc()) {
        fputcsv($output, [$row['username'], $row['email'], $row['registration_time']]);
    }

    fclose($output);
    exit();
} else {
    $_SESSION['notification'] = ['type' => 'error', 'message' => 'You do not have permission to download attendees for this event.'];
    header('Location: manage_events.php');
    exit();
}
?>