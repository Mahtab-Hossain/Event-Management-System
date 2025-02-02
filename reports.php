<?php
include 'includes/auth.php';
requireLogin();
requireAdmin();
include 'includes/db.php';

// Initialize filter variables
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$event_name = isset($_GET['event_name']) ? $_GET['event_name'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch events based on filters
$eventsQuery = "SELECT e.id, e.name, e.category, u.username, u.email, a.registration_time 
                FROM events e 
                LEFT JOIN attendees a ON e.id = a.event_id 
                LEFT JOIN users u ON a.user_id = u.id 
                WHERE 1=1";

if ($start_date) {
    $eventsQuery .= " AND e.date >= '$start_date'";
}
if ($end_date) {
    $eventsQuery .= " AND e.date <= '$end_date'";
}
if ($event_name) {
    $eventsQuery .= " AND e.name LIKE '%$event_name%'";
}
if ($category) {
    $eventsQuery .= " AND e.category = '$category'";
}

$eventsResult = $conn->query($eventsQuery);

// Generate CSV if requested
if (isset($_GET['download_csv'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=event_reports.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Event Name', 'Attendee Name', 'Attendee Email', 'Registration Date']);

    while ($row = $eventsResult->fetch_assoc()) {
        fputcsv($output, [$row['name'], $row['username'], $row['email'], $row['registration_time']]);
    }

    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reports - Event Management System</title>
    <!-- CSS links -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container mt-5">
        <h3>Event Reports</h3>
        <!-- Filter form -->
        <form method="GET" action="reports.php" class="form-inline mb-3">
            <input type="date" name="start_date" class="form-control mr-2" placeholder="Start Date" value="<?php echo htmlspecialchars($start_date); ?>">
            <input type="date" name="end_date" class="form-control mr-2" placeholder="End Date" value="<?php echo htmlspecialchars($end_date); ?>">
            <input type="text" name="event_name" class="form-control mr-2" placeholder="Event Name" value="<?php echo htmlspecialchars($event_name); ?>">
            <input type="text" name="category" class="form-control mr-2" placeholder="Category" value="<?php echo htmlspecialchars($category); ?>">
            <button type="submit" class="btn btn-primary">Filter</button>
            <button type="submit" name="download_csv" class="btn btn-success ml-2">Download CSV</button>
        </form>
        <!-- Events table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Attendee Name</th>
                    <th>Attendee Email</th>
                    <th>Registration Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $eventsResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['registration_time']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript links -->
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