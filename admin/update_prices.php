<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../model/db.php';

// Fetch menu items
$stmt = $conn->prepare("SELECT id, name, price FROM menu_items");
$stmt->execute();
$menu_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Handle price update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_prices'])) {
    foreach ($_POST['prices'] as $item_id => $price) {
        $price = floatval($price);
        if ($price > 0) {
            $update_stmt = $conn->prepare("UPDATE menu_items SET price = ? WHERE id = ?");
            $update_stmt->bind_param("di", $price, $item_id);
            $update_stmt->execute();
        }
    }
    header("Location: update_prices.php?success=Prices updated successfully");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Menu Prices - Restaurant Management System</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php">Admin Dashboard</a>
        <a href="../logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Update Menu Prices</h2>
        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="update_prices" value="1">
            <table class="menu-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Current Price (£)</th>
                        <th>New Price (£)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menu_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <input type="number" name="prices[<?php echo $item['id']; ?>]" value="<?php echo $item['price']; ?>" step="0.01" min="0" required>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn-primary">Update Prices</button>
        </form>
    </div>
    <?php include '../public/includes/footer.php'; ?>
</body>
</html>
