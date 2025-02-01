<?php
include 'includes/db.php';
include 'includes/auth.php';
requireLogin();

header('Content-Type: application/json');

if (!isset($_GET['event_id'])) {
    echo json_encode(['error' => 'Event ID is required']);
    exit();
}

$event_id = $_GET['event_id'];

$stmt = $conn->prepare("SELECT e.id, e.name, e.description, e.date, e.max_capacity, u.username as creator 
                        FROM events e 
                        JOIN users u ON e.user_id = u.id 
                        WHERE e.id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Event not found']);
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();
$conn->close();

echo json_encode($event);
?>