<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';
if(!isLoggedIn()){
    header("location: ../login");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php 
    require_once './includes/header.php';
?>
<body>
    <div class="container">
        <?php require_once './includes/sidenav.php'; ?>

        <main>
            <h1>Dashboard</h1>

            <div class="recent-order reservation-table">
                <h2>Orders List</h2>

                <?php if (isset($successMessage)): ?>
                    <div style="color: green;"><?php echo $successMessage; ?></div>
                <?php endif; ?>
                <?php if (isset($errorMessage)): ?>
                    <div style="color: red;"><?php echo $errorMessage; ?></div>
                <?php endif; ?>

                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Customer Name</th>
                            <th>Price</th>
                            <th>Items</th>
                            <th>Order Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        // Query to fetch all orders with customer details from the database
                        $query = "SELECT o.id, o.created_at, o.total, o.status, u.full_name as customer_name
                                  FROM orders o
                                  LEFT JOIN users u ON o.user_id = u.id";
                        $result = $mysqli->query($query);

                        // Check if there are results
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Fetch order items for this order
                                $order_id = $row['id'];
                                $items_query = "SELECT oi.quantity, m.name as item_name
                                               FROM order_items oi
                                               JOIN menus m ON oi.menu_item_id_n = m.id
                                               WHERE oi.order_id = $order_id";
                                $items_result = $mysqli->query($items_query);
                                
                                $items_display = '';
                                if ($items_result->num_rows > 0) {
                                    while ($item_row = $items_result->fetch_assoc()) {
                                        $items_display .= $item_row['quantity'] . ' x ' . $item_row['item_name'] . '<br>';
                                    }
                                }
                        ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($row['customer_name'] ?: 'Guest'); ?></td>
                                    <td><?php echo htmlspecialchars($row['total']); ?></td>
                                    <td><?php echo $items_display; ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td>
                                        <select class="status-select" data-order-id="<?php echo htmlspecialchars($row['id']); ?>" style="border: 1px solid #ccc; padding: 5px;">
                                            <option value="pending" <?php echo $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="confirmed" <?php echo $row['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                            <option value="cooking" <?php echo $row['status'] == 'cooking' ? 'selected' : ''; ?>>Cooking</option>
                                            <option value="ready" <?php echo $row['status'] == 'ready' ? 'selected' : ''; ?>>Ready</option>
                                            <option value="delivered" <?php echo $row['status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                            <option value="cancelled" <?php echo $row['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='7'>No orders found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>

        <?php require_once './includes/right-sidenav.php'; ?>
    </div>

    <?php require_once './includes/script.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelects = document.querySelectorAll('.status-select');
            statusSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const orderId = this.getAttribute('data-order-id');
                    const newStatus = this.value;

                    fetch('update_orders_status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `order_id=${orderId}&status=${newStatus}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Status updated successfully');
                        } else {
                            alert('Failed to update status: ' + data.message);
                            // Revert the dropdown to the previous value if update fails
                            this.value = this.getAttribute('data-previous-value');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating the status');
                        // Revert the dropdown to the previous value if update fails
                        this.value = this.getAttribute('data-previous-value');
                    });

                    // Store the current value as the previous value for potential reversion
                    this.setAttribute('data-previous-value', newStatus);
                });

                // Initialize the data-previous-value attribute
                select.setAttribute('data-previous-value', select.value);
            });
        });
    </script>
</body>
</html>