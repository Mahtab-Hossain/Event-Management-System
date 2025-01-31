<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $max_capacity = $_POST['max_capacity'];
    $user_id = $_SESSION['user_id'];

    // Check for duplicate event
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM events WHERE name = ? AND date = ?");
    $checkStmt->bind_param("ss", $name, $date);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        $error = "An event with the same name and date already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO events (name, description, date, max_capacity, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $name, $description, $date, $max_capacity, $user_id);

        if ($stmt->execute()) {
            $_SESSION['notification'] = ['type' => 'success', 'message' => 'Event created successfully!'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">Create Event</div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
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