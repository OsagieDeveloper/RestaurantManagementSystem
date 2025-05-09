<?php
    require_once '../model/session.php';
    require_once '../config/database.php';
    require_once '../model/function.php';
    
    // Check if user is logged in and is staff or admin
    if (!isLoggedIn() || !in_array($_SESSION['role'], ['staff', 'admin'])) {
        header('Location: ../login.php');
        exit;
    }
    
    // Fetch orders (simplified example)
    $query = "SELECT * FROM orders ORDER BY created_at DESC LIMIT 20";
    $result = $mysqli->query($query);
    $orders = array();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
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
                <h2 class="text-center mb-4">Manage Orders</h2>
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Orders</h5>
                        <a href="staff-dashboard.php" class="btn btn-primary btn-sm">Back to Dashboard</a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($orders)): ?>
                            <p class="text-center text-muted">No orders found.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order ID</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Items</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                                <td><?php echo htmlspecialchars($order['customer_name'] ?? 'N/A'); ?></td>
                                                <td><?php echo htmlspecialchars($order['items'] ?? 'N/A'); ?></td>
                                                <td>$<?php echo number_format($order['total_amount'] ?? 0, 2); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        switch ($order['status'] ?? 'pending') {
                                                            case 'completed': echo 'success'; break;
                                                            case 'in_progress': echo 'primary'; break;
                                                            case 'cancelled': echo 'danger'; break;
                                                            default: echo 'warning'; break;
                                                        }
                                                    ?>">
                                                        <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $order['status'] ?? 'pending'))); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('F j, Y h:i A', strtotime($order['created_at'] ?? 'now')); ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <?php if (($order['status'] ?? 'pending') == 'pending'): ?>
                                                        <button class="btn btn-sm btn-outline-success">Accept</button>
                                                        <button class="btn btn-sm btn-outline-danger">Reject</button>
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
