<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

$event_id = $_GET['event_id'];
$user_id = $_SESSION['user_id'];

// Fetch event details
$stmt = $conn->prepare("SELECT name, description, date, max_capacity, user_id FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$stmt->bind_result($name, $description, $date, $max_capacity, $event_creator_id);
$stmt->fetch();
$stmt->close();

// Check if the user is the event creator
if ($user_id == $event_creator_id) {
    $_SESSION['notification'] = ['type' => 'error', 'message' => 'You cannot register for your own event.'];
    header('Location: view_event.php?id=' . $event_id);
    exit();
}

// Check if the event is full
$stmt = $conn->prepare("SELECT COUNT(*) FROM attendees WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$stmt->bind_result($attendee_count);
$stmt->fetch();
$stmt->close();

if ($attendee_count >= $max_capacity) {
    $_SESSION['notification'] = ['type' => 'error', 'message' => 'The event is full.'];
    header('Location: view_event.php?id=' . $event_id);
    exit();
}

// Check if the user is already registered
$stmt = $conn->prepare("SELECT COUNT(*) FROM attendees WHERE event_id = ? AND user_id = ?");
$stmt->bind_param("ii", $event_id, $user_id);
$stmt->execute();
$stmt->bind_result($registration_count);
$stmt->fetch();
$stmt->close();

if ($registration_count > 0) {
    $_SESSION['notification'] = ['type' => 'error', 'message' => 'You are already registered for this event.'];
    header('Location: view_event.php?id=' . $event_id);
    exit();
}

// Register the user for the event
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO attendees (event_id, user_id, registration_time) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $event_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['notification'] = ['type' => 'success', 'message' => 'You have successfully registered for the event.'];
        header('Location: view_event.php?id=' . $event_id);
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Event - Event Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">Register for Event</div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="register_attendee.php?event_id=<?php echo $event_id; ?>">
                            <div class="form-group">
                                <label for="name">Event Name</label>
                                <input type="text" id="name" class="form-control" value="<?php echo $name; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control" disabled><?php echo $description; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="text" id="date" class="form-control" value="<?php echo date('Y-m-d H:i', strtotime($date)); ?>" disabled>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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