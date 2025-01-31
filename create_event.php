<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $max_capacity = $_POST['max_capacity'];

    $stmt = $conn->prepare("INSERT INTO events (name, description, date, max_capacity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $description, $date, $max_capacity);

    if ($stmt->execute()) {
        echo "Event created successfully!";
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Create Event - Event Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">Create Event</div>
                    <div class="card-body">
                        <form method="POST" action="create_event.php">
                            <div class="form-group">
                                <label for="name">Event Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Event Name" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="datetime-local" name="date" id="date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="max_capacity">Max Capacity</label>
                                <input type="number" name="max_capacity" id="max_capacity" class="form-control" placeholder="Max Capacity" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Create Event</button>
                        </form>
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