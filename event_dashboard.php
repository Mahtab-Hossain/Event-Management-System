<?php
include 'includes/auth.php';
requireLogin();
include 'includes/db.php';

// Get sorting, ordering, pagination, and filtering parameters
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Validate sorting and ordering parameters
$validSortColumns = ['date', 'max_capacity', 'category'];
if (!in_array($sort, $validSortColumns)) {
    $sort = 'date';
}

$validOrder = ['ASC', 'DESC'];
if (!in_array($order, $validOrder)) {
    $order = 'ASC';
}

// Fetch total events count for pagination
$totalEventsQuery = "SELECT COUNT(*) as total FROM events WHERE name LIKE ?";
$totalEventsStmt = $conn->prepare($totalEventsQuery);
$searchTerm = '%' . $filter . '%';
$totalEventsStmt->bind_param("s", $searchTerm);
$totalEventsStmt->execute();
$totalEventsStmt->bind_result($totalEvents);
$totalEventsStmt->fetch();
$totalEventsStmt->close();

$totalPages = ceil($totalEvents / $limit);

// Fetch events with pagination, sorting, and filtering
$eventsQuery = "SELECT id, name, description, date, max_capacity, user_id FROM events WHERE name LIKE ? ORDER BY $sort $order LIMIT ? OFFSET ?";
$eventsStmt = $conn->prepare($eventsQuery);
$eventsStmt->bind_param("sii", $searchTerm, $limit, $offset);
$eventsStmt->execute();
$eventsResult = $eventsStmt->get_result();
$eventsStmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Dashboard - Event Management System</title>
    <!-- CSS links -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container mt-5">
        <h3>Event Dashboard</h3>
        <!-- Filter form -->
        <form method="GET" action="event_dashboard.php" class="form-inline mb-3">
            <input type="text" name="filter" class="form-control mr-2" placeholder="Search by name" value="<?php echo htmlspecialchars($filter); ?>">
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
        <!-- Events table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><a href="?sort=name&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Event Name</a></th>
                    <th>Description</th>
                    <th><a href="?sort=date&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Date</a></th>
                    <th><a href="?sort=max_capacity&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Max Capacity</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $eventsResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['max_capacity']); ?></td>
                        <td>
                            <!-- Action buttons based on user role -->
                            <?php if ($row['user_id'] == $_SESSION['user_id']): ?>
                                <a href="update_event.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete_event.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                            <?php else: ?>
                                <a href="view_event.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>&filter=<?php echo htmlspecialchars($filter); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
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