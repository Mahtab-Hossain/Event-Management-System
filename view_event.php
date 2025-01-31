<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT name, description, date, max_capacity FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $description, $date, $max_capacity);
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
                        <a href="update_event.php?id=<?php echo $id; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete_event.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a>
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