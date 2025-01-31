<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch total events
$totalEventsQuery = "SELECT COUNT(*) as total FROM events";
$totalEventsResult = $conn->query($totalEventsQuery);
$totalEvents = $totalEventsResult->fetch_assoc()['total'];

// Fetch total attendees
$totalAttendeesQuery = "SELECT COUNT(*) as total FROM attendees";
$totalAttendeesResult = $conn->query($totalAttendeesQuery);
$totalAttendees = $totalAttendeesResult->fetch_assoc()['total'];

// Fetch upcoming events
$upcomingEventsQuery = "SELECT COUNT(*) as total FROM events WHERE date >= NOW()";
$upcomingEventsResult = $conn->query($upcomingEventsQuery);
$upcomingEvents = $upcomingEventsResult->fetch_assoc()['total'];

// Search events and attendees
$searchQuery = "SELECT e.id, e.name, e.description, e.date, e.max_capacity, u.username 
                FROM events e 
                LEFT JOIN attendees a ON e.id = a.event_id 
                LEFT JOIN users u ON a.user_id = u.id 
                WHERE e.name LIKE ? OR u.username LIKE ?";
$searchStmt = $conn->prepare($searchQuery);
$searchTerm = '%' . $search . '%';
$searchStmt->bind_param("ss", $searchTerm, $searchTerm);
$searchStmt->execute();
$searchResult = $searchStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System - Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Event Management System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create_event.php">Create Event</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_events.php">Manage Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="attendee_list.php">Attendee List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reports.php">Reports</a>
                </li>
            </ul>
            <form class="form-inline ml-auto" method="GET" action="dashboard.php">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Total Events</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $totalEvents; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Attendees</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $totalAttendees; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Upcoming Events</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $upcomingEvents; ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <h3>Search Results</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Max Capacity</th>
                            <th>Attendee</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $searchResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['max_capacity']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>