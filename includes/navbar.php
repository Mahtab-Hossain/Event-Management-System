<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <!-- Brand -->
    <a class="navbar-brand" href="#">Event Management System</a>
    <!-- Toggler/collapsible Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <!-- Home link -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <!-- Create Event link -->
            <li class="nav-item">
                <a class="nav-link" href="create_event.php">Create Event</a>
            </li>
            <!-- Manage Events link -->
            <li class="nav-item">
                <a class="nav-link" href="manage_events.php">Manage Events</a>
            </li>
            <!-- Event Dashboard link -->
            <li class="nav-item">
                <a class="nav-link" href="event_dashboard.php">Event Dashboard</a>
            </li>
            <!-- Admin specific links -->
            <?php if (isAdmin()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="reports.php">Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register_admin.php">Register Admin</a>
                </li>
            <?php endif; ?>
        </ul>
        <!-- Search form -->
        <form class="form-inline ml-auto" method="GET" action="dashboard.php">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
        </form>
        <!-- User authentication links -->
        <?php if (isLoggedIn()): ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        <?php else: ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</nav>