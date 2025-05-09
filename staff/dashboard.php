<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - Restaurant Management System</title>
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .dashboard-card .card-body {
            padding: 2rem;
            text-align: center;
        }
        .dashboard-card .card-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #343a40;
        }
        .dashboard-card .card-text {
            color: #6c757d;
        }
        .sidebar {
            background-color: #28a745;
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
        }
        .sidebar .nav-link {
            color: #fff3cd;
            transition: color 0.3s ease;
        }
        .sidebar .nav-link:hover {
            color: white;
            background-color: #218838;
        }
        .content-area {
            margin-left: 250px;
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h3 class="mb-4 text-center">Staff Menu</h3>
            <nav class="nav flex-column">
                <a class="nav-link active" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="view_orders.php">View Orders</a>
                <a class="nav-link" href="update_order_status.php">Update Order Status</a>
                <a class="nav-link" href="view_reservations.php">View Reservations</a>
                <a class="nav-link" href="../logout.php">Logout</a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="content-area w-100">
            <h1 class="mb-4 text-center">Staff Dashboard</h1>
            <p class="text-center mb-5">Welcome to the Restaurant Management System. Use the cards below to navigate through staff functions.</p>
            <div class="container">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
                    <div class="col"><div class="card dashboard-card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">View Orders</h5>
                            <p class="card-text">Check the list of active customer orders.</p>
                            <a href="view_orders.php" class="btn btn-success">Go to Orders</a>
                        </div>
                    </div></div>
                    <div class="col"><div class="card dashboard-card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Update Order Status</h5>
                            <p class="card-text">Update the progress of orders from preparation to delivery.</p>
                            <a href="update_order_status.php" class="btn btn-success">Update Status</a>
                        </div>
                    </div></div>
                    <div class="col"><div class="card dashboard-card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">View Reservations</h5>
                            <p class="card-text">See upcoming reservations and table assignments.</p>
                            <a href="view_reservations.php" class="btn btn-success">Go to Reservations</a>
                        </div>
                    </div></div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../public/js/bootstrap.bundle.min.js"></script>
    <?php require_once './includes/script.php'; ?>
</body>
</html>
