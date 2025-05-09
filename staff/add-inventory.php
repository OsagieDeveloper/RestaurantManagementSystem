<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';

if (!isLoggedIn()) {
    header("location: ../login");
    die();
}
require_once './includes/details.php';

// Handle form submission to add inventory items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addInventory'])) {
        $itemId = 'item' . uniqid();
        $itemName = $_POST['item_name'] ?? '';
        $quantityOnHand = $_POST['quantity_on_hand'] ?? '';
        $reorderLevel = $_POST['reorder_level'] ?? '';
        $supplierInfo = $_POST['supplier_info'] ?? '';
        $createdAt = date('Y-m-d H:i:s');
        $updatedAt = date('Y-m-d H:i:s');

        if (!empty($itemName) && !empty($quantityOnHand) && !empty($reorderLevel) && !empty($supplierInfo)) {
            $stmt = $mysqli->prepare("INSERT INTO inventory (item_id, item_name, quantity_on_hand, reorder_level, supplier_info, requested_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssisssss", $itemId, $itemName, $quantityOnHand, $reorderLevel, $supplierInfo, $staff_name, $createdAt, $updatedAt);

            if ($stmt->execute()) {
                $successMessage = "Inventory item added successfully!";
                header("location: ./inventory?msg=".$successMessage);
            } else {
                $errorMessage = "Failed to add inventory item. Please try again.";
            }
            $stmt->close();
        } else {
            $errorMessage = "Please fill out all fields correctly.";
        }
    }
}

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
            <?php if (isset($successMessage)): ?>
                <div style="color: green;"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div style="color: red;"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <!-- Add Inventory Form -->
            <div class="add-table-form" style="width: 100%;">
                <h2>Add Inventory Item</h2>
                <form method="POST" class="inventoryForm" style="display: flex; flex-direction: column; gap: 15px;">
                    <label for="item_name">Item Name:</label>
                    <input type="text" id="item_name" name="item_name" required>
                    <label for="quantity_on_hand">Quantity on Hand:</label>
                    <input type="number" id="quantity_on_hand" name="quantity_on_hand" required>
                    <label for="reorder_level">Reorder Level:</label>
                    <input type="number" id="reorder_level" name="reorder_level" required>
                    <label for="supplier_info">Supplier Info:</label>
                    <textarea id="supplier_info" name="supplier_info" required></textarea>
                    <button type="submit" name="addInventory" style="background-color: #007bff; color: white;">Add Item</button>
                </form>
            </div>
        </main>

        <?php require_once './includes/right-sidenav.php'; ?>
    </div>
    <?php require_once './includes/script.php'; ?>
</body>
</html>
