<?php
require_once '../model/session.php';
require_once '../config/database.php';
require_once '../model/function.php';

if (!isLoggedIn()) {
    header("location: ../login");
    die();
}

// Fetch logged-in staff ID from session
require_once './includes/details.php';

// Fetch staff schedules
$scheduleResults = [];
$query = "SELECT id, shift_start, shift_end, created_at FROM staff_schedule WHERE staff_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();
$scheduleResults = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once './includes/header.php'; ?>
<body>
    <div class="container">
        <?php require_once './includes/sidenav.php'; ?>

        <main>
            <h1>My Schedule</h1>

            <?php if (isset($successMessage)): ?>
                <div style="color: green;"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div style="color: red;"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <!-- Schedule Table -->
            <div class="recent-order">
                <h2>My Schedule</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Shift Start</th>
                            <th>Shift End</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($scheduleResults)) {
                            $today = date('Y-m-d');
                            foreach ($scheduleResults as $row) {
                                $status = (date('Y-m-d', strtotime($row['created_at'])) === $today) ? 
                                    '<span style="color: green;">Active</span>' : 
                                    '<span style="color: red;">Inactive</span>';
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['shift_start']); ?></td>
                                    <td><?php echo htmlspecialchars($row['shift_end']); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                    <td><?php echo $status; ?></td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='5'>No schedules found for you.</td></tr>";
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
