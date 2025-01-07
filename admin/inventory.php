<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';

if(!isLoggedIn()){
    header("location: ../login");
    die();
}

// Handle form submission to add inventory items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addInventory'])) {
        $itemId = 'item'.uniqid();
        $itemName = $_POST['item_name'] ?? '';
        $quantityOnHand = $_POST['quantity_on_hand'] ?? '';
        $reorderLevel = $_POST['reorder_level'] ?? '';
        $supplierInfo = $_POST['supplier_info'] ?? '';
        $createdAt = date('Y-m-d H:i:s');
        $updatedAt = date('Y-m-d H:i:s');
        $requested_by = "Admin";

        if (!empty($itemId) && !empty($itemName) && !empty($quantityOnHand) && !empty($reorderLevel) && !empty($supplierInfo)) {
            // Insert the new inventory item
            $stmt = $mysqli->prepare("INSERT INTO inventory (item_id, item_name, quantity_on_hand, reorder_level, supplier_info, requested_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssisssss", $itemId, $itemName, $quantityOnHand, $reorderLevel, $supplierInfo, $requested_by, $createdAt, $updatedAt);

            if ($stmt->execute()) {
                $successMessage = "Inventory item added successfully!";
            } else {
                $errorMessage = "Failed to add inventory item. Please try again.";
            }
            $stmt->close();
        } else {
            $errorMessage = "Please fill out all fields correctly.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php 
require_once './includes/header.php';
?>
<body>
    <div class="container">
        <?php 
        require_once './includes/sidenav.php';
        ?>

        <main>
            <h1>Inventory Management</h1>

            <?php if (isset($successMessage)): ?>
                <div style="color: green;"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div style="color: red;"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <div class="add-table-form" style="width: 100%;">
                <h2>Add Inventory Item</h2>
                <form method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                    <label for="item_name">Item Name:</label>
                    <input 
                        type="text" 
                        id="item_name" 
                        name="item_name" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">

                    <label for="quantity_on_hand">Quantity on Hand:</label>
                    <input 
                        type="number" 
                        id="quantity_on_hand" 
                        name="quantity_on_hand" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">

                    <label for="reorder_level">Reorder Level:</label>
                    <input 
                        type="number" 
                        id="reorder_level" 
                        name="reorder_level" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;">

                    <label for="supplier_info">Supplier Info:</label>
                    <textarea 
                        id="supplier_info" 
                        name="supplier_info" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px;"></textarea>

                    <button 
                        type="submit" 
                        name="addInventory" 
                        style="padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px;">
                        Add Item
                    </button>
                </form>
            </div>

            <!-- Table displaying all inventory items -->
            <div class="recent-order inventory-list">
                <h2>Existing Inventory</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Reorder Level</th>
                            <th>Supplier Info</th>
                            <th>Requested By</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        // Fetch all inventory items from the database
                        $query = "SELECT id, item_id, item_name, quantity_on_hand, reorder_level, supplier_info, requested_by, created_at, updated_at FROM inventory";
                        $result = $mysqli->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['item_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['quantity_on_hand']); ?></td>
                                    <td><?php echo htmlspecialchars($row['reorder_level']); ?></td>
                                    <td><?php echo htmlspecialchars($row['supplier_info']); ?></td>
                                    <td><?php echo htmlspecialchars($row['requested_by']); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='8'>No inventory items found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>

        <?php
        require_once './includes/right-sidenav.php';
        ?>
    </div>
    <?php require_once './includes/script.php'; ?>
</body>
</html>