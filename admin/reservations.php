<?php
    require_once '../model/session.php';
    require_once '../config/database.php';
    require_once '../model/function.php';
    
    // Check if user is logged in and is staff or admin
    if (!isLoggedIn() || !in_array($_SESSION['role'], ['staff', 'admin'])) {
        header('Location: ../login.php');
        exit;
    }
    
    // Fetch reservations (simplified example)
    $query = "SELECT * FROM reservations WHERE date >= CURDATE() ORDER BY date, time LIMIT 20";
    $result = $mysqli->query($query);
    $reservations = array();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php 
        require_once '../public/includes/header.php';
    ?>
    <body>
        <header>
            <?php require_once '../admin/includes/nav.php'; ?>
        </header>

        <section class="d-flex align-items-center justify-content-center bg-light" style="min-height: calc(100vh - 200px); margin-top: 80px;">
            <div class="container">
                <h2 class="text-center mb-4">Manage Reservations</h2>
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Upcoming Reservations</h5>
                        <a href="staff-dashboard.php" class="btn btn-primary btn-sm">Back to Dashboard</a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($reservations)): ?>
                            <p class="text-center text-muted">No upcoming reservations found.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">Guests</th>
                                            <th scope="col">Table</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reservations as $reservation): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($reservation['id']); ?></td>
                                                <td><?php echo htmlspecialchars($reservation['name']); ?></td>
                                                <td><?php echo date('F j, Y', strtotime($reservation['date'])); ?></td>
                                                <td><?php echo date('h:i A', strtotime($reservation['time'])); ?></td>
                                                <td><?php echo htmlspecialchars($reservation['number_of_guests']); ?></td>
                                                <td><?php echo htmlspecialchars($reservation['table_id'] ?? 'N/A'); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        switch ($reservation['status'] ?? 'pending') {
                                                            case 'confirmed': echo 'success'; break;
                                                            case 'cancelled': echo 'danger'; break;
                                                            default: echo 'warning'; break;
                                                        }
                                                    ?>">
                                                        <?php echo htmlspecialchars(ucwords($reservation['status'] ?? 'pending')); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <?php if (($reservation['status'] ?? 'pending') == 'pending'): ?>
                                                        <button class="btn btn-sm btn-outline-success">Confirm</button>
                                                        <button class="btn btn-sm btn-outline-danger">Cancel</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php
        require_once '../public/includes/footer.php';
        require_once '../public/includes/script.php';
        ?>
    </body>
</html>
