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
} else {
    $_SESSION['notification'] = ['type' => 'error', 'message' => 'You do not have permission to view attendees for this event.'];
    header('Location: manage_events.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendees - Event Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container mt-5">
        <h3>Attendees for Event</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Registration Time</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $attendeesResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['registration_time']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        <?php if (isset($_SESSION['notification'])): ?>
            showNotification('<?php echo $_SESSION['notification']['type']; ?>', '<?php echo $_SESSION['notification']['message']; ?>');
            <?php unset($_SESSION['notification']); ?>
        <?php endif; ?>
    </script>
</body>
</html>