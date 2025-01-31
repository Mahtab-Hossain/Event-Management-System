<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $max_capacity = $_POST['max_capacity'];

    $stmt = $conn->prepare("UPDATE events SET name = ?, description = ?, date = ?, max_capacity = ? WHERE id = ?");
    $stmt->bind_param("sssii", $name, $description, $date, $max_capacity, $id);

    if ($stmt->execute()) {
        echo "Event updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT name, description, date, max_capacity FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $description, $date, $max_capacity);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event - Event Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">Update Event</div>
                    <div class="card-body">
                        <form method="POST" action="update_event.php">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <label for="name">Event Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Event Name" value="<?php echo $name; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Description" required><?php echo $description; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="datetime-local" name="date" id="date" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($date)); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="max_capacity">Max Capacity</label>
                                <input type="number" name="max_capacity" id="max_capacity" class="form-control" placeholder="Max Capacity" value="<?php echo $max_capacity; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Update Event</button>
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