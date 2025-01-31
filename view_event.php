<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, description, date, max_capacity, user_id FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $description, $date, $max_capacity, $event_creator_id);
$stmt->fetch();
$stmt->close();

// Check if the user is registered for the event
$stmt = $conn->prepare("SELECT COUNT(*) FROM attendees WHERE event_id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$stmt->bind_result($registration_count);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Event - Event Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">Event Details</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $name; ?></h5>
                        <p class="card-text"><?php echo $description; ?></p>
                        <p class="card-text"><strong>Date:</strong> <?php echo date('Y-m-d H:i', strtotime($date)); ?></p>
                        <p class="card-text"><strong>Max Capacity:</strong> <?php echo $max_capacity; ?></p>
                        <?php if ($user_id == $event_creator_id): ?>
                            <a href="update_event.php?id=<?php echo $id; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete_event.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a>
                        <?php else: ?>
                            <?php if ($registration_count > 0): ?>
                                <a href="cancel_registration.php?event_id=<?php echo $id; ?>" class="btn btn-warning">Cancel Registration</a>
                            <?php else: ?>
                                <a href="register_attendee.php?event_id=<?php echo $id; ?>" class="btn btn-success">Register</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>