<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';

if (!isLoggedIn()) {
    header("location: ../login");
    die();
}
require_once './includes/details.php';

// Fetch inventory data
$query = "SELECT * FROM inventory";
$result = $mysqli->query($query);
$inventoryItems = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $inventoryItems[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once './includes/header.php'; ?>
<body>
    <div class="container">
        <?php require_once './includes/sidenav.php'; ?>

        <main>
            <h1>Inventory Management</h1>

            <!-- Success or error messages -->
            <?php if (isset($_GET['msg'])){ ?>
                <div style="color: green;"><?php echo trim($_GET['msg']); ?></div>
            <?php } ?>

            <!-- Low Stock Alerts -->
            <div class="low-stock-alerts">
                <h2>Low Stock Alerts</h2>
                <ul>
                    <?php
                    foreach ($inventoryItems as $item) {
                        if ($item['quantity_on_hand'] < $item['reorder_level']) {
                            echo "<li style='color: red;'>
                                <strong>{$item['item_name']}</strong> is below reorder level (Qty: {$item['quantity_on_hand']}, Reorder Level: {$item['reorder_level']}).
                                Reorder Now
                              </li>";
                        }
                    }
                    ?>
                </ul>
            </div>

            <!-- Inventory Table -->
            <div class="recent-order inventory-list">
                <h2>Existing Inventory</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Reorder Level</th>
                            <th>Supplier Info</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($inventoryItems as $item) {
                            echo "<tr>
                                <td>{$item['item_id']}</td>
                                <td>{$item['item_name']}</td>
                                <td>{$item['quantity_on_hand']}</td>
                                <td>{$item['reorder_level']}</td>
                                <td>{$item['supplier_info']}</td>
                                <td>{$item['created_at']}</td>
                                <td>{$item['updated_at']}</td>
                              </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

  
        </main>

        <?php require_once './includes/right-sidenav.php'; ?>
    </div>
    <?php require_once './includes/script.php'; ?>
</body>
</html>
