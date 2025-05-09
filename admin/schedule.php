<?php
    require_once '../model/session.php';
    require_once '../config/database.php';
    require_once '../model/function.php';
    
    // Check if user is logged in and is staff or admin
    if (!isLoggedIn() || !in_array($_SESSION['role'], ['staff', 'admin'])) {
        header('Location: ../login.php');
        exit;
    }
    
    // Fetch staff schedule (simplified example)
    $staffId = $_SESSION['user_id'];
    $query = "SELECT * FROM shifts WHERE staff_id = ? AND date >= CURDATE() ORDER BY date, start_time LIMIT 14";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $staffId);
    $stmt->execute();
    $result = $stmt->get_result();
    $shifts = array();
    while ($row = $result->fetch_assoc()) {
        $shifts[] = $row;
    }
    $stmt->close();
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
                <h2 class="text-center mb-4">Your Schedule</h2>
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Upcoming Shifts</h5>
                        <a href="staff-dashboard.php" class="btn btn-primary btn-sm">Back to Dashboard</a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($shifts)): ?>
                            <p class="text-center text-muted">No upcoming shifts scheduled. Contact your manager for updates.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Day</th>
                                            <th scope="col">Start Time</th>
                                            <th scope="col">End Time</th>
                                            <th scope="col">Duration</th>
                                            <th scope="col">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($shifts as $shift): 
                                            $start = new DateTime($shift['start_time']);
                                            $end = new DateTime($shift['end_time']);
                                            $interval = $start->diff($end);
                                            $duration = $interval->format('%h hours %i minutes');
                                        ?>
                                            <tr>
                                                <td><?php echo date('F j, Y', strtotime($shift['date'])); ?></td>
                                                <td><?php echo date('l', strtotime($shift['date'])); ?></td>
                                                <td><?php echo date('h:i A', strtotime($shift['start_time'])); ?></td>
                                                <td><?php echo date('h:i A', strtotime($shift['end_time'])); ?></td>
                                                <td><?php echo $duration; ?></td>
                                                <td><?php echo htmlspecialchars($shift['notes'] ?? 'N/A'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Admin: Schedule Management</h5>
                        </div>
                        <div class="card-body text-center">
                            <p>As an admin, you can manage staff schedules.</p>
                            <a href="scheduling.php" class="btn btn-primary">Manage All Schedules</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
        require_once '../public/includes/footer.php';
        require_once '../public/includes/script.php';
        ?>
    </body>
</html>
