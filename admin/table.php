<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';
if(!isLoggedIn()){
    header("location: ../login");
    die();
}

// Handle form submission to add a table
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addTable'])) {
        $tableNumber = $_POST['table_number'] ?? '';
        $seats = $_POST['seats'] ?? 0;

        if (!empty($tableNumber) && $seats > 0) {
            // Check if the table already exists
            $checkQuery = $mysqli->prepare("SELECT COUNT(*) FROM tables WHERE table_number = ?");
            $checkQuery->bind_param("s", $tableNumber);
            $checkQuery->execute();
            $checkQuery->bind_result($count);
            $checkQuery->fetch();
            $checkQuery->close();

            if ($count > 0) {
                $errorMessage = "Table number already exists. Please use a different table number.";
            } else {
                // Insert the new table if it doesn't exist
                $stmt = $mysqli->prepare("INSERT INTO tables (table_number, seats) VALUES (?, ?)");
                $stmt->bind_param("si", $tableNumber, $seats);

                if ($stmt->execute()) {
                    $successMessage = "Table added successfully!";
                } else {
                    $errorMessage = "Failed to add table. Please try again.";
                }
                $stmt->close();
            }
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
            <h1>Manage Tables</h1>

            <!-- Display messages -->
            <?php if (isset($successMessage)): ?>
                <div style="color: green;"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div style="color: red;"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <!-- Form to add a new table -->
            <div class="add-table-form" style="width: 100%;">
                <h2 style="margin-bottom: 20px; font-size: 1.5rem; color: #333;">Add Table</h2>
                <form method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                    <label for="table_number" style="font-weight: bold; color: #555;">Table Number:</label>
                    <input 
                        type="text" 
                        id="table_number" 
                        name="table_number" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">

                    <label for="seats" style="font-weight: bold; color: #555;">Seats:</label>
                    <input 
                        type="number" 
                        id="seats" 
                        name="seats" 
                        min="1" 
                        required 
                        style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">

                    <button 
                        type="submit" 
                        class="primary" 
                        name="addTable" 
                        style="padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer;">
                        Add Table
                    </button>
                </form>
            </div>


            <!-- Table displaying all existing tables -->
            <div class="recent-order table-list">
                <h2>Existing Tables</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Table ID</th>
                            <th>Table Number</th>
                            <th>Seats</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        // Fetch all tables from the database
                        $query = "SELECT id, table_number, seats FROM tables";
                        $result = $mysqli->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['table_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['seats']); ?></td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='3'>No tables found.</td></tr>";
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